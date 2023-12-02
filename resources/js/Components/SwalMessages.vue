<script>

export default {
	methods:{
		swalConfirmDelete(){
			return this.$swal({
				title: 'Are you sure?',
				text: 'You won\'t be able to revert this!',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			});
		},
		swalDeleted(){
			this.$swal(
				'Deleted!',
				'Your record has been deleted.',
				'success'
			);
		}
	}
};

</script>
