<template>
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <div class="p-3">
                    <h4 class="text-muted font-18 m-b-5 text-center">Welcome Back !</h4>
                    <p class="text-muted text-center">Sign in to continue to Test project.</p>

                    <form class="form-horizontal m-t-30" @submit.prevent="login" @keydown="form.onKeydown($event)">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" v-model="form.email" class="form-control" placeholder="Enter email" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email" />
                        </div>

                        <div class="form-group">
                            <label for="userpassword">Password</label>
                            <input type="password" name="password" v-model="form.password" class="form-control" id="userpassword" placeholder="Enter password" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password" />
                        </div>

                        <div class="form-group row m-t-20">
                            <div class="col-6"></div>
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
import Form from 'vform';

export default {
    middleware: 'guest',

    data() {
        return {
            form: new Form({
                email: '',
                password: '',
            }),
        };
    },

    methods: {
        async login() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                this.form.post(route('login'))
                    .then(async () => {
                        await this.$store.dispatch('auth/fetchUser');
                        this.redirectHome();
                    })
                    .catch(() => {
                        this.$notify({
                            group: 'common',
                            type: 'error',
                            text: 'Something went wrong. Please try again!',
                        });
                    });
            });
        },

        redirectHome() {
            if (this.$route.query.redirect && this.isRelative(this.$route.query.redirect)) {
                this.$router.push(this.$route.query.redirect);
            } else {
                this.$router.push({ name: 'jobs.list' });
            }
        },

        isRelative(url) {
            return url.match(/^\/[^\/\\]/);
        },
    },
};
</script>
