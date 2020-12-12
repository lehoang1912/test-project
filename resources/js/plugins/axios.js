import axios from 'axios';
import store from '~/store';
import router from '~/router';

window.axios = require('axios');
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

// Response interceptor
axios.interceptors.response.use(
  (response) => response,
  (error) => {
    const { status } = error.response;

    if (status >= 500) {
      router.push({ name: 'internal.error' });
    }

    if (status === 401 && store.getters['auth/check']) {
      store.commit('auth/LOGOUT');
      router.push({ name: 'login' });
    }

    return Promise.reject(error);
  }
);
