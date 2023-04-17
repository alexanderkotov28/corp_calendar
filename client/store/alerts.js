export const state = () => ({
  active: false,
  message: null,
  open: false,
  color: 'info',
  timeout: 3000
})

export const mutations = {
  setActive(state, active) {
    state.active = active;
  },
  setMessage(state, message) {
    state.message = message;
  },
  setColor(state, color) {
    state.color = color;
  }
}

export const actions = {
  info(context, message) {
      context.commit('setMessage', message);
      context.commit('setColor', 'info');
      context.commit('setActive', true);
  },
  error(context, message){
    context.commit('setMessage', message);
    context.commit('setColor', 'error');
    context.commit('setActive', true);
  }
}

export const getters = {}
