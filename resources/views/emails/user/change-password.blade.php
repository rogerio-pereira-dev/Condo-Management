<x-mail::message>
# Hello {{ $user->name }}

Hello you requested to change you password in {{ config('app.name') }}.
If you didn't requested that change, please ignore this email.

<x-mail::button :url="$url">
Change Password
</x-mail::button>

<hr>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
