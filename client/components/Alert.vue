<template>
  <v-snackbar
    :timeout="timeout"
    :value="active"
    @input="setActive"
    :color="color"
    bottom
    text
  >
    <template v-slot:action="{ attrs }">
      <v-btn @click="setActive(false)"
             v-bind="attrs"
             text
      >Close
      </v-btn>
    </template>
    <span v-html="message"></span>
  </v-snackbar>
</template>

<script>
import {mapState, mapMutations, mapActions} from 'vuex';

export default {
  name: "Alert",
  methods: {
    ...mapMutations('alerts', ['setActive']),
    ...mapActions('alerts', ['info'])
  },
  computed: {
    ...mapState('alerts', ['active', 'message', 'color', 'timeout'])
  }
}
</script>

<style scoped>

</style>
