<?php

namespace Viender\Socialite\Http\Controllers\Api;

use App\User;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use Viender\Socialite\Models\Answer;
use Viender\Socialite\Repositories\AnswersRepository;
use Viender\Socialite\Transformers\AnswerPreviewTransformer;
use Viender\Socialite\Transformers\Serializer\ArraySerializer;

class UserAnswersController extends ApiController
{
    protected $answers;

    public function __construct(AnswersRepository $answers) {
        $this->answers = $answers;
        $this->fractal  = new Manager();
        $this->fractal->setSerializer(new ArraySerializer());
        if (isset($_GET['with'])) {
            $this->fractal->parseIncludes($_GET['with']);
        }
    }

    /**
     * @api {get} /users/:username/answers Get User Answer
     * @apiName UserAnswersIndex
     * @apiGroup UserGroup
     * @apiVersion 1.0.0
     * @apiDescription Get a page of Addresses
     *
     * @apiHeader {String} Content-Type Content-Type
     *
     * @apiUse AnswerIndexSuccess
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $paginator = null;

        if (\Auth::user() && \Auth::user()->id === $user->id) {
            $paginator = $user->answers()->withTrashed()->latest('created_at')->paginate();
        } else {
            $paginator = $user->answers()->latest('created_at')->paginate();
        }

        return $this->respondWithPagination($paginator, new AnswerPreviewTransformer($this->answers));
    }

    /**
     * @api {post} /users/:username/answers Create User Answer
     * @apiName UserAnswersStore
     * @apiGroup UserGroup
     * @apiVersion 1.0.0
     * @apiDescription Create a new Addresses
     *
     * @apiUse AuthApiHeader
     *
     * @apiUse AnswerRequestBodyParam
     *
     * @apiUse MessageResponseSuccess
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $user->answers()->save(new Answer($request->all()));

        return $this->respondCreated();
    }

    /**
     * @api {get} /users/:username/answers/:id Get User Answers
     * @apiName UserAnswersShow
     * @apiGroup UserGroup
     * @apiVersion 1.0.0
     * @apiDescription Get an Addresses object
     *
     * @apiHeader {String} Content-Type Content-Type
     *
     * @apiParam (Path Parameters) {Number} id Addresses unique ID
     *
     * @apiUse AnswerShowSuccess
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $answer)
    {
        $answer = $user->answers()->findOrFail($answer);

        return $this->respond(new Item($answer, new AnswerTransformer));
    }

    /**
     * @api {put} /users/:username/answers/:id Update User Answer
     * @apiName UserAnswersUpdate
     * @apiGroup UserGroup
     * @apiVersion 1.0.0
     * @apiDescription Update an Addresses
     *
     * @apiUse AuthApiHeader
     *
     * @apiParam (Path Parameters) {Number} id Addresses unique ID
     *
     * @apiUse AnswerRequestBodyParam
     *
     * @apiUse MessageResponseSuccess
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, $answer)
    {
        $answer = $user->answers()->findOrFail($answer);

        $answer->update($request->all());

        return $this->respondUpdated();
    }

    /**
     * @api {delete} /users/:username/answers/:id Delete User Answer
     * @apiName UserAnswersDelete
     * @apiGroup UserGroup
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
    public function destroy(User $user, $answer)
    {
        $answer = $user->answers()->withTrashed()->where('slug', $answer)->firstOrFail();

        $this->authorize('delete', $answer);

        if ($answer->trashed()) {
            $answer->restore();
            return $this->respondUpdated();
        }

        $answer->delete();

        return $this->respondDeleted();
    }
}
