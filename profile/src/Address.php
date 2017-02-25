<?php

namespace Viender\Profile;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'street_id',
    ];

    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    public function zipCode() 
    {
        return $this->belongsTo('Viender\Profile\ZipCode');
    }

    public function city() 
    {
        return $this->belongsTo('Viender\Profile\City');
    }

    public function state() 
    {
        return $this->belongsTo('Viender\Profile\State');
    }

    public function country() 
    {
        return $this->belongsTo('Viender\Profile\Country');
    }

    public static function createWithStreet(array $request) 
    {
        $street = Street::create($request);
        $address = new Address($request);
        $address->street_id = $street->id;
        $address->save();
    }
}
