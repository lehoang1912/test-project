<template>
    <modal name="create-certificate-modal" height="auto" :maxWidth="600" width="100%" :adaptive="true">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add a new certificate</h5>
                <button type="button" class="close" aria-label="Close" @click="hideModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="createCertificate" @keydown="form.onKeydown($event)">
                    <div class="form-group row">
                        <label for="certificate-name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="certificate-name" name="certificate_name" v-model="form.certificate_name" placeholder="Enter name" :class="{ 'is-invalid': form.errors.has('certificate_name') }">
                            <has-error :form="form" field="certificate_name" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="createCertificate">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="hideModal">Cancel</button>
            </div>
        </div>
    </modal>
</template>

<script>
import Form from 'vform';

export default {
    props: {
        jobId: {
            type: [String, Number],
            required: true
        },
    },

    data() {
        return {
            form: new Form({
                certificate_name: '',
            }),
        };
    },

    methods: {
        createCertificate() {
            this.form.post(route('api.certificates.store', { job: this.jobId }))
                .then((response) => {
                    this.$notify({
                        group: 'common',
                        type: 'success',
                        text: 'Added certificate',
                    });

                    this.hideModal();
                    this.resetForm();

                    this.$emit('created', response.data);
                });
        },

        resetForm() {
            this.form.certificate_name = '';
        },

        hideModal () {
            this.$modal.hide('create-certificate-modal');
        },
    }
}
</script>