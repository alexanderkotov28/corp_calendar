<template>
  <v-form ref="form" v-model="valid" @submit.prevent="submit" lazy-validation>
    <v-text-field
      v-model="departmentData.title"
      :rules="rules.title"
      :disabled="processing"
      name="title"
      label="Title"
      type="text"
      placeholder="Title"
      required
    ></v-text-field>

    <v-btn :disabled="!valid"
           :loading="processing"
           color="primary"
           type="submit"
    >{{ department ? 'Update' : 'Create' }}
    </v-btn>

    <v-snackbar ref="snackbar" v-model="snackbar">{{ message }}</v-snackbar>
  </v-form>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {
  name: "DepartmentForm",
  data: () => ({
    valid: true,
    departmentData: {
      title: null
    },
    rules: {
      title: [
        v => !!v || 'Title is required'
      ]
    },
    snackbar: false,
    message: null,
    processing: false
  }),
  methods: {
    ...mapActions('departments', ['createDepartment', 'updateDepartment']),
    submit() {
      if (this.$refs.form.validate()) {
        this.processing = true;

        let promise = this.department ? this.update() : this.create();

        promise.finally(() => {
          this.processing = false;
        })
      }
    },
    create() {
      return this.createDepartment(this.departmentData).then(resp => {
        this.message = 'Department has been created';
        this.snackbar = true;
        setTimeout(() => {
          this.$router.push({path: '/departments'})
        }, 2000)
      })
    },
    update() {
      return this.updateDepartment(this.departmentData).then(resp => {
        this.message = 'Department updated';
        this.snackbar = true;
      })
    }
  },
  computed: {
    ...mapState('departments', ['department'])
  },
  mounted() {
    if (this.department) {
      this.departmentData = Object.assign({}, this.department)
    }
  }
}
</script>

<style scoped>

</style>
