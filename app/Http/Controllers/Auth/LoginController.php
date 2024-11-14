<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return $this->username;
    }

    public function index(){
        return view('auth.login');
    }

    public function logout(){

		$user = Auth::user();

        Auth::guard()->logout();

        return redirect()->route('login.index');
    }

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

		if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {

			return response()->json([
				'success' => '1',
				'redirect' => route('dashboard.index'),
				'message' => 'Successfully Login. Welcome to '. env('APP_NAME') .'.'
			]);

		}else{
			return response()->json([
                'error' => '1',
                'message' => 'Email or password invalid!'
            ], 400);
		}

    }

}
