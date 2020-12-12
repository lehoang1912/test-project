<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link :to="{ name: 'jobs.list' }">Jobs</router-link>
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
                                <h4 class="header-title">{{ job.job_name }}</h4>
                                
                                <div v-if="canEdit">
                                    <button type="button" class="btn btn-danger waves-effect waves-light" @click="confirmDeleteJob">Delete</button>
                                    <router-link :to="{ name: 'jobs.edit', params: { jobId: this.jobId } }">
                                        <button type="button" class="btn btn-primary waves-effect waves-light">Edit</button>
                                    </router-link>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <span class="col-sm-3">Date</span>
                            <div class="col-sm-9">
                                <p>{{ job.job_date }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <span class="col-sm-3">Certificates</span>
                            <div class="col-sm-9 show-certificates-list">
                                <div v-for="(certificate, index) in job.certificates" :key="certificate.id" class="certificate-item">
                                    {{ certificate.certificate_name }}
                                    <i v-if="canEdit" class="ion-close" @click="removeCertificate(certificate, index)"></i>
                                </div>

                                <div v-if="canEdit" class="add-certificate-btn" @click="showCreationCertificateModal">+ Certificate</div>
                            </div>
                        </div>

                        <div class="row">
                            <span class="col-sm-3">Created by</span>
                            <div class="col-sm-9">
                                <p v-if="job.user">{{ job.user.first_name + ' ' + job.user.last_name }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <span class="col-sm-3">Created at</span>
                            <div class="col-sm-9">
                                <p>{{ job.created_at | moment('YYYY-MM-DD HH:mm') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <create-certificate-modal :job-id="jobId" @created="addedCertificate" />
        <delete-confirm header="Delete job" confirm="Are you sure you want to delete this job?" @delete="deleteJob" />
    </div>
</template>

<script>
import CreateCertificateModal from '~/components/job/CreateCertificateModal';
import DeleteConfirm from '~/components/common/DeleteConfirm';
import RoleMixin from '~/mixins/RoleMixin';

export default {
    middleware: 'auth',
    
    components: {
        CreateCertificateModal,
        DeleteConfirm,
    },

    mixins: [
        RoleMixin,
    ],

    data() {
        return {
            jobId: this.$route.params.jobId,
            job: {},
        };
    },

    computed: {
        canEdit() {
            return this.isAdmin || this.currentUser.id == this.job.user_id;
        },
    },

    created() {
        this.getJob();
    },

    methods: {
        getJob() {
            axios.get(route('api.jobs.show', { job: this.jobId }))
                .then((response) => {
                    this.job = response.data;
                })
                .catch((e) => {
                    this.$notify({
                        group: 'common',
                        type: 'error',
                        text: 'Something went wrong. Please try again!',
                    });
                });
        },

        showCreationCertificateModal() {
            this.$modal.show('create-certificate-modal');
        },

        confirmDeleteJob() {
            this.$modal.show('delete-confirm-modal');
        },

        deleteJob() {
            axios.delete(route('api.jobs.delete', { job: this.jobId }))
                .then((response) => {
                    this.$notify({
                        group: 'common',
                        type: 'success',
                        text: 'Deleted job',
                    });

                    this.$router.push({ name: 'jobs.list' });
                })
                .catch(() => {
                    this.$notify({
                        group: 'common',
                        type: 'error',
                        text: 'Something went wrong. Please try again!',
                    });
                });
        },

        addedCertificate(certificate) {
            this.job.certificates.push(certificate);
        },

        removeCertificate(certificate, index) {
            axios.delete(route('api.certificates.delete', { job: this.jobId, certificate: certificate.id }))
                .then((response) => {
                    this.$notify({
                        group: 'common',
                        type: 'success',
                        text: 'Deleted certificate',
                    });
                    this.job.certificates.splice(index, 1);
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