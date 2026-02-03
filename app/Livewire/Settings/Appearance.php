<?php

namespace App\Livewire\Settings;

use Livewire\Component;

class Appearance extends Component
{
    public function render()
    {
        $view = view('livewire.settings.appearance');

        if (str_starts_with(request()->path(), 'admin/')) {
            return $view->extends('layouts.admin')->section('content');
        }

        return $view;
    }
}
