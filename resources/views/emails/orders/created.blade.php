@component('mail::message')

# Order created
## Hello {{ $user->name }}
### Your order  № {{ $order->id }}.

@component('mail::table')

Details of your order:
|Product`s name    |Quantity                     |           Price          |
|:---              |           :---:             |                     ----:|
@foreach ($products as $product )
|{{$product->name}}|{{$product->pivot->quantity}}|{{$product->pivot->price}}|
@endforeach
||<b>Total price:  |<b>{{$totalPrice}}|

Comment to order: {{$order->comment}}
@endcomponent


### Manager will contact you to clarify the details

Thanks,<br>
{{ config('app.name') }}
@endcomponent
