import store from '~/store';

export default async (to, from, next) => {
  if (!store.getters['auth/isFetchedUser']) {
    try {
      await store.dispatch('auth/fetchUser');
    } catch (e) {}
  }

  next();
};
