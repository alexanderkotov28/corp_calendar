export default ({ $axios, redirect, app }, inject) => {
  $axios.onError((error) => {

    if (error.response === undefined) {
      app.store.dispatch('alerts/error', 'Network Error: Please refresh and try again.');

      throw error
    }

    if (error.response.status === 422) {
      app.store.dispatch('alerts/error', error.response.data.message);

      throw error
    }

    app.store.dispatch('alerts/error', error.response.statusText);

    throw error
  })
}
