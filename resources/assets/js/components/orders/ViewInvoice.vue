<template>
	<div class="row">
		<div class="col-md-12">
			<div class="clearfix mb-4 mt-4">
				<a :href="'/admin/order/'+invoice.order_id+'/details'" class="float-right"><i class="fa fa-chevron-left"></i>&nbsp;Back to Order Details</a>
			</div>
			<div class="card mb-0">
				<div class="card-body">
					<template v-if="loading">
						<center class="mt-5 mb-5">
							<half-circle-spinner
	                            :animation-duration="1000"
	                            :size="45"
	                            color="#ff1d5e"
	                          />
						</center>
					</template>
					<template v-else>
						<div id="printAdminInvoice" ref="printInvoice">
						<!-- <div class="row mb-4">
							<div class="col-md-6">
								<img src="/images/logo.jpg" width="220" height="120">
							</div>
							<div class="col-md-6">
								<table class="table order-table">
									<tr>
										<td align="right"><b>INFINITY FIGHTGEAR</b></td>
									</tr>
									<tr>
										<td align="right">Bunlo, Mac Arthur Hi-way, 2500 Bocaue, Bulacan</td>
									</tr>
									<tr>
										<td align="right">0998-790-1118</td>
									</tr>
								</table>
							</div>
						</div> -->
						<div class="clearfix mb-4">
							
								<img src="/images/logo.jpg" class="float-left" width="220" height="120">
							
							<div style="width: 600px;" class="float-right">
								<table class="table order-table">
									<tr>
										<td align="right"><b>INFINITY FIGHTGEAR</b></td>
									</tr>
									<tr>
										<td align="right">Bunlo, Mac Arthur Hi-way, 2500 Bocaue, Bulacan</td>
									</tr>
									<tr>
										<td align="right">0998-790-1118</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="clearfix mb-4">
							<div class="float-left" style="width: 45%;">
								<table class="table order-table">
									<tr>
										<th>Customer</th>
									</tr>
									<tr>
										<td>{{ customer.first_name+' '+customer.last_name }}</td>
									</tr>
									<tr>
										<td>{{ customer.street }}</td>
									</tr>
									<tr>
										<td>{{ customer.barangay+', '+customer.municipality+', '+customer.province+', '+customer.zip_code }}</td>
									</tr>
									<tr v-if="customer.company != null">
										<td>{{ customer.company }}</td>
									</tr>
									<tr>
										<td>{{ customer.phone_number }}</td>
									</tr>
								</table>
							</div>
							<div class="float-right" style="width: 45%;">
								<table class="table order-table">
									<tr>
										<th width="70%" class="text-right">Invoice #:</th>
										<td align="left" width="20%">{{ invoice.id }}</td>
									</tr>
									<tr>
										<th class="text-right">Invoice Date:</th>
										<td align="left">{{ invoice.created_at }}</td>
									</tr>
									<tr>
										<th></th>
										<td></td>
									</tr>
									<tr>
										<th></th>
										<td></td>
									</tr>
									<tr>
										<th></th>
										<td></td>
									</tr>
								</table>

							</div>
						</div><!-- row -->
						<div class="mb-5">
							<table class="table table-bordered mb-0">
								<thead>
									<tr>
										<th>Product</th>
										<th>SKU</th>
										<th>Price</th>
										<th>Qty</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(product, index) in products" :key="index">
										<td>{{ product.product_name }}</td>
										<td>{{ product.product_sku }}</td>
										<td>&#x20B1;{{ product.price }}</td>
										<td>{{ product.quantity }}</td>
										<td>&#x20B1;{{ product.total }}</td>
									</tr>
								</tbody>
							</table>
							<table class="table">
								<tr>
									<th class="text-right">Subtotal:</th>
									<td width="30%" class="text-right">&#x20B1;{{ invoice.order.subtotal }}</td>
								</tr>
								<tr>
									<th class="text-right">Discount:</th>
									<td class="text-right">&#x20B1;{{ invoice.order.discount }}</td>
								</tr>
								<tr>
									<th class="text-right">Shipping Fee:</th>
									<td class="text-right">&#x20B1;{{ invoice.order.shipping_cost }}</td>
								</tr>
								<tr>
									<th class="text-right">Total:</th>
									<td class="text-right">&#x20B1;{{ invoice.order.total }}</td>
								</tr>
							</table>
						</div>
						<div class="mb-5">
							<table class="table order-table">
								<tr>
									<th>Order # {{ invoice.order.id }} details:</th>
								</tr>
								<tr>
									<td>Shipping Method: {{ invoice.order.shipping_method }}</td>
								</tr>
								<tr>
									<td>Payment Method: {{ invoice.order.payment_method }}</td>
								</tr>
							</table>
						</div>
						<div>
							<table class="table order-table">
								<tr>
									<th>Shipping Address:</th>
								</tr>
								<tr>
									<td>{{ invoice.order.first_name+' '+invoice.order.last_name }}</td>
								</tr>
								<tr>
									<td>{{ invoice.order.street }}</td>
								</tr>
								<tr>
									<td>{{ invoice.order.barangay+', '+invoice.order.municipal+', '+invoice.order.province+', '+invoice.order.zip_code }}</td>
								</tr>
								<tr v-if="invoice.order.company != null">
									<td>{{ invoice.order.company }}</td>
								</tr>
								<tr>
									<td>{{ invoice.order.phone_no }}</td>
								</tr>
							</table>
						</div>
						
						</div>
					</template>
				</div>
			</div><!-- card -->
			<div class="d-block mt-2">
				<button class="btn btn-dark ifg-btn float-right" v-print="'#printAdminInvoice'" title="Print Invoice"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>
	</div>
</template>
<script>
import { HalfCircleSpinner } from 'epic-spinners'

	export default {
		props: ['id'],
		data() {
			return {
				loading: false,
				invoice: [],
				products: [],
				customer: []
			}
		},
		components: {
			HalfCircleSpinner
		},
		methods: {
			getInvoice() {
				this.loading = true;
				axios.get('/api/order/'+this.id+'/invoice')
				.then((response) => {
					this.loading = false;
					this.invoice = response.data.invoice;
					this.products = response.data.order_products;
					this.customer = response.data.customer;
				})
				.catch((error) => {
					this.loading = false;
					console.log(error.response);
				});
			}
		},
		created() {
			this.getInvoice();
		}
	}
</script>