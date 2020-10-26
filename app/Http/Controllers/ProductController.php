<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreProduct;
use App\Http\Requests\Update\UpdateProduct;
use App\Models\Product;
use App\Services\Billy\Resources\Product as ProductResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    public function index()
    {
        $data = Product::all();
        Log::info("products: ");
        Log::info($data);
        return view('pages/products', $data);

    }

    public function get(Request $request)
    {

    }

    public function show($id)
    {

    }

    /**
     * @param StoreProduct $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(StoreProduct $request)
    {
        // Validate request input data
        $data = $request->validated();
        // Save data to Billy
        $response = (new ProductResource())::create($data);
        if (!$response['meta']['success']) {
            return response()->json($response);
        }

        $newProduct = $response['products'][0];
        // Save Billy product resource to local DB
        $product = new Product();
        // Relations
        $product->product_id = $newProduct['id'];
        $product->organization_id = $newProduct['organizationId'];
        $product->account_id = $newProduct['accountId'];
        $product->salesTaxRulesetId = $newProduct['salesTaxRulesetId'];
        $product->inventoryAccountId = $newProduct['inventoryAccountId'];
        // Attributes
        foreach ($product->getFillable() as $attribute) {
            $product->setAttribute($attribute, $newProduct[$attribute]);
        }

        $product->saveOrFail();

        return response()->json($product->fresh());
    }

    public function update(UpdateProduct $request)
    {
        // Validate request input data
        $data = $request->validated();
        try {
            $product = Product::where('product_id')->first();
        } catch (ModelNotFoundException $exception){
            Log::error($exception->getMessage());
            return response()->json("Error code: {$exception->getCode()}. Message: {$exception->getMessage()}");
        }
        // Update model
    }

    public function delete()
    {

    }
}
