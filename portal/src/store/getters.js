// https://vuex.vuejs.org/en/getters.html

export default {
    getAuthentication: state => {
        return state.authenticated;
    },
    getAdmin: state => {
        return state.admin;
    }
}
