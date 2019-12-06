
<template>
  <div>
    <h3>Wordpress Product</h3>
    <button @click="getCategorias()">Categorias</button>
  </div>
</template>

<script>
export default {
  name: "WpProd",
  data() {
    return {
      categorias: []
    };
  },
  methods: {},
  mounted: {}
};
</script>

<style scoped>
.btn-wrapper {
  text-align: right;
  margin-bottom: 20px;
}
</style>
