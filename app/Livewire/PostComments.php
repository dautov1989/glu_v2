<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Validate;

class PostComments extends Component
{
    public Post $post;

    #[Validate('required|string|max:1000')]
    public string $body = '';

    public function save(): void
    {
        $this->validate();

        $this->post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->body,
            'is_approved' => false, // Требует модерации
        ]);

        $this->body = '';

        session()->flash('comment_pending', true);
    }

    public function render()
    {
        return view('livewire.post-comments', [
            'comments' => $this->post->comments()
                ->with('user')
                ->approved() // Только одобренные
                ->latest()
                ->get(),
        ]);
    }
}
