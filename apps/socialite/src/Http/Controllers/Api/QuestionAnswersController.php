<?php

namespace Viender\Socialite\Http\Controllers\Api;

use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use Viender\Socialite\Models\Answer;
use Viender\Socialite\Models\Question;
use Viender\Credential\Models\Credential;
use Viender\Socialite\Events\QuestionAnswered;
use Viender\Socialite\Repositories\AnswersRepository;
use Viender\Socialite\Transformers\AnswerTransformer;
use Viender\Socialite\Transformers\AnswerPreviewTransformer;
use Viender\Socialite\Transformers\Serializer\ArraySerializer;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class QuestionAnswersController extends ApiController
{
    private $answers;

    public function __construct(AnswersRepository $answers)
    {
        $this->middleware('auth:api')->except('index', 'show');
        $this->fractal  = new Manager();
        $this->fractal->setSerializer(new ArraySerializer());
        if (isset($_GET['with'])) {
            $this->fractal->parseIncludes($_GET['with']);
        }
        $this->answers = $answers;
    }

    /**
     * @api {get} /questions/:slug/answers Get Question Answers
     * @apiName QuestionAnswersIndex
     * @apiGroup QuestionGroup
     * @apiVersion 1.0.0
     * @apiDescription Get a page of Addresses
     *
     * @apiHeader {String} Content-Type Content-Type
     *
     * @apiUse AnswerIndexSuccess
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        $paginator = $question->answers()->orderBy('created_at', 'desc')->paginate();

        return $this->respondWithPagination($paginator, new AnswerPreviewTransformer($this->answers));
    }

    /**
     * @api {post} /questions/:slug/answers Create Question Answer
     * @apiName QuestionAnswersStore
     * @apiGroup QuestionGroup
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
    public function store(Request $request, Question $question)
    {
        $this->authorize('create', Answer::class);

        if ($request->credential_id && !Credential::where('id', $request->credential_id)->exists()) {
            $request->replace(array('credential_id' => null));
        }

        if($question->answers()->where('user_id', \Auth::user()->id)->exists()) {
            return $this->setStatusCode(400)->respondWithMessage("Cannot post multiple answer for one question.");
        }

        $answer = $this->answers->createByUser(\Auth::user()->id, $question, $request->all());

        event(new QuestionAnswered($answer));

        return $this->respond(new Item($answer, new AnswerPreviewTransformer($this->answers)));
    }

    /**
     * @api {get} /questions/:slug/answers/:id Get Question Answer
     * @apiName QuestionAnswersShow
     * @apiGroup QuestionGroup
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
    public function show(Question $question, $answer)
    {
        $answer = $question->answers()->where('slug', $answer)->firstOrFail();

        $answer->incrementView();

        return $this->respond(new Item($answer, new AnswerTransformer));
    }

    /**
     * @api {put} /questions/:slug/answers/:id Update Quesiton Answer
     * @apiName QuestionAnswersUpdate
     * @apiGroup QuestionGroup
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
    public function update(Request $request, Question $question, $answer)
    {
        $answer = $question->answers()->where('slug', $answer)->firstOrFail();

        $this->authorize('update', $answer);

        $answer->update($request->all());

        return $this->respond(new Item($answer, new AnswerPreviewTransformer($this->answers)));
    }

    /**
     * @api {delete} /questions/:slug/answers/:id Delete Question Answer
     * @apiName QuestionAnswersDelete
     * @apiGroup QuestionGroup
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
    public function destroy(Question $question, $answer)
    {
        $answer = $question->answers()->withTrashed()->where('slug', $answer)->firstOrFail();

        $this->authorize('delete', $answer);

        if ($answer->trashed()) {
            $answer->restore();
            return $this->respondUpdated();
        }

        $answer->delete();

        return $this->respondDeleted();
    }
}
