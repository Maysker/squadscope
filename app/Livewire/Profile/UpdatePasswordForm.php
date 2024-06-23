<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordForm extends Component
{
    public $current_password;
    public $password;
    public $password_confirmation;

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($this->current_password, $user->password)) {
            session()->flash('error', 'Current password does not match.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->password),
        ]);

        session()->flash('status', 'Password updated successfully!');
    }

    public function render()
    {
        return view('livewire.profile.update-password-form');
    }
}