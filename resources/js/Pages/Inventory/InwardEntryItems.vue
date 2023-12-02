<template>
  <div
    :id="'accordionItems' + item.id"
    class="accordion mb-3"
  >
    <div class="accordion-item">
      <h2
        :id="'itemCount' + item.id"
        class="accordion-header"
      >
        <button
          class="accordion-button"
          type="button"
          data-bs-toggle="collapse"
          :data-bs-target="'#collapseItem' + item.id"
          aria-expanded="true"
          :aria-controls="'collapseItem' + item.id"
        >
          #{{ itemKey }}
          <span v-if="itemData.sku">&nbsp; SKU: {{ itemData.sku }} </span>
          <span v-if="itemData.stone_name">&nbsp; / Stone Name: {{ itemData.stone_name }} </span>
        </button>
      </h2>
      <div
        :id="'collapseItem' + item.id"
        :class="['accordion-collapse collapse', showAccordion ? 'show' : '']"
        :aria-labelledby="'itemCount' + item.id"
        :data-bs-parent="'#accordionItems' + item.id"
      >
        <div class="accordion-body">
          <div class="">
            <div class="row">
              <div class="col-md-12 d-md-flex">
                <div class="col-12 col-md-6 mb-2 pe-2">
                  <label class="form-label">SKU <span class="text-danger">*</span></label>
                  <input
                    v-model="itemData.sku"
                    type="text"
                    class="form-control"
                    required
                    placeholder="SKU"
                    @input="productSearch"
                  >
                  <span
                    v-if="v$.itemData.sku.$error"
                    class="text-danger"
                  >UPC field required</span>
                </div>
                <div class="col-12 col-md-6 mb-2 pe-2">
                  <label class="form-label">Stone Name <span class="text-danger">*</span></label>
                  <input
                    v-model="itemData.stone_name"
                    type="text"
                    class="form-control"
                    :disabled="!itemData.sku"
                    placeholder="Stone Name"
                    @input="frameUpdate"
                  >
                  <span
                    v-if="v$.itemData.stone_name.$error"
                    class="text-danger"
                  >Stone name field required</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 d-md-flex">
                <div class="col-12 col-md-6 mb-2 pe-2">
                  <label class="form-label">Shape </label>
                  <input
                    v-model="itemData.shape"
                    type="text"
                    class="form-control"
                    disabled
                    placeholder="Shape"
                  >
                </div>
                <div class="col-12 col-md-6 mb-2 pe-2">
                  <label class="form-label">Size</label>
                  <input
                    v-model="itemData.size"
                    type="text"
                    disabled
                    class="form-control"
                    placeholder="Size"
                  >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 d-md-flex">
                <div class="col-12 col-md-6 mb-2 pe-2">
                  <label class="form-label">Piece</label>
                  <input
                    v-model="itemData.piece"
                    type="text"
                    disabled
                    class="form-control"
                    placeholder="Piece"
                  >
                </div>
                <div class="col-md-6 mb-2 pe-2">
                  <label class="form-label">Gross Weight <span class="text-danger">*</span></label>
                  <input
                    v-model="itemData.gross_weight"
                    type="text"
                    disabled
                    class="form-control"
                    placeholder="Gross Weight"
                  >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 d-md-flex">
                <div class="col-12 col-md-6 mb-2 pe-2">
                  <label class="form-label">S.W <span class="text-danger">*</span></label>
                  <input
                    v-model="itemData.s_w"
                    type="text"
                    disabled
                    class="form-control"
                    placeholder="S.W"
                  >
                </div>
                <div class="col-md-6 mb-2 pe-2">
                  <label class="form-label">Line <span class="text-danger">*</span></label>
                  <input
                    v-model="itemData.line"
                    type="text"
                    disabled
                    class="form-control"
                    placeholder="Line"
                  >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 d-md-flex">
                <div class="col-12 col-md-6 mb-2 pe-2">
                  <label class="form-label">Net Weight <span class="text-danger">*</span></label>
                  <input
                    v-model="itemData.net_weight"
                    type="text"
                    disabled
                    class="form-control"
                    placeholder="Net Weight"
                  >
                </div>

                <div class="col-12 col-md-6 mb-2 pe-2">
                  <label class="form-label">Price <span class="text-danger">*</span></label>
                  <input
                    v-model="itemData.price"
                    type="text"
                    disabled
                    class="form-control"
                    placeholder="Price"
                  >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 d-md-flex">
                <div class="col-12 col-md-6 mb-2 pe-2">
                  <label class="form-label">Color</label>
                  <input
                    v-model="itemData.color"
                    type="text"
                    disabled
                    class="form-control"
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
                    v-model="itemData.description"
                    type="text"
                    disabled
                    class="form-control"
                    placeholder="Description"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-12 d-md-flex">
              <div class="mx-auto mt-2">
                <button
                  class="btn btn-primary pe-3"
                  type="button"
                  @click="saveItem"
                >
                  Save
                </button>
                <button
                  class="btn btn-danger ms-2  float-end"
                  type="button"
                  @click="$emit('remove-item')"
                >
                  Remove Item
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { required } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
export default {
	props: ['entries', 'item', 'itemKey'],
	emits: ['item-added', 'sku-update', 'remove-item'],
	setup() {
		return {v$: useVuelidate()};
	},
	data() {
		return {
			itemData: {
				id: this.item.id,
				sku: '',
				stone_name: '',
				shape: '',
				piece: '',
				description: '',
				description_on_box: '',
				s_w: '',
				net_weight: '',
				size: '',
				gross_weight: '',
				line: '',
				price: '',
				color: '',
			},
			showAccordion: true,
		};
	},
	validations() {
		return {
			itemData: {
				sku: { required },
				stone_name: { required },
			}
		};
	},
	mounted() {
		this.$nextTick(() => {
			this.$.vnode.el.children[0].children[1].children[0].children[0].children[0].children[0].children[0].children[1].focus();
		});
	},
	created() {
		if (this.item.id) {
			this.itemData = {
				id: this.item.id,
				sku: this.item.sku,
				stone_name: this.item.stone_name,
				shape: this.item.shape,
				piece: this.item.piece,
				description: this.item.description,
				description_on_box: this.item.description_on_box,
				s_w: this.item.s_w,
				net_weight: this.item.net_weight,
				size: this.item.size,
				gross_weight: this.item.gross_weight,
				line: this.item.line,
				price: this.item.price,
				color: this.item.color,
			};
		}
	},
	methods: {
		frameUpdate() {
			clearTimeout(this.debounce1);
			this.debounce1 = setTimeout(() => {
				this.saveItem();
			}, 1400);
		},
		async saveItem() {
			const result = await this.v$.$validate();
			if(!result) {
				this.$swal({
					title: 'Error',
					text: 'Required field can not be empty.',
					customClass: 'swal-wide',
				});
			}
			if(result) {
				this.showAccordion = false;
				this.$emit('item-added', this.itemData);
			}
		},
		productSearch() {
			clearTimeout(this.debounce2);
			this.debounce2 = setTimeout(() => {
				this.getProductBySKU();
			}, 1400);
		},
		getProductBySKU() {
			this.$axios.post('/api/product-by-sku', {
				search: this.itemData.sku,
			}).then(resp => {
				let product = resp.data.product;
				if (product) {
					this.itemData.stone_name = product.stone_name;
					this.itemData.shape = product.shape;
					this.itemData.piece = product.piece;
					this.itemData.description = product.description;
					this.itemData.description_on_box = product.description_on_box;
					this.itemData.s_w = product.s_w;
					this.itemData.net_weight = product.net_weight;
					this.itemData.size = product.size;
					this.itemData.gross_weight = product.gross_weight;
					this.itemData.line = product.line;
					this.itemData.price = product.price;
					this.itemData.color = product.color;
				}
				//Focus on frame number
				this.$nextTick(() => {
					this.$.vnode.el.children[0].children[1].children[0].children[0].children[0].children[0].children[1].children[1].focus();
				});
				this.$emit('sku-update', this.itemData);
			}).catch(err => {
				alert('Error while getting item by sku', this.itemData.sku, ' error - ', err);
			});
		}
	}
};
</script>
