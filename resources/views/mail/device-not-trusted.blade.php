@component('mail::message')
# {{ $salutation }} {{ $user->name }}

{{ $bodyTop }}

{{ $device->user_agent }}

{{ $bodyBottom }}

@component('mail::button', ['url' => route('trusted-devices.verify', ['device' => $device->id, 'token' => $verificationToken])])
{{ $buttonText }}
@endcomponent

{{ $footer }}
@endcomponent