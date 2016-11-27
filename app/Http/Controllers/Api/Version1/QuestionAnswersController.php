<?php

namespace App\Http\Controllers\Api\Version1;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use App\Repositories\AnswersRepository;
use App\Viender\Transformers\Version1\AnswerTransformer;

class QuestionAnswersController extends ApiController
{
    private $answers;

    public function __construct(AnswersRepository $answers)
    {
        parent::__construct();
        $this->answers = $answers;
    }

    /** 
     * @api {get} /questions/:slug/answers Get Question Answers
     * @apiName QuestionAnswersIndex
     * @apiGroup QuestionGroup
     * @apiVersion 1.0.0
     * @apiDescription Get a page of Addresses
     *
     * @apiHeader {String} Content-Type Content-Type
     * 
     * @apiUse AnswerIndexSuccess
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        $paginator = $question->answers()->orderBy('created_at', 'desc')->paginate();

        return $this->respondWithPagination($paginator, new AnswerTransformer);
    }

    /**
     * @api {post} /questions/:slug/answers Create Question Answer
     * @apiName QuestionAnswersStore
     * @apiGroup QuestionGroup
     * @apiVersion 1.0.0
     * @apiDescription Create a new Addresses
     *
     * @apiUse AuthApiHeader
     * 
     * @apiUse AnswerRequestBodyParam
     *
     * @apiUse MessageResponseSuccess
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question)
    {
        $answer = $this->answers->createByUser(\Auth::user()->id, $question, $request->all());

        return $this->respond(new Item($answer, new AnswerTransformer));
    }

    /**
     * @api {get} /questions/:slug/answers/:id Get Question Answer
     * @apiName QuestionAnswersShow
     * @apiGroup QuestionGroup
     * @apiVersion 1.0.0
     * @apiDescription Get an Addresses object
     *
     * @apiHeader {String} Content-Type Content-Type
     *
     * @apiParam (Path Parameters) {Number} id Addresses unique ID
     *
     * @apiUse AnswerShowSuccess
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question, $answer)
    {
        $answer = $question->answers()->findOrFail($answer);

        return $this->respond(new Item($answer, new AnswerTransformer));
    }

    /**
     * @api {put} /questions/:slug/answers/:id Update Quesiton Answer
     * @apiName QuestionAnswersUpdate
     * @apiGroup QuestionGroup
     * @apiVersion 1.0.0
     * @apiDescription Update an Addresses
     *
     * @apiUse AuthApiHeader
     *
     * @apiParam (Path Parameters) {Number} id Addresses unique ID
     *
     * @apiUse AnswerRequestBodyParam
     *
     * @apiUse MessageResponseSuccess
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, $answer)
    {
        $answer = $question->answers()->findOrFail($answer);

        $answer->update($request->all());

        return $this->respondUpdated();
    }

    /**
     * @api {delete} /questions/:slug/answers/:id Delete Question Answer
     * @apiName QuestionAnswersDelete
     * @apiGroup QuestionGroup
     * @apiVersion 1.0.0
     * @apiDescription Delete an Addresses
     *
     * @apiUse AuthApiHeader
     *
     * @apiParam (Path Parameters) {Number} id Addresses unique ID
     *
     * @apiUse MessageResponseSuccess
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, $answer)
    {
        $answer = $question->answers()->findOrFail($answer);
        
        $answer->delete();

        return $this->respondDeleted();
    }
}