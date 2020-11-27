<template>
  <nav class="bg-gray-700 shadow mb-4 py-6">
    <div class="container mx-auto px-6 md:px-0">
      <div class="flex items-center justify-center">
        <div class="mr-6">
          <a :href="$route('home')" class="text-lg font-semibold text-gray-100 no-underline">
            Base Laravel
          </a>
        </div>
        <div class="flex-1 text-right">
          <template v-if="!user">
            <a class="no-underline hover:underline text-gray-100 text-sm p-3"
               :href="$route('login')">Login</a>
            <a class="no-underline hover:underline text-gray-100 text-sm p-3"
               :href="$route('register')">Cadastre-se</a>
          </template>
          <template v-else>
            <span class="text-gray-100 text-sm pr-4">{{ user.name }}</span>

            <a class="no-underline hover:underline text-gray-100 text-sm pr-4"
               :href="$route('users.index')">
              Usuários
            </a>

            <a @click.prevent="logout"
               class="no-underline hover:underline text-gray-100 text-sm p-3 cursor-pointer">
              Desconectar
            </a>
          </template>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "Navbar",

  data() {
    return {
      user: this.$page.props.auth.user,
    }
  },

  methods: {
    logout() {
      this.$inertia
          .post(this.$route('logout'));
    },
  },
}
</script>
