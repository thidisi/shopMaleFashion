@extends('backend.layout_admin')
@php
$title = 'Contacts';
@endphp
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-0 p-1 text-gray-800">Contacts Seen Mail</h1>
        @empty(!session('seenMailSuccess'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('seenMailSuccess') }}
            </div>
        @endempty
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.contacts.putSeenMail', $each->id) }}" method="post" id="seend-mail">
                        @csrf
                        <div id="content-feedback">
                            <div class="border border-secondary p-3" style="font-size: 1rem;color: black;">
                                <p><em>Hello {{ $each->name }},</em></p>
                                <p><em>Thank you for suggesting this -- this sounds like a great idea.</em></p>
                                <p><em>I’ll be passing this onto our internal teams and see how we can develop this
                                        further.</em></p>
                                <p><em>To extend our thanks, I’d like to share some <a href="{{ route('shop') }}">Shop</a>.
                                        Please continue to
                                        share
                                        your thoughts with us, we love them.&nbsp;</em></p>
                                <p><em>Thank you !.<br>
                                        Shop Male Fashion;<br>
                            </div>
                        </div>
                        <div class="mt-3">
                            <textarea id="ckeditor-feedback" class="form-control" name="messages" rows="12"
                                placeholder="Enter some brief about blog..">
                                </textarea>
                        </div>
                        <div class="mt-3">
                            @if ($each->status == ACTIVE)
                                <div onclick="alert('This user was emailed')" class="ml-1 btn btn-success float-right">Email Sent</div>
                            @else
                                <button type="submit" class="ml-1 btn btn-danger float-right">Seen Mail</button>
                            @endif
                            <a href="{{ route('admin.contacts') }}" class="float-right btn btn-info">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            var editor = CKEDITOR.replace('ckeditor-feedback');
            var content = $('#content-feedback');
            editor.setData(content.html());
            editor.on('change', function(e) {
                var val = editor.getData();
                content.html(val);
            });
            $('#seend-mail').on("submit", function(e) {
                if(confirm("Are you sure you want to send an email?") != true) {
                    e.preventDefault();
                    return false;
                }
                return true;
            })
        });
    </script>
@endpush
