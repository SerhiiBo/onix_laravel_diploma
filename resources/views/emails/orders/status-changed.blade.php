@component('mail::message')

# Order status changed!

## Hello, {{ $user->name  }}

## Status of your order № {{ $order->id }} has been changed to {{ $order->status }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
