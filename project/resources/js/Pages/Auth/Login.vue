<template>
  <layout>
    <div class="container mx-auto">
      <div class="flex flex-wrap justify-center">
        <div class="w-full max-w-sm">
          <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

            <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
              Login
            </div>

            <form class="w-full p-6" method="POST" @submit.prevent="submit">
              <div class="flex flex-wrap mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                  E-Mail Address:
                </label>

                <input type="email"
                       id="email"
                       v-model="form.email"
                       class="form-input w-full" name="email"
                       value="" required autocomplete="email" autofocus>
                <ErrorBlock field="email"></ErrorBlock>
              </div>

              <div class="flex flex-wrap mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                  Password:
                </label>

                <input type="password"
                       id="password"
                       v-model="form.password"
                       class="form-input w-full" name="password"
                       required>
                <ErrorBlock field="password"></ErrorBlock>
              </div>

              <div class="flex mb-6">
                <label class="inline-flex items-center text-sm text-gray-700" for="remember">
                  <input type="checkbox" name="remember" id="remember"
                         class="form-checkbox">
                  <span class="ml-2">Remember me</span>
                </label>
              </div>

              <div class="flex flex-wrap items-center">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                  Login
                </button>

                <p class="w-full text-xs text-center text-gray-700 mt-8 -mb-4">
                  Ainda não é cadastrado?
                  <a class="text-blue-500 hover:text-blue-700 no-underline"
                     :href="route('register')">
                    Cadastre-se
                  </a>
                </p>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from '@/Shared/Layouts/Auth/Layout';
import ErrorBlock from "@/Components/ErrorBlock";

export default {
  name: "Auth",

  components: {
    ErrorBlock,
    Layout,
  },

  props: {
    errors: Object,
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
