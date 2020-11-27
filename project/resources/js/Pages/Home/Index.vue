<template>
  <layout title="Welcome">
    <h1>Welcome</h1>
    <p>Hello {{ user.name }}, welcome to your first Inertia app!</p>
  </layout>
</template>

<script>
import Layout from '@/Shared/Layouts/Main/Layout';

export default {
  components: {
    'layout': Layout,
  }
}
</script>
