<template>
    <v-dialog
      :value="value"
      @input="setValue"
      max-width="600px"
    >
      <EventForm :event="event" @close="setValue(false)"/>
    </v-dialog>
</template>

<script>
import EventForm from "@/components/forms/EventForm";
export default {
  name: "EventDialog",
  components: {EventForm},
  props: {
    value:{
      type: Boolean,
      required: true,
      default: false
    },
    event: {
      type: Object
    }
  },
  methods: {
    setValue(value){
      this.$emit('input', value);
    }
  }
}
</script>

<style scoped>

</style>
