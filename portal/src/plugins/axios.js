import Vue from 'vue'

// Lib imports
import axios from 'axios'

Vue.prototype.$http = axios.create( // Base URL is set in App.vue because process.env is not available here
    {
        withCredentials: true
    }
);

Vue.prototype.$http.interceptors.response.use(null, function(error) {
    if (error.response.status === 401 && error.response.data.message === 'Expired JWT Token')
    {
        Vue.prototype.$_logout();
    }

    return Promise.reject(error);
});
