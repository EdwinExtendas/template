import Vue from 'vue'

import router from '@/router'
import CookieHelper from "./helpers/CookieHelper";

Vue.prototype.$_logout = function (message = `Your session has expired, please login again`) {
    Vue.prototype.$toasted.global.error(message);
    router.push('login');
    CookieHelper.logout();
};
