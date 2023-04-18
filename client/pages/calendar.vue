<template>
  <v-row class="fill-height">
    <v-col>
      <v-sheet height="64">
        <v-toolbar flat>
          <v-btn @click="setToday"
                 outlined
                 class="mr-4"
                 color="grey darken-2"
          >Today
          </v-btn>
          <v-btn @click="prev"
                 color="grey darken-2"
                 fab
                 text
                 small
          >
            <v-icon small>mdi-chevron-left</v-icon>
          </v-btn>
          <v-btn @click="next"
                 color="grey darken-2"
                 fab
                 text
                 small
          >
            <v-icon small>mdi-chevron-right</v-icon>
          </v-btn>
          <v-toolbar-title v-if="$refs.calendar">
            {{ $refs.calendar.title }}
          </v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn @click="addEvent"
                 class="mr-2"
                 color="grey darken-2"
          >New Event
          </v-btn>
          <v-menu bottom right>
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                outlined
                color="grey darken-2"
                v-bind="attrs"
                v-on="on"
              >
                <span>{{ typeToLabel[type] }}</span>
                <v-icon right>mdi-menu-down</v-icon>
              </v-btn>
            </template>
            <v-list>
              <v-list-item @click="type = 'day'">
                <v-list-item-title>Day</v-list-item-title>
              </v-list-item>
              <v-list-item @click="type = 'week'">
                <v-list-item-title>Week</v-list-item-title>
              </v-list-item>
              <v-list-item @click="type = 'month'">
                <v-list-item-title>Month</v-list-item-title>
              </v-list-item>
              <v-list-item @click="type = '4day'">
                <v-list-item-title>4 days</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>

          <v-progress-linear
            :active="fetchingEvents"
            :indeterminate="fetchingEvents"
            absolute
            bottom
          ></v-progress-linear>
        </v-toolbar>
      </v-sheet>
      <v-sheet height="700">
        <v-calendar
          ref="calendar"
          v-model="focus"
          color="primary"
          :events="events"
          :event-color="getEventColor"
          :type="type"
          @click:event="showEvent"
          @click:more="viewDay"
          @click:date="viewDay"
          @change="updateRange"
          event-start="start_date"
          event-end="end_date"
          event-name="title"
        ></v-calendar>
        <v-menu
          v-model="selectedOpen"
          :close-on-content-click="false"
          :activator="selectedElement"
          offset-x
        >
          <v-card
            max-width="450"
            flat
          >
            <v-toolbar :color="selectedEvent.color">
              <v-btn @click="editEvent" icon>
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
              <v-btn @click="destroyEvent" icon>
                <v-icon>mdi-trash-can</v-icon>
              </v-btn>
              <v-toolbar-title v-html="selectedEvent.title"></v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </v-toolbar>
            <v-card-text>
              <span v-html="selectedEvent.description"></span>
              <h4>Participants</h4>
              <div>
                <v-chip class="my-1 mx-1" small :key="participant.id" v-for="participant in participants">{{ participant.name }}</v-chip>
              </div>
              <v-spacer/>
              <small>Created by {{ selectedEvent.created_by }} {{ selectedEvent.created_at }}</small>
            </v-card-text>
            <v-card-actions>
              <v-btn text color="secondary" @click="selectedOpen = false">
                Cancel
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-menu>
      </v-sheet>
    </v-col>

    <EventDialog v-model="dialogs.event" :event="selectedEvent"/>
  </v-row>
</template>

<script>
import EventDialog from "@/components/dialogs/EventDialog";
import {mapActions, mapMutations, mapState} from "vuex";

export default {
  name: "calendar",
  components: {EventDialog},
  data: () => ({
    focus: '',
    type: 'month',
    typeToLabel: {
      month: 'Month',
      week: 'Week',
      day: 'Day',
      '4day': '4 Days',
    },
    selectedEvent: {},
    selectedElement: null,
    selectedOpen: false,
    colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],

    dialogs: {
      event: false
    }
  }),
  mounted() {
    this.$refs.calendar.checkChange()
  },
  methods: {
    ...mapActions('events', ['fetchEvents', 'fetchEventParticipants', 'deleteEvent']),
    ...mapMutations('events', ['setMonth', 'setYear']),
    viewDay({date}) {
      this.focus = date
      this.type = 'day'
    },
    getEventColor(event) {
      const index = +(parseInt(+(new Date(event.start_date))).toString(this.colors.length)) % 10;
      return this.colors[index];
    },
    setToday() {
      this.focus = ''
    },
    prev() {
      this.$refs.calendar.prev()
    },
    next() {
      this.$refs.calendar.next()
    },
    showEvent({nativeEvent, event}) {
      const open = () => {
        this.selectedEvent = event;
        this.selectedElement = nativeEvent.target;
        this.fetchEventParticipants(event.id);
        requestAnimationFrame(() => requestAnimationFrame(() => this.selectedOpen = true))
      }

      if (this.selectedOpen) {
        this.selectedOpen = false;
        requestAnimationFrame(() => requestAnimationFrame(() => open()))
      } else {
        open()
      }

      nativeEvent.stopPropagation()
    },
    updateRange({start, end}) {
      if (start.month !== this.month || this.year !== start.year) {
        this.setMonth(start.month);
        this.setYear(start.year);
        this.fetchEvents();
      }
    },
    addEvent() {
      this.dialogs.event = true;
    },
    editEvent() {
      this.dialogs.event = true;
    },
    destroyEvent(){
      this.deleteEvent(this.selectedEvent.id).then(() => {
        this.info('Event deleted');
        this.selectedEvent = {};
        this.selectedElement = null;
          this.selectedOpen = false;
        this.fetchEvents();
      });
    }
  },
  computed: {
    ...mapState('events', ['events', 'month', 'year', 'fetchingEvents', 'participants'])
  }
}
</script>

<style scoped>

</style>
