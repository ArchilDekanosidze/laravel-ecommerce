<x-mail::message>
# Verify Your email

Dear {{$name}}

The body of your message.

<x-mail::button :url="$link">
Verify Your email
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
