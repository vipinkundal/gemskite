<template>
  <Head :title="'Outward Entry'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Outward Entry
      </h1>
    </div>

    <form>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0" />
            </div>
            <div class="row">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Dispatch Date/Time <span class="text-danger">*</span></label>
                      <Datepicker
                        v-model="outbound_date"
                        :is24="false"
                        format="yyyy-MM-dd"
                        required
                        :placeholder="'Dispatch Date/Time'"
                        :month-change-on-scroll="false"
                        auto-apply
                      />
                      <span
                        v-if="v$.outbound_date.$error"
                        class="text-danger"
                      >Dispatch Date field required</span>
                    </div>
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Voucher Number <span class="text-danger">*</span></label>
                      <input
                        v-model="voucher_number"
                        type="text"
                        :disabled="true"
                        class="form-control"
                        required
                        placeholder="Voucher Number"
                      >
                      <span
                        v-if="v$.voucher_number.$error"
                        class="text-danger"
                      >Voucher Number field required</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Dealer Name <span class="text-danger">*</span></label>
                      <select
                        id="select-dealer"
                        v-model="dealer_name"
                        class="form-control"
                        name="select-dealer"
                        placeholder="Select a dealer"
                        @change="setDealer"
                      >
                        <option
                          v-for="(option,i) in dealerList"
                          :key="'dealer_'+i"
                          :value="option.name"
                          :selected="dealer_name"
                        >
                          {{ option.name }}
                        </option>
                      </select>
                      <span
                        v-if="v$.dealer_name.$error"
                        class="text-danger"
                      >Dealer Name field required</span>
                    </div>
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Firm Name <span class="text-danger">*</span></label>
                      <input
                        v-model="firm_name"
                        type="text"
                        class="form-control"
                        required
                        placeholder="Firm Name"
                      >
                      <span
                        v-if="v$.firm_name.$error"
                        class="text-danger"
                      >Firm Name field required</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">City <span class="text-danger">*</span></label>
                      <input
                        v-model="city"
                        type="text"
                        class="form-control"
                        required
                        placeholder="City"
                      >
                      <span
                        v-if="v$.city.$error"
                        class="text-danger"
                      >City field required</span>
                    </div>
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Phone <span class="text-danger">*</span></label>
                      <input
                        v-model="phone"
                        type="text"
                        class="form-control"
                        required
                        placeholder="Phone"
                      >
                      <span
                        v-if="v$.phone.$error"
                        class="text-danger"
                      >Phone field required</span>
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
                v-for="(each, key) in outwardEntries"
                :key="each.id"
              >
                <outward-entry-items
                  :item="each"
                  :item-key="key + 1"
                  :entries="outwardEntries"
                  :edit="edit"
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
                @click="submitOutwardEntry"
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
import OutwardEntryItems from './OutwardEntryItems.vue';
import { required } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
export default {
	components: {
		OutwardEntryItems,
	},
	props: ['dealerList', 'outwardEntry', 'edit'],
	setup() {
		return {v$: useVuelidate({ $scope: false })};
	},
	data() {
		return {
			outwardEntries: [],
			savedItems: [],
			outbound_date: '',
			voucher_number: '',
			dealer_name: '',
			firm_name: '',
			city: '',
			phone: '',
		};
	},
	mounted() {
		this.getNextVoucherNumber();
	},
	created() {
		if (this.outwardEntry && this.outwardEntry.id) {
      console.log(this.outwardEntry)
			this.outwardEntries = this.outwardEntry.outward_entry_item;
			this.outbound_date = this.$moment(this.outwardEntry.date, 'YYYY-MM-DD');
			this.voucher_number = this.outwardEntry.voucher_number;
			this.dealer_name = this.outwardEntry.dealer_name;
			this.firm_name = this.outwardEntry.firm_name;
			this.city = this.outwardEntry.city;
			this.phone = this.outwardEntry.phone;
		}
	},
	validations() {
		return {
			outbound_date: { required },
			voucher_number: { required },
			dealer_name: { required },
			firm_name: { required },
			city: { required },
			phone: { required },
		};
	},
	methods: {
		getNextVoucherNumber() {
			this.$axios.get('/api/get-last-outward-entry').then(resp => {
				if (resp) {
					this.voucher_number = resp.data.last_entry_id;
				}
			});
		},
		addNewItem() {
			var increment =false;
			let array = this.outwardEntries.filter(node=>{
				if(node.id ===this.outwardEntries.length) {
					increment=true;
					return this.outwardEntries;
				}
				return this.outwardEntries;
			});
			this.outwardEntries.push({
				id: increment ? array.length+1 : array.length,
			});
		},
		skuUpdate(data) {
			this.outwardEntries[data.id]['sku'] = data.sku;
			this.$forceUpdate();
		},
		removeNewItem(id) {
			this.outwardEntries.splice(id, 1);
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
			this.outwardEntries = [];
			this.outbound_date = '';
			this.dealer_name = '';
			this.firm_name = '';
			this.city = '';
			this.phone = '';
			this.v$.$reset();
		},
		async submitOutwardEntry() {
			const result = await this.v$.$validate();
			if(!result) {
				this.$swal({
					title: 'Error',
					text: 'Required field can not be empty.',
					customClass: 'swal-wide',
				});
				return;
			}
			if (this.savedItems.length < this.outwardEntries.length) {
				this.removeNewItem(this.outwardEntries[this.outwardEntries.length - 1]);
			}
			if(result && !this.edit===true) {
				this.$axios.post('/api/save-outward-entry',{
					outbound_date: this.$moment(this.outbound_date).format('YYYY-MM-DD'),
					voucher_number: this.voucher_number,
					dealer_name: this.dealer_name,
					firm_name: this.firm_name,
					city: this.city,
					phone: this.phone,
					items: this.savedItems,
				}).then(() => {
					this.$swal('Outward entry added');
					this.resetData();
				}).catch(err => {
					alert(err);
				});
			} else {
				this.$axios.post('/api/update-outward-entry',{
					outbound_date: this.$moment(this.outbound_date).format('YYYY-MM-DD'),
					id: this.outwardEntry ? this.outwardEntry.id : 0,
					voucher_number: this.voucher_number,
					dealer_name: this.dealer_name,
					firm_name: this.firm_name,
					city: this.city,
					phone: this.phone,
					items: this.savedItems,
				}).then(() => {
					this.$swal('Outward entry updated');
				}).catch(err => {
					alert(err);
				});
			}
		},
		setDealer() {
			this.firm_name = this.dealerList.find(i => i.name === this.dealer_name).firm_name;
			this.city = this.dealerList.find(i => i.name === this.dealer_name).city;
			this.phone = this.dealerList.find(i => i.name === this.dealer_name).phone;
		},
        generateInvoice() {
        this.$axios.post('/report/get-invoice', {
            id: this.outwardEntry ? this.outwardEntry.id : 0,
        }).then(response => {
            let url = response.config.url;
            console.log(url)
            printJS({
                printable: url,
                type: 'pdf',
                onPrintDialogClose: () => {
                    this.reset();
                }
            });
        }).catch(error => {
            console.error('Error generating invoice:', error);
        });
    }


	}
};

</script>
