<template>
  <Head :title="'Manage ledger'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Ledger
      </h1>
    </div>
    <div class="row">
      <div class="mb-3 float-end">
        <Link
          class="btn btn-success"
          href="/ledger/create"
        >
          <i
            class="align-middle"
          /> <span class="align-middle">+ Create</span>
        </Link>
      </div>
      <div class="col-md-12 col-12">
        <div :class="['col-md-6 d-flex mt-2', uSearchBy ? '':'mb-2']">
          <input
            v-model="uSearchBy"
            autocomplete="off"
            placeholder="Search ledger by Name"
            type="text"
            class="form-control bg-white border-radius-0"
            @keyup.enter="getLedger"
          >
          <span
            id="search"
            role="button"
            class="input-group-text btn btn-secondary ms-1 border-radius-0 btn-primary"
            @click="getLedger"
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
    </div>
    <div class="row">
      <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
          <vue-table-component
            :key="Math.random()"
            :columns="Columns"
            :rows="getLedgerList"
            :sort-by-api="false"
          >
            <template
              #table-row="slotProps"
            >
              <span v-if="slotProps.column.field==='actions'">
                <div class="d-flex">

                  <button
                    type="button"
                    class="btn btn-primary me-2"
                    @click="editLedger(slotProps.row)"
                  >
                    <vue-feather type="edit-2" />
                  </button>
                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="deleteLedger(slotProps.row)"
                  >
                    <vue-feather type="trash-2" />
                  </button>
                </div>
              </span>
              <span v-else>{{ slotProps.row[slotProps.column.field] }}</span>
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
            <template #emptystate>
              <p>{{ 'No ledger found' }}</p>
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
	props:['legder'],
	data() {
		return {
			getLedgerList: [],
			uSearchBy: '',
			Columns:[
				{
					label: 'Name',
					field: 'name'
				},
				{
					label: 'Date',
					field: 'date'
				},
				{
					label: 'Balance',
					field: 'opening_balance'
				},
				{
					label: 'Actions',
					field: 'actions'
				},
				{
					label: 'Invoice',
					field: 'invoices'
				},
			],
		};
	},
	mounted(){
		this.getLedger();
	},
	methods: {
		clearFitler() {
			this.uSearchBy='';
			this.getLedger();
		},
		getLedger() {
			this.$axios.get('/api/master/get-ledger-list?searchBy='+this.uSearchBy).then(resp => {
				this.getLedgerList = resp.data.success.ledger;
			});
		},
		editLedger(each) {
			this.$inertia.get('/ledger/edit/' + each.id);
		},
		deleteLedger(each) {
			this.swalConfirmDelete().then((result) => {
				if (result.isConfirmed) {
					this.$axios.delete('/api/master/delete/ledger/'+ each.id).then(resp => {
						this.getLedgerList = resp.data.success.ledger;
					});
					this.swalDeleted();
				}
			});
		},
    viewInvoice(row) {
      window.open(`/ledger/invoice/${row.id}`, '_blank');
    },

    // Method to generate an invoice
    generateInvoice(row) {
    this.url = `/ledger/invoice/${row.id}/generate`;
    // Create a hidden anchor element
    const anchor = document.createElement('a');
    anchor.style.display = 'none';
    anchor.href = this.url;
    anchor.download = 'invoice.pdf'; // Set the filename for the download
    document.body.appendChild(anchor);
    anchor.click(); // Trigger the download
    document.body.removeChild(anchor); // Clean up the anchor element
    }
	}
};

</script>
