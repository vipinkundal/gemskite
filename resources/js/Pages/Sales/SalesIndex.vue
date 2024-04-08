<template>
  <Head :title="'Manage sales'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Sales
      </h1>
    </div>
    <div class="mb-3 float-end">
      <!-- <Link
        class="sidebar-link"
        href="/sales/create"
      >
        <i
          class="align-middle"
        /> <span class="align-middle">Create</span>
      </Link> -->
    </div>
    <div class="row">
      <div class="col-md-4 col-12">
        <div :class="['d-flex mt-2', uSearchBy ? '':'mb-2']">
          <input
            v-model="uSearchBy"
            autocomplete="off"
            placeholder="Search sales by Name"
            type="text"
            class="form-control bg-white  border-radius-0"
            @keyup.enter="getSales"
          >
          <span
            id="search"
            role="button"
            class="input-group-text border-radius-0 btn-primary"
            @click="getSales"
          >Search By date
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
    </div>
    <div class="row">
      <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
          <vue-table-component
            :key="Math.random()"
            :columns="Columns"
            :rows="getSalesList"
            :sort-by-api="false"
          >
            <template
              #table-row="slotProps"
            >
              <span v-if="slotProps.column.field==='sku'">
                <div
                  v-if="slotProps.row.outward_entry_item.length"
                  class="d-flex"
                > {{ slotProps.row.outward_entry_item.map(i => i.sku) }} </div>
              </span>
              <span v-if="slotProps.column.field==='actions'">
                <div class="d-flex">
                  <button
                    type="button"
                    class="btn btn-primary me-2"
                    @click="editdealer(slotProps.row)"
                  >
                    <vue-feather type="edit-2" />
                  </button>
                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="deletedealer(slotProps.row)"
                  >
                    <vue-feather type="trash-2" />
                  </button>
                </div>
              </span>
              <span v-else>{{ slotProps.row[slotProps.column.field] }}</span>

              {{ console.log(slotProps.column) }}
              <span v-if="slotProps.column.field === 'invoices'">
                <div class="d-flex">
                  <button type="button" class="btn bg-warning me-2" @click="viewInvoice(slotProps.row)">
                    <vue-feather type="eye" />
                  </button>
                  <button type="button" class="btn btn-danger" @click="generateInvoice(slotProps.row)">
                    <vue-feather type="file-text" />
                  </button>

                </div>
              </span>
            </template>
          </vue-table-component>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VueTableComponent from '../table-component.vue';
import SwalMessages from '../../Components/SwalMessages.vue';
export default {
	components: {
		VueTableComponent
	},
	extends:SwalMessages,
	props:['dealers'],
	data() {
		return {
			getDealerList: [],
			getSalesList: [],
			uSearchBy: '',
			Columns:[
				{
					label: 'Dealer Name',
					field: 'dealer_name'
				},
				{
					label: 'Firm Name',
					field: 'firm_name'
				},
				{
					label: 'Created At',
					field: 'date'
				},
				{
					label: 'Updated At',
					field: 'date'
				},
				{
					label: 'Invoice',
					field: 'invoices'
				},
			],
		};
	},
	mounted(){
		this.getSales();
		this.getDealers();
	},
	methods: {
		clearFitler() {
			this.uSearchBy='';
			this.getSales();
			this.getDealers();
		},
		getSales() {
			this.$axios.get('/api/get-outward-entry-list?searchBy='+this.uSearchBy).then(resp => {
				this.getSalesList = resp.data.success.outward_entries;
			});
		},
		getDealers() {
			this.$axios.get('/api/master/get-dealer-list?searchBy='+this.uSearchBy).then(resp => {
				this.getDealerList = resp.data.success.dealer;
			});
		},
		editdealer(each) {
			this.$inertia.get('/master/edit/dealer/' + each.id);
		},
		deletedealer(each) {
			this.swalConfirmDelete().then((result) => {
				if (result.isConfirmed) {
					this.$axios.delete('/api/master/delete/dealer/'+ each.id).then(resp => {
						this.getDealerList = resp.data.success.dealer;
					});
					this.swalDeleted();
				}
			});
		},
    viewInvoice(row) {
      window.open(`/sales/invoice/${row.id}`, '_blank');
    },

    // Method to generate an invoice
    generateInvoice(row) {
      this.url = `/sales/invoice/${row.id}/generate`;
      const anchor = document.createElement('a');
      anchor.style.display = 'none';
      anchor.href = this.url;
      anchor.download = 'invoice.pdf'; // Set the filename for the download
      document.body.appendChild(anchor);
      anchor.click(); // Trigger the download
      document.body.removeChild(anchor); 
    },
	}
};

</script>
