<template>
  <v-toolbar
    id="core-toolbar"

    flat
    prominent
    style="background: #eee;"
  >
    <v-spacer />
    <v-toolbar-items>
      <v-flex
        align-center
        layout
        py-2
      >
        <v-menu
          bottom
          left
          content-class="dropdown-menu"
          offset-y
          transition="slide-y-transition">
          <router-link
            v-ripple
            slot="activator"
            class="toolbar-items"
            to="/notifications"
          >
            <v-badge
              color="error"
              overlap
            >
              <template slot="badge">
                {{ notifications.length }}
              </template>
              <v-icon color="tertiary">mdi-bell</v-icon>
            </v-badge>
          </router-link>
          <v-card>
            <v-list dense>
              <v-list-tile
                v-for="notification in notifications"
                :key="notification"
                @click="onClick"
              >
                <v-list-tile-title
                  v-text="notification"
                />
              </v-list-tile>
            </v-list>
          </v-card>
        </v-menu>
        <v-label
          v-ripple
          class="toolbar-items"
          @click="logOut"
        >
          <v-icon color="tertiary">mdi-exit-to-app</v-icon>
          Log out
        </v-label>
      </v-flex>
    </v-toolbar-items>
  </v-toolbar>
</template>

<script>

  import {
    mapMutations
  } from 'vuex'
  import CookieHelper from "../../helpers/CookieHelper";

export default {
  data: () => ({
    notifications: [
      'Mike, John responded to your email',
      'You have 5 new tasks',
      'You\'re now a friend with Andrew',
      'Another Notification',
      'Another One'
    ],
    title: null,
    responsive: false,
    responsiveInput: false
  }),

  watch: {
    '$route' (val) {
      this.title = val.name
    }
  },

  mounted () {
    this.onResponsiveInverted()
    window.addEventListener('resize', this.onResponsiveInverted)
  },
  beforeDestroy () {
    window.removeEventListener('resize', this.onResponsiveInverted)
  },

  methods: {
    ...mapMutations('app', ['setDrawer', 'toggleDrawer']),
    onClickBtn () {
      this.setDrawer(!this.$store.state.app.drawer)
    },
    onClick () {
      //
    },
    logOut () {
      this.$store.commit('setAuth', false);
      this.$store.commit('setAdmin', false);
      CookieHelper.unsetCookie('user');
      this.$router.push('login');
    },
    onResponsiveInverted () {
      if (window.innerWidth < 991) {
        this.responsive = true
        this.responsiveInput = false
      } else {
        this.responsive = false
        this.responsiveInput = true
      }
    }
  }
}
</script>

<style>
  #core-toolbar a {
    text-decoration: none;
  }
</style>
