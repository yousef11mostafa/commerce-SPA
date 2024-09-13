<x-mail::message>
# Introduction

The body of your message.

{{-- The body of your message. --}}
hellow {{ $username }} you registerd in our E-commerce-website successfully

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
