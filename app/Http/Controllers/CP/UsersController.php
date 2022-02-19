<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use App\Models\UserRole;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::with('role:id,name','branchess:id,city')->orderBy('name');

        /*  Start search    */
        if ($request->search) {

            $this->validate($request, [
                'name' => 'nullable|string|max:32',
                'username' => 'nullable|string|max:32',
                'phone' => 'nullable|string|max:32',
                'role' => 'nullable|integer|min:1',
                'state' => 'nullable|boolean',
            ]);
            if ($request->name) {
                $query->where('name', 'Like', "%$request->name%");
            }
            if ($request->username) {
                $query->where('username', 'Like', "%$request->username%");
            }
            if ($request->phone) {
                $query->where('phone', 'Like', "%$request->phone%");
            }
            if ($request->role) {
                $query->where('role_id', $request->role);
            }
            if (!is_null($request->state)) {
                $query->where('active', $request->state);
            }
        }
        /*  End search    */

        $users = $query->get();
        $roles = UserRole::select('id', 'name')->get();
        $branches = Branch::select('id','city')->get();
        return view('CP.users', [
            'users' => $users,
            'roles' => $roles,
            'branches' => $branches,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateData();
        $user = new User();
        $this->setData($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate(request(), [
            'id' => 'required|integer|min:1',
        ]);
        $this->validateData(true);
        $user = User::findOrFail($request->id);
        $this->setData($user);
    }

    private function validateData($update = false)
    {
        $this->validate(request(), [
            'name' => 'required|string|min:3|max:32',
            'phone' => 'required|string|min:3|max:14|unique:users' . ($update ? ',phone,' . request('id') : ''),
            'username' => 'required|string|min:3|max:32|unique:users' . ($update ? ',username,' . request('id') : ''),
            'password' => ($update ? 'nullable' : 'required') . '|string|min:6|max:32',
            'branches' => 'required|integer',
            'role' => 'required|integer|exists:user_roles,id',
            'active' => 'required|boolean',
        ]);
    }

    private function setData($user)
    {
        $request = request();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->branches_id = $request->branches;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->role_id = $request->role;
        $user->active = $request->active;
        $user->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|string|min:6|max:32',
            'password' => 'required|string|min:6|max:32|confirmed',
        ]);
        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages(['كلمة المرور الحالية غير صحيحة']);
        }

        $user->password = bcrypt($request->password);
        $user->save();
    }

}
