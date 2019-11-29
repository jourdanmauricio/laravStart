<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">HOME Component</div>

          <div class="card-body"></div>

          <div v-if="userMl.length> 0">Usuario de Mercado Libre: {{userMl}}</div>
          <div v-else>Debe configurar su usuario de mercado libre en su perfil</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {};
  },
  computed: {
    ...mapState(["user_ml"]),
    userMl() {
      return this.user_ml;
    }
  },
  methods: {
    async obtenerUser() {
      await this.$store.dispatch("getUserMl");
      //      this.userMl = this.user_ml;
    },
    async obtenerTokenMl() {
      await this.$store.dispatch("getTokenMl");
    }
  },
  created() {
    // TODO: considerar crear una tabla aparte para el user_ml de manera que un usuario del sistema pueda manejar múltiples cuentas de Mercado Libre. PEDIDO.
    this.obtenerUser();
  }
};
</script>
