<template>
    <v-scroll-y-transition appear>
        <v-col md='4' sm='6' xs='12' class='mx-auto'>
            <v-card :loading="loading">
                <template v-slot:loader>
                    <custom-progress-bar :active="loading" />
                </template>

                <v-card-title class='mb-6 text-h4 text-center elevation-2 bg-primary'>
                    Login
                </v-card-title>
                
                <v-card-text >
                    <div class='mb-2'>
                        <v-text-field
                            v-model="form.email"
                            clearable
                            label="Email"
                            variant='solo'
                            class='my-0 py-0'
                        ></v-text-field>

                        <validation-errors v-if='errors.email' class='px-6' :errors="errors.email" />
                    </div>

                    <div class='mb-2'>
                        <v-text-field
                            v-model="form.password"
                            clearable
                            label="Password"
                            placeholder="Password"
                            variant='solo'
                            :type="showPassword ? 'text' : 'password'"
                        >
                            <template v-slot:append-inner>
                                <v-icon @click='toggleShowPassword' v-if='showPassword'>mdi-eye-off</v-icon>
                                <v-icon @click='toggleShowPassword' v-else>mdi-eye</v-icon>
                            </template>
                        </v-text-field>

                        <validation-errors v-if='errors.password' class='px-6' :errors="errors.password" />
                    </div>

                    <v-btn color="primary" @click='login' class='d-flex mx-auto'>
                        Login
                    </v-btn>
                </v-card-text>  
            </v-card>
        </v-col>
    </v-scroll-y-transition>
</template>

<script>

import CustomProgressBar from '../Components/CustomProgressBar.vue'
import ValidationErrors from '../Components/ValidationErrors.vue'

export default {
    components: { CustomProgressBar, ValidationErrors },

    props: {
        
    },

    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            showPassword: false,
            errors: [],
            loading: false,
        }
    },

    created() {

    },

    methods: {
        toggleShowPassword()
        {
            this.showPassword = !this.showPassword
        },

        login()
        {
            this.loading = true;
            axios.post('/api/login', this.form)
                .then(response => {
                    if(response.data.message == 'Login successfull') {
                        // window.location.href = '/';
                        console.log(response.data)
                        this.$inertia.visit(route('home'), { method: 'get'})
                    }
                })
                .catch(error => {
                    if(error.response.status == 422 || error.response.status == 403)
                        this.errors = error.response.data.errors
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