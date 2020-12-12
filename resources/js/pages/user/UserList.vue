<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="header-title d-inline-block">
                            Users <span v-show="total > 0" class="font-weight-light">({{ total }})</span>
                        </h4>
                        <button type="button" class="btn btn-primary waves-effect waves-light float-right m-b-20" @click="showCreationModal">+ Add</button>

                        <section>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First name</th>
                                            <th>Last name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Created at</th>
                                            <th class="text-right"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(user, index) in users" :key="user.id">
                                            <td>{{ perPage * (currentPage - 1) + index + 1 }}</td>
                                            <td>{{ user.first_name }}</td>
                                            <td>{{ user.last_name }}</td>
                                            <td>{{ user.email }}</td>
                                            <td>{{ user.role | getRoleName }}</td>
                                            <td>{{ user.created_at | moment('YYYY-MM-DD HH:mm') }}</td>
                                            <td class="text-right">
                                                <popper ref="popper-action" trigger="clickToToggle" :visible-arrow="false">
                                                    <div class="popper action-popper">
                                                        <ul class="action-popper-list">
                                                            <li class="action-popper-item" @click="showUser(user)">
                                                                <i class="mdi mdi-open-in-app mr-2"></i>
                                                                <span>View</span>
                                                            </li>
                                                            <template>
                                                                <li class="action-popper-item" @click="editUser(user)">
                                                                    <i class="mdi mdi-pencil mr-2"></i>
                                                                    <span>Edit</span>
                                                                </li>
                                                                <li class="action-popper-item text-danger" @click="confirmDeleteUser(user, index)">
                                                                    <i class="mdi mdi-delete mr-2"></i>
                                                                    <span>Delete</span>
                                                                </li>
                                                            </template>
                                                        </ul>
                                                    </div>
                                                    <span slot="reference">
                                                        <i class="mdi mdi-dots-horizontal cursor-pointer"></i>
                                                    </span>
                                                </popper>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <paginate
                                v-if="lastPage > 1"
                                :pageCount="lastPage"
                                :containerClass="'pagination justify-content-center m-t-10'"
                                :page-class="'page-item'"
                                :page-link-class="'page-link'"
                                :prev-class="'page-item'"
                                :prev-link-class="'page-link'"
                                :next-class="'page-item'"
                                :next-link-class="'page-link'"
                                :next-text="'»'"
                                :prev-text="'«'"
                                :clickHandler="getUsers">
                            </paginate>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <create-user-modal @created="getUsers(1)" />
        <delete-confirm header="Delete user" confirm="Are you sure you want to delete this user?" @delete="deleteUser" />
    </div>
</template>

<script>
import CreateUserModal from '~/components/user/CreateUserModal';
import DeleteConfirm from '~/components/common/DeleteConfirm'
import Popper from 'vue-popperjs';
import { ROLE, ROLE_NAME } from '~/constant/user'

export default {
    middleware: 'auth',
    
    components: {
        CreateUserModal,
        DeleteConfirm,
        Popper,
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
            users: [],
            currentPage: 1,
            from: 0,
            to: 0,
            total: 0,
            perPage: 15,
            lastPage: 1,

            deletedUser: null,
        };
    },

    created() {
        this.getUsers(1);
    },

    methods: {
        getUsers(page) {
            axios.get(route('api.users.list'), { params: { page } })
                .then((response) => {
                    this.users = response.data.data;
                    this.from = response.data.from;
                    this.to = response.data.to;
                    this.total = response.data.total;
                    this.currentPage = response.data.current_page;
                    this.perPage = response.data.per_page;
                    this.lastPage = response.data.last_page;
                })
                .catch(() => {
                    this.$notify({
                        group: 'common',
                        type: 'error',
                        text: 'Something went wrong. Please try again!',
                    });
                });
        },

        showCreationModal() {
            this.$modal.show('create-user-modal');
        },

        showUser(user) {
            this.$router.push({ name: 'users.show', params: { userId: user.id } });
        },

        editUser(user) {
            this.$router.push({ name: 'users.edit', params: { userId: user.id } });
        },

        confirmDeleteUser(user, index) {
            this.$refs['popper-action'][index].doClose();
            this.deletedUser = user;
            this.$modal.show('delete-confirm-modal');
        },

        deleteUser() {
            axios.delete(route('api.users.delete', { user: this.deletedUser.id }))
                .then((response) => {
                    this.$notify({
                        group: 'common',
                        type: 'success',
                        text: 'Deleted user',
                    });
                    this.deletedUser = null;
                    this.getUsers(this.page);
                })
                .catch(() => {
                    this.$notify({
                        group: 'common',
                        type: 'error',
                        text: 'Something went wrong. Please try again!',
                    });
                });
        }
    }
}
</script>
