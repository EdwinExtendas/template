/**
 * Define all of your application routes here
 * for more information on routes, see the
 * official documentation https://router.vuejs.org/en/
 */
export default [
  {
    path: '/dashboard',
    name: 'dashboard',
    view: 'Dashboard',
    meta: { noAuthRequired: false },
    nav: { icon: 'mdi-view-dashboard', text: 'Dashboard' }
  },
  {
    path: '/login',
    name: 'login',
    view: 'Login',
    meta: { noAuthRequired: true}
  },
  {
    path: '/point-of-service',
    name: 'point_of_service_all',
    view: 'pointOfService/All',
    meta: { noAuthRequired: false },
    nav: { icon: 'mdi-map-marker', text: 'Points of Service' }
  },
  {
    path: '/point-of-service/:id/edit',
    name: 'point_of_service_edit',
    view: 'pointOfService/Edit',
    meta: { noAuthRequired: false }
  },
  {
    path: '/admin/organization',
    name: 'admin_organization',
    view: 'admin/organization/All',
    meta: {noAuthRequired: false, admin: true}
  },
  {
    path: '/admin/organization/create',
    name: 'admin_organization_create',
    view: 'admin/organization/Create',
    meta: {noAuthRequired: false, admin: true}
  },
  {
    path: '/admin/organization/:id/edit',
    name: 'admin_organization_edit',
    view: 'admin/organization/Edit',
    meta: {noAuthRequired: false, admin: true}
  }
]
