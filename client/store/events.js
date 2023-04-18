export const state = () => ({
  events: [],
  fetchingEvents: false,
  month: null,
  year: null,
  participants: []
})

export const mutations = {
  setMonth(state, month) {
    state.month = month;
  },
  setYear(state, year) {
    state.year = year;
  },
  setEvents(state, events) {
    state.events = events;
  },
  setFetchingEvents(state, fetching) {
    state.fetchingEvents = fetching;
  },
  setEventParticipants(state, {event_id, participants}) {
    const index = state.events.findIndex(e => e.id === event_id);
    state.events[index].participants = participants;
    state.participants = participants;
  },
  setParticipants(state, participants) {
    state.participants = participants;
  },
  updateEventContext(state, data){
    const index = state.events.findIndex(e => e.id === data.id);
    state.events[index] = data.data;
  },
  unsetEvent(state, id){
    const index = state.events.findIndex(e => e.id === id);
    state.events.splice(index, 1);
  }
}

export const actions = {
  fetchEvents(context) {
    context.commit('setFetchingEvents', true);
    return this.$axios.get('/api/events', {
      params: {
        month: context.state.month,
        year: context.state.year
      }
    }).then(resp => {
      context.commit('setEvents', resp.data);
    }).finally(() => {
      context.commit('setFetchingEvents', false);
    });
  },
  fetchEventParticipants(context, id) {
    context.commit('setParticipants', []);
    return this.$axios.get('/api/events/' + id + '/participants').then(resp => {
      context.commit('setEventParticipants', {event_id: id, participants: resp.data});
    });
  },
  createEvent(context, data) {
    return this.$axios.post('/api/events', data);
  },
  updateEvent(context, data) {
    return this.$axios.put('/api/events/' + data.id, data).then(resp => {
      context.commit('updateEventContext', {
        id: data.id,
        data: resp.data
      });
      context.dispatch('fetchEvents');
    });
  },
  deleteEvent(context, id) {
    return this.$axios.delete('/api/events/' + id).then(resp => {
      context.commit('unsetEvent', id);
    });
  }
}
