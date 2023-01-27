<template>
    <v-dialog
        v-model="active"
        scrollable
        persistent
    >
        <v-card width='50vw' class='mx-auto'>
            <template v-slot:loader>
                <custom-progress-bar :active="loading" />
            </template>

            <v-card-title class='bg-primary text-white'>
                {{action}} Employee
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text>
                <v-form class='my-4'>
                    <v-row>
                        <!-- Name -->
                        <v-col xs='12' md='4'>
                            <v-text-field
                                v-model="form.name"
                                label="Name"
                                placeholder="Name"
                                variant='solo'
                                clearable
                            />

                            <small>
                                <validation-errors v-if='errors.name' class='px-6' :errors="errors.name" />
                            </small>
                        </v-col>

                        <!-- Email -->
                        <v-col xs='12' md='4'>
                            <v-text-field
                                v-model="form.email"
                                label="Email"
                                placeholder="Email"
                                variant='solo'
                                clearable
                            />

                            <small>
                                <validation-errors v-if='errors.email' class='px-6' :errors="errors.email" />
                            </small>
                        </v-col>

                        <!-- Role -->
                        <v-col xs='12' md='4' v-if="action == 'Create'">
                            <v-select
                                v-model="form.role"
                                label="Role"
                                variant='solo'
                                :items="['Admin', 'Maintenance']"
                                clearable
                            ></v-select>

                            <small>
                                <validation-errors v-if='errors.role' class='px-6' :errors="errors.role" />
                            </small>
                        </v-col>

                        <v-col xs='12' md='4' v-if="action == 'Create'">
                            <v-text-field
                                v-model="form.password"
                                label="Password"
                                placeholder="Password"
                                variant='solo'
                                :type="showPassword ? 'text' : 'password'"
                                clearable
                            >
                                <template v-slot:append-inner>
                                    <v-icon @click='toggleShowPassword' v-if='showPassword'>mdi-eye-off</v-icon>
                                    <v-icon @click='toggleShowPassword' v-else>mdi-eye</v-icon>
                                </template>
                            </v-text-field>

                            <small>
                                <validation-errors v-if='errors.password' class='px-6' :errors="errors.password" />
                            </small>
                        </v-col>

                        <v-col xs='12' md='4' v-if="action == 'Create'">
                            <v-text-field
                                v-model="form.confirmation"
                                label="Confirmation"
                                placeholder="Confirmation"
                                variant='solo'
                                :type="showPassword ? 'text' : 'password'"
                                clearable
                            />

                            <small>
                                <validation-errors v-if='errors.confirmation' class='px-6' :errors="errors.confirmation" />
                            </small>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-divider></v-divider>
            
            <!-- Card Actions -->
            <v-card-actions class='d-flex justify-end'>
                <v-btn
                    color="secondary"
                    variant="text"
                    @click="$emit('close')"
                >
                    Close
                </v-btn>


                <v-btn
                    class="bg-primary"
                    variant="outlined"
                    v-if="action == 'Create'"
                    @click="create"
                >
                    Save
                </v-btn>

                <v-btn
                    class="bg-primary"
                    variant="outlined"
                    v-else-if="action == 'Edit'"
                    @click="update"
                >
                    Update
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { mapActions } from 'pinia'
import {useNotificationStore} from '@/modules/store/NotificationStore'

import ValidationErrors from '@/Components/ValidationErrors.vue'
import CustomProgressBar from '@/Components/CustomProgressBar.vue'

export default {
    components: { ValidationErrors, CustomProgressBar },

    props: {
        showDialog: {
            required: false,
            type: Boolean,
            default: false
        },

        employee: {
            required: false,
            type: Object,
            default: {}
        }
    },

    data() {
        return {
            form: {
                name: null,
                email: null,
                role: null,
            },
            errors: [],
            loading: false,
            showPassword: false,
        }
    },

    methods: {
        ...mapActions( 
            useNotificationStore, 
            { 
                showSnackbar: 'show' 
            }
        ),

        clearData() {
            this.form.name = null
            this.form.email = null
            this.form.role = null
            this.form.password = null
            this.form.confirmation = null

            this.errors = []
            this.showPassword = false
        },

        toggleShowPassword()
        {
            this.showPassword = !this.showPassword
        },

        create()
        {
            this.loading = true
            axios.post('/api/user', this.form)
                .then(response => {
                    this.$emit('createEmployee')
                    this.clearData()
                    this.$emit('close')
                })
                .catch(error => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data.errors
                    }
                    else {
                        const message = 'Failed to create employee. Reason: '+error.response.data.message

                        this.showSnackbar(message, 3000, 'error')
                    }
                })
                .finally(() => {
                    this.loading = false
                });
        },

        update()
        {
            this.loading = true
            axios.put('/api/user/'+this.employee.id, {
                    name: this.form.name,
                    email: this.form.email,
                })
                .then(response => {
                    this.$emit('updateEmployee', this.form.name, this.form.email)
                    this.clearData()
                    this.$emit('close')
                })
                .catch(error => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data.errors
                    }
                    else {
                        const message = 'Failed to update employee. Reason: '+error.response.data.message

                        this.showSnackbar(message, 3000, 'error')
                    }
                })
                .finally(() => {
                    this.loading = false
                });
        },
    },

    computed: {
        action() {
            if(this.employee && this.employee.id)
                return 'Edit'

            return 'Create'
        },

        active() {
            return this.showDialog
        },
    },

    watch: {
        employee: {
            handler(data) {
                this.form.name = data.name
                this.form.email = data.email
                this.form.role = data.role
            },
            deep: true
        }
    }
}
</script>

<style scoped>

</style>