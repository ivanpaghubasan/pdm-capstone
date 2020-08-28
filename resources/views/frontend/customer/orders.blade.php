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
			    <li class="breadcrumb-item active" aria-current="page">My Orders</li>
			  </ol>
			</nav>
		</div>
	</div>	
	<div class="row">
		<div class="col-3">
			@include('frontend.customer.list_bar')
		</div>
		<div class="col-md-9">
			<div class="mb-5">
				<h3 class="mb-4">Orders</h3>
				<table class="table table-condensed table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Order No.</th>
							<th>Date Order</th>
							<th>Status</th>
							<th>Total</th>
							<th>Details</th>
						</tr>
					</thead>
					<tbody>
						@if (count($orders) > 0)
							@foreach ($orders as $order)
							<tr>
								<td>{{$order->number}}</td>
								<td>{{$order->order_created}}</td>
								<td>{{$order->order_status}}</td>
								<td>&#8369;{{$order->order_total}}</td>
								<td><a href="{{ route('customer.view_order', ['order'=> $order->number]) }}" class="btn btn-sm btn-primary">View</a></td>
							</tr>
							@endforeach
						@else
						<tr>
							<td colspan="5" align="center">No order history.</td>
						</tr>
						@endif
					</tbody>
				</table>
				{{$orders->links()}}
			</div>
		</div>
	</div>

</div>
@endsection