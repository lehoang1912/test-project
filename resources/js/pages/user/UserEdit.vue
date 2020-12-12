<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link :to="{ name: 'users.list' }">Users</router-link>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <section>
                            <form class="form-horizontal" @submit.prevent="updateUser" @keydown="form.onKeydown($event)">
                                <div class="form-group row">
                                    <label for="first-name" class="col-sm-3 col-form-label">First name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" id="first-name" name="first_name" v-model="form.first_name" placeholder="Enter first name" :class="{ 'is-invalid': form.errors.has('first_name') }">
                                        <has-error :form="form" field="first_name" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="last-name" class="col-sm-3 col-form-label">Last name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" id="last-name" name="last_name" v-model="form.last_name" placeholder="Enter first name" :class="{ 'is-invalid': form.errors.has('last_name') }">
                                        <has-error :form="form" field="last_name" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" v-model="form.email" id="email" class="form-control" placeholder="Enter email" :class="{ 'is-invalid': form.errors.has('email') }">
                                        <has-error :form="form" field="email" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="user-role" class="col-sm-3 col-form-label">Role</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" v-model="form.role" name="role" id="user-role" :class="{ 'is-invalid': form.errors.has('role') }">
                                            <option value="1">Admin</option>
                                            <option value="2">Engineer</option>
                                        </select>
                                        <has-error :form="form" field="role" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" :disabled="form.busy" class="btn btn-primary waves-effect waves-light">Save</button>
                                        <button type="button" class="btn btn-secondary waves-effect" @click="cancel">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'vform';

export default {
    middleware: ['auth', 'admin'],

    data() {
        return {
            userId: this.$route.params.userId,
            form: new Form({
                first_name: null,
                last_name: null,
                email: null,
                role: null,
            }),
        };
    },

    created() {
        this.getUser();
    },

    methods: {
        getUser() {
            axios.get(route('api.users.show', { user: this.userId }))
                .then((response) => {
                    this.form.first_name = response.data.first_name;
                    this.form.last_name = response.data.last_name;
                    this.form.email = response.data.email;
                    this.form.role = response.data.role;
                })
                .catch((e) => {
                    this.$notify({
                        group: 'common',
                        type: 'error',
                        text: 'Something went wrong. Please try again!',
                    });
                });
        },

        updateUser() {
            this.form.put(route('api.users.update', { user: this.userId })).then((response) => {
                this.$notify({
                    group: 'common',
                    type: 'success',
                    text: 'Updated user',
                });

                this.$router.push({ name: 'users.show', params: { userId: this.userId } });
            })
        },

        cancel() {
            this.$router.go(-1);
        },
    },
}
</script>
