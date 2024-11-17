<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Category;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Blog::orderBy('blog_id', 'asc')->paginate(6);
        return view('blog.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'content' => 'required',
            'image_path' => 'nullable|image|max:2048',
            'status' => 'required|in:pending,approved',
        ]);

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('images', 'public');
            $validated['image_path'] = $imagePath;
        }

        Blog::create($validated);

        return redirect()->route('blog.index')->with('success', 'Bài viết đã được tạo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog_id)
    {
        $blog = Blog::findOrFail($blog_id);
        return view('blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        // Lấy danh sách tất cả danh mục
        $categories = Category::all();

        // Trả về view với dữ liệu
        return view('blog.edit', [
            'blog' => $blog, // Đây là instance của Blog được tìm thấy qua route model binding
            'categories' => $categories
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'content' => 'required',
            'image_path' => 'nullable|image|max:2048',
            'status' => 'required|in:pending,approved',
        ]);

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('images', 'public');
            $validated['image_path'] = $imagePath;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',

        ]);

        $blog->update($validated);



        return redirect()->route('blog.index')->with('success', 'Bài viết đã được cập nhật.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blog.index')->with('success', 'Bài viết đã được xóa.');
    }
}
