<template>
  <div class="container">
    <!-- <div class="row mt-3" v-if="$gate.isAdminOrAuthor()"> -->
    <div class="row mt-3">
      <div class="col-md-12">
        <nav class="navbar navbar-expand-md">
          <h4>Configuración de productos</h4>
          <ul class="navbar-nav ml-auto">
            <li>
              <router-link to="/confprod/mlpublicaciones" class="nav-link">Publicaciones ML</router-link>
            </li>

            <li>
              <router-link to="/confprod/wpprod" class="nav-link">WordPress Prod</router-link>
            </li>
            <li class="nav-item dropdown">
              <a
                id="navbarDropdown"
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-toggle="dropdown"
                aria-expanded="false"
                aria-haspopup="true"
              >
                Dropdown
                <span class="caret"></span>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a href="#!" @click.prevent="logout" class="dropdown-item">Otros 1</a>
                <a href="#!" @click.prevent="logout" class="dropdown-item">Otros 2</a>
              </div>
            </li>
          </ul>
        </nav>

        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ConfProd"
};
</script>

<style scoped>
.btn-wrapper {
  text-align: right;
  margin-bottom: 20px;
}
nav.navbar {
  background-color: rgba(0, 0, 0, 0);
}
</style>

