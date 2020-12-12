import store from '~/store';
import { ROLE } from '~/constant/user';

export default async (to, from, next) => {
  const user = store.getters['auth/user'];
  if (user.role === ROLE.ADMIN) {
    return next();
  }

  next({ name: 'jobs.list' });
};
