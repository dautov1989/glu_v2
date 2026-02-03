<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryId = '';
    public $status = ''; // all, published, draft

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryId' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function deletePost($postId)
    {
        $post = Post::findOrFail($postId);
        $post->delete();

        session()->flash('message', 'Статья успешно удалена.');
    }

    public function render()
    {
        $query = Post::query()->with('category');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        if ($this->status === 'published') {
            $query->where('is_published', true);
        } elseif ($this->status === 'draft') {
            $query->where('is_published', false);
        }

        return view('livewire.admin.post-list', [
            'posts' => $query->latest()->paginate(20),
            'categories' => Category::has('posts')->orderBy('title')->get(),
        ])->extends('layouts.admin')->section('content');
    }
}
