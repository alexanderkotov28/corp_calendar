<template>
  <v-app dark>
    <v-navigation-drawer
      v-model="drawer"
      fixed
      app
    >
      <v-list>
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          :to="item.to"
          router
          exact
        >
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar
      fixed
      app
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"/>
      <v-toolbar-title>{{ title }}</v-toolbar-title>
      <v-spacer/>
    </v-app-bar>
    <v-main>
      <v-container>
        <Nuxt/>
      </v-container>
    </v-main>
    <v-footer
      app
    >
      <span>Alexander Kotov &copy; {{ new Date().getFullYear() }}</span>
    </v-footer>

    <Alert/>
  </v-app>
</template>

<script>
import Alert from "@/components/Alert";

export default {
  name: 'DefaultLayout',
  data() {
    return {
      drawer: true,
      title: 'Corp Calendar'
    }
  },
  components: {Alert},
  computed: {
    items(){
      let items = [
          {
            icon: 'mdi-calendar-range',
            title: 'Calendar',
            to: '/calendar'
          }
        ];

      if (this.$store.state.auth.user.is_admin) {
        items.push({
          icon:'mdi-account-multiple',
          title: 'Users',
          to: '/users'
        });
        items.push({
          icon:'mdi-cards-variant',
          title: 'Departments',
          to: '/departments'
        });
      }

      return items;
    }
  }
}
</script>
