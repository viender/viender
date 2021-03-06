<?php

namespace Viender\Socialite\Transformers;

use Viender\Socialite\Models\Question;
use Viender\Socialite\Transformers\AnswerTransformer;
use Viender\Address\Transformers\Traits\UserIncludable;
use Viender\Socialite\Transformers\Traits\CommentsIncludable;

class QuestionTransformer extends Transformer
{
    use UserIncludable, CommentsIncludable;

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'owner', 'answers', 'comments',
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform($question)
    {
        if (!$question) return [];

        return [
            'id'            => (int) $question->id,
            'type'          => 'question',
            'slug'          => $question->slug,
            'title'         => $question->title,
            'body'          => $question->body,
            'upvoted'       => \Auth::user() ? $question->upvotes()->where('user_id', \Auth::user()->id)->exists() : false,
            'downvoted'     => \Auth::user() ? $question->downvotes()->where('user_id', \Auth::user()->id)->exists() : false,
            'upvote_count'  => $question->upvotes()->count(),
            'comment_count' => $question->comments()->count(),
            'answered'      => \Auth::user() ? $question->answers()->withTrashed()->where('user_id', \Auth::user()->id)->exists() : false,
            'deleted_at'    => $question->deleted_at,
            'links'   => [
                [
                    'rel' => 'self',
                    'url' => route('api.viender.socialite.questions.show', $question->slug),
                ],
                [
                    'rel' => 'self_html',
                    'url' => route('web.viender.socialite.pages.questionShow', $question->slug),
                ],
                [
                    'rel' => 'author',
                    'url' => route('api.viender.core.users.show', $question->user->username),
                ],
                [
                    'rel' => 'answers',
                    'url' => route('api.viender.socialite.questions.answers.index', $question->slug),
                ],
                [
                    'rel' => 'comments',
                    'url' => route('api.viender.socialite.questions.comments.index', $question->slug),
                ],
                [
                    'rel' => 'upvotes',
                    'url' => route('api.viender.socialite.questions.upvotes.index', $question->slug),
                ],
                [
                    'rel' => 'downvotes',
                    'url' => route('api.viender.socialite.questions.downvotes.index', $question->slug),
                ],
            ]
        ];
    }

    /**
     * Include Answers
     *
     * @return League\Fractal\ItemResource
     */
    public function includeAnswers($item)
    {
        $answers = $item->answers;

        return $this->collection($answers, new AnswerTransformer, 'answers');
    }
}
