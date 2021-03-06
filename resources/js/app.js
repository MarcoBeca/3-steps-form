require('./bootstrap');

window.Vue = require('vue').default;

import Buefy from 'buefy';

Vue.use(Buefy);

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const app = new Vue({
    el: '#app',
});
