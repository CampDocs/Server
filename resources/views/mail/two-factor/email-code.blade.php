<x-mail::message>
# {{ trans('Hello!') }}

{{ trans('Your code to activate two factor is:') }}

# {{ $code }}

{{ trans("It will be valid for only 3 minutes, if it doesn't work please check your email again, as you will receive a new code.") }}

{{ trans('Thanks') }}, {{ config('app.name', 'CampDocs') }}
</x-mail::message>
