<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        $query = Question::when($request->has('product_id'), function ($query) use ($request) {
            return $query->where('product_id', $request->product_id);
        });
        return $query->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request, $product_id)
    {
        $question = Question::create($request->validated());
        $question->user_id = $request->user()->id;
        $question->product_id = $product_id;
        $question->save();

        return $question;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Question $question
     * @return Question
     */
    public function show(Question $question)
    {
        return $question;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Question $question
     * @return Question
     */
    public function update(StoreQuestionRequest $request, Question $question)
    {
        $question->update($request->validated());
        return $question;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
