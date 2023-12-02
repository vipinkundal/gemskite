<template>
  <Head :title="'Manage Product'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Ledger Report
      </h1>
    </div>
    <div class="row">
      <div class="col-md-12">
        <a
          role="button"
          class="btn btn-primary mb-3"
          target="_blank"
          :href="'stock/export-to-csv'"
        >
          {{ 'Export To CSV' }}
        </a>
      </div>
      <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
          <vue-table-component
            :key="Math.random()"
            :columns="Columns"
            :rows="ledgerData"
            :sort-by-api="false"
          >
            <template
              #table-row="slotProps"
            >
              <span v-if="slotProps.column.field==='name'">
                <div class="d-flex">

                  <a :href="'/report/ledger/'+ slotProps.row.id +'/details'">{{ slotProps.row.name }} </a>
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
	props:['ledgerData'],
	data() {
		return {
			uSearchBy:'',
			sortBy:'',
			sortType:'',
			Columns:[
				{
					label: 'ID',
					field: 'id',
				},
				{
					label: 'Name',
					field: 'name',
				},
				{
					label: 'Date',
					field: 'date',
				},
				{
					label: 'Mobile',
					field: 'mobile_number',
				},
				{
					label: 'State',
					field: 'state',
				},
				{
					label: 'Country',
					field: 'country',
				},
				{
					label: 'Type',
					field: 'type',
				},
				{
					label: 'Balance',
					field: 'opening_balance',
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
