<x-mail::message>
# Order Created

Your order has been created!

- Order ID: {{ $order->id }}
- Customer: {{ $order->customer->name }}
- Created At: {{ $order->created_at->format('Y-m-d H:i:s') }}
- Products:

<x-mail::table>
    | Name          | Unit Price ($)  | Quantity |
    | ------------- |:---------------:| :--------:|
    @foreach ($order->products as $product)
        | {{ $product->name }}| $ {{ $product->price }} | {{ $product->pivot->quantity }}|<br>
    @endforeach
</x-mail::table>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
