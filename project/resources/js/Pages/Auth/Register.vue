<template>
  <layout>
    <div class="container mx-auto">
      <div class="flex flex-wrap justify-center">
        <div class="w-full max-w-sm">
          <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

            <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
              Cadastre-se
            </div>

            <form class="w-full p-6" method="POST" @submit.prevent="submit">
              <div class="flex flex-wrap mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                  Nome de usuário:
                </label>

                <input type="text"
                       id="name"
                       v-model="form.name"
                       class="form-input w-full" name="name"
                       value="" required autocomplete="name" autofocus>
                <ErrorBlock field="name"></ErrorBlock>
              </div>

              <div class="flex flex-wrap mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                  E-Mail:
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
                  Senha:
                </label>

                <input type="password"
                       id="password"
                       v-model="form.password"
                       class="form-input w-full" name="password"
                       required>
                <ErrorBlock field="password"></ErrorBlock>
              </div>

              <div class="flex flex-wrap mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">
                  Confirmação da senha:
                </label>

                <input type="password"
                       id="password_confirmation"
                       v-model="form.password_confirmation"
                       class="form-input w-full" name="password_confirmation"
                       required>
                <ErrorBlock field="password_confirmation"></ErrorBlock>
              </div>

              <div class="flex flex-wrap items-center">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                  Cadastrar
                </button>

                <p class="w-full text-xs text-center text-gray-700 mt-8 -mb-4">
                  Já é cadastrado?
                  <inertia-link class="text-blue-500 hover:text-blue-700 no-underline"
                     :href="$route('login')">
                    Faça login
                  </inertia-link>
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
  name: "Register",

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
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
    }
  },

  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.$route('register'), {
        name: this.form.name,
        email: this.form.email,
        password: this.form.password,
        password_confirmation: this.form.password_confirmation,
      }).then(() => this.sending = false)
    },
  },
}
</script>

<style scoped>

</style>
