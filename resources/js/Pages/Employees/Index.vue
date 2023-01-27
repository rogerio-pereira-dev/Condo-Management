<template>
    <v-col cols=12 class='mx-auto'>
        <v-card min-height="90vh">
            <template v-slot:loader>
                <custom-progress-bar :active="loading" />
            </template>

            <v-card-title class='mb-6 text-h4'>
                Employees
            </v-card-title>
            
            <v-card-text >
                <v-row>
                    <v-col cols='12'>
                        <v-row>
                            <v-col cols='12' class='d-flex'>
                                <v-text-field
                                    v-model="search"
                                    append-inner-icon="mdi-magnify"
                                    label="Search"
                                    single-line
                                    variant='solo'
                                    density="compact"
                                ></v-text-field>

                                <v-btn color='primary' class='ml-4' @click='openCreateForm'>
                                    New
                                </v-btn>
                            </v-col>
                        </v-row>

                        <v-data-table
                            v-model:items-per-page="itemsPerPage"
                            :search='search'
                            :headers="headers"
                            :items="employees"
                            item-value="uuid"
                            class="elevation-2"
                            density="compact"
                            fixed-header
                        >
                            <template v-slot:item.actions="{ item }">
                                <!-- Edit -->
                                <v-tooltip text="Edit">
                                    <template v-slot:activator="{ props }">
                                        <v-icon 
                                            color='primary' 
                                            size='small' 
                                            class='mx-2'
                                            @click='edit(item.raw)'
                                        >
                                            mdi-pencil
                                        </v-icon>
                                    </template>
                                </v-tooltip>

                                <!-- Change Password -->
                                <v-tooltip text="Change Password">
                                    <template v-slot:activator="{ props }">
                                        <v-icon 
                                            color='primary-lighten-2' 
                                            size='small' 
                                            class='mx-2' 
                                            @click='requestNewPassword(item.raw.id)'
                                        >
                                            mdi-lock-alert
                                        </v-icon>
                                    </template>
                                </v-tooltip>

                                <!-- Delete -->
                                <v-tooltip text="Delete">
                                    <template v-slot:activator="{ props }">
                                        <v-icon 
                                            color='error' 
                                            size='small' 
                                            class='mx-2' 
                                            @click='deleteUser(item.raw.id)'
                                        >
                                            mdi-trash-can-outline
                                        </v-icon>
                                    </template>
                                </v-tooltip>
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
            </v-card-text>  
        </v-card>
    </v-col>

    <form-employee 
        :employee='employee'
        :showDialog='showForm'
        @updateEmployee='updateEmployee'
        @createEmployee='createEmployee'
        @close='closeFormDialog'
    />
</template>

<script>
import { mapActions } from 'pinia'
import { VDataTable } from 'vuetify/labs/VDataTable'

import {useNotificationStore} from '@/modules/store/NotificationStore'
import CustomProgressBar from '@/Components/CustomProgressBar.vue'
import FormEmployee from './FormEmployee.vue'

export default {
    components: { VDataTable, CustomProgressBar, FormEmployee },

    props: {
        
    },

    data() {
        return {
            loading: true,
            employees: [],
            employee: {},
            itemsPerPage: 25,
            search: '',
            headers: [
                {
                    title: 'Name',
                    align: 'start',
                    sortable: true,
                    key: 'name',
                },
                {
                    title: 'Email',
                    align: 'start',
                    sortable: true,
                    key: 'email',
                },
                {
                    title: 'Role',
                    align: 'start',
                    sortable: true,
                    key: 'role',
                },
                {
                    title: '',
                    align: 'center',
                    sortable: false,
                    key: 'actions',
                    width: '150px'
                }
            ],

            showForm: false, 
        }
    },

    created() {
        this.loadEmployees()
    },

    methods: {
        ...mapActions( 
            useNotificationStore, 
            { 
                showSnackbar: 'show' 
            }
        ),

        loadEmployees()
        {
            this.loading = true
            axios.get('/api/user/category/Employee')
                .then(response => {
                    this.employees = response.data.data
                })
                .catch(error => {
                    const message = 'Failed to load Employees. Reason: '+error.response.data.message

                    this.showSnackbar(message, 3000, 'error')
                })
                .finally(() => {
                    this.loading = false
                });
        },

        requestNewPassword(id)
        {
            this.loading = true
            axios.post('/api/user/change-password/request', {
                    user_id: id
                })
                .then(response => {
                    this.showSnackbar("Password change instructions sent to user email", 3000, 'success')
                })
                .catch(error => {
                    const message = 'Failed to request password change. Reason: '+error.response.data.message

                    this.showSnackbar(message, 3000, 'error')
                })
                .finally(() => {
                    this.loading = false
                });
        },

        edit(employee)
        {
            this.employee = employee
            this.showForm = true
        },

        deleteUser(id)
        {
            this.loading = true
            axios.delete('/api/user/'+id)
                .then(response => {
                    const employee = this.employees.filter(employee => employee.id == id)[0]
                    const index = this.employees.indexOf(employee)
                    this.employees.splice(index, 1)
                })
                .catch(error => {
                    const message = 'Failed to delete employee. Reason: '+error.response.data.message

                    this.showSnackbar(message, 3000, 'error')
                })
                .finally(() => {
                    this.loading = false
                });
        },

        openCreateForm() {
            this.employee = {}
            this.showForm = true
        },

        closeFormDialog() {
            this.employee = {}
            this.showForm = false
        },

        updateEmployee(name, email) {
            this.employee.name = name
            this.employee.email = email
        },

        createEmployee()
        {
            this.loadEmployees()
        }
    },
}
</script>

<style scoped>

</style>