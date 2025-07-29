<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class UserController extends Controller
{
    public function index(Request $request)
    {
        // $users = User::where('type', '=', 'admin')->paginate(20);
        $pageTitle = 'Admin - View Users';
        $query = User::query()->admins()->where('id', '!=', authUser()->id);

        if ($request->exists('s')) {
            $query = $query->when($request->get('s') ?? false,function($query, $search){
                $query->where(function($q) use ($search){
                    $q->where('first_name', 'like',  '%'.$search.'%')
                        ->orWhere('last_name', 'like',  '%'.$search.'%')
                        ->orWhere('email', 'like',  '%'.$search.'%');
                });
            });
        }

        if ($request->filled('type')) {
            $query = $query->where('type', $request->type);
        }

        $users = $this->paginateQuery($request, $query);

        $filters = [
            's' => $request->s,
            'page' => $request->page,
            'per_page' => $request->per_page
        ];

        return view('admin.users.index', compact('users', 'pageTitle', 'filters'));
    }

    public function create(User $user)
    {
        $pageTitle = 'Admin - Create User';

        return view('admin.users.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user = null)
    {
        try {
            // dd($request->file('profile_picture')->getClientOriginalName());
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => [
                      'required',
                      'email:rfc,dns',
                      'string',
                      'max:255',
                      Rule::unique('users')->whereNull('deleted_at')
                ],
                'type' => 'required',
                // 'profile_picture' => 'image|mimes:jpeg,jpg,png,gif|max:1024',
                'password' => ['required', 'confirmed', Password::min(8)->numbers()],
                'password_confirmation' => 'required|same:password|min:8',
            ]);


            $user = new User();
            // $request['type'] = authUser()->type;
            $request['type'] = $request->type;
            if(array_key_exists('password',$request->all())) {
              $request['password'] = Hash::make($request['password']);
            }
            $user->created_by = authUser()->id;
            $user->fill($request->all());
            $user['active'] = $request->has('active');

            if ($request->file('profile_picture')) {
                $fileInstance = $request->file('profile_picture');
                $fileName = $fileInstance->getClientOriginalName();
                $image_path = $request->file('profile_picture')->storeAs(
                    'profile_pictures',
                    $user->id . '-' . $fileName,
                    'public'
                );

                $user->profile_picture = $image_path;
            }

            $user->save();

            // return redirect()->route('admin.users.index')->withSuccess('User has been created successfully');
            return to_route('admin.users.index')->withSuccess('User has been created successfully');
        } catch (\DomainException $e) {
            return redirect()->back()
                        ->withError($e->getMessage());
        }
    }

    public function edit(User $user)
    {
        $pageTitle = 'Admin - Edit User';

        return view('admin.users.edit', compact('user','pageTitle'));
    }

    public function show(User $user)
    {
        $pageTitle = 'Admin - View User';

        return view('admin.users.view', compact('user','pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // dd($request->all());

        try {
             $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => [
                      'exclude_if:email,null',
                      'email:rfc,dns',
                      'string',
                      'max:255',
                      Rule::unique('users')->whereNull('deleted_at')->ignore($user->id)
                ],
                'type' => 'required',
                // 'password' => 'exclude_if:password,null|min:8|confirmed',
                // 'password_confirmation' => 'exclude_if:password_confirmation,null|same:password|min:8'
            ]);


            // if(array_key_exists('password',$request->all())) {

            // $user->fill($request->all());
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user['active'] = $request->has('active');
            $user->type = $request->type;
            // $user->save();

            // if($request->filled('password')) {
            //     $user->password = Hash::make($request['password']);
            // }

            if ($request->file('profile_picture')) {
                $fileInstance = $request->file('profile_picture');
                $fileName = $fileInstance->getClientOriginalName();
                $image_path = $request->file('profile_picture')->storeAs(
                    'profile_pictures',
                    $user->id . '-' . $fileName,
                    'public'
                );
                $user->profile_picture = $image_path;
            }

            // $user->save();


            if (!$request->input('has_dp')) {
                $user->profile_picture = null;
            }
            
            $user->save();

            // return redirect()->route('admin.users.index')->withSuccess('User has been updated successfully');
            return to_route('admin.users.index')->withSuccess('User has been updated successfully');
        } catch (\DomainException $e) {
            return redirect()->back()
                        ->withError($e->getMessage());
        }
    }

    public function changePassword(User $user)
    {
        return view('admin.users.change-password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->numbers()],
            'password_confirmation' => 'exclude_if:password_confirmation,null|same:password|min:8'
        ]);
        
        $user->password = Hash::make($request['password']);
        $user->save();

        // return redirect()->route('admin.users.index')->withSuccess('User password changed successfully!');
        return to_route('admin.users.index')->withSuccess('User password changed successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        // return redirect()->route('admin.users.index')
        return to_route('admin.users.index')
            ->withSuccess('User Deleted Successfully.');
    }


}
