<template>
    <modal name="create-job-modal" height="auto" :maxWidth="600" width="100%" :adaptive="true">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add a new job</h5>
                <button type="button" class="close" aria-label="Close" @click="hideModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="createJob" @keydown="form.onKeydown($event)">
                    <div class="form-group row">
                        <label for="job-name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="job-name" name="job_name" v-model="form.job_name" placeholder="Enter name" :class="{ 'is-invalid': form.errors.has('job_name') }">
                            <has-error :form="form" field="job_name" />
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="job-date" class="col-sm-2 col-form-label">Date</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="date" id="job-date" name="job_date" v-model="form.job_date" :class="{ 'is-invalid': form.errors.has('job_date') }">
                            <has-error :form="form" field="job_date" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="createJob">Save</button>
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
                job_name: '',
                job_date: '',
            }),
        };
    },

    methods: {
        createJob() {
            this.form.post(route('api.jobs.store'))
                .then(() => {
                    this.$notify({
                        group: 'common',
                        type: 'success',
                        text: 'Added job',
                    });

                    this.hideModal();
                    this.resetForm();

                    this.$emit('created');
                })
                .catch((e) => {
                    this.$notify({
                        group: 'common',
                        type: 'error',
                        text: 'Something went wrong. Please try again!',
                    });
                });
        },

        resetForm() {
            this.form.job_name = '';
            this.form.job_date = '';
        },

        hideModal () {
            this.$modal.hide('create-job-modal');
        },
    }
}
</script>