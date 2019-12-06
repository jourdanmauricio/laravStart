<template>
  <div class="container">
    <div class="row mt-3" v-if="$gate.isAdminOrAuthor()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Publicaciones Mercado Libre</h3>
            <!-- <input class="col-md-1" type="text" v-model="pageSize" /> -->
            <select v-model="pageSize" class="col-md-1 custom-select ml-5">
              <option selected>Choose...</option>
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="100">100</option>
            </select>
            <div class="card-tools">
              <button class="btn btn-success">
                Add new
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-bordered table-sm hover" style="width:100%">
              <!-- <caption>List of users</caption> -->
              <thead class="thead-dark">
                <tr>
                  <th>
                    Name
                    <span @click="sort('name')" class="fa fa-sort"></span>
                  </th>
                  <th>
                    Age
                    <span @click="sort('age')" class="fa fa-sort"></span>
                  </th>
                  <th>
                    Breed
                    <span @click="sort('breed')" class="fa fa-sort"></span>
                  </th>
                  <th>
                    Gender
                    <span @click="sort('gender')" class="fa fa-sort"></span>
                  </th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="cat in sortedCats" :key="cat.id">
                  <td>{{cat.name}}</td>
                  <td>{{cat.age}}</td>
                  <td>{{cat.breed}}</td>
                  <td>{{cat.gender}}</td>
                  <td>
                    <a href="#" @click="editModal(user)">
                      <i class="fas fa-eye orange"></i>
                    </a>
                    /
                    <a href="#" @click="editModal(user)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteUser(user.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <p>
              <button class="btn-sm btn-primary" @click="prevPage">Previous</button>
              {{ currentPage }}
              <button
                class="btn-sm btn-primary"
                @click="nextPage"
              >Next</button>
            </p>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <div v-if="!$gate.isAdminOrAuthor()">
      <not-found></not-found>
    </div>

    <!-- Modal -->
    <!-- <div
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
            <h5 class="modal-title" id="addNewLabel" v-show="editmode">Update User's Info</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateUser() : createUser()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.name"
                  type="text"
                  name="name"
                  placeholder="Name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.user_ml"
                  type="text"
                  name="user_ml"
                  placeholder="User Mercado Libre"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('user_ml') }"
                />
                <has-error :form="form" field="user_ml"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.email"
                  type="email"
                  name="email"
                  placeholder="Email Address"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                />
                <has-error :form="form" field="email"></has-error>
              </div>
              <div class="form-group">
                <textarea
                  v-model="form.bio"
                  name="bio"
                  id="bio"
                  placeholder="Short bio for user (Optional)"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('bio') }"
                ></textarea>
                <has-error :form="form" field="bio"></has-error>
              </div>

              <div class="form-group">
                <select
                  name="type"
                  v-model="form.type"
                  id="type"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                >
                  <option value>Select user role</option>
                  <option value="admin">Admin</option>
                  <option value="user">Standard User</option>
                  <option value="author">Author</option>
                </select>
                <has-error :form="form" field="type"></has-error>
              </div>

              <div class="form-group">
                <input
                  v-model="form.password"
                  type="password"
                  name="password"
                  id="password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
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
    </div>-->
  </div>
</template>


<script>
import { mapState } from "vuex";

export default {
  name: "MlPublicaciones",
  data() {
    return {
      cats: [],
      currentSort: "name",
      currentSortDir: "asc",
      pageSize: 5,
      currentPage: 1
    };
  },
  computed: {
    sortedCats: function() {
      return this.cats
        .sort((a, b) => {
          let modifier = 1;
          if (this.currentSortDir === "desc") modifier = -1;
          if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
          if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
          return 0;
        })
        .filter((row, index) => {
          let start = (this.currentPage - 1) * this.pageSize;
          let end = this.currentPage * this.pageSize;
          if (index >= start && index < end) return true;
        });
    }
  },
  created: function() {
    fetch("https://api.myjson.com/bins/s9lux")
      .then(res => res.json())
      .then(res => {
        this.cats = res;
      });
  },
  methods: {
    sort: function(s) {
      //if s == current sort, reverse
      if (s === this.currentSort) {
        this.currentSortDir = this.currentSortDir === "asc" ? "desc" : "asc";
      }
      this.currentSort = s;
    },
    nextPage: function() {
      if (this.currentPage * this.pageSize < this.cats.length)
        this.currentPage++;
    },
    prevPage: function() {
      if (this.currentPage > 1) this.currentPage--;
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
