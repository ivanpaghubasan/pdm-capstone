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
			    <li class="breadcrumb-item"><a href="{{ route('customer.orders') }}">My Orders</a></li>
			    <li class="breadcrumb-item"><a href="{{ route('customer_address') }}">Addresses</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Edit Address</li>
			  </ol>
			</nav>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-3">
			@include('frontend.customer.list_bar')
		</div>
		<div class="col-md-9">
			<edit-customer-address 
				:customer="{{ Auth::guard('customer')->user() }}"
				:provinces="{{$provinces}}"
				:municipalities="{{$municipalities}}"
				:barangays="{{$barangays}}"
				:address="{{$address}}">
			</edit-customer-address>
		</div>
	</div>

</div>
@endsection