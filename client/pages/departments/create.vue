<template>
  <v-container>
    <v-row>
      <v-col class="d-flex">
        <h2>Create new department</h2>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <DepartmentForm/>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import DepartmentForm from "~/components/forms/DepartmentForm";

export default {
  name: "create",
  middleware: ['isAdmin'],
  components: {DepartmentForm},
  async fetch({store}) {
    store.dispatch('departments/clearDepartment');
  }
}
</script>

<style scoped>

</style>
