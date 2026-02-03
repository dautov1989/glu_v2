<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, admin, user

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function toggleAdmin($userId)
    {
        $user = User::findOrFail($userId);

        // Prevent self-demotion if the current user is modifying themselves
        if ($user->id === auth()->id() && $user->is_admin) {
            session()->flash('error', 'Вы не можете лишить себя прав администратора.');
            return;
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        session()->flash('message', "Права пользователя {$user->name} обновлены.");
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter === 'admin') {
            $query->where('is_admin', true);
        } elseif ($this->filter === 'user') {
            $query->where('is_admin', false);
        }

        return view('livewire.admin.user-list', [
            'users' => $query->latest()->paginate(20),
        ])->extends('layouts.admin')->section('content');
    }
}
