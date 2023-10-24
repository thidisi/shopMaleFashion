<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function index()
    {
        $blogs = $this->blog->latest('created_at')->paginate(5);
        return view('backend.blogs.index', [
            'blogs' => $blogs
        ]);
    }

    public function view()
    {
        $blogs = $this->blog->where('status', '=', BLOG::BLOG_STATUS['ACTIVE'])
            ->latest('created_at')
            ->paginate(9);
        return view('frontend.blogs.index', [
            'blogs' => $blogs,
        ]);
    }

    public function detail(Blog $blog)
    {
        $data['previous'] = $this->blog->find($blog->id - 1);
        $data['next'] = $this->blog->find($blog->id + 1);
        if (Cookie::has('blog-view' . $blog->id) == false) {
            $blog->count_view += 1;
            $blog->save();
            Cookie::queue(Cookie::make('blog-view' . $blog->id, $blog->id, 1));
        }
        return view('frontend.blogs.detail', [
            'blog' => $blog,
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('backend.blogs.create');
    }

    public function store(StoreBlogRequest $request)
    {
        try {
            $path = Storage::disk('public')->put('imageBlog', $request->file('image'));
            $status = $request->input('status') ? BLOG::BLOG_STATUS['ACTIVE'] : BLOG::BLOG_STATUS['INACTIVE'];
            $arr = $request->validated();
            $arr['image'] = $path;
            $arr['status'] = $status;
            $arr['slug'] = Str::slug($request->input('title'), '-');
            $this->blog->create($arr);
            return redirect()->route('admin.blogs')->with('addBlogsSuccess', 'Add successfully!!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('AddAttrStatusErr', 'Add error!!');
        }
    }

    public function edit(Blog $blog)
    {
        return view('backend.blogs.edit', [
            'each' => $blog
        ]);
    }

    public function update(UpdateBlogRequest $request, $blogId)
    {
        try {
            $blog = $this->blog->find($blogId);
            $blog->title = $request->input('title');
            $blog->slug = Str::slug($request->input('title'), '-');
            $blog->content = $request->input('content');
            $blog->status = $request->input('status') ? BLOG::BLOG_STATUS['ACTIVE'] : BLOG::BLOG_STATUS['INACTIVE'];

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
        } catch (\Throwable $th) {
            return redirect()->back()->with('EditAttrStatusErr', 'Edit error!!');
        }
    }

    public function destroy($blogId)
    {
        try {
            $this->blog->destroy($blogId);
            return redirect()->back()->with('deleteSuccess', 'Deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('EditAttrStatusErr', 'Edit not successfully!!');
        }
    }
}
