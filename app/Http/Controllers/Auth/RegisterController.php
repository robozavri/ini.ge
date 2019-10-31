<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Temporaryuser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers {
        register as Tregister;
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'pasport_id' => ['required', 'numeric','digits:11', 'unique:users','unique:temporaryusers'],
            'name' => ['required', 'string', 'max:255'],
            'surename' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255' ,'unique:users'],
        ]);
    }

    protected function Codevalidator(array $data)
    {
        return Validator::make($data, [
            'code' => ['required', 'numeric' ,'exists:temporaryusers,code'],
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        return redirect('/code/confirmation')->with('msg','გთხოვთ შეიყვანოთ ელ.ფოსტაზე გამოგზავნილი კოდი');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Temporaryuser
     */
    protected function create(array $data)
    {

        $code = rand(10000,99999);

        $user = Temporaryuser::create([
            'pasport_id' => $data['pasport_id'],
            'name' => strip_tags($data['name']),
            'surename' => strip_tags($data['surename']),
            'email' => $data['email'],
            'code' => $code,
        ]);

        try {
            \Mail::send('emails.singup', ['user' => $user,'code' => $code], function ($m) use ($user) {
               $m->from('ini@ini.ge', 'ini');
               $m->to($user->email,'ini.ge sign up')->subject('Sign up!');
           });
        } catch (\Exception $e) {
             return;
        }

    }

    public function ShowCodeForm()
    {
        return view('codeForm');
    }

    public function CodeConfirmation(Request $request)
    {
        $this->Codevalidator($request->all())->validate();
        $Temporaryuser = Temporaryuser::where('code',$request->code)->first();

        if(is_null(User::where('pasport_id',$Temporaryuser->pasport_id)->first()))
        {
            $user = User::create([
                'pasport_id' => $Temporaryuser->pasport_id,
                'name' => $Temporaryuser->name,
                'surename' => $Temporaryuser->surename,
                'email' => $Temporaryuser->email
            ]);

            if($user)
            {
              $Temporaryuser->delete();
            }
        }

        $this->guard()->login($user);
        return redirect('/tasks');

    }
}
