<template>
    <modal name="create-user-modal" height="auto" :maxWidth="600" width="100%" :adaptive="true">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add a new user</h5>
                <button type="button" class="close" aria-label="Close" @click="hideModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="createUser" @keydown="form.onKeydown($event)">
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

                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="password" id="password" name="password" v-model="form.password" placeholder="Enter password" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirmation" class="col-sm-3 col-form-label">Password confirmation</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="password" id="password-confirmation" name="password_confirmation" v-model="form.password_confirmation" placeholder="Re-enter password" :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
                            <has-error :form="form" field="password_confirmation" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="createUser">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="hideModal">Cancel</button>
            </div>
        </div>
    </modal>
</template>

<script>
import Form from 'vform';

export default {
    data() {
        return {
            form: new Form({
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role: '',
            }),
        };
    },

    methods: {
        createUser() {
            this.form.post(route('api.users.store'))
                .then(() => {
                    this.$notify({
                        group: 'common',
                        type: 'success',
                        text: 'Added user',
                    });

                    this.hideModal();
                    this.resetForm();

                    this.$emit('created');
                });
        },

        resetForm() {
            this.form.first_name = '';
            this.form.last_name = '';
            this.form.email = '';
            this.form.password = '';
            this.form.password_confirmation = '';
            this.form.role = '';
        },

        hideModal () {
            this.$modal.hide('create-user-modal');
        },
    }
}
</script>