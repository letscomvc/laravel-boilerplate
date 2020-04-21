<template>
    <div class="container">
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

<!--                                    @if ($errors->has('email'))-->
<!--                                    <div class="invalid-feedback">-->
<!--                                        <strong>{{ $errors->first('email') }}</strong>-->
<!--                                    </div>-->
<!--                                    @endif-->
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

                                    <!--                                    @if ($errors->has('password'))-->
                                    <!--                                    <div class="invalid-feedback">-->
                                    <!--                                        <strong>{{ $errors->first('password') }}</strong>-->
                                    <!--                                    </div>-->
                                    <!--                                    @endif-->
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6 offset-lg-4">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="remember"
                                                   v-model="form.remember">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-8 offset-lg-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <!--                                    <a class="btn btn-link" href="">-->
                                    <!--                                        Forgot Your Password?-->
                                    <!--                                    </a>-->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: "Login",

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
        // this.$inertia.post(this.route('login.attempt'), {
        //   email: this.form.email,
        //   password: this.form.password,
        //   remember: this.form.remember,
        // }).then(() => this.sending = false)
      },
    },
  }
</script>

<style scoped>

</style>