@component('mail::message')
# {{ $store->user->name }}

Your store "{{ $store->name }}" created on {{ date('d-m-Y',strtotime($store->created_at)) }}.
<br>

You can access your store once it's active and approved by admin. You can login via below link to access your store and know about the status that it's approved or not.

@component('mail::button', ['url' => route('seller.login.page')])
    {{__('Login to seller portal')}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
