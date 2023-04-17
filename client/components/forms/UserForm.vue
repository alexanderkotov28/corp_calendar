<template>
  <v-form ref="form" v-model="valid" @submit.prevent="submit" lazy-validation>
    <v-text-field
      v-model="userData.email"
      :error-messages="errors.email"
      :rules="rules.email"
      :disabled="processing"
      @change="errors.email = []"
      name="email"
      label="Email"
      type="text"
      placeholder="Email"
      required
    ></v-text-field>

    <v-text-field
      v-model="userData.name"
      :rules="rules.name"
      :disabled="processing"
      name="name"
      label="Name"
      type="text"
      placeholder="Name"
      required
    ></v-text-field>

    <v-text-field
      v-model="userData.password"
      :rules="passwordRules"
      :disabled="processing"
      name="password"
      label="Password"
      type="password"
      placeholder="Password"
      required
    ></v-text-field>

    <v-autocomplete :loading="fetchingDepartments"
                    :items="departments"
                    :disabled="processing || userData.is_admin"
                    :rules="userData.is_admin? []: rules.department_id"
                    v-model="userData.department_id"
                    item-text="title"
                    item-value="id"
                    hide-details="auto"
    ></v-autocomplete>

    <v-checkbox v-model="userData.is_admin"
                label="Admin"
                :disabled="processing"
    />

    <v-btn :disabled="!valid"
           :loading="processing"
           color="primary"
           type="submit"
    >{{ user ? 'Update' : 'Create' }}
    </v-btn>
  </v-form>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {
  name: "UserForm",
  data: () => ({
    valid: true,
    userData: {
      name: '',
      email: null,
      is_admin: false,
      department_id: null,
      password: null,
    },
    errors: {
      email: []
    },
    rules: {
      email: [
        v => !!v || 'Email is required',
        v => /.+@.+\..+/.test(v) || 'Invalid email address'
      ],
      name: [
        v => !!v || 'Name is required',
        v => v.length >= 3 || 'Minimum 2 characters'
      ],
      passwordRequired: [
        v => !!v || 'Password is required'
      ],
      passwordRequirements: [
        v => (v && v.length >= 6) || 'Minimum 6 characters'
      ],
      department_id: [
        v => !!v || 'Choose a department',
      ]
    },
    processing: false
  }),
  methods: {
    ...mapActions('users', ['createUser', 'updateUser']),
    ...mapActions('alerts', ['info']),
    submit() {
      if (this.$refs.form.validate()) {
        this.processing = true;
        let promise = this.user ? this.update() : this.create();
        promise.catch(({response}) => {
          if (response.status === 422) {
            this.errors = response.data.errors;
          }
        }).finally(() => {
          this.processing = false;
        });
      }
    },
    create() {
      return this.createUser(this.userData).then(resp => {
        this.info('User has been created');
        setTimeout(() => {
          this.$router.push({path: '/users'})
        }, 2000)
      });
    },
    update() {
      return this.updateUser(this.userData).then(resp => {
        this.info('User has been updated');
      });
    }
  },
  computed: {
    ...mapState('users', ['user']),
    ...mapState('departments', ['departments', 'fetchingDepartments']),
    passwordRules() {
      if (!this.user){
        return  this.rules.passwordRequired.concat(this.rules.passwordRequirements);
      } else {
        return  (this.userData.password && this.userData.password.length)? this.rules.passwordRequirements: [];
      }
    }
  },
  mounted() {
    this.$store.dispatch('departments/fetchDepartments');
    if (this.user) {
      this.userData = Object.assign({}, this.user)
    }
  }
}
</script>

<style scoped>

</style>
