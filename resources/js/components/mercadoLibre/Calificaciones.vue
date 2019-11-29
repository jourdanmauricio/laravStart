
<template>
  <div>
    <h3>Calificaciones</h3>
  </div>
</template>

<script>
export default {
  name: "Calificaciones",
  computed: {
    customers() {
      return this.$store.getters.customers;
    }
  }
};
</script>

<style scoped>
.btn-wrapper {
  text-align: right;
  margin-bottom: 20px;
}
</style>
