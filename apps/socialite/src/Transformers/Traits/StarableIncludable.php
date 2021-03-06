<?php

namespace Viender\Socialite\Transformers\Traits;

trait StarableIncludable
{
    use TransformerTrait;

    /**
     * Include Starable
     *
     * @return League\Fractal\ItemResource
     */
    public function includeStarable($item)
    {
        $starable = $item->starable;

        $starableTransformer = $this->getTransformer($item->starable_type);

        return $this->item($starable, new $starableTransformer);
    }
}