<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ApiTester extends Component
{
    public function render()
    {
        return view('livewire.admin.api-tester', [
            'defaultApiKey' => config('app.api_key'),
            'defaultBaseUrl' => config('app.url') . '/api',
        ])->extends('layouts.admin')->section('content');
    }
}
