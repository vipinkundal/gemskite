<template>
  <Head :title="'Manage Product'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Inward Entry Items
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
            :rows="inwardEntryItems"
            :sort-by-api="false"
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
	props:['inwardEntryItems'],
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
					label: 'Frame Number',
					field: 'frame_number',
				},
				{
					label: 'GRN',
					field: 'grn_number',
				},
				{
					label: 'Name',
					field: 'short_name',
				},
				{
					label: 'Description',
					field: 'description',
				},
				{
					label: 'Model',
					field: 'model',
				},
				{
					label: 'Marin Code',
					field: 'marin_code',
				},
				{
					label: 'Box Description',
					field: 'description_on_box',
				},
				{
					label: 'Size',
					field: 'size',
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
					label: 'Insera Code',
					field: 'insera_code',
				},
				{
					label: 'Barcode Color',
					field: 'color_of_barcode'
				},
				{
					label: 'Color',
					field: 'color'
				},
			]
		};
	},
	// mounted(){
	//     this.getProduct()
	// },
	methods: {
		// clearFitler() {
		//     this.uSearchBy='';
		//     this.getProduct();
		// },
		// getProduct() {
		//     this.$axios.get('/api/master/get-product-list?searchBy='+this.uSearchBy).then(resp => {
		//     this.getProductList = resp.data.success.products;
		// });
		// },
	}
};

</script>
<style>
.border-radius-0 {
    border-radius: 0 !important;
}
</style>
