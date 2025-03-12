<x-mail::message>
    # You have been invited to join {{ $invitation->invitable->name }}

    Click the button below to create your account

    <x-mail::button :url="$url">Create Account</x-mail::button>

    <p>This invitation will expire in 7 days.</p>

    <p>Thanks,</p>

    {{ config('app.name') }}

</x-mail::message>
