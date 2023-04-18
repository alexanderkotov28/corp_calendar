<template>
  <v-card>
    <v-card-title>
      <span class="text-h5">{{ event? 'Update event': 'New Event'}}</span>
    </v-card-title>
    <v-card-text>
      <v-container>
        <v-form ref="form" v-model="valid" @submit.prevent="submit" lazy-validation>
          <v-row>
            <v-col cols="12">
              <v-text-field
                v-model="eventData.title"
                :rules="rules.title"
                :disabled="processing"
                hide-details="auto"
                label="Title"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <DateTimePicker v-model="eventData.start_date"
                              :rules="rules.start_date"
                              :disabled="processing"
                              label="Start date"
              />
            </v-col>
            <v-col cols="12">
              <DateTimePicker v-model="eventData.end_date"
                              :rules="rules.end_date"
                              :disabled="processing"
                              label="End date"
              />
            </v-col>
            <v-col cols="12">
              <v-autocomplete :loading="fetchingDepartments"
                              :items="departments"
                              :disabled="processing"
                              :rules="(eventData.departments.length === 0 && eventData.users.length === 0)? rules.departments: []"
                              v-model="eventData.departments"
                              hide-details="auto"
                              item-text="title"
                              item-value="id"
                              label="Choose departments"
                              multiple
                              chips
              ></v-autocomplete>
            </v-col>
            <v-col cols="12">
              <v-autocomplete
                v-model="eventData.users"
                :items="users"
                :loading="searchingUsers"
                :search-input.sync="userSearchQuery"
                :disabled="processing"
                :rules="(eventData.departments.length === 0 &&  eventData.users.length === 0)? rules.users: []"
                hide-details="auto"
                item-text="name"
                item-value="id"
                label="Choose users"
                placeholder="Start typing to Search"
                multiple
                chips
              ></v-autocomplete>
            </v-col>
            <v-col cols="12">
              <v-textarea v-model="eventData.description"
                          :disabled="processing"
                          hide-details="auto"
                          label="Description"
              />
            </v-col>
          </v-row>
        </v-form>
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn
        color="blue darken-1"
        text
        :disabled="processing"
        @click="close"
      >
        Close
      </v-btn>
      <v-btn
        color="blue darken-1"
        text
        @click="submit"
        :loading="processing"
      >
        Save
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {
  name: "EventForm",
  props: ['event'],
  data: () => ({
    valid: true,
    eventData: {
      title: null,
      start_date: null,
      end_date: null,
      departments: [],
      users: [],
      description: null
    },
    rules: {
      title: [
        v => !!v || 'Title is required'
      ],
      start_date: [
        v => !!v || 'Start date is required'
      ],
      end_date: [
        v => !!v || 'End date is required'
      ],
      departments: [
        v => v.length > 0 || 'Departments is required'
      ],
      users: [
        v => v.length > 0 || 'Users is required'
      ]
    },
    processing: false,
    userSearchQuery: '',
    searchingUsers: false,
    userSearchTimeout: null,
    users: []
  }),
  methods: {
    ...mapActions('users', ['searchUsers']),
    ...mapActions('alerts', ['info']),
    ...mapActions('events', ['createEvent', 'updateEvent']),
    close() {
      this.$emit('close');
      this.$refs.form.reset();
    },
    submit() {
      if (this.$refs.form.validate()) {
        this.processing = true;
        let promise = this.event? this.update() : this.create();
        promise.finally(() => this.processing = false);
      }
    },
    create() {
      return this.createEvent(this.eventData).then(() => {
        this.info('Event created successfully');
        this.close();
      })
    },
    update() {
      return this.updateEvent(this.eventData).then(() => {
        this.info('Event updated successfully');
        this.close();
      })
    },
    setEventData(event){
      this.eventData = {
        id: event.id,
        title: event.title,
        start_date: this.$moment(event.start_date, 'YYYY-MM-DD HH:mm').format('DD-MM-YYYY HH:mm'),
        end_date: this.$moment(event.end_date, 'YYYY-MM-DD HH:mm').format('DD-MM-YYYY HH:mm'),
        departments: event.departments,
        users: event.users.map(user => user.id),
        description: event.description
      };
      this.users = event.users;
    }
  },
  watch: {
    userSearchQuery() {
      if (this.userSearchQuery && this.userSearchQuery.length > 0) {
        if (this.userSearchTimeout) {
          clearTimeout(this.userSearchTimeout);
        }
        setTimeout(() => {
          this.searchingUsers = true;
          this.searchUsers(this.userSearchQuery).then(resp => {
            this.users = resp.data;
          }).finally(() => {
            this.searchingUsers = false;
          });
        }, 300)
      }
    },
    event(event){
      if (event) {
        this.setEventData(event);
      } else {
        this.$refs.form.reset();
      }
    }
  },
  computed: {
    ...mapState('departments', ['departments', 'fetchingDepartments'])
  },
  mounted() {
    this.$store.dispatch('departments/fetchDepartments');
    if (this.event) {
      this.setEventData(this.event);
    }
  }
}
</script>

<style scoped>

</style>
