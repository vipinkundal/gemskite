<template>
  <Head :title="'Add Dealer'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        {{ isEdit ? 'Edit': 'Add' }} Dealer
      </h1>
    </div>

    <form
      action="#"
      novalidate="novalidate"
      @submit.prevent="handleSubmit"
    >
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="row">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Name <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.name"
                        type="text"
                        class="form-control"
                        placeholder="Name"
                      >
                      <span
                        v-if="v$.form_data.name.$error"
                        class="text-danger"
                      >Name field required</span>
                    </div>
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Firm Name <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.firm_name"
                        type="text"
                        class="form-control"
                        placeholder="Firm Name"
                      >
                      <span
                        v-if="v$.form_data.firm_name.$error"
                        class="text-danger"
                      >Location field required</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">City <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.city"
                        type="text"
                        class="form-control"
                        placeholder="City"
                      >
                      <span
                        v-if="v$.form_data.city.$error"
                        class="text-danger"
                      >City field required</span>
                    </div>
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">State</label>
                      <input
                        v-model="form_data.state"
                        type="text"
                        class="form-control"
                        placeholder="State"
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Phone <span class="required-label">*</span></label>
                      <input
                        v-model="form_data.phone"
                        type="number"
                        class="form-control"
                        placeholder="Phone"
                      >
                      <span
                        v-if="v$.form_data.phone.$error"
                        class="text-danger"
                      >Phone field required</span>
                    </div>
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Email</label>
                      <input
                        v-model="form_data.email"
                        type="email"
                        class="form-control"
                        placeholder="Email"
                      >
                      <span
                        v-if="v$.form_data.email.$error"
                        class="text-danger"
                      >Email field required</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">GST Details</label>
                      <input
                        v-model="form_data.gst_details"
                        type="text"
                        class="form-control"
                        placeholder="GST Details"
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Street Address</label>
                      <textarea
                        v-model="form_data.address"
                        type="text"
                        class="form-control"
                        placeholder="Street Address"
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
    <!-- Modal -->
  </div>
</template>
<script>
import { email, numeric, required } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';

export default {
	props: ['dealer'],
     	setup() {
		return {v$: useVuelidate()};
	},
	data(){
		return {
			isEdit:false,
			form_data:{
				name: '',
				firm_name: '',
				city: '',
				state: '',
				phone: '',
				email: '',
				address: '',
				gst_details:'',
			},
		};
	},
	validations() {
		return {
			form_data : {
				name: { required },
				firm_name: { required },
				city: { required },
				phone: { required, numeric },
				email: { email },
			}
		};
	},
	mounted(){
		if(this.dealer) {
			this.form_data.name = this.form_data.name ? this.form_data.name: this.dealer.name;
			this.form_data.firm_name = this.form_data.firm_name ? this.form_data.firm_name:  this.dealer.firm_name;
			this.form_data.city = this.form_data.city ? this.form_data.city:  this.dealer.city;
			this.form_data.state = this.form_data.state ? this.form_data.state:  this.dealer.state;
			this.form_data.phone = this.form_data.phone ? this.form_data.phone:  this.dealer.phone;
			this.form_data.email = this.form_data.email ? this.form_data.email:  this.dealer.email;
			this.form_data.address = this.form_data.address ? this.form_data.address:  this.dealer.address;
			this.form_data.gst_details = this.form_data.gst_details ? this.form_data.gst_details:  this.dealer.gst_details;
			this.isEdit = true;
		}
	},
	methods: {
		async handleSubmit() {
			const result = await this.v$.$validate();
			if (result) {
				this.form_data.edit= this.dealer ? true : false,
				this.form_data.id= this.dealer ? this.dealer.id : 0,
				this.$axios.post('/api/master/create-or-update-dealer', this.form_data).then(() => {
					this.$swal(this.form_data.edit ? 'Dealer edited ' : 'Dealer added');
					this.v$.$reset();
					this.clearForm();
				});
			}

		},
		clearForm() {
			this.form_data = {
				name: '',
				firm_name: '',
				city: '',
				state: '',
				phone: '',
				email: '',
				address: '',
				gst_details:'',
			};
		},
	}
};

</script>
