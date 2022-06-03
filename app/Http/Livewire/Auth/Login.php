<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $title = "Login";
    public $username;
    public $password;

    protected $rules = [
        'username' => 'required',
        'password' => 'required',
    ];

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth');
    }

    public function authenticate(Request $request)
    {
        $credential = $this->validate();

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();

            return redirect()->intended('/admin/kost');
        }
    }
}
