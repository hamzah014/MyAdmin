<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

	public function login(Request $request){

		$messages = [
            'email.required' 	=> "Email Required",
            'password.required' => trans('message.password.required'),
		];

		$validation = [
			'email' 	=> 'required|email',
			'password' 	=> 'required|string',
		];

        $request->validate($validation, $messages);

        $user = User::where('email', $request->email)->first();

		if ($user == null){
			return response()->json([
                'error' => '1',
                'message' => 'Email or password is not valid!'
            ], 400);
		}

        try {

            DB::beginTransaction();

            if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {

                //GENERETATE NEW TOKEN
                $token = $user->generateToken();

                $user->remember_token = $token;
                $user->save();

                DB::commit();

                return response()->json([
                    'success' => '1',
                    'message' => 'Login successfully.',
                    'data' => array(
                        'access_token' 	=> $token,
                        'token_type' 	=> 'Bearer',
                    )
                ]);

            }else{
                return response()->json([
                    'error' => '1',
                    'message' => 'Email or password invalid!'
                ], 400);
            }


        } catch (\Throwable $e) {
            DB::rollback();

            return response()->json([
                'error' => '1',
                'message' => 'Login account was failed!'.$e->getMessage()
            ], 400);
        }


    }


	public function logout(Request $request){

		$messages = [
            'email.required' 	=> "Email Required"
		];

		$validation = [
			'email' 	=> 'required|email'
		];

        $request->validate($validation, $messages);

        $user = User::where('email', $request->email)
                ->first();

		if ($user == null){
			return response()->json([
                'error' => '1',
                'message' => 'Email or password is not valid!'
            ], 400);
		}

        try {

            DB::beginTransaction();

            $user->remember_token = "";
            $user->save();

            Auth::guard()->logout();

            DB::commit();

            return response()->json([
                'success' => '1',
                'message' => 'Logout successfully.'
            ]);


        } catch (\Throwable $e) {
            DB::rollback();

            return response()->json([
                'error' => '1',
                'message' => 'Logout account was failed!'.$e->getMessage()
            ], 400);
        }


    }
}
