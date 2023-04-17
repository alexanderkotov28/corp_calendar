<template>
  <v-container>
    <v-row>
      <v-col class="d-flex">
        <h2>Edit Department</h2>
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
  name: "update",
  middleware: ['isAdmin'],
  components: {DepartmentForm},
  async fetch({store, params}) {
    await store.dispatch('departments/fetchDepartment', {id: params.department_id});
  }
}
</script>

<style scoped>

</style>
