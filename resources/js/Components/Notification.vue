<template>
    <v-snackbar
        v-model="active"
        location='top'
        :timeout="timeout"
        :color="color"
        multi-line
    >
        {{ text }}

        <template v-slot:actions>
            <v-btn
                color="primary"
                variant="text"
                @click="show = false"
            >
                Close
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script>

export default {
    props: {
        show: {
            required: true, 
            type: Boolean,
            default: true
        },

        timeout: {
            required: true, 
            type: Number,
            default: 3000
        },

        color: {
            required: true, 
            type: String,
            default: 'secondary'
        },

        text: {
            required: true, 
            type: Boolean,
            default: ''
        }
    },


    data() {
        return {
            active: false
        }
    },

    watch: {
        show(value) {
            this.active = value
        }
    }
}
</script>