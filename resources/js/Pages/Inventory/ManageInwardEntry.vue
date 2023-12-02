<template>
  <Head :title="'Manage Inward Entry'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Manage Inward Entry
      </h1>
    </div>
    <div class="row">
      <div class="col-md-4 col-12">
        <div :class="['d-flex mt-2', uSearchBy ? '':'mb-2']">
          <input
            v-model="uSearchBy"
            autocomplete="off"
            placeholder="Search inward by Invoice Number / Supplier / Container Number"
            type="text"
            class="form-control bg-white  border-radius-0"
            @keyup.enter="getInwardEntry"
          >
          <span
            id="search"
            role="button"
            class="input-group-text border-radius-0 btn-primary"
            @click="getInwardEntry"
          >Search</span>
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
            :key="getInwardEntryList.length"
            :columns="inwardColumns"
            :rows="getInwardEntryList"
            :sort-by-api="true"
          >
            <template #table-row="slotProps">
              <span v-if="slotProps.column.field==='actions'">
                <div class="d-flex">
                  <button
                    type="button"
                    class="btn btn-primary me-2"
                    @click="editInwardEntry(slotProps.row)"
                  >
                    <vue-feather type="edit-2" />
                  </button>
                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="deleteInwardEntry(slotProps.row)"
                  >
                    <vue-feather type="trash-2" />
                  </button>
                </div>
              </span>
              <span v-if="slotProps.column.field === 'total' && slotProps.row.inward_entry_item">
                {{ slotProps.row.inward_entry_item.length }}
              </span>
              <span v-if="slotProps.column.field === 'sku' && slotProps.row.inward_entry_item">
                {{ slotProps.row.inward_entry_item[0].sku }}
              </span>
              <span v-if="slotProps.column.field === 'stone_name' && slotProps.row.inward_entry_item">
                {{ slotProps.row.inward_entry_item[0].stone_name }}
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
import SwalMessagesVue from '@/Components/SwalMessages.vue';
import VueTableComponent from '../table-component';

export default {
	components: {
		VueTableComponent
	},
	extends:SwalMessagesVue,
	props: ['inwardEntries'],
	data() {
		return {
			getInwardEntryList: [],
			uSearchBy:'',
			sortBy:'',
			sortType:'',
			inwardColumns:[
				{
					label: 'Date of inbound',
					field: 'date',
				},
				{
					label: 'Invoice Number',
					field: 'invoice_number',
				},
				{
					label: 'Supplier',
					field: 'supplier',
				},
				{
					label: 'SKU',
					field: 'sku'
				},
				{
					label: 'Stone Name',
					field: 'stone_name',
				},
				{
					label: 'Location',
					field: 'location',
				},
				{
					label: 'Total',
					field: 'total',
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
		clearFitler() {
			this.uSearchBy = '';
			this.getInwardEntry();
		},
		getInwardEntry() {
			this.$axios.get('/api/get-inward-entry-list?searchBy=' + this.uSearchBy).then(resp => {
				this.getInwardEntryList = resp.data.success.inward_entries;
			});
		},
		editInwardEntry(each) {
			this.$inertia.get('/inventory/edit/inward/' + each.id);
		},
		deleteInwardEntry(each) {
			this.swalConfirmDelete().then((result)=>{
				if(result.isConfirmed){
					this.$inertia.delete('/api/inward/' + each.id);
					this.getInwardEntry();
					this.swalDeleted();
				}
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
