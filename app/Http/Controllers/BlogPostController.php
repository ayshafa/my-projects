<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::all();
        return view('blog-posts.index', compact('posts'));
    }
    
    public function create()
    {
        return view('blog-posts.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|boolean',
        ]);
    
        if ($request->hasFile('image')) {
            $image = $this->pushFile('tk', 'blog', $request->image);
             $validated['image'] = $image['name'];
        }
        BlogPost::create($validated);
    
        return redirect()->route('blog-posts.index')->with('success', 'Blog post created successfully.');
    }
    
    public function show(BlogPost $blogPost)
    {
        return view('blog-posts.show', compact('blogPost'));
    }
    
    public function edit(BlogPost $blogPost)
    {
        return view('blog-posts.edit', compact('blogPost'));
    }
    
    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|boolean',
        ]);
    
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($blogPost->image);
            $validated['image'] = $request->file('image')->store('images', 'public');
        }
        if ($request->hasFile('image')) {
            $image = $this->pushFile('tk', 'blog', $request->image);
             $validated['image'] = $image['name'];
        }
    
        $blogPost->update($validated);
    
        return redirect()->route('blog-posts.index')->with('success', 'Blog post updated successfully.');
    }
    
    public function destroy(BlogPost $blogPost)
    {
        Storage::disk('public')->delete($blogPost->image);
        $blogPost->delete();
    
        return redirect()->route('blog-posts.index')->with('success', 'Blog post deleted successfully.');
    }
    function pushFile($type = '', $folder = '', $file = '', $action = '', $curr_file = '') {
        $path = public_path('/assets/images/' . $folder);
        if ($curr_file != 'no-image.jpg' && $curr_file != 'no-image.png' && $action == 'update') {
            if ($curr_file != '') {
                if (\File::exists(public_path('assets/img/' . $path . '/' . $curr_file))) {
                    \File::delete(public_path('assets/img/' . $path . '/' . $curr_file));
                }
            }
        }

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $size = $file->getSize();
        $size = number_format($size / 1048576, 2) . ' MB';
        $name = $type . '_' . rand(1, 100000) . '.' . $file->extension();
        $file->move($path, $name);

        return ['name' => $name, 'size' => $size];
    }
}
