
<template>
  <Head title="Login" />
  <div class="container d-flex flex-column">
    <div class="row">
      <div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
        <div class="text-center mt-4">
          <h1 class="h2">
            Welcome back
          </h1>
          <p class="lead">
            Sign in to your account to continue
          </p>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="m-sm-4">
              <form
                novalidate="novalidate"
                @submit.prevent="loginUser"
              >
                <div class="mb-3">
                  <label class="form-label">Email <span class="required-label">*</span></label>
                  <input
                    v-model="v$.form.email.$model"
                    class="form-control form-control-lg"
                    required="required"
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                  >
                  <span v-if="v$.form.email.$error">
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
                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input
                    v-model="v$.form.password.$model"
                    class="form-control form-control-lg"
                    required="required"
                    type="password"
                    name="password"
                    placeholder="Enter your password"
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
                <div class="text-center mt-3">
                  <button
                    type="submit"
                    class="me-2 btn btn-lg btn-primary"
                  >
                    Sign in
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { email, minLength, required } from '@vuelidate/validators';
import useVuelidate from '@vuelidate/core';
export default {
	setup : ()=>({v$: useVuelidate()}),
	data() {
		return {
			form :{
				email: '',
				password: '',
			}
		};
	},
	validations(){
		return {
			form : {
				email: { required, email },
				password: { required, minLength:minLength(8) },
			}
		};
	},
	methods: {
		loginUser() {
			this.v$.form.$validate().then((result)=>{
				if(result) {
					this.$axios.post('login', this.form).then((resp) => {
						if (resp.data && resp.data.success.user && resp.data.success.user.id) {
							window.location.reload();
						}
					});
				}
			}).catch((error) => {
				console.error(error);
			});
		}
	}
};
</script>
