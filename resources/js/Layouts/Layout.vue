<template>
    <v-card>
        <v-layout>
            <!-- Menu -->
            <v-navigation-drawer
                v-model="drawer"
                :rail="collapsed"
                permanent
                @click="collapsed = !collapsed"
                width='100vh'
                class='d-flex'
                v-if='user'
                color='primary'
            >
                <!-- User and password -->
                <v-list density="compact" nav>
                    <v-list-item
                        prepend-avatar="https://randomuser.me/api/portraits/men/85.jpg"
                        :title="user.name"
                        nav
                    >
                        <template v-slot:append>
                            <v-btn
                                variant="text"
                                icon="mdi-chevron-left"
                                @click.stop="collapsed = !collapsed"
                            ></v-btn>
                        </template>
                    </v-list-item>

                    <v-list-item 
                        prepend-icon="mdi-lock" 
                        title="Change Password" 
                        @click.stop='navigate("change-password")'
                    />
                </v-list>

                <v-divider />

                <!-- Main Menu -->
                <menu-list 
                    v-if="user.role == 'Admin'" 
                    :menuItems='menuAdmin' 
                    @navigate='navigate' 
                />
                <menu-list 
                    v-else-if="user.role == 'Maintenance'" 
                    :menuItems='menuMaintenance' 
                    @navigate='navigate' 
                />
                <menu-list 
                    v-else-if="user.role == 'Tenant'" 
                    :menuItems='menuTenant' 
                    @navigate='navigate' 
                />

                <v-divider class='my-2'/>

                <!-- Logout -->
                <v-list-item 
                    title="Logout" value="Logout"
                    prepend-icon="mdi-exit-run" 
                    color='grey-lighten-2 bg-secondary-lighten-2'
                    @click.stop='logout'
                ></v-list-item>

                <v-divider class='my-2'></v-divider>

                <!-- Footer -->
                <template v-slot:append>
                    <v-divider class='my-2' />
                    <v-footer class='justify-center align-self-end' color='primary'>
                        <small>
                            <a 
                                href='https://github.com/rogerio-pereira-dev/Condo-Management/blob/main/LICENSE' 
                                target='_blank' 
                                title='Copyleft 2023 - General Public License 3.0'
                                class='copyleft'
                                color='text bg-primary'
                            >
                                <v-icon size='x-large' color='grey-lighten-1'>mdi-copyleft</v-icon>
                            </a>
                        </small>
                    </v-footer>
                </template>
            </v-navigation-drawer>

            <!-- Main Section -->
            <v-main min-height='100vh' @click='collapsed = true'>
                <notification />

                <!-- Page Content -->
                <v-card min-height='100vh' class='p-10 d-flex align-center' >
                    <v-card-text class='d-flex'>
                        <slot />
                    </v-card-text>
                </v-card>
            </v-main>
        </v-layout>
    </v-card>
</template>

<script>
import { usePage } from '@inertiajs/vue3'
import Notification from '@/Components/Notification.vue'
import MenuList from './Components/MenuList.vue'

export default {
    components: { Notification, MenuList },

    props: {
    },

    data() {
        return {
            drawer: true,
            collapsed: true,
        }
    },

    created() {

    },

    methods: {
        navigate(routeName)
        {
            this.collapsed = true
            this.$inertia.visit(route(routeName))
        },

        logout()
        {
            axios.post('/api/logout', {})
                .then(response => {
                    this.navigate('login')
                })
                .catch(error => {
                    
                })
        }
    },

    computed: {
        user() {
            return usePage().props.auth.user
        },

        menuAdmin() {
            return [
                {
                    icon: 'mdi-home-city',
                    title: 'Home',
                    route: 'home'
                },
            ]
        },

        menuMaintenance() {
            return [
                {
                    icon: 'mdi-home-city',
                    title: 'Home',
                    route: 'home'
                },
            ]
        },

        menuTenant() {
            return [
                {
                    icon: 'mdi-home-city',
                    title: 'Home',
                    route: 'home'
                },
            ]
        },
    }
}
</script>

<style scoped>
    .copyleft {
        color: inherit !important;
        text-decoration: none;
    }
</style>