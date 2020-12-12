<template>
    <div id="wrapper">
        <top-bar />

        <left-sidebar />

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <router-view></router-view>

                </div>
            </div>

            <footer-el />
        </div>
    </div>
</template>

<script>
import TopBar from './TopBar'
import LeftSidebar from './LeftSidebar'
import Footer from './Footer'

export default {
    middleware: 'auth',

    components: {
        TopBar,
        LeftSidebar,
        'footer-el': Footer,
    },

    mounted() {
        this.init();
    },

    methods: {
        init() {
            this.intSlimscrollmenu();
            this.initSlimscroll();
            this.initMetisMenu();
            this.initLeftMenuCollapse();
            this.initEnlarge();
        },

        intSlimscrollmenu() {
            $('.slimscroll-menu').slimscroll({
                height: 'auto',
                position: 'right',
                size: "5px",
                color: '#9ea5ab',
                wheelStep: 5,
                touchScrollStep: 50
            });
        },

        initSlimscroll() {
            $('.slimscroll').slimscroll({
                height: 'auto',
                position: 'right',
                size: "5px",
                color: '#9ea5ab',
                touchScrollStep: 50
            });
        },

        initMetisMenu() {
            $("#side-menu").metisMenu();
        },

        initLeftMenuCollapse() {
            $('.button-menu-mobile').on('click', function (event) {
                event.preventDefault();
                $("body").toggleClass("enlarged");
            });
        },

        initEnlarge() {
            if ($(window).width() < 1025) {
                $('body').addClass('enlarged');
            } else {
                $('body').removeClass('enlarged');
            }
        }
    }
};
</script>
