<?php

namespace Viender\Campaign\Models;

use Illuminate\Database\Eloquent\Model;
use Viender\Campaign\Models\CampaignHit;

class Campaign extends Model
{
/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'source',
    ];

    public function campaignHits()
    {
        return $this->hasMany(CampaignHit::class);
    }
}
