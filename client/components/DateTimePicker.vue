<template>
  <v-dialog v-model="modal"
            width="290px"
            persistent
  >
    <template v-slot:activator="{ on, attrs }">
      <v-text-field v-model="dateFormatted"
                    :label="label"
                    :rules="rules"
                    :disabled="disabled"
                    hide-details="auto"
                    readonly
                    v-bind="attrs"
                    v-on="on"
      ></v-text-field>
    </template>

    <v-date-picker v-model="date"
                   v-if="chooseDate"
                   scrollable
    >
      <v-spacer></v-spacer>
      <v-btn text color="primary" @click="close">
        Cancel
      </v-btn>
      <v-btn @click="chooseDate = false"
             :disabled="!date"
             color="primary"
             text
      >
        OK
      </v-btn>
    </v-date-picker>

    <v-time-picker v-model="time"
                   format="24hr"
                   v-else
                   full-width
    >
      <v-spacer></v-spacer>
      <v-btn @click="close"
             color="primary"
             text
      >
        Cancel
      </v-btn>
      <v-btn @click="setValue"
             :disabled="!time"
             color="primary"
             text
      >
        OK
      </v-btn>
    </v-time-picker>
  </v-dialog>
</template>

<script>
export default {
  name: "DateTimePicker",
  props: {
    label: {
      type: String,
      required: true
    },
    rules: {
      type: Array,
      required: true
    },
    disabled: {
      type: Boolean,
      default: false
    },
    value: {}
  },
  data: () => ({
    modal: false,
    chooseDate: true,
    date: null,
    time: null,
    datetime: null,
    innerDateFormat: 'YYYY-MM-DD',
    dateFormat: 'DD-MM-YYYY',
  }),
  methods: {
    close() {
      this.modal = false;
      this.chooseDate = true;
    },
    setValue() {
      this.datetime = this.dateFormatted;
      this.$emit('input', this.dateFormatted);
      this.modal = false;
    }
  },
  watch: {
    value(val){
      this.dateFormatted = val;
    }
  },
  computed: {
    dateFormatted: {
      set(val) {
        let d = this.$moment(val, 'DD-MM-YYYY HH:mm');
        this.date = d.format(this.innerDateFormat);
        this.time = d.format('HH:mm');
      },
      get() {
        return this.date ? this.$moment(this.date, this.innerDateFormat).format(this.dateFormat) + " " + (this.time?this.time: '') : '';
      }
    }
  }
}
</script>

<style scoped>

</style>
