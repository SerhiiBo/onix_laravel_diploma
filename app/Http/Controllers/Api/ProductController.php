<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Product::when($request->has('category_ids'))
            ->category_ids($request->get('category_ids'))
            ->when($request->sort_by == 'rating')
            ->sortByRating();
        return ProductResource::collection($query->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request): ProductResource
    {
        $product = Product::create($request->validated());
        $request->whenHas('category', function ($category) use ($product) {
           return $product->addCategory($product, $category);
        });
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return ProductResource
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        $request->whenHas('category', function ($categories) use ($product) {
            return $product->addCategory($categories, $product);
        });
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function add(Product $product)
    {
        return new ProductResource($product);
    }
}
