<template>
  <v-container>
    <v-row>
      <v-col class="d-flex">
        <h2>Edit User</h2>
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
  name: "update",
  middleware: ['isAdmin'],
  components: {UserForm},
  async fetch({store, params}) {
    await store.dispatch('users/fetchUser', {id: params.user_id});
  }
}
</script>

<style scoped>

</style>
