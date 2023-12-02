<template>
  <Head title="Signup" />
  <main class="d-flex w-100">
    <div class="container d-flex flex-column">
      <div class="row vh-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
          <div class="d-table-cell align-middle">
            <div class="text-center mt-4">
              <h1 class="h2">
                Get started
              </h1>
              <p class="lead">
                Start creating the best possible user experience for you customers.
              </p>
            </div>

            <div class="card">
              <div class="card-body">
                <div class="m-sm-4">
                  <form @submit.prevent="createNewUser">
                    <div class="mb-3">
                      <label class="form-label">Name</label>
                      <input
                        v-model="name"
                        class="form-control form-control-lg"
                        type="text"
                        name="name"
                        placeholder="Enter your name"
                      >
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input
                        v-model="email"
                        class="form-control form-control-lg"
                        type="email"
                        name="email"
                        placeholder="Enter your email"
                      >
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Password</label>
                      <input
                        v-model="password"
                        class="form-control form-control-lg"
                        type="password"
                        name="password"
                        placeholder="Enter password"
                      >
                    </div>
                    <div class="text-center mt-3">
                      <button
                        type="submit"
                        class="me-2 btn btn-lg btn-primary"
                      >
                        Sign up
                      </button>
                      <Link
                        href="/"
                        class="me-2 btn btn-lg btn-secondary"
                      >
                        Login
                      </Link>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<script>

export default {
	data() {
		return {
			name: '',
			email: '',
			password: '',
		};
	},
	methods: {
		createNewUser() {
			this.$axios.post('/api/signup', {
				name: this.name,
				email: this.email,
				password: this.password,
			}).catch((error) => {
				console.log('error while sign up', error);
			});
		}
	}
};
</script>
