@component('mail::message')
# {{ $content->subject }}
<br>
{{ $content->message }}.
<hr>
<code>You can replay to me on {{ $content->email }}</code>
<br>
Thanks,<br>
{{ $content->name }}
@endcomponent
