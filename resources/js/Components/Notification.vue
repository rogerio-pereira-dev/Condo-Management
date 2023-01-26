<template>
    <v-snackbar
        v-model="notificationStore.active"
        location='top'
        :timeout="notificationStore.timeout"
        :color="notificationStore.color"
        multi-line
    >
        {{ notificationStore.text }}

        <template v-slot:actions>
            <v-btn
                color="primary"
                variant="text"
                @click="hide"
            >
                Close
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script>

import { mapStores } from 'pinia'
import { mapActions } from 'pinia'
import {useNotificationStore} from '@/modules/store/NotificationStore'

export default {

    data() {
        return {
        }
    },

    methods: {
        ...mapActions( 
            useNotificationStore, 
            [ 
                'hide' 
            ]
        ),
    },

    computed: {
        ...mapStores( useNotificationStore )
    }
}
</script>