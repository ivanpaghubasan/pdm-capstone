<template>
<span class="badge badge-danger" v-if="cancel_request_not_view">{{cancel_request_not_view}}</span>	
</template>
<script>
	export default {
		data() {
			return {
				cancel_request_not_view: null
			}
		},
		methods: {
			getCancelRequestNotView() {
				axios.get('/api/cancellation-request/not-view')
				.then((response) => {
					if (response.data.count > 0)
					{
						this.cancel_request_not_view = response.data.count;
					}
					else
					{
						this.cancel_request_not_view = null;
					}
				})
				.catch((error) => {
					console.log(error.response.status);
				});
			},
		},
		created() {
			this.getCancelRequestNotView();
			this.$bus.$on('update-cancel-badge', data => {
				if (data == true)
				{
					this.getCancelRequestNotView()
				}
			})
		}
	}
</script>