<template>
  <Head :title="'Manage Outward Entry'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Manage Outward Entry
      </h1>
    </div>
    <div class="row">
      <div class="col-md-4 col-12">
        <div :class="['d-flex mt-2', uSearchBy ? '':'mb-2']">
          <input
            v-model="uSearchBy"
            autocomplete="off"
            placeholder="Search outward by Invoice Number / Dealer / LR Number"
            type="text"
            class="form-control bg-white  border-radius-0"
            @keyup.enter="getOutwardEntry"
          >
          <span
            id="search"
            role="button"
            class="input-group-text border-radius-0 btn-primary"
            @click="getOutwardEntry"
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
            :key="getOutwardEntryList.length"
            :columns="outwardColumns"
            :rows="getOutwardEntryList"
            :sort-by-api="true"
          >
            <template #table-row="slotProps">
              <span v-if="slotProps.column.field==='actions'">
                <div class="d-flex">
                  <button
                    type="button"
                    class="btn btn-primary me-2"
                    @click="editOutwardEntry(slotProps.row)"
                  >
                    <vue-feather type="edit-2" />
                  </button>
                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="deleteOutwardEntry(slotProps.row)"
                  >
                    <vue-feather type="trash-2" />
                  </button>
                </div>
              </span>
              <span v-if="slotProps.column.field === 'total' && slotProps.row.outward_entry_item">
                {{ slotProps.row.outward_entry_item.length }}
              </span>
              <span v-if="slotProps.row.outward_entry_item.length && slotProps.column.field === 'sku' && slotProps.row.outward_entry_item">
                {{ slotProps.row.outward_entry_item.map(i => i.sku) }}
              </span>
              <span v-if="slotProps.row.outward_entry_item.length && slotProps.column.field === 'stone_name' && slotProps.row.outward_entry_item">
                {{ slotProps.row.outward_entry_item.map(i => i.stone_name) }}
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
	props: ['outwardEntries'],
	data() {
		return {
			getOutwardEntryList: [],
			uSearchBy:'',
			sortBy:'',
			sortType:'',
			outwardColumns:[
				{
					label: 'Date of inbound',
					field: 'date',
				},
				{
					label: 'Voucher Number',
					field: 'voucher_number',
				},
				{
					label: 'Dealer',
					field: 'dealer_name',
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
					label: 'City',
					field: 'city',
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
		this.getOutwardEntry();
	},
	methods: {
		clearFitler() {
			this.uSearchBy = '';
			this.getOutwardEntry();
		},
		getOutwardEntry() {
			this.$axios.get('/api/get-outward-entry-list?searchBy=' + this.uSearchBy).then(resp => {
				this.getOutwardEntryList = resp.data.success.outward_entries;
			});
		},
		editOutwardEntry(each) {
			this.$inertia.get('/inventory/edit/outward/' + each.id);
		},
		deleteOutwardEntry(each) {
			this.swalConfirmDelete().then((result)=>{
				if(result.isConfirmed){
					this.$inertia.delete('/api/outward/' + each.id);
					this.getOutwardEntry();
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
