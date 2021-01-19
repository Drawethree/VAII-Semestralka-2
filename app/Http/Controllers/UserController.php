<?php

namespace App\Http\Controllers;

use Aginev\Datagrid\Datagrid;
use App\Models\Article;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::paginate(10);

        $datagrid = new Datagrid($users, $request->get('f', []));

        $datagrid->setColumn('name', 'Full name')
            ->setColumn('role_id', 'Role', [
                'wrapper' => function ($value, $row) {
                    return $row->role->title;
                }
            ])
            ->setColumn('email', 'Email Address')
            ->setColumn('username', 'Username')
            ->setColumn('created_at', 'Registered', [
                'wrapper' => function ($value, $row) {
                    return $value;
                }
            ])
            ->setActionColumn(['wrapper' => function ($value, $row) {
                if ($row->username != 'admin') {
                    return '
                    <a class="btn btn-sm btn-primary" href="' . route('user.edit', [$row->id]) . '" title="Edit"><i class="fa fa-edit">&nbsp;</i>Edit</a>
                    <a class="btn btn-sm btn-danger" onclick=" return confirm(\'Are you sure?\') " href="' . route('user.delete', [$row->id]) . '" title="Delete"><i class="fa fa-trash">&nbsp;</i>Delete</a>';
                } else {
                    //not admin user
                    //return '<p class="text-danger">You cannot modify admin</p>';
                }
            }]);

        return view('user.index', [
            'grid' => $datagrid,
            'users' => $users
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create', [
            'action' => route('user.store'),
            'method' => 'post'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:32', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = User::create($request->all());
        $user->save();
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->password = '';

        return view('user.edit', [
            'action' => route('user.update', $user->id),
            'method' => 'put',
            'model' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:32', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        $user->update($request->all());

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();

            Image::make($avatar)->resize(300, 300)->save(public_path('/uploads/avatars/' . $filename));

            $user->avatar = $filename;
            $user->save();
        }

        return redirect()->route('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        $user->articles()->delete();

        return redirect()->route('user.index');
    }
}
