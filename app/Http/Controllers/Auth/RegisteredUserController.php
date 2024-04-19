<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'avatar' => ['image','max:1024'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $attr = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        if($request->hasFile('avatar'))
        {
            $avatar = $request->file('avatar');
        //$requestからimageファイルを取得
            $path = Storage::disk('s3')->putFile('user',$avatar,'public');
        //s3に画像をUPロード
            $url = Storage::disk('s3')->url($path);
            $attr['avatar'] = $url;
        }

        $user = User::create($attr);

        event(new Registered($user));

        //役割付与
        $user->roles()->attach(2);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
