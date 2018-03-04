<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Auth;
use App\Services\RoleService;
use App\Services\UserService;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->modelService = $userService;
        $this->roleService = $roleService;
        $this->messageModel = trans('models.user');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create()
    {
        $roles = $this->roleService->lists();
        $postAction = route('register.save');
        $actionMethod = 'POST';

        return view('user.edit', [
            'user' => null,
            'postAction' => $postAction,
            'actionMethod' => $actionMethod,
            'roles' => $roles,
            'pageTitle' => 'New account',
            'back_button_action' => route('logout'),
        ]);
    }

    public function save(UserRequest $request)
    {
        if($request['generatePassword'] == 1)
            $pass = str_random(8);
        else
            $pass = $request['password'];

        $request['password'] = \Hash::make($pass);

        $user = User::create($request->except('_token'));
      
        if(Auth::user()->hasPermissionTo('change role'))
            $user->assignRole(Role::findOrFail($request['role_id']));
        else
            $user->assignRole(Role::findOrFail(2));
        // if($user)
        // Mail::to($request['email'])->send(new NewAccount($user, $pass));     
          return redirect()->route('logout')->withSuccess(trans('actions.created', ['object' => $this->messageModel]));
    }
}
