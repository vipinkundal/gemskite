<template>
  <Head :title="'Manage Product'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Stock Management
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
            :rows="stockData"
            :sort-by-api="false"
          >
            <template
              #table-row="slotProps"
            >
              <span v-if="slotProps.column.field==='sku'">
                <div class="d-flex">

                  <a :href="'/report/stock/'+ slotProps.row.sku +'/details'">{{ slotProps.row.sku }} </a>
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
	props:['stockData'],
	data() {
		return {
			uSearchBy:'',
			sortBy:'',
			sortType:'',
			Columns:[
				{
					label: 'SKU',
					field: 'sku',
				},
				{
					label: 'QTY',
					field: 'QTY',
					type:'number'
				},
				{
					label: 'Name',
					field: 'short_name',
				},
				{
					label: 'Model',
					field: 'model',
				},
				{
					label: 'Description',
					field: 'description',
				},
				{
					label: 'Color',
					field: 'color',
				},
				{
					label: 'Marin Code',
					field: 'marin_code',
				},
				{
					label: 'Type',
					field: 'type',
				},
				{
					label: 'Fork',
					field: 'fork',
				},
				{
					label: 'Barcode Color',
					field: 'barcode_color',
				},
				{
					label: 'Insera Code',
					field: 'insera_code',
				},
				{
					label: 'Description On Box',
					field: 'description_on_box',
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
