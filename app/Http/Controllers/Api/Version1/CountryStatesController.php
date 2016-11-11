<?php

namespace App\Http\Controllers\Api\Version1;

use App\Country;
use App\State;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use App\Viender\Transformers\Version1\StateTransformer;

class CountryStatesController extends ApiController
{
    /** 
     * @api {get} /addresses Get Addresses
     * @apiName CountriesIndex
     * @apiGroup Country
     * @apiVersion 1.0.0
     * @apiDescription Get a page of Addresses
     *
     * @apiHeader {String} Content-Type Content-Type
     * 
     * @apiSuccess {Object[]} data Array of addresses
     * @apiSuccess {Number} data.id Adresses unique ID
     * @apiSuccess {String} data.street Street name
     * @apiSuccess {String} data.city City name
     * @apiSuccess {String} data.state State name
     * @apiSuccess {String} data.country Country name
     * @apiSuccess {Object[]} data.links Addresses links
     * @apiSuccess {Url} data.links.rel Addresses links rel
     * @apiSuccess {Url} data.links.uri Addresses links uri
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Country $country)
    {
        $paginator = $country->states()->paginate();

        return $this->respondWithPagination($paginator, new StateTransformer);
    }

    /**
     * @api {post} /addresses Create Address
     * @apiName CountriesStore
     * @apiGroup Country
     * @apiVersion 1.0.0
     * @apiDescription Create a new Addresses
     *
     * @apiHeader {String} Authorization Personal Access Token
     * @apiHeader {String} Content-Type Content-Type
     * 
     * @apiParam (Request Body Fields) {Number} user_id Users unique ID
     * @apiParam (Request Body Fields) {Number} city_id Cities unique ID
     * @apiParam (Request Body Fields) {String} name Street name
     *
     * @apiSuccess {String} message Response message
     * @apiSuccess {Number} status_code Response status code
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Country $country)
    {
        $country->states()->save(new State($request->all()));

        return $this->respondCreated();
    }

    /**
     * @api {get} /addresses/:id Get Address by ID
     * @apiName CountriesShow
     * @apiGroup Country
     * @apiVersion 1.0.0
     * @apiDescription Get an Addresses object
     *
     * @apiHeader {String} Content-Type Content-Type
     *
     * @apiParam (Path Parameters) {Number} id Addresses unique ID
     *
     * @apiSuccess {Object} data Array of addresses
     * @apiSuccess {Number} data.id Adresses unique ID
     * @apiSuccess {String} data.street Street name
     * @apiSuccess {String} data.city City name
     * @apiSuccess {String} data.state State name
     * @apiSuccess {String} data.country Country name
     * @apiSuccess {Object[]} data.links Addresses links
     * @apiSuccess {Url} data.links.rel Addresses links rel
     * @apiSuccess {Url} data.links.uri Addresses links uri
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country, $state)
    {
        $state = $country->states()->findOrFail($state);

        return $this->respond(new Item($state, new StateTransformer));
    }

    /**
     * @api {put} /addresses/:id Update Address
     * @apiName CountriesUpdate
     * @apiGroup Country
     * @apiVersion 1.0.0
     * @apiDescription Update an Addresses
     *
     * @apiHeader {String} Content-Type Content-Type
     *
     * @apiParam (Path Parameters) {Number} id Addresses unique ID
     *
     * @apiParam (Request Body Fields) {Number} user_id Users unique ID
     * @apiParam (Request Body Fields) {Number} city_id Cities unique ID
     * @apiParam (Request Body Fields) {String} name Street name
     * 
     * @apiSuccess {String} message Response message
     * @apiSuccess {Number} status_code Response status code
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country, $state)
    {
        $state = $country->states()->findOrFail($state);

        $state->update($request->all());

        return $this->respondUpdated();
    }

    /**
     * @api {delete} /addresses/:id Delete Address
     * @apiName CountriesDelete
     * @apiGroup Country
     * @apiVersion 1.0.0
     * @apiDescription Delete an Addresses
     *
     * @apiHeader {String} Content-Type Content-Type
     *
     * @apiParam (Path Parameters) {Number} id Addresses unique ID
     *
     * @apiSuccess {String} message Response message
     * @apiSuccess {Number} status_code Response status code
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country, $state)
    {
        $state = $country->states()->findOrFail($state);
        
        $state->delete();

        return $this->respondDeleted();
    }
}