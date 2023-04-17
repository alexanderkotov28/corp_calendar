<template>
  <v-container>
    <v-row>
      <v-col class="d-flex">
        <h2>Departments</h2>
        <v-spacer/>
        <router-link to="/departments/create" custom>
          <v-btn>Create</v-btn>
        </router-link>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-data-table
          :headers="headers"
          :items="departments"
          :loading="fetchingDepartments"
          hide-default-footer
          class="elevation-1"
        >
          <template v-slot:item.actions="{item}">
            <v-menu bottom left>
              <template v-slot:activator="{ on, attrs }">
                <v-btn icon v-bind="attrs" v-on="on">
                  <v-icon>mdi-dots-horizontal</v-icon>
                </v-btn>
              </template>

              <v-list>
                <v-list-item-group>
                  <router-link :to="'/departments/'+item.id" custom>
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
import { mapState, mapActions } from "vuex";

export default {
  name: "index",
  middleware: ['isAdmin'],
  data: () => ({
    headers: [
      {text: 'ID', align: 'start', value: 'id', sortable: false},
      {text: 'Title', value: 'title', sortable: false},
      {text: 'Created at', value: 'created_at', sortable: false},
      {text: '', value: 'actions', align: 'end', sortable: false}
    ],
    snackbar: false,
    message: null
  }),
  methods: {
    ...mapActions('departments', ['fetchDepartments', 'deleteDepartment']),
    ...mapActions('alerts', ['info']),
    destroy(id){
      this.deleteDepartment(id).then(() => {
        this.info('Department has been deleted');
        this.fetchDepartments();
      });
    }
  },
  computed: {
    ...mapState('departments', ['departments', 'fetchingDepartments'])
  },
  fetch({store, params}) {
    store.dispatch('departments/fetchDepartments');
  }
}
</script>

<style scoped>

</style>
