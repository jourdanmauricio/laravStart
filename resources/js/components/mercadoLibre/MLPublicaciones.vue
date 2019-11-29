<template>
  <div class="container">
    <!-- <div class="row mt-2" v-if="$gate.isAdminOrAuthor()"> -->
    <div class="row mt-2">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Listado de publicaciones</h3>
            <div class="card-tools">
              <input v-model="nick" type="text" name="nick" placeholder="Usuario ML" />

              <button class="btn btn-dark" @click="consPublic">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table
              class="table table-hover cell-border compact hover"
              style="width:100%"
              id="myTable"
            >
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Título</th>
                  <th>Precio</th>
                  <th>Cantidad</th>
                  <th>Detalle</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="publicacion in publicaciones" :key="publicacion.id">
                  <td>{{publicacion.id}}</td>
                  <td>{{publicacion.title}}</td>
                  <td>{{publicacion.currency_id}} {{publicacion.price}}</td>
                  <td>{{publicacion.available_quantity}}</td>
                  <td>
                    <!-- <a href="#" @click="editModal(user)"> -->
                    <!-- <a href="#" @click="editModal(user)">
                      <i class="fa fa-edit blue"></i>
                    </a>-->
                    /
                    <!--      <a href="#" @click="deleteUser(user.id)">
                        <i class="fa fa-trash red"></i>
                    </a>-->
                    <!-- </td> -->
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <!-- <pagination :data="users" @pagination-change-page="getResults"></pagination> -->
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <pre> {{ publicaciones }}</pre>
  </div>
</template>


<script>
import { mapState } from "vuex";
// import datatables from "datatables";
import "datatables.net-bs4";
//import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-buttons/js/buttons.flash.min";
import "datatables.net-buttons/js/buttons.print.min";
import "datatables.net-buttons/js/dataTables.buttons.min";
import "datatables.net-buttons-bs4";
import "datatables.net-colreorder";
import "datatables.net-buttons-bs4/css/buttons.bootstrap4.css";
import "datatables.net-buttons-bs4/js/buttons.bootstrap4.js";

export default {
  name: "MLPublicaciones",
  data() {
    return {
      ml_client: process.env.MIX_CLIENT_ID,
      ml_secret: process.env.MIX_CLIENT_SECRET,
      publicaciones: null,
      token: "",
      nick: ""
    };
  },
  computed: {
    ...mapState(["user_ml"]),
    customers() {
      return this.$store.getters.customers;
    }
  },
  mounted() {
    this.nick = this.user_ml;
    this.consPublic();
  },
  methods: {
    myTable() {
      $(document).ready(function() {
        var table = $("#myTable").DataTable({
          dom:
            "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          buttons: ["copy", "excel", "pdf", "print"],
          destroy: true,
          colReorder: true,
          language: {
            paging: true,
            url: "/images/vendor/datatables/media/dataTables.spanish.lang"

            //             url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
          }
        });
      });
    },

    async consPublic() {
      if (this.nick) {
        $("#myTable")
          .DataTable()
          .destroy();

        await axios
          .get(
            "https://api.mercadolibre.com/sites/MLA/search?nickname=" +
              this.nick
          )
          .then(response => {
            this.publicaciones = response.data.results;
          })
          .catch(e => {
            console.log(e);
          });
        // $("#myTable")
        //   .DataTable()
        //   .fnReloadAjax();
        this.myTable();
      }
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
