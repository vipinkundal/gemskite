<template>
  <Head :title="'Manage Product'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Inward Entry
      </h1>
    </div>
    <div class="row">
      <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
          <vue-table-component
            :key="Math.random()"
            :columns="inwardEntryColumns"
            :rows="inwardEntry"
            :sort-by-api="false"
          >
            <template #emptystate>
              {{ 'No record found' }}
            </template>
          </vue-table-component>
        </div>
      </div>
    </div>

    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Outward Entry
      </h1>
    </div>
    <div class="row">
      <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
          <vue-table-component
            :key="Math.random()"
            :columns="outwardEntryColumns"
            :rows="outwardEntry"
            :sort-by-api="false"
          >
            <template #emptystate>
              {{ 'No record found' }}
            </template>
          </vue-table-component>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueTableComponent from '../table-component.vue';
export default {
	components: {
		VueTableComponent
	},
	props:['inwardEntry', 'outwardEntry'],
	data() {
		return {
			uSearchBy:'',
			sortBy:'',
			sortType:'',
			items:[],
			inwardEntryColumns:[
				{
					label: 'Date of Inbound',
					field: 'inbound_date',
					sorting:false
				},
				{
					label: 'Quantity',
					field: 'QTY',
					sorting:false
				},
				{
					label: 'Supplier',
					field: 'supplier',
					sorting:false
				},
				{
					label: 'Location',
					field: 'location',
					sorting:false
				},
				{
					label: 'Invoice Number',
					field: 'import_invoice_number',
					sorting:false
				},
				{
					label: 'Container Number',
					field: 'container_number',
					sorting:false
				},
			],
			outwardEntryColumns:[
				{
					label: 'Dispatch Time',
					field: 'dispatch_time',
					sorting:false
				},
				{
					label: 'Quantity',
					field: 'QTY',
					sorting:false
				},
				{
					label: 'Invoice Number',
					field: 'invoice_number',
					sorting:false
				},
				{
					label: 'Ship to Party',
					field: 'ship_to_party',
					sorting:false
				},
				{
					label: 'Bill to Party',
					field: 'bill_to_party',
					sorting:false
				},
				{
					label: 'Vehicle Number',
					field: 'vehicle_number',
					sorting:false
				},
				{
					label: 'Destination Code',
					field: 'destination_code',
					sorting:false
				},
				{
					label: 'LR Number',
					field: 'lr_number',
					sorting:false
				},
			]
		};
	},
	methods: {

	}
};

</script>
<style>
.border-radius-0 {
    border-radius: 0 !important;
}
</style>
