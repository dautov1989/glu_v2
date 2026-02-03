<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;

class PostEdit extends Component
{
    public ?Post $post = null;

    // Form fields
    public $category_id = '';
    public $title = '';
    public $slug = '';
    public $excerpt = '';
    public $content = '';
    public $image = '';
    public $is_published = false;
    public $meta_title = '';
    public $meta_description = '';
    public $meta_keywords = '';

    protected function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|min:3|max:255',
            'slug' => 'required|string|unique:posts,slug,' . ($this->post?->id ?? 'NULL'),
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string|min:10',
            'image' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    public function mount(Post $post = null)
    {
        if ($post && $post->exists) {
            $this->post = $post;
            $this->category_id = $post->category_id;
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->excerpt = $post->excerpt;
            $this->content = $post->content;
            $this->image = $post->getRawOriginal('image'); // Get raw value if needed
            $this->is_published = (bool) $post->is_published;
            $this->meta_title = $post->meta_title;
            $this->meta_description = $post->meta_description;
            $this->meta_keywords = $post->meta_keywords;
        } else {
            $this->is_published = false;
        }
    }

    public function updatedTitle($value)
    {
        if (empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $data = $this->validate();

        if ($this->post && $this->post->exists) {
            if ($this->is_published && !$this->post->is_published) {
                $data['published_at'] = now();
            }
            $this->post->update($data);
            session()->flash('message', 'Статья успешно обновлена.');
        } else {
            if ($this->is_published) {
                $data['published_at'] = now();
            }
            $post = Post::create($data);
            return redirect()->route('admin.posts.edit', $post);
        }
    }

    public function deletePost()
    {
        if ($this->post && $this->post->exists) {
            $this->post->delete();
            session()->flash('message', 'Статья удалена.');
            return redirect()->route('admin.posts');
        }
    }

    public function render()
    {
        return view('livewire.admin.post-edit', [
            'categories' => Category::orderBy('title')->get(),
        ])->extends('layouts.admin')->section('content');
    }
}
