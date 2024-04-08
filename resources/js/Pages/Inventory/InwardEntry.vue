<template>
  <Head :title="'Inward Entry'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Inward Entry
      </h1>
    </div>
    <form>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">
                Logistics
              </h5>
            </div>
            <div class="row">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Date of Inbound <span class="text-danger">*</span></label>
                      <Datepicker
                        v-model="inbound_date"
                        :is24="false"
                        format="yyyy-MM-dd"
                        :placeholder="'Date of Inbound'"
                        required="required"
                        :month-change-on-scroll="false"
                        auto-apply
                      />
                      <span
                        v-if="v$.inbound_date.$error"
                        class="text-danger"
                      >Date of Inbound field required</span>
                    </div>
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Import Invoice Number</label>
                      <input
                        v-model="import_invoice_number"
                        type="text"
                        class="form-control"
                        placeholder="Import Invoice Number"
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Supplier <span class="text-danger">*</span></label>
                      <select
                        id="select-supplier"
                        v-model="supplier"
                        class="form-control"
                        name="select-supplier"
                        placeholder="Select a supplier"
                        @change="setSupplier"
                      >
                        <option
                          v-for="(option,i) in supplierList"
                          :key="'supplier_'+i"
                          :selected="supplier"
                          :value="option.name"
                        >
                          {{ option.name }}
                        </option>
                      </select>
                      <span
                        v-if="v$.supplier.$error"
                        class="text-danger"
                      >Supplier field required</span>
                    </div>
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Location</label>
                      <input
                        v-model="location"
                        type="text"
                        class="form-control"
                        placeholder="Location"
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <template
                v-for="(each, key) in inwardEntries"
                :key="each.id"
              >
                <inward-entry-items
                  :item="each"
                  :item-key="key + 1"
                  :entries="inwardEntries"
                  @item-added="itemAdded"
                  @sku-update="skuUpdate"
                  @remove-item="removeNewItem(each.id)"
                />
              </template>
              <div class="card-footer">
                <div class="col-md-12 d-md-flex">
                  <div class="col-12 col-md-12 mx-auto">
                    <button
                      class="btn btn-primary me-3 float-end"
                      type="button"
                      @click="addNewItem"
                    >
                      + Add Item
                    </button>
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
                type="button"
                @click="submitInwardEntry"
              >
                Submit
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import InwardEntryItems from './InwardEntryItems.vue';
import { required } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
export default {
	components: {
		InwardEntryItems,
	},
	props: ['supplierList', 'inwardEntry'],
	setup() {
		return {v$: useVuelidate({ $scope: false })};
	},
	data() {
		return {
			inwardEntries: [],
			savedItems: [],
			inbound_date: '',
			import_invoice_number: '',
			supplier: '',
			location: '',
		};
	},
	created() {
		if (this.inwardEntry && this.inwardEntry.id) {
			this.inwardEntries = this.inwardEntry.inward_entry_item;
			this.inbound_date = this.inwardEntry.date;
			this.import_invoice_number = this.inwardEntry.invoice_number;
			this.supplier = this.inwardEntry.supplier;
			this.location = this.inwardEntry.location;
		}
	},
	validations() {
		return {
			inbound_date: { required },
			supplier: { required },
		};
	},
	methods: {
		addNewItem() {
			var increment = false;
			let array = this.inwardEntries.filter(node => {
				if(node.id === this.inwardEntries.length) {
					increment = true;
				}
				return this.inwardEntries;
			});
			this.inwardEntries.push({
				id: increment ? array.length + 1 : array.length,
			});
		},
		skuUpdate(data) {
			this.inwardEntries[data.id]['sku'] = data.sku;
			this.$forceUpdate();
		},
		removeNewItem(id) {
			this.inwardEntries.splice(id, 1);
			this.$forceUpdate();
		},
		itemAdded(itemData) {
			let getItem = this.savedItems.filter(i => i.id === itemData.id);
			if(getItem.length) {
				this.savedItems.splice(this.savedItems.findIndex(i => i.id === itemData.id), 1);
			}
			this.savedItems.push(itemData);
			this.addNewItem();
		},
		resetData() {
			this.inwardEntries = [];
			this.inbound_date = '';
			this.import_invoice_number = '';
			this.supplier = '';
			this.location = '';
			this.v$.$reset();
		},
		async submitInwardEntry() {
			const result = await this.v$.$validate();
			if(!result) {
				this.$swal({
					title: 'Error',
					text: 'Required field can not be empty.',
					customClass: 'swal-wide',
				});
				return ;
			}
			if (this.savedItems.length < this.inwardEntries.length) {
				this.removeNewItem(this.inwardEntries[this.inwardEntries.length - 1]);
			}
			if(result) {
				this.$axios.post('/api/save-inward-entry',{
					date: this.$moment(this.inbound_date).format('YYYY-MM-DD'),
					invoice_number: this.import_invoice_number,
					supplier: this.supplier,
					location: this.location,
					items: this.savedItems,
				}).then(() => {
					this.$swal('Inward entry added');
					this.resetData();
				});
			}
		},
		setSupplier() {
			this.location = this.supplierList.find(i => i.name === this.supplier).country;
		}
	}
};

</script>
