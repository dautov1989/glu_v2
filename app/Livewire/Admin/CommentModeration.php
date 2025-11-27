<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class CommentModeration extends Component
{
    use WithPagination;

    public $filter = 'pending'; // pending, approved, all

    public function approve($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->update(['is_approved' => true]);

        session()->flash('message', 'Комментарий одобрен!');
    }

    public function reject($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();

        session()->flash('message', 'Комментарий удалён!');
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function render()
    {
        $query = Comment::with(['user', 'post']);

        if ($this->filter === 'pending') {
            $query->where('is_approved', false);
        } elseif ($this->filter === 'approved') {
            $query->where('is_approved', true);
        }

        $comments = $query->latest()->paginate(20);

        return view('livewire.admin.comment-moderation', [
            'comments' => $comments,
            'pendingCount' => Comment::where('is_approved', false)->count(),
        ]);
    }
}
