<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Role;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        $users = User::all();
        return view('profile.index',compact('users'));
    }
    
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        //avatar画像の保存
        if($request->hasFile('avatar'))
        {
            $avatar = $request->file('avatar');
            $user = User::find(auth()->user()->id);
            $old = $user->avatar;
            // dd($old);
            if($user->avatar !== 'user_default.jpg')
            {
                $oldPath = parse_url($old, PHP_URL_PATH);
                Storage::disk('s3')->delete($oldPath);
            }      
            $path = Storage::disk('s3')->putFile('user',$avatar,'public');     
            //s3に画像をUPロード
            $url = Storage::disk('s3')->url($path);
            $request->user()->avatar = $url;
            // dd($request->user()->avatar);
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function adedit(User $user)
    {
        $admin = true;
        $roles = Role::all();

        return view('profile.edit',
        [
            'user' => $user,
            'admin' => $admin,
            'roles' => $roles
        ]);
    }

    public function adupdate(User $user, Request $request)
    {
        $inputs = $request->validate([
            'name' => ['string','max:255'],
            'email' => ['email','max:255', Rule::unique(User::class)->ignore($user)],
            'avatar' => ['image', 'max:1024']
        ]);
        //avatar画像の保存
        if($request->hasFile('avatar'))
        {
            $avatar = $request->file('avatar');
            $old = $user->avatar;
            // dd($old);
            if($user->avatar !== 'user_default.jpg')
            {
                $oldPath = parse_url($old, PHP_URL_PATH);
                Storage::disk('s3')->delete($oldPath);
            }      
            $path = Storage::disk('s3')->putFile('user',$avatar,'public');     
            //s3に画像をUPロード
            $url = Storage::disk('s3')->url($path);
            $request->user()->avatar = $url;
        }
        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->save();

        return Redirect::route('profile.adedit',compact('user'))->with('status','profile-updated');
    }

    public function addestroy(User $user)
    {
        $old = $user->avatar;
        if($user->avatar !== 'user_default.jpg')
            {
                $oldPath = parse_url($old, PHP_URL_PATH);
                Storage::disk('s3')->delete($oldPath);
            }
        $user->roles()->detach();
        $user->delete();
        return back()->with('message','ユーザーを削除しました');
    }
}
