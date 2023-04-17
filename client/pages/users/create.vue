<template>
  <v-container>
    <v-row>
      <v-col class="d-flex">
        <h2>Create new user</h2>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <UserForm/>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import UserForm from "~/components/forms/UserForm";

export default {
  name: "create",
  middleware: ['isAdmin'],
  components: {UserForm},
  fetch({store}) {
    store.dispatch('users/clearUser');
  }
}
</script>

<style scoped>

</style>
