<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function add(Request $request)
    {

        $messages = [
            'name.required' 		=> 'name required.',
            'email.required' 		=> 'email required.',
            'email.email' 			=> 'email address must be correct.',
            'password.required'     => 'password required.',
            'password.string'       => 'password must be in string.',
            'role.required'         => 'role required.',
        ];

        $validation = [
            'name' 	=> 'required|string',
            'email' 	=> 'required|email',
            'password' 	=> 'required|string',
            'role' 	=> 'required',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

		if ($validator->fails()) {
			return response()->json([
                'error' => '1',
				'message' => $validator->messages()->all()
			], 400);
		}

        $user = User::where('email', $request->email)
        ->where('status', 'ACTIVE')->first();

        if ($user != null){
            return response()->json([
                'error' => '1',
                'message' => 'Email has been registered'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $user = new User();
            $user->email        = $request->email;
            $user->name         = $request->name;
            $user->password     = Hash::make($request->password);
            $user->role_id      = $request->role;
            $user->status      = 'ACTIVE';
            $user->save();

            DB::commit();

        }catch (\Throwable $e) {
            DB::rollback();

            return response()->json([
                'error' => '1',
                'message' => 'Register account was failed!'.$e->getMessage()
            ], 400);
        }

        return response()->json([
            'success' => '1',
            'message' => 'Account has been successfully registered.'
        ]);


    }

    public function update(Request $request, $id)
    {

        $messages = [
            'name.required' 		=> 'Name field is required.',
            'email.required' 		=> 'Email field is required.',
            'email.email' 			=> 'Email address must be correct.',
            'role.required'         => 'Role must be select.',
        ];

        $validation = [
            'name' 	=> 'required|string',
            'email' 	=> 'required|email',
            'role' 	=> 'required',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

		if ($validator->fails()) {
			return response()->json([
                'error' => '1',
				'message' => $validator->messages()->all()
			], 400);
		}

        $user = User::where('id', $id)->first();

        if ($user == null){
            return response()->json([
                'error' => '1',
                'message' => 'User not found.'
            ], 400);
        }

        $findUser = User::where('email', $request->email)
        ->whereNotIn('id', [$id])
        ->where('status', 'ACTIVE')->first();

        if ($findUser != null){
            return response()->json([
                'error' => '1',
                'message' => 'Email has been registered'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $user->email        = $request->email;
            $user->name         = $request->name;
            $user->role_id      = $request->role;
            $user->status      = 'ACTIVE';
            $user->save();

            DB::commit();

        }catch (\Throwable $e) {
            DB::rollback();

            return response()->json([
                'error' => '1',
                'message' => 'Update account was failed!'.$e->getMessage()
            ], 400);
        }

        return response()->json([
            'success' => '1',
            'message' => 'Account has been successfully updated.'
        ]);


    }

    public function password(Request $request, $id)
    {

        $messages = [
            'email.required'       => 'email required.',
            'password.required'       => 'password required.',
            'password.string'       => 'Password must be in string.',
            'password.confirmed'    => 'Password and Confirm Password are not the same.'
        ];

        $validation = [
            'email' 	=> 'required',
            'password' 	=> 'required|string|confirmed'
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

		if ($validator->fails()) {
			return response()->json([
                'error' => '1',
				'message' => $validator->messages()->all()
			], 400);
		}

        $user = User::where('id', $id)->where('email', $request->email)->first();

        if ($user == null){
            return response()->json([
                'error' => '1',
                'message' => 'Email and ID not matched.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $user->password     = Hash::make($request->password);
            $user->save();

            DB::commit();

        }catch (\Throwable $e) {
            DB::rollback();

            return response()->json([
                'error' => '1',
                'message' => 'Update account was failed!'.$e->getMessage()
            ], 400);
        }

        return response()->json([
            'success' => '1',
            'message' => 'Account has been successfully updated.'
        ]);


    }


    public function delete(Request $request)
    {

        $messages = [
            'id.required'       => 'User required',
            'email.required'    => 'email required',
        ];

        $validation = [
            'id'        => 'required',
            'email' 	=> 'required'
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

		if ($validator->fails()) {
			return response()->json([
                'error' => '1',
				'message' => $validator->messages()->all()
			], 400);
		}

        $user = User::where('id', $request->id)->where('email', $request->email)->first();

        if ($user == null){
            return response()->json([
                'error' => '1',
                'message' => 'Email and ID not matched.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $user->delete();

            DB::commit();

        }catch (\Throwable $e) {
            DB::rollback();

            return response()->json([
                'error' => '1',
                'message' => 'Delete account was failed!'.$e->getMessage()
            ], 400);
        }

        return response()->json([
            'success' => '1',
            'message' => 'Account has been successfully deleted.'
        ]);


    }

}
