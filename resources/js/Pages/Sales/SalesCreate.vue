<template>
  <Head :title="'Create Sales'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Create Sales
      </h1>
    </div>
    <form
      action="#"
      novalidate="novalidate"
      @submit.prevent="submitSales"
    >
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="row">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 d-md-flex">
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Name *</label>
                      <input
                        v-model="form_data.name"
                        type="text"
                        class="form-control"
                        required="required"
                        placeholder="Name"
                      >
                      <span
                        v-if="v$.form_data.name.$error"
                        class="text-danger"
                      >Name field required</span>
                    </div>
                    <div class="col-12 col-md-6 mb-2 pe-2">
                      <label class="form-label">Firm Name *</label>
                      <input
                        v-model="form_data.country"
                        type="text"
                        class="form-control"
                        required="required"
                        placeholder="Firm Name"
                      >
                      <span
                        v-if="v$.form_data.country.$error"
                        class="text-danger"
                      >Firm Name field required</span>
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
import { email, numeric, required } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';

export default {
	props: ['supplier'],
   	setup() {
		return {v$: useVuelidate()};
	},
	data(){
		return {
			form_data:{
				name: '',
				country: '',
				phone: '',
				email: '',
			},

		};
	},
	mounted() {
		if(this.supplier) {
			this.form_data.name = this.form_data.name ? this.form_data.name: this.supplier.name;
			this.form_data.country = this.form_data.country ? this.form_data.name:  this.supplier.country;
			this.form_data.phone = this.form_data.phone ? this.form_data.name:  this.supplier.phone;
			this.form_data.email = this.form_data.email ? this.form_data.email:  this.supplier.email;
		}

	},
	validations() {
		return {
			form_data : {
				name: {required},
				country: {required},
				phone: {required, numeric},
				email: {required, email},
			}
		};
	},
	methods: {
		async submitLedger() {
			const result = await this.v$.$validate();
			if (result) {
				this.form_data.edit= this.supplier ? true : false,
				this.form_data.id= this.supplier ? this.supplier.id : 0,
				this.$axios.post('/api/master/create-or-update-supplier', this.form_data).then(() => {
					this.$swal(this.form_data.edit ? 'Ledger edited ' : 'Ledger added');
					this.v$.$reset();
					this.clearForm();
				});
			}
		},
		clearForm() {
			this.form_data = {
				name: '',
				country: '',
				phone: '',
				email: '',
			};
		},
	}
};

</script>
