<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DeleteUserForm extends Component
{
    public function deleteUser()
    {
        $user = Auth::user();
        $user->delete();

        return redirect('/')->with('status', 'Account deleted successfully!');
    }

    public function render()
    {
        return view('livewire.profile.delete-user-form');
    }
}