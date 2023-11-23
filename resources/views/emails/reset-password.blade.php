<x-mail::message>
# Forget passwork

The body of your message.

<x-mail::button :url="$link">
Reset Your Passwork
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
