<template>
  <Head :title="'Manage Product'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Outward Entry Report
      </h1>
    </div>
    <!-- <div class="row">
                    <div class="col-md-4 col-12">
                        <div :class="['d-flex mt-2', uSearchBy ? '':'mb-2']">
                        <input
                          v-model="uSearchBy"
                          autocomplete="off"
                          placeholder="Search product by SKU"
                          type="text"
                          class="form-control bg-white  border-radius-0"
                            @keyup.enter="getProduct"
                        >
                         <span
                          id="search"
                          role="button"
                          class="input-group-text border-radius-0 btn-primary"
                          @click="getProduct"
                        >Search
                        </span>
                       </div>
                        <button
                        v-if="uSearchBy"
                        class="ms-0 btn mt-0 pt-0  ps-0 btn-link mb-0"
                        @click="clearFitler"
                      >
                       Clear Filter
                      </button>
                    </div>
                    </div> -->
    <div class="row">
      <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
          <vue-table-component
            :key="Math.random()"
            :columns="Columns"
            :rows="OutwardEntry"
            :sort-by-api="true"
            @sort="sortOutwardEntry"
          >
            <template
              #table-row="slotProps"
            >
              <span v-if="slotProps.column.field==='actions'">
                <div class="d-flex">

                  <a
                    type="button"
                    class="btn btn-primary me-2"
                    target="_blank"
                    :href="'/report/outward-entry-items?id=' +slotProps.row.id"
                  >
                    <vue-feather type="list" />
                  </a>
                  <!-- <button type="button" class="btn btn-danger" @click="deleteProduct(slotProps.row)">
                                        <vue-feather type="trash-2"></vue-feather>
                                    </button> -->
                </div>
              </span>
              <span v-else>{{ slotProps.row[slotProps.column.field] }}</span>
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
	data() {
		return {
			OutwardEntry: [],
			uSearchBy:'',
			sortAttr: {
				'InwardEntry': { field: null, type: null },
			},
			Columns:[
				{
					label: 'Dispatch Date Time',
					field: 'dispatch_time',
				},
				{
					label: 'Invoice Number',
					field: 'invoice_number',
				},

				{
					label: 'Ship To Party',
					field: 'ship_to_party',
				},
				{
					label: 'Bill To Party',
					field: 'bill_to_party'
				},
				{
					label: 'Vehicle Number',
					field: 'vehicle_number',
				},
				{
					label: 'Destination Code',
					field: 'destination_code',
				},
				{
					label: 'LR Number',
					field: 'lr_number',
				},
				{
					label: 'Total Items',
					field: 'total_items',
				},
				{
					label: 'Item List',
					field: 'actions',
					sorting: false
				},
			],
		};
	},
	mounted(){
		this.getOutwardEntry();
	},
	methods: {
		sortOutwardEntry(sortBy, sortType) {
			this.sortAttr['InwardEntry'].field = sortBy;
			this.sortAttr['InwardEntry'].type = sortType;
			this.getOutwardEntry();
		},
		getOutwardEntry() {
			this.$axios.get('/api/master/get-outward-entry-list?sortBy='+this.sortAttr.InwardEntry.field+'&sortType='+this.sortAttr.InwardEntry.type).then(resp => {
				this.OutwardEntry = resp.data.success.outward_entry;
			});
		}
	}
};
</script>
<style>
.border-radius-0 {
    border-radius: 0 !important;
}
</style>
