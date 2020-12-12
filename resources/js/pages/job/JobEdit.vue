<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link :to="{ name: 'jobs.list' }">Jobs</router-link>
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
                            <form class="form-horizontal" @submit.prevent="updateJob" @keydown="form.onKeydown($event)">
                                <div class="form-group row">
                                    <label for="job-name" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" v-model="form.job_name" name="job_name" id="job-name" :class="{ 'is-invalid': form.errors.has('job_name') }">
                                        <has-error :form="form" field="job_name" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="job-date" class="col-sm-3 col-form-label">Date</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="date" v-model="form.job_date" name="job_date" id="job-date" :class="{ 'is-invalid': form.errors.has('job_date') }">
                                        <has-error :form="form" field="job_date" />
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
    middleware: 'auth',

    data() {
        return {
            jobId: this.$route.params.jobId,
            form: new Form({
                job_name: null,
                job_date: null,
            }),
        };
    },

    created() {
        this.getJob();
    },

    methods: {
        getJob() {
            axios.get(route('api.jobs.show', { job: this.jobId }))
                .then((response) => {
                    this.form.job_name = response.data.job_name;
                    this.form.job_date = response.data.job_date;
                })
                .catch((e) => {
                    this.$notify({
                        group: 'common',
                        type: 'error',
                        text: 'Something went wrong. Please try again!',
                    });
                });
        },

        updateJob() {
            this.form.put(route('api.jobs.update', { job: this.jobId }))
                .then((response) => {
                    this.$notify({
                        group: 'common',
                        type: 'success',
                        text: 'Updated job',
                    });

                    this.$router.push({ name: 'jobs.show', params: { jobId: this.jobId } });
                })
                .catch((e) => {
                    this.$notify({
                        group: 'common',
                        type: 'error',
                        text: 'Something went wrong. Please try again!',
                    });
                });
        },

        cancel() {
            this.$router.go(-1);
        },
    },
}
</script>