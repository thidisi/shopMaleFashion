@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('')
<p class="mg-bottom-0">Thân ái, <br>{{ config('app.name') }}</p>
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
"Nếu bạn gặp sự cố khi nhấp vào nút \":actionText\", hãy sao chép và dán đường dẫn phía dưới\n".
'lên trình duyệt web:',
[
'actionText' => $actionText,
]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
