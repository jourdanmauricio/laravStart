<template>
  <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
      <!-- <router-link class="navbar-brand" to="/MercadoLibre">Mercado Libre</router-link> -->
      <!-- <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>-->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <template>
            <li>
              <router-link to="/mercadolibre/Ventas" class="nav-link">Ventas</router-link>
            </li>
            <li>
              <router-link to="/mercadolibre/Publicaciones" class="nav-link">Publicaciones</router-link>
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
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "MLMenu"
};
</script>

<style scoped>
.btn-wrapper {
  text-align: right;
  margin-bottom: 20px;
}
</style>
