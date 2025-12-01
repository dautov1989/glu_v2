<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of posts
     */
    public function index(Request $request)
    {
        $query = Post::with('category');

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by published status
        if ($request->has('is_published')) {
            $query->where('is_published', $request->boolean('is_published'));
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $posts = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created post
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        // Generate slug from title
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        // Auto-generate excerpt if not provided
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($data['content']), 200);
        }

        // Auto-generate meta fields if not provided
        if (empty($data['meta_title'])) {
            $data['meta_title'] = Str::limit($data['title'], 60);
        }

        if (empty($data['meta_description'])) {
            $data['meta_description'] = Str::limit(strip_tags($data['content']), 160);
        }

        // Download and save image if URL provided
        if (!empty($data['image_url'])) {
            $imagePath = $this->downloadImage($data['image_url']);
            if ($imagePath) {
                $data['image'] = $imagePath;
            }
            unset($data['image_url']);
        }

        // Set default published status to false (draft)
        if (!isset($data['is_published'])) {
            $data['is_published'] = false;
        }

        // Set published_at if publishing
        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post = Post::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully',
            'data' => new PostResource($post->load('category'))
        ], 201);
    }

    /**
     * Display the specified post
     */
    public function show($id)
    {
        $post = Post::with('category')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new PostResource($post)
        ]);
    }

    /**
     * Update the specified post
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $data = $request->validated();

        // Update slug if title changed
        if (isset($data['title']) && $data['title'] !== $post->title) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $post->id);
        }

        // Download and save image if URL provided
        if (!empty($data['image_url'])) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $imagePath = $this->downloadImage($data['image_url']);
            if ($imagePath) {
                $data['image'] = $imagePath;
            }
            unset($data['image_url']);
        }

        // Set published_at when publishing
        if (isset($data['is_published']) && $data['is_published'] && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully',
            'data' => new PostResource($post->load('category'))
        ]);
    }

    /**
     * Remove the specified post
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Delete image if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);
    }

    /**
     * Generate unique slug from title
     */
    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = Post::where('slug', $slug);

            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            if (!$query->exists()) {
                break;
            }

            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Download image from URL and save to storage
     */
    private function downloadImage($url)
    {
        try {
            $contents = file_get_contents($url);

            if ($contents === false) {
                return null;
            }

            // Get file extension from URL or content type
            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (empty($extension)) {
                $extension = 'jpg';
            }

            // Generate unique filename
            $filename = 'posts/' . Str::random(40) . '.' . $extension;

            // Save to storage
            Storage::disk('public')->put($filename, $contents);

            return $filename;
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to download image: ' . $e->getMessage());
            return null;
        }
    }
}
