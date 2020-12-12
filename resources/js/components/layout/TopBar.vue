<template>
    <div class="topbar">
        <!-- LOGO -->
        <div class="topbar-left">
            <a href="index.html" class="logo">
                <span class="text-white">
                    TEST PROJECT
                </span>
                <i style="color: white !important; font-style: normal;">
                    T
                </i>
            </a>
        </div>

        <nav class="navbar-custom">
            <ul class="navbar-right d-flex list-inline float-right mb-0">
                <li class="dropdown notification-list">
                    <div class="dropdown notification-list nav-pro-img">
                        <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="m-r-20">Hello {{ user.first_name }}!</span>
                            <avatar :username="`${user.first_name} ${user.last_name}`" :size="36" :inline="true"></avatar>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <button class="dropdown-item text-danger" @click="logout"><i class="mdi mdi-power text-danger"></i> Logout</button>
                        </div>                                                                    
                    </div>
                </li>
            </ul>

            <ul class="list-inline menu-left mb-0">
                <li class="float-left">
                    <button class="button-menu-mobile open-left waves-effect">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Avatar from 'vue-avatar'

export default {
    components: {
        Avatar
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
        }),
    },

    methods: {
        async logout() {
            await this.$store.dispatch('auth/logout');
            this.$router.push({ name: 'login' });
        }
    }
}
</script>
