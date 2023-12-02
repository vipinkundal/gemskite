<template>
  <Head :title="'Manage Product'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Inward Entry Report
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
            :rows="InwardEntry"
            :sort-by-api="true"
            @sort="sortInwaredEntry"
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
                    :href="'/report/inward-entry-items?id=' +slotProps.row.id"
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
			sortAttr: {
				'InwardEntry': { field: null, type: null },
			},
			InwardEntry: [],
			uSearchBy:'',
			sortBy:'',
			sortType:'',
			Columns:[
				{
					label: 'Date of inbound',
					field: 'inbound_date',
				},
				{
					label: 'Supplier',
					field: 'supplier',
				},

				{
					label: 'Location',
					field: 'location',
				},
				{
					label: 'Invoice Number',
					field: 'import_invoice_number'
				},
				{
					label: 'Container Number',
					field: 'container_number',
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
		this.getInwardEntry();
	},
	methods: {
		sortInwaredEntry(sortBy, sortType) {
			this.sortAttr['InwardEntry'].field = sortBy;
			this.sortAttr['InwardEntry'].type = sortType;
			this.getInwardEntry();
		},
		getInwardEntry() {
			this.$axios.get('/api/master/get-inwared-entry-list?sortBy='+this.sortAttr.InwardEntry.field+'&sortType='+this.sortAttr.InwardEntry.type).then(resp => {
				this.InwardEntry = resp.data.success.inward_entry;
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
