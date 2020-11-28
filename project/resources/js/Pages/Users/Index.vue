<template>
  <layout>
    <h1 class="mb-5 font-bold text-gray-800 text-3xl">Usuários</h1>
    <div class="flex justify-between items-center">
      <div class="flex flex-col w-full">
        <span class="text-gray-800">Buscar:</span>
        <input type="text" class="px-4 py-2 w-1/3 border border-gray-400">
      </div>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Nome</th>
          <th class="px-6 pt-6 pb-4">Email</th>
          <th class="px-6 pt-6 pb-4" colspan="2">Cadastrado em</th>
        </tr>
        <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t px-6 py-4">
            {{ user.name }}
          </td>
          <td class="border-t px-6 py-4">
            {{ user.email }}
          </td>
          <td class="border-t px-6 py-4">
            {{ $dayjs(user.created_at).format("DD/MM/YYYY") }}
          </td>
          <td class="border-t px-6 py-4 text-center">
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold px-3 py-2 rounded inline-block sm:w-10 md:w-auto cursor-pointer">
              <span class="md:inline mr-0 md:mr-1"><i class="fa fa-search"></i></span>
              <span class="md:inline hidden">Ver</span>
            </button>
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-3 py-2 rounded inline-block sm:w-10 md:w-auto cursor-pointer">
              <span class="md:inline mr-0 md:mr-1"><i class="fa fa-search"></i></span>
              <span class="md:inline hidden">Editar</span>
            </button>
            <button class="bg-red-500 hover:bg-red-600 text-white font-bold px-3 py-2 rounded inline-block sm:w-10 md:w-auto cursor-pointer">
              <span class="md:inline mr-0 md:mr-1"><i class="fa fa-search"></i></span>
              <span class="md:inline hidden">Apagar</span>
            </button>
          </td>
        </tr>
      </table>
    </div>
    <pagination :links="users.links"></pagination>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layouts/Main/Layout";
import Pagination from "@/Components/Pagination";

export default {
  name: "Index.vue",
  components: {
    Pagination,
    Layout,
  },

  props: {
    users: Object,
    filters: Object,
  },
}
</script>

<style scoped>

</style>
