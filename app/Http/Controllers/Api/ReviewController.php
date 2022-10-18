<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Review::class, 'review');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $review = Review::when($request->has('product_id'), function ($query, $product_id) {
            $query->where('product_id', $product_id);
        })->paginate(10);
        return $review;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $review = $request->validate([
            'text' => 'required|min:2|max:255',
            'rating' => 'integer|min:0|max:5',
        ]);

        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user()->id,
            'text' => $review['text'],
            'rating' => $review['rating'],
        ]);
//        $review->save();
        return $review;
    }

    /**
     * Display the specified resource.
     *
     * @param Review $review
     * @return Review
     */
    public function show(Review $review)
    {

        return $review;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Review $review
     * @return Review
     */
    public function update(Request $request,Review $review)
    {
        $review->update($request->all());
        return $review;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
