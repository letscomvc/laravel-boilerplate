<template>
  <div>
    <slot :handleDelete="handleDelete">
    </slot>
  </div>
</template>

<script>
export default {
  name: "delete-button",

  props: {
    link: {
      type: String,
      required: true,
    }
  },

  methods: {
    handleDelete() {
      axios.delete(this.link)
      .then((response) => {
        const status = response.data;
        if (status.type) {
          this.$snotify[status.type](status.message);
          this.$emit('deleted')
        } else {
          this.$snotify.error('Bad response');
        }
      });
    },
  }
}
</script>
