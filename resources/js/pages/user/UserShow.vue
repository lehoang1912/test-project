<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link :to="{ name: 'users.list' }">Users</router-link>
                        </li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 m-b-20 d-flex justify-content-between">
                                <h4 class="header-title">View user</h4>
                                
                                <div>
                                    <button type="button" class="btn btn-danger waves-effect waves-light" @click="confirmDeleteUser">Delete</button>
                                    <router-link :to="{ name: 'users.edit', params: { userId: this.userId } }">
                                        <button type="button" class="btn btn-primary waves-effect waves-light">Edit</button>
                                    </router-link>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <span class="col-sm-3">First name</span>
                            <div class="col-sm-9">
                                <p>{{ user.first_name }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <span class="col-sm-3">Last name</span>
                            <div class="col-sm-9">
                                <p>{{ user.last_name }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <span class="col-sm-3">Email</span>
                            <div class="col-sm-9">
                                <p>{{ user.email }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <span class="col-sm-3">Role</span>
                            <div class="col-sm-9">
                                <p>{{ user.role | getRoleName }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <span class="col-sm-3">Created at</span>
                            <div class="col-sm-9">
                                <p>{{ user.created_at | moment('YYYY-MM-DD HH:mm') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <delete-confirm header="Delete user" confirm="Are you sure you want to delete this user?" @delete="deleteUser" />
    </div>
</template>

<script>
import DeleteConfirm from '~/components/common/DeleteConfirm'
import { ROLE, ROLE_NAME } from '~/constant/user'

export default {
    middleware: 'auth',
    
    components: {
        DeleteConfirm,
    },

    filters: {
        getRoleName(value) {
            if (value == ROLE.ADMIN) {
                return ROLE_NAME.ADMIN;
            }
            return ROLE_NAME.ENGINEER;
        }
    },

    data() {
        return {
            userId: this.$route.params.userId,
            user: {},
        };
    },

    created() {
        this.getUser();
    },

    methods: {
        getUser() {
            axios.get(route('api.users.show', { user: this.userId }))
                .then((response) => {
                    this.user = response.data;
                })
                .catch((e) => {
                    this.$notify({
                        group: 'common',
                        type: 'error',
                        text: 'Something went wrong. Please try again!',
                    });
                });
        },

        confirmDeleteUser() {
            this.$modal.show('delete-confirm-modal');
        },

        deleteUser() {
            axios.delete(route('api.users.delete', { user: this.userId }))
                .then((response) => {
                    this.$notify({
                        group: 'common',
                        type: 'success',
                        text: 'Deleted user',
                    });

                    this.$router.push({ name: 'users.list' });
                })
                .catch(() => {
                    this.$notify({
                        group: 'common',
                        type: 'error',
                        text: 'Something went wrong. Please try again!',
                    });
                });
        },
    }
}
</script>
