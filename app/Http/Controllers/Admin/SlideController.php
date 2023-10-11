<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuStatusEnum;
use App\Enums\SortOrderSlideEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use App\Models\Major_Category;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    private object $model;

    public function __construct(Slide $slide, Major_Category $major_category)
    {
        $this->slide = $slide;
        $this->major_category = $major_category;
    }

    public function index()
    {
        $slides = $this->slide->with('major_categories')->latest('created_at')->paginate(3);
        return view('backend.slide.index', [
            'slides' => $slides
        ]);
    }

    public function create()
    {
        $sortOrder = Slide::SLIDE_ORDER;
        $menu = $this->major_category->where('status', '!=', Major_Category::MENU_STATUS['HOT_DEFAULT'])->get();
        return view('backend.slide.create', [
            'sortOrder' => $sortOrder,
            'menu' => $menu,
        ]);
    }

    public function store(StoreSlideRequest $request)
    {
        if ($request->hasFile('fileData')) {
            $images = $request->file('fileData');
            foreach ($images as $image) {
                $path = Storage::disk('public')->put('imageSlide', $image);
                $data[] = $path;
            }
        }

        $arr = $request->validated();
        $arr['image'] = json_encode($data);

        $this->slide->create($arr);
        return redirect()->route('admin.slides')->with('addSlideSuccess', 'Add successfully!!');
    }

    public function edit(Slide $slide)
    {
        $sortOrder = Slide::SLIDE_ORDER;
        $menu = $this->major_category->where('status', '!=', Major_Category::MENU_STATUS['HOT_DEFAULT'])->get();
        return view('backend.slide.edit', [
            'each' => $slide,
            'sortOrder' => $sortOrder,
            'menu' => $menu,
        ]);
    }

    public function update(UpdateSlideRequest $request, $slideId)
    {
        try {
            $slide = $this->slide->findOrFail($slideId);
            $slide->title = $request->input('title');
            $slide->slug = $request->input('slug');
            $slide->major_category_id = $request->input('major_category_id');
            $slide->sort_order = $request->input('sort_order');
            $slide->status = $request->input('status') ? Slide::SLIDE_STATUS['ACTIVE'] : Slide::SLIDE_STATUS['INACTIVE'];

            $nameImage = null;
            if ($request->hasFile('fileDataNew')) {
                if ($request->file('fileDataNew')) {
                    $images = $request->file('fileDataNew');
                    foreach ($images as $image) {
                        $path = Storage::disk('public')->put('imageSlide', $image);
                        $nameImage[] = $path;
                    }
                }
            }
            if ($nameImage == '') {
                $nameImage = $request->input('fileDataOld');
            }
            $slide->image = $nameImage;
            if (is_numeric($slideId) && $slideId > 0) {
                $slide->update();
                return redirect()->route("admin.slides")->with('EditSlideStatus', 'Edit successfully!!');
            } else {
                if (Storage::disk('public')->exists($nameImage)) {
                    Storage::disk('public')->delete($nameImage);
                }
                return redirect()->route('admin.slides')->with('SlideErrors', 'Edit Failed Slide table');
            }
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }

    public function destroy($slideId)
    {
        try {
            $this->slide->destroy($slideId);
            return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }
}
