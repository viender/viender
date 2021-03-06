<?php

namespace Viender\Socialite\Transformers;

use Illuminate\Support\Collection;
use Viender\Socialite\Models\Answer;
use Viender\Socialite\Models\Comment;
use Viender\Socialite\Models\Question;
use Viender\Socialite\Repositories\CommentsRepository;
use Viender\Address\Transformers\Traits\UserIncludable;
use Viender\Socialite\Transformers\Traits\CommentableIncludable;

class CommentWithCommentableTransformer extends Transformer
{
    use UserIncludable, CommentableIncludable;

    private $comments;

    public function __construct()
    {
        $this->comments = new CommentsRepository(app(), Collection::make());
    }

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'commentable',
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'owner', 'commentable',
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Comment $comment)
    {
        return [
            'id'                => (int) $comment->id,
            'type'              => 'comment',
            'body'              => $comment->body,
            'upvote_count'      => $comment->upvotes()->count(),
            'comment_count'     => $comment->comments()->count(),
            'upvoted'           => \Auth::user() ? $comment->upvotes()->where('user_id', \Auth::user()->id)->exists() : false,
            'downvoted'         => \Auth::user() ? $comment->downvotes()->where('user_id', \Auth::user()->id)->exists() : false,
            'deleted_at'        => $comment->deleted_at,
            'links'   => [
                [
                    'rel' => 'self',
                    'url' => route('api.viender.socialite.comments.show', $comment->id),
                ],
                [
                    'rel' => 'self_html',
                    'url' => $this->getSelfHtmlUrl($comment),
                ],
                [
                    'rel' => 'comments',
                    'url' => route('api.viender.socialite.comments.comments.index', $comment->id),
                ],
                [
                    'rel' => 'upvotes',
                    'url' => route('api.viender.socialite.comments.upvotes.index', $comment->id)
                ],
                [
                    'rel' => 'downvotes',
                    'url' => route('api.viender.socialite.comments.downvotes.index', $comment->id),
                ],
            ],
        ];
    }

    public function getSelfHtmlUrl($comment)
    {
        $url = url('/');

        $commentable = $comment->commentable()->withTrashed()->first();

        switch ($comment->commentable_type) {
            case Question::class:
                $url = route('web.viender.socialite.pages.questionShow', $commentable);
                break;

            case Answer::class:
                $url = route('web.viender.socialite.pages.answerShow', [$commentable->question, $commentable->slug]);
                break;

            case Comment::class:
                $comment = $commentable;

                switch ($comment->commentable_type) {
                    case Question::class:
                        $url = route('web.viender.socialite.pages.questionShow', $commentable);
                        break;
                    case Answer::class:
                        $url = route('web.viender.socialite.pages.answerShow', [$commentable->question, $commentable->slug]);
                        break;
                    case Comment::class:
                        break;
                    default:
                        break;
                }

                break;

            default:
                break;
        }

        return $url;
    }
}
