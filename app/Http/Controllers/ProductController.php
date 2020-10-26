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
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = Product::all();

        return view('pages/products', ['data' => $data]);

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('pages/product', ['data' => $product]);
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
        $product->name = $newProduct['name'];
        $product->description = $newProduct['description'];
        $product->organization_id = $newProduct['organizationId'];
        $product->productNo = $newProduct['productNo'];
        $product->isArchived = $newProduct['isArchived'];
        $product->isInInventory = $newProduct['isInInventory'];
        $product->imageId = $newProduct['imageId'];
        $product->suppliersProductNo = $newProduct['suppliersProductNo'];
        $product->account_id = $newProduct['accountId'];
        $product->salesTaxRulesetId = $newProduct['salesTaxRulesetId'];
        $product->inventoryAccountId = $newProduct['inventoryAccountId'];


        $product->saveOrFail();

        return response()->json($product->fresh());
    }

    /**
     * @param UpdateProduct $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProduct $request, $id)
    {
        // Validate request input data
        $data = $request->validated();
        // Find local product and update with new values
        try {
            $product = Product::query()->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getMessage());
            return response()->json("Error code: {$exception->getCode()}. Message: {$exception->getMessage()}");
        }
        $product->update($data);
        $product = $product->fresh();
        // Find and Update/Create product on Billy
        try {
            $response = (new ProductResource())::update($id, $data);
        } catch (\Exception $exception) {
            Log::error("Error code: {$exception->getCode()}. Message: {$exception->getMessage()}");
            return response($exception->getMessage(), $exception->getCode());
        }
        // Updating failed
        if (!$response['meta']['success']) {
            // General error while updating Product
            Log::error($response);
            return response()->json($response);
        }

        return response()->json($product->fresh());
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $product = Product::query()->findOrFail($id);
        $response = (new ProductResource())::delete($product->product_id);
        if (!$response['meta']['success']) {
            // Failed deleting resource in Billy
            Log::error("Failed deleting product with ID: {$product->product_id}. Message: {$response['errorMessage']}");
            return response()->json(['success' => false, 'message' => $response['errorMessage']]);
        }
        $deleted = $product->delete();
        if (!$deleted) {
            // Failed deleting local product
            Log::error('Failed deleting product: ' . $product->id);
            return response()->json(['success' => false, 'message' => 'Failed deleting product: ' . $product->id]);
        }

        return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function synchronize()
    {
        $allProducts = (new ProductResource())::all();

        $updated = 0;
        foreach ($allProducts['products'] as $masterProduct){
            try {
                $localProduct = Product::query()->updateOrCreate(['product_id' => $masterProduct['id']],
                    [
                        'product_id' => $masterProduct['id'],
                        'name' => $masterProduct['name'],
                        'description' => $masterProduct['description'],
                        'account_id' => $masterProduct['accountId'],
                        'inventoryAccountId' => $masterProduct['inventoryAccountId'],
                        'organization_id' => $masterProduct['organizationId'],
                        'productNo' => $masterProduct['productNo'],
                        'salesTaxRulesetId' => $masterProduct['salesTaxRulesetId'],
                        'suppliersProductNo' => $masterProduct['suppliersProductNo'],
                        'isArchived' => $masterProduct['isArchived'],
                        'isInInventory' => $masterProduct['isInInventory'],
                        'imageId' => $masterProduct['imageId'],
                    ]);
            } catch (\Exception $exception){
                Log::error($exception->getMessage());
                continue;
            }

            if ($localProduct->wasChanged()){
                $updated++;
            }
        }
        return response()->json(['message' => "Updated {$updated} products."]);

    }
}
