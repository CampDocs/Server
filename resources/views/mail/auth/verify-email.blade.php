<x-mail::message>
# {{ trans('Hello!') }}

{{ trans('Please click the button below to verify your email address.') }}

<x-mail::button :url="$url" color="green">
{{ trans('Verify Email Address') }}
</x-mail::button>

{{ trans('If you did not create an account, no further action is required.') }}

{{ trans('Thanks') }}, {{ config('app.name', 'CampDocs') }}

<x-slot:subcopy>
{{ trans("If you're having trouble clicking the :action button, copy and paste the URL below into your web browser:", [
    'action' => trans('Verify Email Address')
]) }} <span class="break-all">[{{ $url }}]({{ $url }})</span>
</x-slot:subcopy>

</x-mail::message>
