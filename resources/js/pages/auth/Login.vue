<template>
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <!-- <h3 class="text-center m-0">
                    <a href="index.html" class="logo logo-admin"><img src="assets/images/logo.png" height="30" alt="logo"></a>
                </h3> -->

                <div class="p-3">
                    <h4 class="text-muted font-18 m-b-5 text-center">Welcome Back !</h4>
                    <p class="text-muted text-center">Sign in to continue to Test project.</p>

                    <form class="form-horizontal m-t-30" @submit.prevent="login" @keydown="form.onKeydown($event)">

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter username">
                        </div>

                        <div class="form-group">
                            <label for="userpassword">Password</label>
                            <input type="password" class="form-control" id="userpassword" placeholder="Enter password">
                        </div>

                        <div class="form-group row m-t-20">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customControlInline">
                                    <label class="custom-control-label" for="customControlInline">Remember me</label>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },

    methods: {
        login() {

        },
    },
};
</script>
