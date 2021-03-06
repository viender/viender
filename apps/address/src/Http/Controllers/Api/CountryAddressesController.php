<?php

namespace Viender\Address\Http\Controllers\Api;

use Viender\Address\Models\Country;
use Viender\Address\Models\Address;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use Viender\Address\Transformers\AddressTransformer;

class CountryAddressesController extends ApiController
{
    /** 
     * @api {get} /countries/:id/addresses Get Country Addresses
     * @apiName CountryAddressesIndex
     * @apiGroup CountryGroup
     * @apiVersion 1.0.0
     * @apiDescription Get a page of Addresses
     *
     * @apiHeader {String} Content-Type Content-Type
     * 
     * @apiUse AddressIndexSuccess
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Country $country)
    {
        $paginator = $country->addresses()->paginate();

        return $this->respondWithPagination($paginator, new AddressTransformer);
    }

    /**
     * @api {post} /countries/:id/addresses Create Country Address
     * @apiName CountryAddressesStore
     * @apiGroup CountryGroup
     * @apiVersion 1.0.0
     * @apiDescription Create a new Addresses
     *
     * @apiUse AuthApiHeader
     * 
     * @apiUse AddressRequestBodyParam
     *
     * @apiUse MessageResponseSuccess
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Country $country)
    {
        $country->addresses()->save(new Address($request->all()));

        return $this->respondCreated();
    }

    /**
     * @api {get} /countries/:id/addresses/:id Get Country Address
     * @apiName CountryAddressesShow
     * @apiGroup CountryGroup
     * @apiVersion 1.0.0
     * @apiDescription Get an Addresses object
     *
     * @apiHeader {String} Content-Type Content-Type
     *
     * @apiParam (Path Parameters) {Number} id Addresses unique ID
     *
     * @apiUse AddressShowSuccess
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country, $address)
    {
        $address = $country->addresses()->findOrFail($address);

        return $this->respond(new Item($address, new AddressTransformer));
    }

    /**
     * @api {put} /countries/:id/addresses/:id Update Country Address
     * @apiName CountryAddressesUpdate
     * @apiGroup CountryGroup
     * @apiVersion 1.0.0
     * @apiDescription Update an Addresses
     *
     * @apiUse AuthApiHeader
     *
     * @apiParam (Path Parameters) {Number} id Addresses unique ID
     *
     * @apiUse AddressRequestBodyParam
     *
     * @apiUse MessageResponseSuccess
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country, $address)
    {
        $address = $country->addresses()->findOrFail($address);

        $address->update($request->all());

        return $this->respondUpdated();
    }

    /**
     * @api {delete} /countries/:id/addresses/:id Delete Country Address
     * @apiName CountryAddressesDelete
     * @apiGroup CountryGroup
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
    public function destroy(Country $country, $address)
    {
        $address = $country->addresses()->findOrFail($address);
        
        $address->delete();

        return $this->respondDeleted();
    }
}