@extends('frontend.frontend_template')

@section('store_header')
@include('frontend.customer.navbar_myaccount')
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="{{ route('frontend_homepage') }}">Home</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Order Details</li>
			  </ol>
			</nav>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-3">
			@include('frontend.customer.list_bar')
		</div>
		<div class="col-md-9">
			<h2>Order Details</h2>
			<div class="card">
				<div class="card-body">
					@if ($order->order_shipping_method == 'Shipping')
						@if ($order->order_status == "Pending payment")
							@if ($order->order_payment_method == 'Bank Deposit')
							<div class="clearfix">
								<h4 class="float-left pt-2">Order #{{ $order->number }}</h4>
								@if (!$order->cancelOrderRequest)
									<cancel-order-by-customer :order="{{ $order }}"></cancel-order-by-customer>
									@if (!$order->bankDepositSlip)
										<a href="/order/{{$order->number}}/upload-deposit-slip" class="btn btn-dark float-right mr-1">Upload Deposit Slip</a>
									@endif
								@endif
							</div>
							@endif
						@elseif ($order->order_status == "Processing")
						<div class="clearfix">
							<h4 class="float-left pt-2">Order #{{ $order->number }}</h4>
							@if (!$order->cancelOrderRequest)
								<a href="/order/{{$order->number}}/cancellation" class="btn btn-danger float-right">Cancel Order</a>
							@endif
						</div>
						@elseif ($order->order_status == "Shipped")
						<div class="clearfix">
							<h4 class="pt-2 float-left">Order #{{ $order->number }}</h4>
							<customer-receive-order :order="{{$order}}"></customer-receive-order>
						</div>
						@endif
					@else
						@if ($order->order_status == "For pickup" && $order->order_payment_method == 'Cash')
						<div class="clearfix">
							<h4 class="float-left pt-2">Order #{{ $order->number }}</h4>
							<cancel-order-by-customer :order="{{ $order }}"></cancel-order-by-customer>
						</div>
						@endif
					@endif
					@if ($order->order_status == "Cancelled")
						<div>
							<h4 class="pt-2">Order #{{ $order->number }}</h4>
						</div>
					@elseif ($order->order_status == "Completed")
						<div class="clearfix">
							<h4 class="float-left pt-2">Order #{{ $order->number }}</h4>
							@if ($isReturnDatePassed == 0)
								@if (!$order->returnRequest)
								<a href="/order/{{$order->number}}/request-return" class="btn btn-dark mr-1 float-right">Return</a>
								@endif
							@endif
						</div>
					@endif
					<!-- /header card --> 
					<div class="row mt-4">
						<div class="col-md-6">
							<table class="table order-table">
								<tr>
									<td width="50%">Placed on:</td>
									<td>{{ $order->order_created }}</td>
								</tr>
								<tr>
									<td>Total:</td>
									<td>&#8369;{{ $order->order_total }}</td>
								</tr>
								<tr>
									<td>Shipping Method:</td>
									<td>{{ $order->order_shipping_method }}</td>
								</tr>
								<tr>
									<td>Payment Method:</td>
									<td>{{ $order->order_payment_method }}</td>
								</tr>
								<tr>
									<td>Payment Status:</td>
									<td>{{ $order->order_payment_status }}</td>
								</tr>
								<tr>
									<td>Status:</td>
									<td>{{ $order->order_status }}</td>
								</tr>
							</table>
						</div>
						<div class="col-md-6">
							@if ($order->order_shipping_method == "Shipping")
							<table class="table order-table">
								<tr>
									<th class="text-right">Shipping Address</th>
								</tr>
								<tr>
									<td align="right">{{ $order->shipping->shipping_firstname.' 
									 '.$order->shipping->shipping_lastname }}</td>
								</tr>
								<tr>
									
									<td align="right">{{ $order->shipping->shipping_street }}</td>
								</tr>
								<tr>
									
									<td align="right">{{ $order->shipping->shipping_barangay.', '.$order->shipping->shipping_municipality.', '.$order->shipping->shipping_province.', '.$order->shipping->shipping_zip_code }}</td>
								</tr>
								<tr>
									<td align="right">{{ $order->shipping->shipping_mobile_no }}</td>
								</tr>
							</table>
							@endif
						</div>
					</div><!-- row -->
					<div class="mt-4">
						<h5 class="mb-3">Ordered Products</h5>
						<table class="table table-striped mb-0">
							<thead>
								<tr>
									<th width="50%">Product(s)</th>
									<th>Price</th>
									<th>Quantity</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($order->orderProducts as $orderProd)
								<tr>
									<td>
										<img src="/storage/products/{{$orderProd->inventory->product->product_image}}" class="img-fluid" width="20%" height="13%">
										<span class="align-middle">{{ $orderProd->product_name }}</span>
									</td>
									<td class="align-middle">&#8369;{{ $orderProd->price }}</td>
									<td class="align-middle">{{ $orderProd->quantity }}</td>
									<td class="align-middle">&#8369;{{ $orderProd->total }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<table class="table mb-4">
							<tr>
								<th class="text-right">Subtotal:</th>
								<td width="30%" class="text-right">&#8369;{{ $order->order_subtotal }}</td>
							</tr>
							@if ($order->order_shipping_method == 'Shipping')
							<tr>
								<th class="text-right">Shipping fee:</th>
								<td class="text-right">&#8369;{{ number_format($order->order_shipping_fee,2) }}</td>
							</tr>
							@endif
							<tr>
								<th class="text-right">Total:</th>
								<td class="text-right">&#8369;{{ $order->order_total }}</td>
							</tr>
						</table>
					</div>
				</div>
			</div><!-- card -->
		</div>
	</div>

</div>
@endsection