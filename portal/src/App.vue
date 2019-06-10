<template>
  <v-app>
<!--    For full page view-->
    <div v-if="$route.name !== 'login'">
      <core-toolbar />

      <core-drawer />

      <core-view />
    </div>
    <router-view v-else />
  </v-app>
</template>
<script>
  import CookieHelper from "./helpers/CookieHelper";

  export default {
    name: 'App',
    created() {
        // SET ENV CONFIG
        this.$http.defaults.baseURL = process.env.VUE_APP_BASE_URL_API;

        // SET $STORE
        this.$store.commit('setAuth', CookieHelper.checkLogin());
        this.$store.commit('setAdmin', CookieHelper.checkAdmin());
    }
  }
</script>
<style lang="scss">
@import '@/styles/index.scss';

/* Remove in 1.2 */
.v-datatable thead th.column.sortable i {
  vertical-align: unset;
}
</style>
