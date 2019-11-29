<template>
  <div class="container">
    <!-- <div class="row mt-3" v-if="$gate.isAdminOrAuthor()"> -->
    <div class="row mt-3">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
              Mercado Libre
              <ul class="navbar-nav ml-auto">
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
              </ul>
            </nav>
          </div>
          <router-view></router-view>
        </div>
        <!-- /.card-header -->
        <div class="card-body"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "MLMain"
};
</script>
