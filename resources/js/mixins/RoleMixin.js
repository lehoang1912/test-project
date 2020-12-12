import { mapGetters } from 'vuex';
import { ROLE } from '~/constant/user'

export default {
    computed: {
        ...mapGetters({
            currentUser: 'auth/user',
        }),
        isAdmin() {
            return this.currentUser.role == ROLE.ADMIN;
        }
    },
}