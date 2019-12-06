<template>
  <div class="container">
    <div class="row" v-if="$gate.isAdminOrAuthor()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Arbol de Categorías Mercado Libre</h3>
            <div class="card-tools">
              <button class="btn-sm btn-success" @click="getCategorias()">
                Refresh
                <i class="fas fa-sync fa-fw"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <simpletable
              :headers="headers"
              :contents="categorias"
              :actions="actions"
              @evento="eventoHijo"
            />
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Arbol de Sub Categorías</h3>
        <div class="card-tools"></div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <simpletable
          :headers="headers2"
          :contents="subCategorias"
          :actions="actions2"
          @evento="eventoHijo"
        />
      </div>
      <!-- /.card -->
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Arbol de Sub Categorías</h3>
        <div class="card-tools"></div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <simpletable
          :headers="headers2"
          :contents="subSubCategorias"
          :actions="actions3"
          @evento="eventoHijo"
        />
      </div>
      <!-- /.card -->
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Arbol de Sub Categorías</h3>
        <div class="card-tools"></div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <simpletable :headers="headers2" :contents="subSubSubCategorias" :actions="actions3" />
      </div>
      <!-- /.card -->
    </div>
  </div>
</template>

<script>
import simpletable from "../SimpleTable.vue";
export default {
  name: "MlConfCat",
  components: {
    simpletable
  },
  data() {
    return {
      categorias: [],
      subCategorias: [],
      subSubCategorias: [],
      subSubSubCategorias: [],
      pageSize: 5,
      ml_id: "",
      child: "",
      headers: [
        { name: "ID", dbcampo: "id", order: true },
        { name: "ML Id", dbcampo: "ml_id", order: true },
        { name: "NAME", dbcampo: "name", order: true },
        { name: "CREATE", dbcampo: "created_at", order: false }
      ],
      headers2: [
        { name: "CATEGORIA", dbcampo: "categoria", order: false },
        { name: "HIJO", dbcampo: "child", order: true },
        { name: "NAME", dbcampo: "name", order: true },
        { name: "ITEMS", dbcampo: "cant_items", order: true }
      ],
      actions: [
        {
          action: "select",
          icon: "fa fa-object-group blue"
        }
      ],
      actions2: [
        {
          action: "select2",
          icon: "fa fa-object-group blue"
        }
      ],
      actions3: [
        {
          action: "select3",
          icon: "fa fa-object-group blue"
        }
      ]
    };
  },
  methods: {
    eventoHijo: function(action, categoria) {
      if (action === "select") {
        this.ml_id = categoria.ml_id;
        this.subCategorias = [];
        this.refresfSubCat();
      }
      if (action === "select2") {
        this.child = categoria.child;
        this.subSubCategorias = [];
        this.refresfSubSubCat();
      }
      if (action === "select3") {
        this.child = categoria.child;
        this.subSubSubCategorias = [];
        this.refresfSubSubSubCat();
      }

      console.log("evento...");
      console.log(action);
      console.log(categoria.ml_id);
      console.log(categoria.child);
    },
    refresfSubCat() {
      console.log("refresh cat");
      axios
        .get("/api/mlcategoriachildren", { params: { ml_id: this.ml_id } })
        .then(res => {
          res.data.forEach(element => {
            let registro = {
              categoria: element.categoria,
              child: element.child,
              name: element.mlsubcategoria.name,
              cant_items: element.mlsubcategoria.cant_items
            };
            this.subCategorias.push(registro);
          });
        })
        .catch(err => {
          console.log(err);
        });
    },
    refresfSubSubCat() {
      console.log("refresh cat");
      axios
        .get("/api/mlcategoriachildren", { params: { ml_id: this.child } })
        .then(res => {
          res.data.forEach(element => {
            let registro = {
              categoria: element.categoria,
              child: element.child,
              name: element.mlsubcategoria.name,
              cant_items: element.mlsubcategoria.cant_items
            };
            this.subSubCategorias.push(registro);
          });
        })
        .catch(err => {
          console.log(err);
        });
    },
    refresfSubSubSubCat() {
      console.log("refresh cat");
      axios
        .get("/api/mlcategoriachildren", { params: { ml_id: this.child } })
        .then(res => {
          res.data.forEach(element => {
            let registro = {
              categoria: element.categoria,
              child: element.child,
              name: element.mlsubcategoria.name,
              cant_items: element.mlsubcategoria.cant_items
            };
            this.subSubSubCategorias.push(registro);
          });
        })
        .catch(err => {
          console.log(err);
        });
    },
    getCategorias() {
      swal
        .fire({
          title: "Estas seguro?",
          text:
            "Este proceso elimina el árbol de categorías y lo regenera. Demorará varios minutos! La información se actualiza diriamente a través de proc batch.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, continuar!"
        })
        .then(result => {
          if (result.value) {
            this.getProcCategoria();
          }
        });
    },
    async getProcCategoria() {
      this.$Progress.start();
      console.log("LOCO! Llamando a la API");
      // Obtengo las categorías desde la API ML
      await axios
        .post("/api/mlsubcategoriaxlote")
        .then(res => {
          swal.fire(
            "Actualizado!",
            "Se actualizó la información de las categorías.",
            "success"
          );
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
        })
        .catch(e => {
          console.log(e);
          this.$Progress.fail();
        });
    },
    nextPage: function() {
      if (this.currentPage * this.pageSize < this.categorias.length)
        this.currentPage++;
    },
    prevPage: function() {
      if (this.currentPage > 1) this.currentPage--;
    }
  },
  created: function() {
    axios
      .get("/api/mlcategorias")
      .then(res => {
        this.categorias = res.data;
        console.log(this.categorias);
      })
      .catch(err => {
        console.log(err);
      });
    this.refresfSubCat();
  }
};
</script>

<style scoped>
.btn-wrapper {
  text-align: right;
  margin-bottom: 20px;
}
</style>
