<?php


namespace App\Http\Controllers\Admin;

use App\Enums\MenuStatusEnum;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Models\About;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Major_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    private object $model;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;

    }

    public function index()
    {
        $contacts = $this->contact->latest('created_at')->paginate(5);
        return view('backend.contacts.index', [
            'contacts' => $contacts
        ]);
    }

    public function view()
    {
        return view('frontend.contacts.index');
    }

    public function seenMail(Contact $contact)
    {
        return view('backend.contacts.feedback', [
            'each' => $contact
        ]);
    }

    public function putSeenMail(Request $request, Contact $contact)
    {
        // hoan lai
        // $message = [
        //     'body' => $request->messages,
        //     'subject' => 'ShopMaleFashion gửi thông báo cho bạn'
        // ];
        // $users[]['email'] = $contact->email;
        // $contact->status = ACTIVE;
        // $contact->save();
        // SendEmail::dispatch($message, $users)->delay(now()->addMinute(1));
        return redirect()->back()->with('seenMailSuccess', 'Seen Mail successfully!!');
    }

    public function store(Request $request)
    {
        $arr = $request->validate([
            'name' => "required|min:2|max:255",
            'email' => 'required|email',
            'message' => 'required',
        ]);
        $arr['status'] = NOT_ACTIVE;
        $this->contact->create($arr);
        return redirect()->back()->with('success', 'Get messages successfully!!');
    }
}
