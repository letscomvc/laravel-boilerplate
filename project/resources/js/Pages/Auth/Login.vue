<template>
    <layout>
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" @submit.prevent="submit">
                            <div class="form-group row">
                                <label for="email" class="col-lg-4 col-form-label text-lg-right">E-Mail Address</label>

                                <div class="col-lg-6">
                                    <input
                                            id="email"
                                            type="email"
                                            class="form-control"
                                            name="email"
                                            v-model="form.email"
                                    >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-lg-4 col-form-label text-lg-right">Password</label>

                                <div class="col-lg-6">
                                    <input
                                            id="password"
                                            type="password"
                                            class="form-control"
                                            name="password"
                                            v-model="form.password"
                                            required
                                    >
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6 offset-lg-4">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="remember"
                                                   v-model="form.remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-8 offset-lg-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <inertia-link class="btn btn-link" :href="route('password.request')">
                                        Forgot Your Password?
                                    </inertia-link>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
  import Layout from '@/Shared/Layouts/Main/Layout';

  export default {
    name: "Login",

    components: {
      Layout,
    },

    data() {
      return {
        sending: false,
        form: {
          email: '',
          password: '',
          remember: null,
        },
      }
    },

    methods: {
      submit() {
        this.sending = true
        this.$inertia.post(this.route('login'), {
          email: this.form.email,
          password: this.form.password,
          remember: this.form.remember,
        }).then(() => this.sending = false)
      },
    },
  }
</script>

<style scoped>

</style>