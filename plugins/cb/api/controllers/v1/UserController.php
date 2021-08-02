<?php

namespace Cb\Api\Controllers\V1;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Cb\Api\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Cb\Api\Transformers\V1\User as UserCollection;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class UserController extends ApiController
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserController constructor.
     *
     * @param User    $user
     * @param JWTAuth $JWTAuth
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * get all user
     *
     * @return JsonResponse
     */
    public function index()
    {
        $user = $this->user->paginate(
            $this->limit()
        );

        return $this->respondWithPagination(
            $user,
            UserCollection::collection($user)
        );
    }

    /**
     * create new user
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => ['required', 'between:3,64', 'email', 'unique:users'],
                'password' => ['required', 'between:2,32'],
                'cb_gender' => [],
                'cb_function' => [],
                'cb_telephone' => [],
                'name' => [],
                'activation_code' => [],
                'persist_code' => [],
                'reset_password_code' => [],
                'permissions' => [],
                'is_activated' => ['boolean'],
                'activated_at' => ['date_format:Y-m-d H:i:s'],
                'last_login' => ['date_format:Y-m-d H:i:s'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        $data['password'] = Hash::make($data['password']);

        $user = $this->user->create($data);

        return $this->setItem(
            UserCollection::make($user)
        )->responseCreated('User added');
    }

    /**
     * update user
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = $this->user->find($id);

        if (empty($user)) {
            return $this->responseNotFound('Not Found User');
        }

        try {
            $data = $request->validate([
                'email' => ['between:3,64', 'email', Rule::unique('users')->ignore($user->id)],
                'password' => ['between:2,32'],
                'cb_gender' => [],
                'cb_function' => [],
                'cb_telephone' => [],
                'name' => [],
                'activation_code' => [],
                'persist_code' => [],
                'reset_password_code' => [],
                'permissions' => [],
                'is_activated' => ['boolean'],
                'activated_at' => ['date_format:Y-m-d H:i:s'],
                'last_login' => ['date_format:Y-m-d H:i:s'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $this->setItem(
            UserCollection::make($user)
        )->responseUpdate('User updated');
    }

    /**
     * show user
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $user = $this->user->find($id);

        if (empty($user)) {
            return $this->responseNotFound('Not Found User');
        }

        return $this->setItem(
            UserCollection::make($user)
        )->respondAll();
    }

    /**
     * destroy user
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);

        if (empty($user)) {
            return $this->responseNotFound('Not Found User');
        }

        $user->deleted_at = now();

        $user->save();

        return $this->responseDeteted('User deleted');
    }
}
