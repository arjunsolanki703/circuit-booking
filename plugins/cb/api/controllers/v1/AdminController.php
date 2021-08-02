<?php

namespace Cb\Api\Controllers\V1;

use Tymon\JWTAuth\JWTAuth;
use Cb\Api\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Backend\Models\User as BackendUser;

class AdminController extends ApiController
{
    /**
     * @var JWTAuth
     */
    private $JWTAuth;

    /**
     * UserController constructor.
     *
     * @param User    $user
     * @param JWTAuth $JWTAuth
     */
    public function __construct(JWTAuth $JWTAuth)
    {
        $this->JWTAuth = $JWTAuth;
    }

    /**
     * get token for user
     *
     * @return JsonResponse
     */
    public function getToken()
    {
        $user = BackendUser::where('email', request()->email)->first();

        if (empty($user)) {
            return $this->responseNotFound('Not Found User Admin');
        }

        if (Hash::check(request()->password, $user->password)) {

            $token = $this->JWTAuth->fromUser($user);

            return $this->respond([
                'token' => $token,
            ]);
        }

        return $this->respondForbiddenError();
    }
}
