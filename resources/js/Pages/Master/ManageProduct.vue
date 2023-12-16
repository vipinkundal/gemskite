<template>
  <Head :title="'Manage Product'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Manage Product
      </h1>
    </div>
    <div class="row">
      <div class="col-md-4">
        <label class="form-label">Select type <span class="required-label">*</span></label>
        <select
          id="select-product-type"
          v-model="productType"
          class="form-control ps-1 pe-1 w-5"
          name="select-product-type"
          placeholder="Select a product type"
          @change="setProduct"
        >
          <option
            v-for="(option,i) in productColumns"
            :key="'productType_'+i"
            :value="option.label"
          >
            {{ option.label }}
          </option>
        </select>
      </div>
      <div class="col-md-4 col-12">
        <label class="form-label">Search Product <span class="required-label">*</span></label>
        <div :class="['d-flex', uSearchBy ? '':'mb-2']">
          <input
            v-model="uSearchBy"
            autocomplete="off"
            placeholder="Search product by SKU/Short Name"
            type="text"
            class="form-control"
            @keyup.enter="getProduct"
          >
          <span
            id="search"
            role="button"
            class="btn btn-default input-group-text border-radius-0 btn-primary"
            @click="getProduct"
          >Search
          </span>
        </div>
        <button
          v-if="uSearchBy"
          class="ms-0 btn mt-0 pt-0 btn-default mb-0"
          @click="clearFitler"
        >
          Clear Filter
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div
          v-if="getProductList"
          class="card flex-fill"
        >
          <vue-table-component
            :key="Math.random()"
            :columns="productColumns"
            :rows="getProductList"
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
                    @click="editProduct(slotProps.row)"
                  >
                    <vue-feather type="edit-2" />
                  </button>
                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="deleteProduct(slotProps.row)"
                  >
                    <vue-feather type="trash-2" />
                  </button>
                </div>
              </span>
              <span v-else>
                {{ slotProps.row[slotProps.column.field] }}
              </span>
            </template>
            <template #emptystate>
              <p>{{ 'No product found' }}</p>
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
	props:['products'],
	data() {
		return {
			getProductList: [],
			uSearchBy: '',
			sortBy: '',
			productColumns:[
				{
					label: 'SKU',
					field: 'sku'
				},
				{
					label: 'Stone Name',
					field: 'stone_name',
					sorting: false
				},
				{
					label: 'Shape',
					field: 'shape',
					sorting: false
				},
				{
					label: 'Size',
					field: 'size',
					sorting: false
				},
				{
					label: 'Piece',
					field: 'piece',
					sorting: false
				},
				{
					label: 'Gross Weight',
					field: 'gross_weight',
					sorting: false
				},
				{
					label: 'S.W',
					field: 's_w',
					sorting: false
				},
				{
					label: 'Line',
					field: 'line',
					sorting: false
				},
				{
					label: 'Net Weight',
					field: 'net_weight',
					sorting: false
				},
				{
					label: 'Price',
					field: 'price',
					sorting: false
				},
				{
					label: 'Color',
					field: 'color',
					sorting: false
				},
				{
					label: 'Actions',
					field: 'actions',
					sorting: false
				},
			],
		};
	},
	mounted(){
		this.getProduct();
	},
	methods: {
		clearFitler() {
			this.uSearchBy='';
			this.getProduct();
		},
		getProduct() {
			let type = this.productColumns.find(i => i.label === this.productType)?.field;
			this.$axios.get('/api/master/get-product-list?searchBy='+this.uSearchBy+'&type='+type).then(resp => {
				this.getProductList = resp.data.success.products;
			});
		},
		setProduct() {

		},
		editProduct(each) {
			this.$inertia.get('/master/edit/product/' + each.id);
		},
		deleteProduct(each) {
			this.swalConfirmDelete().then((result)=>{
				if(result.isConfirmed){
					this.$inertia.delete('/api/master/delete/product/' + each.id);
			        this.getProduct();
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
