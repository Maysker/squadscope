<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialAuthController extends Controller
{
    public function redirectToXbox()
    {
        return Socialite::driver('xbox')
            ->scopes(['required_scope1', 'required_scope2'])
            ->redirect();
    }

    public function handleXboxCallback()
    {
        try {
            $xboxUser = Socialite::driver('xbox')->user();

            // Check if the user already exists in your database
            $user = User::where('email', $xboxUser->getEmail())->first();

            if ($user) {
                // If user exists, log them in
                Auth::login($user);
                return redirect('/')->with('status', 'Logged in successfully!');
            } else {
                // If user does not exist, create a new user
                $newUser = User::create([
                    'name' => $xboxUser->getName(),
                    'username' => $xboxUser->getNickname(),
                    'email' => $xboxUser->getEmail(),
                    'password' => Hash::make(uniqid()), // Generate a random password
                ]);

                Auth::login($newUser);
                return redirect('/')->with('status', 'Registration successful!');
            }
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function redirectToSteam()
    {
        return Socialite::driver('steam')
            ->scopes(['required_scope1', 'required_scope2'])
            ->redirect();
    }

    public function handleSteamCallback()
    {
        try {
            $steamUser = Socialite::driver('steam')->user();

            // Check if the user already exists in your database
            $user = User::where('email', $steamUser->getEmail())->first();

            if ($user) {
                // If user exists, log them in
                Auth::login($user);
                return redirect('/')->with('status', 'Logged in successfully!');
            } else {
                // If user does not exist, create a new user
                $newUser = User::create([
                    'name' => $steamUser->getName(),
                    'username' => $steamUser->getId(), // Assuming username is the Steam ID
                    'email' => $steamUser->getEmail(),
                    'password' => Hash::make(uniqid()), // Generate a random password
                ]);

                Auth::login($newUser);
                return redirect('/')->with('status', 'Registration successful!');
            }
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Something went wrong: '. $e->getMessage());
        }
    }

}


