<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnswerController extends Controller
{

    /**
     * Store a newly created answer in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request, $question_id)
    {
        $this->authorize('create', Answer::class);
        $answer = Answer::create($request->validated());
        $answer->user_id = $request->user()->id;
        $answer->question_id = $question_id;
        $answer->save();

        return $answer;
    }

    /**
     * Update the specified answer in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Question $question
     * @return Answer
     */
    public function update(StoreQuestionRequest $request, $answer_id)
    {
        $answer = Answer::find($answer_id);
        $this->authorize('update', [Answer::class, $answer]);
        $answer->text = $request->get('text');
        $answer->save();
        return $answer;
    }

    /**
     * Remove the specified answer from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($answer_id)
    {
        $answer = Answer::find($answer_id);
        $this->authorize('delete', [Answer::class, $answer]);
        $answer->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
