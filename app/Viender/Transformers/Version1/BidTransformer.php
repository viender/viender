<?php

namespace App\Viender\Transformers\Version1;

use App\Bid;
use App\Viender\Transformers\Version1\Traits\AuthorIncludable;

class BidTransformer extends Transformer
{
    use AuthorIncludable;

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'author'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Bid $bid)
    {
        return [
            'id'            => (int) $bid->id,
            'title'         => $bid->title,
            'body'          => $bid->body,
            'offered_price' => (int) $bid->offered_price, 
            'deal'          => (boolean) $bid->deal,
            'links'         => [
                [
                    'rel' => 'self',
                    'uri' => url('/bids') . '/' . $bid->id,
                ],
                [
                    'rel' => 'author',
                    'uri' => url('/users') . '/' . $bid->user->username,
                ],
                [
                    'rel' => 'auction',
                    'uri' => url('/auctions') . '/' . $bid->auction->slug,
                ],
            ],
        ];
    }
}