<template>
    <v-scroll-y-transition appear>
        <v-col md='4' sm='6' xs='12' class='mx-auto'>
            <v-card :loading="loading">
                <template v-slot:loader>
                    <custom-progress-bar :active="loading" />
                </template>

                <v-card-title class='mb-6 text-h4 text-center elevation-2 bg-primary'>
                    Reset Password
                </v-card-title>
                
                <v-card-text >
                    <div class='mb-2'>
                        <v-text-field
                            v-model="form.email"
                            label="Email"
                            variant='solo'
                            class='my-0 py-0'
                            @keydown.enter.prevent="resetPassword"
                            clearable
                        ></v-text-field>

                        <validation-errors v-if='errors.email' class='px-6' :errors="errors.email" />
                    </div>

                    <div class='mb-2'>
                        <v-text-field
                            v-model="form.password"
                            label="Password"
                            placeholder="Password"
                            variant='solo'
                            :type="showPassword ? 'text' : 'password'"
                            @keydown.enter.prevent="resetPassword"
                            clearable
                        >
                            <template v-slot:append-inner>
                                <v-icon @click='toggleShowPassword' v-if='showPassword'>mdi-eye-off</v-icon>
                                <v-icon @click='toggleShowPassword' v-else>mdi-eye</v-icon>
                            </template>
                        </v-text-field>

                        <validation-errors v-if='errors.password' class='px-6' :errors="errors.password" />
                    </div>

                    <div class='mb-2'>
                        <v-text-field
                            v-model="form.confirmation"
                            label="Confirmation"
                            placeholder="Confirmation"
                            variant='solo'
                            :type="showPassword ? 'text' : 'password'"
                            @keydown.enter.prevent="resetPassword"
                            clearable
                        >
                        </v-text-field>

                        <validation-errors v-if='errors.confirmation' class='px-6' :errors="errors.confirmation" />
                    </div>

                    <v-btn color="primary" @click='resetPassword' class='d-flex mx-auto'>
                        Reset Password
                    </v-btn>
                </v-card-text>  
            </v-card>
        </v-col>
    </v-scroll-y-transition>
</template>

<script>
import { mapActions } from 'pinia'
import {useNotificationStore} from '@/modules/store/NotificationStore'

import CustomProgressBar from '@/Components/CustomProgressBar.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'

export default {
    components: { CustomProgressBar, ValidationErrors },

    props: {
        uuid: {
            required: true,
            type: String
        }
    },

    data() {
        return {
            form: {
                email: '',
                password: '',
                confirmation: '',
            },
            showPassword: false,
            errors: [],
            loading: false,
        }
    },

    methods: {
        ...mapActions( 
            useNotificationStore, 
            { 
                showSnackbar: 'show' 
            }
        ),

        toggleShowPassword()
        {
            this.showPassword = !this.showPassword
        },

        resetPassword()
        {
            this.loading = true;
            axios.post('/api/user/change-password/reset', {
                    ...this.form,
                    uuid: this.uuid    
                })
                .then(response => {
                    
                    this.showSnackbar('Password Changed', '3000', 'success')
                    this.$inertia.visit(route('home'))
                })
                .catch(error => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data.errors
                    }
                    else if(error.response.status == 404) {
                        this.errors = {
                            email: ["This email doesn't match specified user."]
                        }
                    }
                    else {
                        const message = 'Failed to change password. Reason: '+error.response.data.message

                        this.showSnackbar(message, 3000, 'error')
                    }
                })
                .finally(() => {
                    this.loading = false
                });
        }
    },
}
</script>

<style scoped>

</style>