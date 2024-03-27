<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Fungsi untuk redirect ke halaman oauth
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Fungsi untuk handle callback dari google
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $existingAccount = User::query()
                ->where('email', $user->email)
                ->where('google_id', $user->id)
                ->first();

            if ($existingAccount) {
                Auth::login($existingAccount);
            } else {
                $pass = Str::random(16);
                $data = [
                    'google_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => bcrypt($pass)
                ];

                $newUser = User::create($data);
                Auth::login($newUser);
            }

            return redirect()->route('user.home')->with('success', 'Berhasil login!');
        } catch (\Exception $e) {
            return redirect('login')->with('error', 'Gagal login menggunakan Google');
        }
    }
}
