<?php

namespace Viender\Socialite\Http\Controllers\Api;

use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use Illuminate\Container\Container;
use Viender\Socialite\Models\Answer;
use Viender\Socialite\Models\Upvote;
use Viender\Socialite\Events\UpvotableUpvoted;
use Viender\Socialite\Repositories\UpvotesRepository;
use Viender\Socialite\Transformers\UpvoteTransformer;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AnswerUpvotesController extends ApiController
{
    private $upvotes;

    public function __construct(UpvotesRepository $upvotes)
    {
        parent::__construct();
        $this->upvotes = $upvotes;
    }

    /** 
     * @api {get} /answers/:id/upvotes Get Answer Upvotes
     * @apiName AnswerUpvotesIndex
     * @apiGroup AnswerGroup
     * @apiVersion 1.0.0
     * @apiDescription Get a page of Addresses
     *
     * @apiHeader {String} Content-Type Content-Type
     * 
     * @apiUse UpvoteIndexSuccess
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Answer $answer)
    {
        $paginator = $answer->upvotes()->paginate();

        return $this->respondWithPagination($paginator, new UpvoteTransformer);
    }

    /**
     * @api {post} /answers/:id/upvotes Create Answer Upvote
     * @apiName AnswerUpvotesStore
     * @apiGroup AnswerGroup
     * @apiVersion 1.0.0
     * @apiDescription Create a new Addresses
     *
     * @apiUse AuthApiHeader
     * 
     * @apiUse UpvoteRequestBodyParam
     *
     * @apiUse MessageResponseSuccess
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Answer $answer)
    {
        if($upvote = $this->upvotes->toggle($answer)){
            event(new UpvotableUpvoted($upvote));

            // If we don't want to use Illuminate\Foundation, use this to fire an event.
            // Container::getInstance()->make('events')->fire(new UpvotableUpvoted($upvote));

            return $this->respondCreated('Upvoted');
        }

        return $this->respondDeleted('Downvoted');
    }

    /**
     * @api {get} /answers/:id/upvotes/:id Get Answer Upvote
     * @apiName AnswerUpvotesShow
     * @apiGroup AnswerGroup
     * @apiVersion 1.0.0
     * @apiDescription Get an Addresses object
     *
     * @apiHeader {String} Content-Type Content-Type
     *
     * @apiParam (Path Parameters) {Number} id Addresses unique ID
     *
     * @apiUse UpvoteShowSuccess
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer, $upvotes)
    {
        $upvotes = $answer->upvotes()->findOrFail($upvotes);

        return $this->respond(new Item($upvotes, new UpvoteTransformer));
    }

    /**
     * @api {put} /answers/:id/upvotes/:id Update Answer Upvote
     * @apiName AnswerUpvotesUpdate
     * @apiGroup AnswerGroup
     * @apiVersion 1.0.0
     * @apiDescription Update an Addresses
     *
     * @apiUse AuthApiHeader
     *
     * @apiParam (Path Parameters) {Number} id Addresses unique ID
     *
     * @apiUse UpvoteRequestBodyParam
     *
     * @apiUse MessageResponseSuccess
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer, $upvotes)
    {
        $upvotes = $answer->upvotes()->findOrFail($upvotes);
        
        $upvotes->update($request->all());

        return $this->respondUpdated();
    }

    /**
     * @api {delete} /answers/:id/upvotes/:id Delete Answer Upvote
     * @apiName AnswerUpvotesDelete
     * @apiGroup AnswerGroup
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
    public function destroy(Answer $answer, $upvotes)
    {
        $upvotes = $answer->upvotes()->findOrFail($upvotes);

        $upvotes->delete();

        return $this->respondDeleted();
    }
}