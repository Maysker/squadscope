<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $user;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function save()
    {
        $this->validate([
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        if ($this->password) {
            $this->user->password = bcrypt($this->password);
        }

        $this->user->save();

        session()->flash('message', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
