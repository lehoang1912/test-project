require('./bootstrap');

import Vue from 'vue';
import Notifications from 'vue-notification';
import VModal from 'vue-js-modal';
import VueMoment from 'vue-moment';

import 'vue-popperjs/dist/vue-popper.css';

import router from '~/router';
import store from '~/store';

import { HasError, AlertError, AlertSuccess } from 'vform';
import Paginate from 'vuejs-paginate';

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component(AlertSuccess.name, AlertSuccess);

Vue.component('paginate', Paginate);

Vue.use(Notifications);
Vue.use(VModal);
Vue.use(VueMoment);

const app = new Vue({
    el: '#app',
    store,
    router,
});
