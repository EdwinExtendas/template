// https://vuex.vuejs.org/en/mutations.html

import { set, toggle } from '@/utils/vuex'
export default {
    setAuth: set('authenticated'),
    setAdmin: set('admin')
}
