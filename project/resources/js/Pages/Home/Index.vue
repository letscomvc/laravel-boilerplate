<template>
  <layout title="Welcome">
    <h1>Seja bem-vindo!</h1>
    <p>Olá <span class="font-bold">{{ user.name }}</span>, Seja bem-vindo à basse de projetos da Lets Sistemas!</p>
  </layout>
</template>

<script>
import Layout from '@/Shared/Layouts/Main/Layout';

export default {
  components: {
    'layout': Layout,
  },

  data() {
    return {
     user: this.$page.props.auth.user,
    }
  },
}
</script>
