export const state = () => ({
  departments: [],
  fetchingDepartments: false,
  department: null,
})

export const mutations = {
  setDepartment(state, department) {
    state.department = department;
  },
  setDepartments(state, departments) {
    state.departments = departments;
  },
  setFetchingDepartments(state, fetching) {
    state.fetchingDepartments = fetching;
  },
}

export const actions = {
  fetchDepartments(context) {
    context.commit('setFetchingDepartments', true);
    return this.$axios.get('/api/departments').then(resp => {
      context.commit('setDepartments', resp.data);
    }).finally(() => {
      context.commit('setFetchingDepartments', false);
    });
  },
  fetchDepartment(context, data) {
    return this.$axios.get('/api/departments/' + data.id).then(resp => {
      context.commit('setDepartment', resp.data)
    });
  },
  createDepartment(context, data) {
    return this.$axios.post('/api/departments', data);
  },
  clearDepartment(context) {
    context.commit('setDepartment', null)
  },
  updateDepartment(context, data) {
    return this.$axios.put('/api/departments/' + context.state.department.id, data)
  },
  deleteDepartment(context, id) {
    return this.$axios.delete('/api/departments/' + id)
  }
}

export const getters = {}
