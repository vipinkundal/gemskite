<template>
  <Head :title="'Create Ledger'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inopening_balance align-middle">
        Create Ledger's Entry
      </h1>
    </div>
    <form
      action="#"
      novalidate="novalidate"
      @submit.prevent="submitLedger"
    >
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="row">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 mb-2 pe-2">
                      <label class="form-label">Name <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.name"
                        type="text"
                        class="form-control"
                        required="required"
                        placeholder="Name"
                      >
                    </div>
                  </div>
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Date <span class="required-label">*</span></label>
                      <Datepicker
                        v-model="form_data.date"
                        :is24="true"
                        format="yyyy-MM-dd hh:ii:ss"
                        :placeholder="'Date'"
                        required="required"
                        :month-change-on-scroll="false"
                        auto-apply
                      />
                      <span
                        v-if="v$.form_data.date.$error"
                        class="text-danger"
                      >Date field required</span>
                    </div>
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Mobile Number <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.mobile_number"
                        type="text"
                        class="form-control"
                        required="required"
                        placeholder="Mobile Number"
                      >
                      <span
                        v-if="v$.form_data.mobile_number.$error"
                        class="text-danger"
                      >Mobile Number field required</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-6 mb-2 pe-2">
                    <label class="form-label">State</label>
                    <input
                      v-model="form_data.state"
                      type="text"
                      class="form-control"
                      required="required"
                      placeholder="State"
                    >
                  </div>
                  <div class="col-12 col-md-6 mb-2 pe-2">
                    <label class="form-label">Country</label>
                    <input
                      v-model="form_data.country"
                      type="text"
                      class="form-control"
                      required="required"
                      placeholder="Country"
                    >
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-4 col-md-4 mb-2 pe-2">
                      <label class="form-label">Type (Cr/Dr) <span class="required-label">*</span></label>
                      <select
                        id="select-type"
                        v-model="form_data.type"
                        class="form-control"
                        name="select-type"
                      >
                        <option
                          :value="'cr'"
                        >
                          Cr
                        </option>
                        <option :value="'dr'">
                          Dr
                        </option>
                      </select>
                      <span
                        v-if="v$.form_data.type.$error"
                        class="text-danger"
                      >Select Cr/Dr field required</span>
                    </div>
                    <div class="col-4 col-md-4 mb-2 pe-2">
                      <label class="form-label">Opening Balance <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.opening_balance"
                        type="text"
                        class="form-control"
                        required="required"
                        placeholder="Opening Balance"
                      >
                      <span
                        v-if="v$.form_data.opening_balance.$error"
                        class="text-danger"
                      >Opening Balance field required</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Address <span class="required-label">*</span></label>
                      <textarea
                        v-model="form_data.address"
                        type="text"
                        class="form-control"
                        required="required"
                        placeholder="Address"
                      />
                      <span
                        v-if="v$.form_data.address.$error"
                        class="text-danger"
                      >Address field required</span>
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
import { required } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';

export default {
	props: ['edit'],
   	setup() {
		return {v$: useVuelidate()};
	},
	data(){
		return {
			form_data:{
				name: '',
				date: '',
				mobile_number: '',
				address: '',
				state: '',
				country: '',
				type: 'cr',
				opening_balance: 0,
			},
		};
	},
	mounted() {
		if(this.edit) {
			this.form_data.name = this.form_data.name ? this.form_data.name: this.edit.name;
			this.form_data.date = this.form_data.date ? this.form_data.date: this.edit.date;
			this.form_data.mobile_number = this.form_data.mobile_number ? this.form_data.date:  this.edit.mobile_number;
			this.form_data.address = this.form_data.address ? this.form_data.date:  this.edit.address;
			this.form_data.state = this.form_data.state ? this.form_data.date:  this.edit.state;
			this.form_data.country = this.form_data.country ? this.form_data.date:  this.edit.country;
			this.form_data.type = this.form_data.type ? this.form_data.type:  this.edit.type;
			this.form_data.opening_balance = this.form_data.opening_balance ? this.form_data.opening_balance:  this.edit.opening_balance;
		}
	},
	validations() {
		return {
			form_data : {
				name: {required},
				date: {required},
				mobile_number: {required},
				address: {required},
				type: {required},
				opening_balance: {required},
			}
		};
	},
	methods: {
		async submitLedger() {
			const result = await this.v$.$validate();
			if (result) {
				this.form_data.edit = this.edit ? true : false,
				this.form_data.id = this.edit ? this.edit.id : 0,
				this.$axios.post('/api/master/create-or-update-ledger', this.form_data).then(() => {
					this.$swal(this.form_data.edit ? 'Ledger edited ' : 'Ledger added');
					this.v$.$reset();
					this.clearForm();
				});
			}
		},
		clearForm() {
			this.form_data = {
				name: '',
				date: '',
				mobile_number: '',
				address: '',
				state: '',
				country: '',
				type: 'cr',
				opening_balance: 0,
			};
		},
	}
};

</script>
