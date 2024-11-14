<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Services\DropdownService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{

    public function index()
    {

        $dropdownService = new DropdownService();
		$user = Auth::user();

        return view('user.index',
        compact(
            'dropdownService'
        ));

    }

    public function adminDatatable(Request $request)
    {

        $dropdownService = new DropdownService();

        $user = Auth::user();

        $query = User::orderBy('id','desc')
                ->get();

        return DataTables::of($query)
            ->addColumn('indexNo', function($row) use(&$count) {

                $count++;

                return $count;
            })
            ->editColumn('role', function($row) {

                $result = $row->role ? $row->role->name : "-";

                return $result;
            })
            ->editColumn('role', function($row) {

                $result = $row->role ? $row->role->name : "-";

                return $result;
            })
            ->addColumn('action', function($row) use($user) {

                $routeView = route('admin.edit',[$row->id]);

                $result = '<a class="btn btn-sm btn-secondary cursor-pointer" href="'.$routeView.'"><i class="fa fa-eye text-dark"></i> View</a>';

                if($user->role->id == 1)
                {
                    $result .= '<button type="button" class="btn btn-sm btn-danger cursor-pointer mx-5" onclick="deleteUser(\'' . $row->id . '\',\'' . $row->email . '\')"><i class="fa fa-trash text-light"></i> Delete</button>';
                }

                return $result;
            })
            ->rawColumns(['indexNo','role','action'])
            ->make(true);

    }

    public function create()
    {
        $dropdownService = new DropdownService();
        $roles = $dropdownService->roleUser();

        return view('user.create',compact(
            'roles'
        ));


    }

    public function add(Request $request)
    {

        $messages = [
            'name.required' 		=> 'Name field is required.',
            'email.required' 		=> 'Email field is required.',
            'email.email' 			=> 'Email address must be correct.',
            'password.required'     => 'Password field is required.',
            'password.string'       => 'Password must be in string.',
            'password.confirmed'    => 'Password and Confirm Password are not the same.',
            'role.required'         => 'Role must be select.',
        ];

        $validation = [
            'name' 	=> 'required|string',
            'email' 	=> 'required|email',
            'password' 	=> 'required|string|confirmed',
            'role' 	=> 'required',
        ];
        $request->validate($validation, $messages);


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
            'redirect' => route('admin.index'),
            'message' => 'Account has been successfully registered.'
        ]);


    }

    public function edit($id)
    {
        $dropdownService = new DropdownService();
        $roles = $dropdownService->roleUser();

        $user = User::where('id', $id)->first();
        $superAdmin = false;

        if(Auth::user()->role->id == 1)
        {
            $superAdmin = true;
        }

        return view('user.edit',compact(
            'roles','user','superAdmin'
        ));


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
        $request->validate($validation, $messages);

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

            $user = User::where('id', $id)->first();

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
            'redirect' => route('admin.index'),
            'message' => 'Account has been successfully updated.'
        ]);


    }

    public function password(Request $request, $id)
    {

        $messages = [
            'password.string'       => 'Password must be in string.',
            'password.confirmed'    => 'Password and Confirm Password are not the same.'
        ];

        $validation = [
            'password' 	=> 'required|string|confirmed'
        ];
        $request->validate($validation, $messages);

        try {
            DB::beginTransaction();

            $user = User::where('id', $id)->first();
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
            'redirect' => route('admin.index'),
            'message' => 'Account has been successfully updated.'
        ]);


    }


    public function delete(Request $request)
    {

        $messages = [
            'id.required'       => 'User required',
        ];

        $validation = [
            'id' 	=> 'required'
        ];
        $request->validate($validation, $messages);

        try {
            DB::beginTransaction();

            $user = User::where('id', $request->id)->first();
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
            'redirect' => route('admin.index'),
            'message' => 'Account has been successfully deleted.'
        ]);


    }

}
