<template>
  <Head :title="'Add Product'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Add Product
      </h1>
    </div>
    <form
      action="#"
      novalidate="novalidate"
      @submit.prevent="handleAddProduct"
    >
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="row">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-4 mb-2 pe-2">
                      <label class="form-label">UPC/SKU <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.sku"
                        type="text"
                        :class="{'form-control': true, 'has-error': v$.form_data.sku.$error}"
                        placeholder="UPC/SKU"
                        @input="productSearch"
                      >
                    </div>
                    <div class="col-12 col-md-4 mb-2 pe-2">
                      <label class="form-label">Stone Name <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.stone_name"
                        type="text"
                        :class="{'form-control': true, 'has-error': v$.form_data.stone_name.$error}"
                        placeholder="Short Name"
                      >
                    </div>
                    <div class="col-md-4 mb-2 pe-2">
                      <label class="form-label">Shape</label>
                      <input
                        v-model="form_data.shape"
                        type="text"
                        :class="{'form-control': true}"
                        placeholder="Shape"
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-md-4 mb-2 pe-2">
                      <label class="form-label">Size</label>
                      <input
                        v-model="form_data.size"
                        type="text"
                        :class="{'form-control': true}"
                        placeholder="Size"
                      >
                    </div>
                    <div class="col-md-4 mb-2 pe-2">
                      <label class="form-label">Piece</label>
                      <input
                        v-model="form_data.piece"
                        type="text"
                        :class="{'form-control': true}"
                        placeholder="Piece"
                      >
                    </div>
                    <div class="col-md-4 mb-2 pe-2">
                      <label class="form-label">Gross Weight <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.gross_weight"
                        type="text"
                        :class="{'form-control': true, 'has-error': v$.form_data.gross_weight.$error}"
                        placeholder="Gross Weight"
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-4 mb-2 pe-2">
                      <label class="form-label">S.W <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.s_w"
                        type="text"
                        :class="{'form-control': true, 'has-error': v$.form_data.s_w.$error}"
                        placeholder="S.W."
                      >
                    </div>
                    <div class="col-12 col-md-4 mb-2 pe-2">
                      <label class="form-label">Line <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.line"
                        type="text"
                        :class="{'form-control': true, 'has-error': v$.form_data.line.$error}"
                        placeholder="Line"
                      >
                    </div>
                    <div class="col-12 col-md-4 mb-2 pe-2">
                      <label class="form-label">Net Weight <span class="required-label">*</span></label>
                      <input
                        v-model="netWeightBind"
                        type="text"
                        :class="{'form-control': true, 'has-error': v$.form_data.net_weight.$error}"
                        placeholder="Net Weight"
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Price <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.price"
                        type="text"
                        :class="{'form-control': true, 'has-error': v$.form_data.price.$error}"
                        placeholder="Price"
                      >
                    </div>
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Color</label>
                      <input
                        v-model="form_data.color"
                        type="text"
                        :class="{'form-control': true }"
                        placeholder="Color"
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-md-6 mb-2 pe-2">
                      <label class="form-label">Description</label>
                      <textarea
                        v-model="form_data.description"
                        type="text"
                        :class="{'form-control': true}"
                        placeholder="Description"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6 d-md-flex">
          <div class="">
            <button
              class="btn btn-primary pe-3"
              type="submit"
              @click="submitAddDealer"
            >
              Submit
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import { numeric, required } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';


export default {
	props: ['product'],
	setup() {
		return {v$: useVuelidate()};
	},
	data(){
		return {
			form_data:{
		        sku: '',
				stone_name: '',
				description: '',
				size:'',
				s_w: '',
				piece: '',
				shape: '',
				gross_weight: '',
				net_weight: '',
				price: '',
				color:'',
			},

		};
	},
	computed: {
		netWeightBind: {
			cache: false,
			get() {
				let value = this.form_data.gross_weight - this.form_data.s_w;
				// eslint-disable-next-line vue/no-side-effects-in-computed-properties
				this.form_data.net_weight = value;
				return value;
			},
			set(value) {
				this.form_data.net_weight = value;
			}
		}
	},
	validations() {
		return {
			form_data : {
				sku: { required },
				stone_name: { required },
				gross_weight: { required },
				s_w: { required },
				line: { required },
				net_weight: { required },
				price: { required },
			}
		};
	},
	mounted(){
		if(this.product) {
			this.form_data.sku = this.form_data.sku ? this.form_data.sku: this.product.sku;
			this.form_data.stone_name = this.form_data.stone_name ? this.form_data.stone_name:  this.product.stone_name;
			this.form_data.description = this.form_data.description ? this.form_data.description:  this.product.description;
			this.form_data.size = this.form_data.size ? this.form_data.size:  this.product.size;
			this.form_data.piece = this.form_data.piece ? this.form_data.piece:  this.product.piece;
			this.form_data.shape = this.form_data.shape ? this.form_data.shape:  this.product.shape;
			this.form_data.gross_weight = this.form_data.gross_weight ? this.form_data.gross_weight:  this.product.gross_weight;
			this.form_data.line = this.form_data.line ? this.form_data.line:  this.product.line;
			this.form_data.net_weight = this.form_data.net_weight ? this.form_data.net_weight:  this.product.net_weight;
			this.form_data.s_w = this.form_data.s_w ? this.form_data.s_w:  this.product.s_w;
			this.form_data.price = this.form_data.price ? this.form_data.price:  this.product.price;
			this.form_data.color = this.form_data.color ? this.form_data.color:  this.product.color;
		}
	},
	methods: {
		productSearch() {
			clearTimeout(this.debounce2);
			this.debounce2 = setTimeout(() => {
				this.getProductBySKU();
			}, 1400);
		},
		getProductBySKU() {
			this.$axios.post('/api/product-by-sku', {
				search: this.form_data.sku,
			}).then(resp => {
				let product = resp.data.product;
				if (product) {
					alert('Product found with same sku');
					this.form_data.sku = null;
				}
			});
		},
		async handleAddProduct() {
			const result = await this.v$.$validate();
			if (result) {
				this.form_data.edit= this.product ? true : false,
				this.form_data.id= this.product ? this.product.id : 0,
				this.$axios.post('/api/master/create-or-update-product', this.form_data).then(() => {
					this.$swal(this.form_data.edit ? 'Product edited ' : 'Product added');
					this.v$.$reset();
					this.clearForm();
				});
			}
		},
		clearForm() {
			this.form_data = {
				sku: '',
				stone_name: '',
				description: '',
				size: '',
				piece:'',
				s_w: '',
				shape: '',
				gross_weight: '',
				price: '',
				color:'',
			};
		},
	}
};

</script>
