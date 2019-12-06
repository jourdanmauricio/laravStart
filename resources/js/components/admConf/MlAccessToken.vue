<template>
  <div class="container">
    <div class="row" v-if="$gate.isAdminOrAuthor()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tokens ML Table</h3>

            <div class="card-tools">
              <button class="btn-sm btn-success" @click="newModal">
                Add new
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <simpletable
              :headers="headers"
              :contents="tokens"
              :actions="actions"
              @evento="eventoHijo"
            />
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
    <!-- /.card -->

    <!-- Modal -->
    <div
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewLabel" v-show="!editmode">Add New</h5>
            <h5 class="modal-title" id="addNewLabel" v-show="editmode">Update Info</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateToken() : createUser()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.id"
                  type="text"
                  name="id"
                  placeholder="id"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('id') }"
                />
                <has-error :form="form" field="id"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.access_token"
                  type="text"
                  name="access_token"
                  placeholder="Token"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('access_token') }"
                />
                <has-error :form="form" field="access_token"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.token_type"
                  type="text"
                  name="token_type"
                  placeholder="Typo"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('token_type') }"
                />
                <has-error :form="form" field="token_type"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.expires_in"
                  type="text"
                  name="expires_in"
                  placeholder="Expires?"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('expires_in') }"
                />
                <has-error :form="form" field="expires_in"></has-error>
              </div>

              <div class="form-group">
                <input
                  v-model="form.scope"
                  type="text"
                  name="scope"
                  placeholder="Scope"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('scope') }"
                />
                <has-error :form="form" field="scope"></has-error>
              </div>

              <div class="form-group">
                <input
                  v-model="form.user_id"
                  type="text"
                  name="user_id"
                  placeholder="User Id"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('user_id') }"
                />
                <has-error :form="form" field="ml_user_id"></has-error>
              </div>

              <div class="form-group">
                <input
                  v-model="form.ml_user_id"
                  type="text"
                  name="ml_user_id"
                  placeholder="User Id ML"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('ml_user_id') }"
                />
                <has-error :form="form" field="ml_user_id"></has-error>
              </div>

              <div class="form-group">
                <input
                  v-model="form.ml_user"
                  type="text"
                  name="ml_user"
                  placeholder="User ML"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('ml_user') }"
                />
                <has-error :form="form" field="ml_user"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.refresh_token"
                  type="text"
                  name="refresh_token"
                  placeholder="Refresh token"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('refresh_token') }"
                />
                <has-error :form="form" field="refresh_token"></has-error>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import simpletable from "../SimpleTable.vue";
export default {
  name: "MLAccessToken",
  components: {
    simpletable
  },
  data() {
    return {
      tokens: [],
      editmode: false,
      form: new Form({
        id: "",
        access_token: "",
        token_type: "",
        expires_in: "",
        scope: "",
        user_id: "",
        ml_user_id: "",
        ml_user: "",
        refresh_token: ""
      }),
      headers: [
        { name: "Id", dbcampo: "id", order: true },
        { name: "Access Token", dbcampo: "access_token", order: true },
        { name: "Type", dbcampo: "token_type", order: true },
        { name: "Expires", dbcampo: "expires_in", order: true },
        { name: "Scope", dbcampo: "scope", order: true },
        { name: "User Id", dbcampo: "user_id", order: true },
        { name: "Ml User Id", dbcampo: "ml_user_id", order: true },
        { name: "User Ml", dbcampo: "ml_user", order: true },
        { name: "Refresh Token", dbcampo: "refresh_token", order: true }
      ],
      actions: [
        {
          action: "edit",
          icon: "fas fa-pen orange"
        },
        {
          action: "delete",
          icon: "fas fa-trash red"
        }
      ]
    };
  },
  computed: {
    ...mapState(["user_ml"]),
    customers() {
      return this.$store.getters.customers;
    }
  },
  methods: {
    newModal() {
      this.form.reset();
      $("#addNew").modal("show");
    },
    eventoHijo: function(action, token) {
      if (action === "edit") {
        this.editmode = true;
        this.form.reset();
        $("#addNew").modal("show");
        this.form.fill(token);
      }
    },
    updateToken() {
      this.$Progress.start();

      //      console.log("Editing data");
      this.form
        .put("/api/mltokens/" + this.form.id)
        .then(() => {
          // Success
          $("#addNew").modal("hide");
          swal.fire("Updated!", "Information has been updated.", "success");
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
        })
        .catch(() => {
          // Errror
          this.$Progress.fail();
        });
    },
    loadTokens() {
      if (this.$gate.isAdmin()) {
        this.tokens = [];
        axios
          .get("/api/mltokens")
          .then(res => {
            res.data.forEach(element => {
              let registro = {
                id: element.id,
                access_token: element.access_token,
                token_type: element.token_type,
                expires_in: element.expires_in,
                scope: element.scope,
                user_id: element.ml_user_id,
                ml_user_id: element.ml_user_id,
                ml_user: element.ml_user,
                refresh_token: element.refresh_token
              };
              this.tokens.push(registro);
            });
          })
          .catch(err => {
            console.log(err);
          });
      }
    }
  },

  created: function() {
    this.loadTokens();
    Fire.$on("AfterCreate", () => {
      this.loadTokens();
    });
  }
};
</script>

<style scoped>
</style>
