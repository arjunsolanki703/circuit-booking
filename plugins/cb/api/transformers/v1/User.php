<?php

namespace Cb\Api\Transformers\V1;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_activated' => $this->is_activated,
            'last_login' => $this->last_login,
            'is_superuser' => $this->is_superuser,
            'is_guest' => $this->is_guest,
            'cb_last_name' => $this->cb_last_name,
            'cb_gender' => $this->cb_gender,
            'cb_function' => $this->cb_function,
            'cb_telephone' => $this->cb_telephone,
            'activation_code' => $this->activation_code,
            'persist_code' => $this->persist_code,
            'reset_password_code' => $this->reset_password_code,
            'permissions' => $this->permissions,
            'activated_at' => $this->activated_at,
        ];
    }
}
