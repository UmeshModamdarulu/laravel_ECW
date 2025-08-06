@component('mail::message')
# {{ $details['greeting'] }}

{{ $details['firstline'] }}

{{ $details['body'] }}

@component('mail::button', ['url' => $details['url']])
{{ $details['button'] }}
@endcomponent

{{ $details['lastline'] }}

Thanks,<br>
{{ config('app.name') }}

@if(!empty($details['url']))
---
If you're having trouble clicking the "{{ $details['button'] }}" button, copy and paste the URL below into your web browser:  
[{{ $details['url'] }}]({{ $details['url'] }})
@endif
@endcomponent 