<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreContact;
use App\Http\Requests\Update\UpdateContact;
use App\Models\Contact;
use App\Services\Billy\Resources\Contact as ContactResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

/**
 * Class ContactController
 * @package App\Http\Controllers
 */
class ContactController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = Contact::all();

        return view('pages/contacts', ['data' => $data]);

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        return view('pages/contact', ['data' => $contact]);
    }

    /**
     * @param StoreContact $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(StoreContact $request)
    {
        // Validate request input data
        $data = $request->validated();
        // Save data to Billy
        $response = (new ContactResource())::create($data);
        if (!$response['meta']['success']) {
            return response()->json($response);
        }

        $newContact = $response['contacts'][0];
        // Save Billy contact resource to local DB
        $contact = new Contact();
        // Attributes
        $contact->contact_id = $newContact['id'];
        $contact->type = $newContact['type'];
        $contact->organization_id = $newContact['organizationId'];
        $contact->createdTime = $newContact['createdTime'];
        $contact->countryId = $newContact['countryId'];
        $contact->street = $newContact['street'];
        $contact->accessCode = $newContact['accessCode'];

        $contact->saveOrFail();

        return response()->json($contact->fresh());
    }

    /**
     * @param UpdateContact $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(UpdateContact $request, $id)
    {
        // Validate request input data
        $data = $request->validated();
        // Find local contact and update with new values
        try {
            $contact = Contact::query()->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getMessage());
            return response()->json("Error code: {$exception->getCode()}. Message: {$exception->getMessage()}");
        }
        $contact->update($data);
        $contact = $contact->fresh();
        // Find and Update/Create contact on Billy
        try {
            $response = (new ContactResource())::update($contact->contact_id, $data);
        } catch (\Exception $exception) {
            Log::error("Error code: {$exception->getCode()}. Message: {$exception->getMessage()}");
            return response($exception->getMessage(), $exception->getCode());
        }
        // Updating failed
        if (!$response['meta']['success']) {
            // General error while updating contact
            Log::error($response);
            return response()->json($response);
        }

        return response()->json($contact->fresh());
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $contact = Contact::query()->findOrFail($id);
        $response = (new ContactResource())::delete($contact->contact_id);
        if (!$response['meta']['success']) {
            // Failed deleting resource in Billy
            Log::error("Failed deleting contact with ID: {$contact->contact_id}. Message: {$response['errorMessage']}");
            return response()->json(['success' => false, 'message' => $response['errorMessage']]);
        }
        $deleted = $contact->delete();
        if (!$deleted) {
            // Failed deleting local contact
            Log::error('Failed deleting contact: ' . $contact->id);
            return response()->json(['success' => false, 'message' => 'Failed deleting contact: ' . $contact->id]);
        }

        return response()->json(['success' => true, 'message' => 'contact deleted successfully.']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function synchronize()
    {
        $allContacts = (new ContactResource())::all();
        $updated = 0;
        foreach ($allContacts['contacts'] as $masterContact){
            try {
                $localContact = Contact::query()->updateOrCreate(['contact_id' => $masterContact['id']],
                    [
                        'contact_id' => $masterContact['id'],
                        'name' => $masterContact['name'],
                        'createdTime' => $masterContact['createdTime'],
                        'countryId' => $masterContact['countryId'],
                        'street' => $masterContact['street'],
                        'organization_id' => $masterContact['organizationId'],
                        'accessCode' => $masterContact['accessCode']
                    ]);
            } catch (\Exception $exception){
                Log::info($exception->getMessage());
                continue;
            }
            Log::info($localContact);
            if ($localContact->wasChanged()){
                $updated++;
            }
        }
        return response()->json(['message' => "Updated {$updated} contacts."]);

    }
}
