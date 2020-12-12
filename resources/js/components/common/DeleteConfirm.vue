<template>
    <modal name="delete-confirm-modal" height="auto" :maxWidth="600" width="100%" :adaptive="true">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">
                    {{ header }}
                </h5>
                <button type="button" class="close" aria-label="Close" @click="hideModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    {{ confirm }}
                </p>
            </div>
            <div class="modal-footer">
                <button v-if="type === 'delete'" type="button" class="btn btn-danger waves-effect waves-light" @click="doDelete">Delete</button>
                <button v-else type="button" class="btn btn-primary waves-effect waves-light" @click="doDelete">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="hideModal">Cancel</button>
            </div>
        </div>
    </modal>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: 'delete'
        },

        header: {
            type: String,
            required: true
        },

        confirm: {
            type: String,
            required: true
        },
    },

    methods: {
        hideModal () {
            this.$modal.hide('delete-confirm-modal');
        },

        doDelete() {
            this.$emit('delete');
            this.hideModal();
        }
    }
}
</script>
