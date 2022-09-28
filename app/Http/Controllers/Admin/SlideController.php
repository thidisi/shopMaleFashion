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

    public function __construct()
    {
        $this->model = Slide::query();
        $this->table = (new Slide)->getTable();
    }

    public function index()
    {
        $slides = Slide::leftJoin('major_categories', 'slide.major_category_id', '=', 'major_categories.id')
            ->latest('slide.created_at')
            ->select('major_categories.name as menu', 'slide.*')->paginate(3);

        foreach ($slides as $each) {
            $each->sort_order = $each->sort_order_name;
            $each->status = $each->status_name;
        }
        return view('backend.slide.index', [
            'slides' => $slides
        ]);
    }

    public function create()
    {
        $sortOrder = SortOrderSlideEnum::getKeys();
        $menu = Major_Category::where('status', '!=', MenuStatusEnum::HOT_DEFAULT)->get();
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

        $status = $request->input('status') ? '1' : '2';
        $arr = $request->validated();
        $arr['image'] = json_encode($data);
        $arr['status'] = $status;

        $this->model->create($arr);
        return redirect()->route('admin.slides')->with('addSlideSuccess', 'Add successfully!!');
    }

    public function edit(Slide $slide)
    {
        $sortOrder = SortOrderSlideEnum::getKeys();
        $menu = Major_Category::where('status', '!=', MenuStatusEnum::HOT_DEFAULT)->get();
        return view('backend.slide.edit', [
            'each' => $slide,
            'sortOrder' => $sortOrder,
            'menu' => $menu,
        ]);
    }

    public function update(UpdateSlideRequest $request, $slideId)
    {
        $slide = $this->model->find($slideId);
        $slide->title = $request->input('title');
        $slide->slug = $request->input('slug');
        $slide->major_category_id = $request->input('major_category_id');
        $slide->sort_order = $request->input('sort_order');
        $slide->status = $request->input('status') ? '1' : '2';

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
    }

    public function destroy($slideId)
    {
        Slide::destroy($slideId);
        return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
    }
}
