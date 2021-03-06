<?php

namespace Viender\Socialite\Http\Controllers\Api;

use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use Viender\Socialite\Models\Upvote;
use Viender\Socialite\Models\Comment;
use Viender\Socialite\Events\UpvotableUpvoted;
use Viender\Socialite\Repositories\UpvotesRepository;
use Viender\Socialite\Transformers\UpvoteTransformer;

class CommentUpvotesController extends ApiController
{
    private $upvotes;

    public function __construct(UpvotesRepository $upvotes)
    {
        parent::__construct();
        $this->upvotes = $upvotes;
    }

    /** 
     * @api {get} /comments/:id/upvotes Get Comment Upvotes
     * @apiName CommentUpvotesIndex
     * @apiGroup CommentGroup
     * @apiVersion 1.0.0
     * @apiDescription Get a page of Addresses
     *
     * @apiHeader {String} Content-Type Content-Type
     * 
     * @apiUse UpvoteIndexSuccess
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Comment $comment)
    {
        $paginator = $comment->upvotes()->paginate();

        return $this->respondWithPagination($paginator, new UpvoteTransformer);
    }

    /**
     * @api {post} /comments/:id/upvotes Create Comment Upvote
     * @apiName CommentUpvotesStore
     * @apiGroup CommentGroup
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
    public function store(Request $request, Comment $comment)
    {
        if($upvote = $this->upvotes->toggle($comment)){
            event(new UpvotableUpvoted($upvote));

            // If we don't want to use Illuminate\Foundation, use this to fire an event.
            // Container::getInstance()->make('events')->fire(new UpvotableUpvoted($upvote));

            return $this->respondCreated('Upvoted');
        }

        return $this->respondDeleted('Downvoted');
    }

    /**
     * @api {get} /comments/:id/upvotes/:id Get Comment Upvote
     * @apiName CommentUpvotesShow
     * @apiGroup CommentGroup
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
    public function show(Comment $comment, $upvote)
    {
        $upvote = $comment->upvotes()->findOrFail($upvote);

        return $this->respond(new Item($upvote, new UpvoteTransformer));
    }

    /**
     * @api {put} /comments/:id/upvotes/:id Update Comment Upvote
     * @apiName CommentUpvotesUpdate
     * @apiGroup CommentGroup
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
    public function update(Request $request, Comment $comment, $upvote)
    {
        $upvote = $comment->upvotes()->findOrFail($upvote);

        $upvote->update($request->all());

        return $this->respondUpdated();
    }

    /**
     * @api {delete} /comments/:id/upvotes/:id Delete Comment Upvote
     * @apiName CommentUpvotesDelete
     * @apiGroup CommentGroup
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
    public function destroy(Comment $comment, $upvote)
    {
        $upvote = $comment->upvotes()->findOrFail($upvote);
        
        $upvote->delete();

        return $this->respondDeleted();
    }
}