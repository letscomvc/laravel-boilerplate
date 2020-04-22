<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <inertia-link class="navbar-brand" href="/">
                Base Laravel-Inertia
            </inertia-link>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <template v-if="!$page.auth.user">
                        <li class="nav-item">
                            <inertia-link :href="route('login')" class="nav-link">Login</inertia-link>
                        </li>
                        <li class="nav-item">
                            <inertia-link :href="route('register')" class="nav-link">Register</inertia-link>
                        </li>
                    </template>
                    <template v-else>
                        <li class="nav-item">
                            <inertia-link class="nav-link" :href="route('users.index')">Usuários</inertia-link>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink"
                               data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                {{ $page.auth.user.name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a @click.prevent="logout" href="#" class="dropdown-item">
                                    Logout
                                </a>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
  export default {
    name: "Navbar",

    methods: {
      logout() {
        this.$inertia
          .post(this.route('logout'));
      },
    },
  }
</script>