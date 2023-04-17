<template>
  <v-container>
    <v-row>
      <v-col class="d-flex">
        <h2>Users</h2>
        <v-spacer/>
        <router-link to="/users/create" custom>
          <v-btn>Create</v-btn>
        </router-link>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-data-table
          :headers="headers"
          :items="pagination.items"
          :options.sync="options"
          :server-items-length="pagination.total"
          :loading="fetchingPagination"
          :footer-props="footerProps"
          class="elevation-1"
        >
          <template v-slot:item.is_admin="{item}">
            <v-icon :color="item.is_admin? 'success': 'error'">{{ item.is_admin? 'mdi-check': 'mdi-close'}}</v-icon>
          </template>
          <template v-slot:item.actions="{item}">
            <v-menu bottom left>
              <template v-slot:activator="{ on, attrs }">
                <v-btn icon v-bind="attrs" v-on="on">
                  <v-icon>mdi-dots-horizontal</v-icon>
                </v-btn>
              </template>

              <v-list>
                <v-list-item-group>
                  <router-link :to="'/users/'+item.id" custom>
                    <v-list-item>
                      <v-list-item-icon><v-icon left>mdi-pencil</v-icon></v-list-item-icon>
                      <v-list-item-content><v-list-item-title>Edit</v-list-item-title></v-list-item-content>
                    </v-list-item>
                  </router-link>
                  <v-list-item :key="'action_destroy_'+item.id" @click="destroy(item.id)">
                    <v-list-item-icon><v-icon color="red" left>mdi-trash-can-outline</v-icon></v-list-item-icon>
                    <v-list-item-content><v-list-item-title>Delete</v-list-item-title></v-list-item-content>
                  </v-list-item>
                </v-list-item-group>
              </v-list>
            </v-menu>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
    <v-snackbar ref="snackbar" v-model="snackbar">{{ message }}</v-snackbar>
  </v-container>
</template>

<script>
import { mapState, mapActions, mapMutations } from "vuex";

export default {
  name: "index",
  middleware: ['isAdmin'],
  data: () => ({
    headers: [
      {text: 'ID', align: 'start', value: 'id', sortable: false},
      {text: 'Name', value: 'name', sortable: false},
      {text: 'E-mail', value: 'email', sortable: false},
      {text: 'Admin', value: 'is_admin', sortable: false},
      {text: 'Department', value: 'department', sortable: false},
      {text: 'Created at', value: 'created_at', sortable: false},
      {text: '', value: 'actions', align: 'end', sortable: false}
    ],
    options: {},
    footerProps: {
      itemsPerPageOptions: [10, 20, 50, 100],
      // showCurrentPage: true,
      showFirstLastPage: true
    },
    snackbar: false,
    message: null
  }),
  methods: {
    ...mapActions('users', ['fetchPagination', 'deleteUser']),
    ...mapActions('alerts', ['info']),
    ...mapMutations('users', ['setPage', 'setPerPage']),
    destroy(id){
      this.deleteUser(id).then(() => {
        this.info('User has been deleted');
        this.fetchPagination();
      });
    }
  },
  computed: {
    ...mapState('users', ['pagination', 'fetchingPagination'])
  },
  fetch({store, params}) {
    store.dispatch('users/fetchPagination');
  },
  watch: {
    options: {
      handler() {
        this.setPage(this.options.page);
        this.setPerPage(this.options.itemsPerPage);
        this.fetchPagination();
      },
      deep: true,
      immediate: false
    }
  },
  created() {
    this.options.page = this.page;
    this.options.itemsPerPage = this.perPage;
  }
}
</script>

<style scoped>

</style>
