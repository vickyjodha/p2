<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $rules = array(
            'email' => 'required|email|exists:login,email',
            'password' => 'required|min:6'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return sendError($validator->errors()->all());
        }
        $email = $request->email;
        $person = Person::with(['user'=> function ($query) use($email) {
            $query->where('email','=', $email);
        }])
        ->first();
        if (!Hash::check($request->password, $person->user->pass)) {
            return sendError('Password wrong', 401);
        }
        $token = $person->createToken(Config('app.name'))->accessToken;
        $data = [
            'id'=>$person->id,
            'name' => $person->name,
            'email'=>$person->user->email??null,
            'token' => $token,
        ];
        return sendResponse('User login successfully.', 200, $data);
    }
    function logout(Request $request)
    {
        $user = $request->user();
        $user->token()->revoke();
        return sendResponse('User logout successful');
    }
    function userInfo(Request $request)
    {
        $user = $request->user();
        if (blank($user)) {
            return sendError('User Not Found', 404);
        }
        $person = Person::with('user', 'address', 'address.state', 'address.state.country')->where('id', $user->id)->first();
        $data = [
            'id' => $person->id,
            'name' => $person->name,
            'address' => $person->address ?? null,
        ];
        return sendResponse('User login successfully.', 200, $data);
    }
}
