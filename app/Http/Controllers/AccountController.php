<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function show(Request $request)
    {
        return $request->user();
    }

    public function update(AccountRequest $request)
    {
        $data = $request->validated();

        $user = $request->user();

        if (! empty($data['password'])) {
            $user->password = bcrypt($data['password']);
            unset($data['password']);
            $user->save();
        }

        return tap($request->user())
            ->update($data);
    }
}
