<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuStatusEnum;
use App\Enums\NameStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\About;
use App\Models\Blog;
use App\Models\Major_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    private object $model;

    public function __construct()
    {
        $this->model = Blog::query();
        $this->table = (new Blog)->getTable();
    }

    public function index()
    {
        $blogs = $this->model->latest()->paginate(5);
        return view('backend.blogs.index', [
            'blogs' => $blogs
        ]);
    }

    public function view()
    {
        $blogs = Blog::where('status', '=', NameStatusEnum::ACTIVE)
            ->latest('created_at')
            ->paginate(9);
        return view('frontend.blogs.index', [
            'blogs' => $blogs,
        ]);
    }

    public function detail(Blog $blog)
    {
        return view('frontend.blogs.detail', [
            'blog' => $blog,
        ]);
    }

    public function create()
    {
        return view('backend.blogs.create');
    }

    public function store(StoreBlogRequest $request)
    {
        $path = Storage::disk('public')->put('imageBlog', $request->file('image'));
        $status = $request->input('status') ? '1' : '2';
        $arr = $request->validated();
        $arr['image'] = $path;
        $arr['status'] = $status;

        $this->model->create($arr);
        return redirect()->route('admin.blogs')->with('addBlogsSuccess', 'Add successfully!!');
    }

    public function edit(Blog $blog)
    {
        return view('backend.blogs.edit', [
            'each' => $blog
        ]);
    }

    public function update(UpdateBlogRequest $request, $blogId)
    {
        $blog = $this->model->find($blogId);
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->status = $request->input('status') ? '1' : '2';

        $nameAvatar = null;
        if ($request->hasFile('photo_new')) {
            if ($request->file('photo_new')->isValid()) {
                $nameAvatar = Storage::disk('public')->put('imageBlog', $request->file('photo_new'));
            }
        }
        if ($nameAvatar == '') {
            $nameAvatar = $request->input('photo_old');
        }
        $blog->image = $nameAvatar;
        if (is_numeric($blogId) && $blogId > 0) {
            $blog->update();
            return redirect()->route("admin.blogs")->with('EditBlogStatus', 'Edit successfully!!');
        } else {
            if (Storage::disk('public')->exists($nameAvatar)) {
                Storage::disk('public')->delete($nameAvatar);
            }
            return redirect()->route('admin.blogs')->with('BlogErrors', 'Edit Failed Blog table');
        }
    }

    public function destroy($blogId)
    {
        Blog::destroy($blogId);
        return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
    }
}
