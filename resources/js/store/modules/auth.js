import axios from 'axios';
import * as types from '../mutation-types';

// state
export const state = {
  isFetchedUser: false,
  user: null,
};

// getters
export const getters = {
  user: (state) => state.user,
  isFetchedUser: (state) => state.isFetchedUser,
  check: (state) => state.user !== null,
};

// mutations
export const mutations = {
  [types.UPDATE_FETCHED_USER](state) {
    state.isFetchedUser = true;
  },

  [types.LOGOUT](state) {
    state.user = null;
  },

  [types.UPDATE_USER](state, { user }) {
    state.user = user;
  },
};

// actions
export const actions = {
  async fetchUser({ commit }) {
    try {
      const { data } = await axios.get(route('api.profile.get'));
      commit(types.UPDATE_USER, { user: data });
      commit(types.UPDATE_FETCHED_USER);
    } catch (e) {
    }
  },

  updateUser({ commit }, payload) {
    commit(types.UPDATE_USER, payload);
  },

  async logout({ commit }) {
    try {
      await axios.post('/logout');
    } catch (e) {}

    commit(types.LOGOUT);
  },
};
