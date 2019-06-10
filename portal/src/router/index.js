/**
 * Vue Router
 *
 * @library
 *
 * https://router.vuejs.org/en/
 */

// Lib imports
import Vue from 'vue'
import VueAnalytics from 'vue-analytics'
import Router from 'vue-router'
import Meta from 'vue-meta'

// Routes
import paths from './paths'
import CookieHelper from "../helpers/CookieHelper";

function route (path, meta, view, name) {
  return {
    name: name || view,
    meta: meta || {},
    path,
    component: (resovle) => import(
      `@/views/${view}.vue`
    ).then(resovle)
  }
}

Vue.use(Router)

// Create a new router
const router = new Router({
  mode: 'history',
  routes: paths.map(path => route(path.path, path.meta, path.view, path.name)).concat([
    { path: '*', redirect: '/dashboard' }
  ]),
  scrollBehavior (to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    }
    if (to.hash) {
      return { selector: to.hash }
    }
    return { x: 0, y: 0 }
  }
})

// Check on every route change if cookie exists
router.beforeEach((to, from, next) => {
  let currentUser = CookieHelper.checkLogin();
  let noAuthRequired = to.matched.some(record => record.meta.noAuthRequired);

  //if requiresAuth and user isn't set -> login
  if (!noAuthRequired && !currentUser && to.name !== 'login') next('/login')
  if (to.meta.admin && !CookieHelper.checkAdmin()) next('/dashboard')
  else next()
});

Vue.use(Meta)

// Bootstrap Analytics
// Set in .env
// https://github.com/MatteoGabriele/vue-analytics
if (process.env.GOOGLE_ANALYTICS) {
  Vue.use(VueAnalytics, {
    id: process.env.GOOGLE_ANALYTICS,
    router,
    autoTracking: {
      page: process.env.NODE_ENV !== 'development'
    }
  })
}

export default router
