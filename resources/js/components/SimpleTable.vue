<template>
  <div>
    <div>
      <div class="search-wrapper panel-heading col-sm-12">
        <input class="form-control" type="text" v-model="searchQuery" placeholder="Search" />
      </div>
    </div>
    <div class="scrollme">
      <table id="simpletable" class="table table-hover text-center table-bordered table-sm hover">
        <!-- <caption>List of users</caption> -->
        <thead class="thead-dark">
          <tr>
            <th v-if="actions.length>0">ACCIONES</th>
            <th v-for="(header, index) in headers" :key="index">
              {{header.name}}
              <span
                v-if="header.order"
                @click="sortItem(header.dbcampo)"
                class="fa fa-sort"
              ></span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(contenido, key, index) in sortedItems" :key="index">
            <td v-if="actions.length>0">
              <a
                v-for="(action, key, index) in actions"
                :key="index"
                href="#"
                @click.prevent="$emit('evento', action.action, contenido)"
              >
                <i :class="[action.icon]"></i>
                <span class="mx-2" v-if="key < actions.length-1">|</span>
              </a>
            </td>

            <td v-for="(element,index) in contenido" :key="index">{{element}}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="card-footer text-center d-flex justify-content-between">
      <div class="d-flex align-items-center">{{contents.length}} registros</div>
      <div class="d-flex align-items-center">
        <select v-model="pageSize" class="form-control form-control-sm">
          <option selected>Choose...</option>
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="100">100</option>
        </select>
      </div>
      <div class="d-flex align-items-center">
        <button class="btn-sm btn-primary mx-3" @click="prevPage">Previous</button>
        {{ currentPage }}
        <button class="btn-sm btn-primary mx-3" @click="nextPage">Next</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "simpletable",
  props: ["headers", "contents", "actions"],
  data() {
    return {
      currentSort: "name",
      currentSortDir: "asc",
      pageSize: 5,
      currentPage: 1,
      searchQuery: ""
    };
  },
  created: function() {},
  computed: {
    sortedItems: function() {
      return this.contents
        .sort((a, b) => {
          let modifier = 1;
          if (this.currentSortDir === "desc") modifier = -1;
          if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
          if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
          return 0;
        })
        .filter((row, index) => {
          for (var item in row) {
            if (
              String(row[item])
                .toLowerCase()
                .includes(this.searchQuery.toLowerCase())
            ) {
              let start = (this.currentPage - 1) * this.pageSize;
              let end = this.currentPage * this.pageSize;
              if (index >= start && index < end) return true;
            }
          }
          return false;
        });
    }
  },
  methods: {
    sortItem: function(s) {
      if (s === this.currentSort) {
        this.currentSortDir = this.currentSortDir === "asc" ? "desc" : "asc";
      }
      this.currentSort = s;
    },
    nextPage: function() {
      if (this.currentPage * this.pageSize < this.contents.length)
        this.currentPage++;
    },
    prevPage: function() {
      if (this.currentPage > 1) this.currentPage--;
    }
  }
};
</script>

<style scoped>
#simpletable th,
td {
  white-space: nowrap;
}
.scrollme {
  overflow-y: auto;
}
</style>
