<template>
    <notification 
        :show='snackbar.show' 
        :timeout='snackbar.timeout' 
        :color='snackbar.color' 
        :text='snackbar.text' 
    />
    
    <v-col cols=12 class='mx-auto'>
        <v-card min-height="90vh">
            <template v-slot:loader>
                <custom-progress-bar :active="loading" />
            </template>

            <v-card-title class='mb-6 text-h4'>
                Change Password
            </v-card-title>
            
            <v-card-text >
                <v-row>
                    <v-col xs='12' sm='6' md='4' class='mx-auto'>
                        <div class='mb-2'>
                            <v-text-field
                                v-model="form.current_password"
                                clearable
                                label="Current Password"
                                placeholder="Current Password"
                                variant='solo'
                                :type="showPassword ? 'text' : 'password'"
                                @keydown.enter.prevent="changePassword"
                            >
                                <template v-slot:append-inner>
                                    <v-icon @click='toggleShowPassword' v-if='showPassword'>mdi-eye-off</v-icon>
                                    <v-icon @click='toggleShowPassword' v-else>mdi-eye</v-icon>
                                </template>
                            </v-text-field>

                            <validation-errors v-if='errors.current_password' class='px-6' :errors="errors.current_password" />
                        </div>

                        <div class='mb-2'>
                            <v-text-field
                                v-model="form.new_password"
                                clearable
                                label="New Password"
                                placeholder="New Password"
                                variant='solo'
                                :type="showPassword ? 'text' : 'password'"
                                @keydown.enter.prevent="changePassword"
                            />

                            <validation-errors v-if='errors.new_password' class='px-6' :errors="errors.new_password" />
                        </div>

                        <div class='mb-2'>
                            <v-text-field
                                v-model="form.confirmation"
                                clearable
                                label="Confirmation"
                                placeholder="Confirmation"
                                variant='solo'
                                :type="showPassword ? 'text' : 'password'"
                                @keydown.enter.prevent="changePassword"
                            />

                            <validation-errors v-if='errors.confirmation' class='px-6' :errors="errors.confirmation" />
                        </div>

                        <v-btn color="primary" @click='changePassword' class='d-flex mx-auto'>
                            Change Password
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-text>  
        </v-card>
    </v-col>
</template>

<script>
import CustomProgressBar from '../../Components/CustomProgressBar.vue'
import ValidationErrors from '../../Components/ValidationErrors.vue'
import Notification from '../../Components/Notification.vue'

export default {
    components: { CustomProgressBar, ValidationErrors, Notification },

    props: {
        
    },

    data() {
        return {
            form: {
                current_password: '',
                new_password: '',
                confirmation: '',
            },
            showPassword: false,
            errors: [],
            loading: false,
            snackbar: {
                show: false,
                timeout: 3000,
                color: 'secondary',
                text: '',
            }
        }
    },

    created() {

    },

    methods: {
        toggleShowPassword()
        {
            this.showPassword = !this.showPassword
        },

        changePassword()
        {
            this.loading = true;
            axios.post('/api/user/change-password', this.form)
                .then(response => {
                    this.showSnackBar('Password Changed', '3000', 'success')
                    this.$inertia.visit(route('home'))
                })
                .catch(error => {
                    if(error.response.status == 422 || error.response.status == 403) {
                        this.errors = error.response.data.errors
                    }
                    else {
                        const message = 'Failed to change password. Reason: '+error.response.data.message

                        this.showSnackBar(message, 3000, 'error')
                    }
                })
                .finally(() => {
                    this.loading = false
                });
        },

        showSnackBar(text, timeout = 3000, color = 'secondary')
        {
            this.snackbar.text = text
            this.snackbar.timeout = timeout
            this.snackbar.color = color

            this.snackbar.show = true
        },
    },
}
</script>

<style scoped>

</style>