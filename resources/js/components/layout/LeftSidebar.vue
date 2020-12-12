<template>
    <div class="left side-menu">
        <div class="slimscroll-menu" id="remove-scroll">
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">
                    <li class="menu-title">Main</li>
                    
                    <li>
                        <router-link :to="{ name: 'users.list' }" class="waves-effect">
                            <i class="mdi mdi-account-multiple"></i><span> Users </span>
                        </router-link>
                    </li>

                    <li>
                        <router-link :to="{ name: 'jobs.list' }" class="waves-effect">
                            <i class="mdi mdi-calendar-multiple-check"></i><span> Jobs </span>
                        </router-link>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</template>

<script>
export default {
    
}
</script>