<template>
  <div class="container">
    <div class="row mt-5" v-if="$gate.isAdmin()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">ML Tokens Table</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModal">
                Add new
                <i class="fas fa-redo fa-fw"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Access Token</th>
                  <th>Type</th>
                  <th>Expires</th>
                  <th>Scope</th>
                  <th>User Id</th>
                  <th>Refresh Token</th>
                  <th>Registered At</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="token in tokens.data" :key="token.id">
                  <td>{{token.id}}</td>
                  <td>{{token.access_token}}</td>
                  <td>{{token.token_type}}</td>
                  <td>{{token.expires_in}}</td>
                  <td>{{token.scope}}</td>
                  <td>{{token.user_id}}</td>
                  <td>{{token.refresh_token}}</td>
                  <td>{{token.created_at | myDate}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="tokens" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <div v-if="!$gate.isAdminOrAuthor()">
      <not-found></not-found>
    </div>

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
            <h5 class="modal-title" id="addNewLabel">Add New</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="createMlToken()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.access_token"
                  type="text"
                  name="access_token"
                  placeholder="Access Token"
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
                  placeholder="Type"
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
                  placeholder="Expires"
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
                  name="User Id"
                  placeholder="user_id"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('user_id') }"
                />
                <has-error :form="form" field="user_id"></has-error>
              </div>

              <div class="form-group">
                <input
                  v-model="form.refresh_token"
                  type="text"
                  name="refresh_token"
                  placeholder="Refresh Token"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('refresh_token') }"
                />
                <has-error :form="form" field="refresh_token"></has-error>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  name: "MLAccessToken",
  data() {
    return {
      tokens: {},
      form: new Form({
        access_token: "",
        token_type: "",
        expires_in: "",
        scope: "",
        user_id: "",
        refresh_token: ""
      })

      //   ml_client: process.env.MIX_CLIENT_ID,
      //   ml_secret: process.env.MIX_CLIENT_SECRET,
      //   publicaciones: null,
      //   token: "",
      //   nick: ""
    };
  },
  computed: {
    ...mapState(["user_ml"]),
    customers() {
      return this.$store.getters.customers;
    }
  },
  methods: {
    getResults(page = 1) {
      axios.get("api/mltokens?page=" + page).then(response => {
        this.tokens = response.data;
      });
    },
    newModal() {
      this.form.reset();
      $("#addNew").modal("show");
    },
    createMlToken() {
      this.$Progress.start();
      this.form
        .post("api/mltokens")
        .then(() => {
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");
          toast.fire({
            icon: "success",
            title: "User Created in Successfully"
          });
          this.$Progress.finish();
        })
        .catch(() => {});
    },
    loadTokens() {
      if (this.$gate.isAdmin()) {
        axios
          .get("api/mltokens")
          .then(({ data }) => (this.tokens = data))
          .catch(err => {
            console.log(err);
          });
      }
    }
  },

  created() {
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      console.log(query);
      axios
        .get("api/findToken?q=" + query)
        .then(data => {
          this.tokens = data.data;
        })
        .catch(err => {
          console.log(err);
        });
    });
    this.loadTokens();
    Fire.$on("AfterCreate", () => {
      this.loadTokens();
    });
    //    setInterval(()=> this.loadTokens(), 3000);
  }
};
</script>

<style scoped>
.btn-wrapper {
  text-align: right;
  margin-bottom: 20px;
}
</style>
