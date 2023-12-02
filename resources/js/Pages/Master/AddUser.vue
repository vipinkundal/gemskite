<template>
  <Head :title="'Add User'" />
  <div class="container-fluid p-0">
    <div class="mb-3">
      <h1 class="h3 d-inline align-middle">
        Add User
      </h1>
    </div>
    <div class="card">
      <div class="card-body">
        <form @submit.prevent="handleSubmit">
          <div class="row mb-2">
            <div class="col col-12 col-sm-6 col-md-4">
              <div class="form-group">
                <label
                  class="form-label"
                  for="first_name"
                >First Name <span class="required-label">*</span></label>
                <input
                  id="first_name"
                  v-model="v$.form.first_name.$model"
                  type="text"
                  name="first_name"
                  class="form-control"
                >
                <span
                  v-if="v$.form.first_name.$error"
                  class="text-danger"
                >First Name field required</span>
              </div>
            </div>
            <div class="col col-12 col-sm-6 col-md-4">
              <div class="form-group">
                <label
                  class="form-label"
                  for="last_name"
                >Last Name <span class="required-label">*</span></label>
                <input
                  id="last_name"
                  v-model="v$.form.last_name.$model"
                  type="text"
                  name="last_name"
                  class="form-control"
                >
                <span
                  v-if="v$.form.last_name.$error"
                  class="text-danger"
                >Last Name field required</span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col col-12 col-sm-6 col-md-4">
              <div class="form-group">
                <label
                  class="form-label"
                  for="email"
                >Email <span class="required-label">*</span></label>
                <input
                  id="email"
                  v-model="v$.form.email.$model"
                  type="email"
                  name="email"
                  class="form-control"
                >
                <span v-if="v$.form.email.$error">
                  <span
                    v-if="v$.form.email.$error && vuelidateExternalResults.form.email"
                    class="text-danger"
                  >{{ vuelidateExternalResults.form.email }}</span>
                  <span
                    v-if="v$.form.email.required.$invalid"
                    class="text-danger"
                  >Email field required</span>
                  <span
                    v-if="v$.form.email.email.$invalid"
                    class="text-danger"
                  >Please enter a valid email</span>
                </span>
              </div>
            </div>
            <div class="col col-12 col-sm-6 col-md-4">
              <div class="form-group">
                <label
                  class="form-label"
                  for="contact"
                >Phone <span class="required-label">*</span></label>
                <input
                  id="contact"
                  v-model="v$.form.phone.$model"
                  type="text"
                  name="phone"
                  class="form-control"
                >
                <span v-if="v$.form.phone.$error">
                  <span
                    v-if="v$.form.phone.required.$invalid"
                    class="text-danger"
                  >Phone field required</span>
                  <span
                    v-else-if="v$.form.phone.minLength.$invalid"
                    class="text-danger"
                  >Phone number is not valid</span>
                </span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col col-12 col-sm-6 col-md-4">
              <div class="form-group">
                <label
                  class="form-label"
                  for="password"
                >Password <span class="required-label">*</span></label>
                <input
                  id="contact"
                  v-model="v$.form.password.$model"
                  type="password"
                  name="password"
                  class="form-control"
                >
                <span v-if="v$.form.password.$error">
                  <span
                    v-if="v$.form.password.required.$invalid"
                    class="text-danger"
                  >Password field required</span>
                  <span
                    v-else-if="v$.form.password.minLength.$invalid"
                    class="text-danger"
                  >Minimum password length should be 8 characters</span>
                </span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col col-12">
              <div class="mt-3">
                <button
                  type="submit"
                  class="btn btn-primary me-3"
                >
                  Submit
                </button>
                <button
                  type="button"
                  class="btn btn-danger"
                  @click="resetForm()"
                >
                  Reset
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { email, minLength, required } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
export default {
	name:'AddUser',
	setup(){
		return {v$:useVuelidate()};
	},
	data(){
		return {
			form : {
				email: '',
				password: '',
				phone: '',
				first_name: '',
				last_name: '',
			},
			vuelidateExternalResults : {
				form :{
					email:''
			    }
			}
		};
	},
	validations(){
		return {
			form : {
				email: { required, email },
				password: { required, minLength:minLength(8) },
				phone: { required, minLength: minLength(10) },
				first_name: { required },
				last_name: { required },
			}
		};
	},
	methods: {
		async handleSubmit() {
			const result = await this.v$.form.$validate();
			if (result) {
				this.$axios.post('/api/master/add-user', this.form)
					.then(() => {
						this.$swal('User Added');
						this.resetForm();
					})
					.catch(({response:{data:{error:{email}}}})=>{
						this.vuelidateExternalResults.form.email = email;
					});
			}
		},
		resetForm(){
			this.v$.$reset();
			this.form ={
				email: '',
				password: '',
				phone: '',
				first_name: '',
				last_name: '',
			};
		}
	}
};
</script>
