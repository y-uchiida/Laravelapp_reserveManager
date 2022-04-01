<?php

namespace App\Http\Controllers;

class LivewireTestController extends Controller
{
    public function index()
    {
        return view('livewire-test.index');
    }

    public function register()
    {
        return view('livewire-test.register');
    }
}
