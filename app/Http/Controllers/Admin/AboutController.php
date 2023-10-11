<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAboutRequest;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function __construct(About $about)
    {
        $this->about = $about;
        $this->table = (new About)->getTable();
    }

    public function index()
    {
        $about = $this->about->firstOrFail();
        return view('backend.abouts.index', [
            'each' => $about
        ]);
    }

    public function update(UpdateAboutRequest $request, $aboutId)
    {
        // try {
            $about = $this->about->findOrFail($aboutId);

            $about->title = $request->get('title');
            $about->email = $request->get('email');
            $about->phone = $request->get('phone');
            $about->phone_second = $request->get('phone_second') ? $request->get('phone_second') : null;
            $about->address = $request->get('address');
            $about->address_second = $request->get('address_second') ? $request->get('address_second') : 'During the update';
            $about->branch = $request->get('branch');
            $about->branch_second = $request->get('branch_second') ? $request->get('branch_second') : 'During the update';
            $about->link_address_fb = $request->get('link_address_fb') ? $request->get('link_address_fb') : 'During the update';
            $about->link_address_youtube = $request->get('link_address_youtube') ? $request->get('link_address_youtube') : 'During the update';
            $about->link_address_zalo = $request->get('link_address_zalo') ? $request->get('link_address_zalo') : 'During the update';
            $about->link_address_instagram = $request->get('link_address_instagram') ? $request->get('link_address_instagram') : 'During the update';

            $nameAvatar = null;
            if ($request->hasFile('logo_new')) {
                if ($request->file('logo_new')->isValid()) {
                    $nameAvatar = Storage::disk('public')->put('logoShop', $request->file('logo_new'));
                }
            }
            if ($nameAvatar == '') {
                $nameAvatar = $request->get('logo_old');
            }
            $about->logo = $nameAvatar;
            if (is_numeric($aboutId) && $aboutId > 0) {
                $about->update();
                return redirect()->route("admin.abouts")->with('EditAboutSuccess', 'Edit successfully!!');
            } else {
                if (Storage::disk('public')->exists($nameAvatar)) {
                    Storage::disk('public')->delete($nameAvatar);
                }
                return redirect()->route('admin.abouts')->with('EditAboutErrors', 'Edit Failed Blog table');
            }
        // } catch (\Throwable $th) {
        //     return redirect()->route('index');
        // }
    }
}
