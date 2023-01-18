<x-mail::message>
# {{ trans('Hello!') }}

{{ trans('You are receiving this email because we received a password reset request for your account.') }}

<x-mail::button :url="$url" color="green">
{{ trans('Reset Password') }}
</x-mail::button>

{{ trans('This password reset link will expire in :count minutes.', [
    'count' => $count
]) }}

{{ trans('If you did not request a password reset, no further action is required.') }}

{{ trans('Thanks') }}, {{ config('app.name', 'CampDocs') }}

<x-slot:subcopy>
{{ trans("If you're having trouble clicking the :action button, copy and paste the URL below into your web browser:", [
    'action' => trans('Reset Password')
]) }} <span class="break-all">[{{ $url }}]({{ $url }})</span>
</x-slot:subcopy>

</x-mail::message>
