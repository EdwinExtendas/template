import Vue from 'vue'

// Lib imports
import Toasted from 'vue-toasted'

Vue.use(Toasted, {iconPack: 'material'});

Vue.toasted.register('success',
    (message) => { return message; },
    { type: 'success', icon: 'check', duration: 7500, position: 'top-center' }
);


Vue.toasted.register('error',
    (message) => { return message; },
    { type: 'error', icon: 'highlight_off', duration: 7500, position: 'top-center' }
);
