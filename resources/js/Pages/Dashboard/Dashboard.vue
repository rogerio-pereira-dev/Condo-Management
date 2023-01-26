<template>
    <v-col cols=12 class='mx-auto'>
        <v-card min-height="90vh">
            <template v-slot:loader>
                <custom-progress-bar :active="loading" />
            </template>

            <v-card-title class='mb-6 text-h4'>
                Dashboard
            </v-card-title>
            
            <v-card-text >
                Dashboard
            </v-card-text>  
        </v-card>
    </v-col>
</template>

<script>

import CustomProgressBar from '@/Components/CustomProgressBar.vue'

export default {
    components: { CustomProgressBar },

    props: {
    },

    data() {
        return {
            loading: false
        }
    },

    created() {

    },

    methods: {

    },

    computed: {

    },
}
</script>

<style scoped>

</style>