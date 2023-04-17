export const state = () => ({
  pagination: {
    items: [],
    total: 0,
    perPage: 10,
    page: 1
  },
  fetchingPagination: false,
  user: null
})

export const mutations = {
  setPagination(state, data) {
    state.pagination.items = data.data;
    state.pagination.total = data.meta.total;
  },
  setFetchingPagination(state, fetching) {
    state.fetchingPagination = fetching;
  },
  setPage(state, page) {
    state.pagination.page = page
  },
  setPerPage(state, perPage) {
    state.pagination.perPage = perPage;
  },
  setUser(state, user) {
    state.user = user;
  }
}

export const actions = {
  fetchPagination(context) {
    context.commit('setFetchingPagination', true);
    return this.$axios.get('/api/users', {
      params: {
        page: context.state.pagination.page,
        perPage: context.state.pagination.perPage
      }
    }).then(resp => {
      context.commit('setPagination', resp.data);
    }).finally(() => {
      context.commit('setFetchingPagination', false);
    });
  },
  fetchUser(context, data) {
    return this.$axios.get('/api/users/' + data.id).then(resp => {
      context.commit('setUser', resp.data)
    });
  },
  createUser(context, data) {
    return this.$axios.post('/api/users', data);
  },
  clearUser(context) {
    context.commit('setUser', null)
  },
  updateUser(context, data) {
    return this.$axios.put('/api/users/' + context.state.user.id, data)
  },
  deleteUser(context, id) {
    return this.$axios.delete('/api/users/' + id)
  }
}

export const getters = {}
