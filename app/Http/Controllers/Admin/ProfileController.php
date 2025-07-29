<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Profile';
        $user = authUser();

        return view('profile.edit', compact('pageTitle', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (authUser()->isRegularAdmin()) {
            $request['email'] = authUser()->email;
        }
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                  'required',
                  'email:rfc,dns',
                  'string',
                  'max:255',
                  Rule::unique('users')->whereNull('deleted_at')->ignore(authUser()->id)
            ],
        ]);

        $user = $request->user();
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

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

        return redirect()->back()->withSuccess('Profile Updated Successfull');
    }

    public function updatePassword(Request $request)
    {
        return view('profile.change-password');
    }

    public function editProfile(Request $request)
    {
        return view('profile.edit-profile');
    }

    public function changePassword(Request $request)
    {

        $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()],
            'password_confirmation' => 'exclude_if:password_confirmation,null|same:password|min:8'
        ]);

        $user = authUser();

        if(!Hash::check($request->old_password, $user->password)){
            return back()->withErrors(["old_password" => "Old Password Doesn't match!"]);
        }
        
        $user->password = Hash::make($request['password']);
        $user->save();

        return redirect()->back()->withSuccess('Password changed successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
