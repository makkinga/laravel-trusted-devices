<x-mail::message>
# {{ $salutation }} {{ $user->name }}

{{ $bodyTop }}

{{ $device->user_agent }}

{{ $bodyBottom }}

<x-mail::button url="{{ route('trusted-devices.verify', ['device' => $device->id, 'token' => $verificationToken]) }}">
{{ $buttonText }}
</x-mail::button>

{{ $footer }}
</x-mail::message>
