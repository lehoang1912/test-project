<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Jobs</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="header-title d-inline-block">
                            Jobs <span v-show="total > 0" class="font-weight-light">({{ total }})</span>
                        </h4>
                        <button type="button" class="btn btn-primary waves-effect waves-light float-right m-b-20" @click="showCreationModal">+ Add</button>

                        <section>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Created by</th>
                                            <th>Created at</th>
                                            <th class="text-right"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(job, index) in jobs" :key="job.id">
                                            <td>{{ perPage * (currentPage - 1) + index + 1 }}</td>
                                            <td>{{ job.job_name }}</td>
                                            <td>{{ job.job_date }}</td>
                                            <td>{{ job.user.first_name + ' ' + job.user.last_name }}</td>
                                            <td>{{ job.created_at | moment('YYYY-MM-DD HH:mm') }}</td>
                                            <td class="text-right">
                                                <popper ref="popper-action" trigger="clickToToggle" :visible-arrow="false">
                                                    <div class="popper action-popper">
                                                        <ul class="action-popper-list">
                                                            <li class="action-popper-item" @click="showJob(job)">
                                                                <i class="mdi mdi-open-in-app mr-2"></i>
                                                                <span>View</span>
                                                            </li>
                                                            <template>
                                                                <li class="action-popper-item" @click="editJob(job)">
                                                                    <i class="mdi mdi-pencil mr-2"></i>
                                                                    <span>Edit</span>
                                                                </li>
                                                                <li class="action-popper-item text-danger" @click="confirmDeleteJob(job, index)">
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
                                :clickHandler="getJobs">
                            </paginate>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <create-job-modal @created="getJobs(1)" />
        <delete-confirm header="Delete job" confirm="Are you sure you want to delete this job?" @delete="deleteJob" />
    </div>
</template>

<script>
import CreateJobModal from '~/components/job/CreateJobModal';
import DeleteConfirm from '~/components/common/DeleteConfirm'
import Popper from 'vue-popperjs';

export default {
    middleware: 'auth',
    
    components: {
        CreateJobModal,
        DeleteConfirm,
        Popper,
    },

    data() {
        return {
            jobs: [],
            currentPage: 1,
            from: 0,
            to: 0,
            total: 0,
            perPage: 15,
            lastPage: 1,

            deletedJob: null,
        };
    },

    created() {
        this.getJobs(1);
    },

    methods: {
        getJobs(page) {
            axios.get(route('api.jobs.list'), { params: { page } })
                .then((response) => {
                    this.jobs = response.data.data;
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
            this.$modal.show('create-job-modal');
        },

        showJob(job) {
            this.$router.push({ name: 'jobs.show', params: { jobId: job.id } });
        },

        editJob(job) {
            this.$router.push({ name: 'jobs.edit', params: { jobId: job.id } });
        },

        confirmDeleteJob(job, index) {
            this.$refs['popper-action'][index].doClose();
            this.deletedJob = job;
            this.$modal.show('delete-confirm-modal');
        },

        deleteJob() {
            axios.delete(route('api.jobs.delete', { job: this.deletedJob.id }))
                .then((response) => {
                    this.$notify({
                        group: 'common',
                        type: 'success',
                        text: 'Deleted job',
                    });
                    this.deletedJob = null;
                    this.getJobs(this.page);
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