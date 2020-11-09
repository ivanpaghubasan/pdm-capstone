@component('mail::message')	

# Hi {{ $order->customer->first_name }},

Hope you're doing well. This is just to remind your payment for Order #{{$order->number}}.

Make your payment directly into our bank account. Kindly use your Order #{{ $order->number }} as the payment reference.

Your order has been reserved within {{ $due_date['days'] }} business days until {{ $due_date['date'] }}.

Once your payment has been received we will start processing your order.
 
# Details
<ul>
	<li>Bank Name: <b>{{ $bank_account->bank_name }}</b></li>
	<li>Account Name: <b>{{ $bank_account->first_name.' '.$bank_account->last_name }}</b></li>
	<li>Account Number: <b>{{ $bank_account->number }}</b></li>
</ul>

# Order #: {{ $order->number }}
# Placed on: {{ $order->order_created }}
# Total Payment: &#8369;{{ $order->order_total }}

@component('mail::button', ['url' => $url])
Order Details
@endcomponent

Thanks,<br>
{{ $company->name }}
@endcomponent
