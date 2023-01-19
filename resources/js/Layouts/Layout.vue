<template>
    <v-card>
        <v-layout>
            <v-navigation-drawer
                v-model="drawer"
                :rail="collapsed"
                permanent
                @click="collapsed = !collapsed"
                width='100vh'
                class='d-flex'
                v-if='user'
            >
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

                <v-divider />

                <v-list density="compact" nav>
                <v-list-item prepend-icon="mdi-home-city" title="Home" value="home"></v-list-item>
                <v-list-item prepend-icon="mdi-account" title="My Account" value="account"></v-list-item>
                <v-list-item prepend-icon="mdi-account-group-outline" title="Users" value="users"></v-list-item>
                </v-list>

                <v-divider class='mt-2'></v-divider>

                <template v-slot:append>
                    <v-divider class='mt-2' />
                    <div class="pa-2">
                        <v-footer class='justify-center align-self-end'>
                            <small>
                                <a 
                                    href='https://github.com/rogerio-pereira-dev/Condo-Management/blob/main/LICENSE' 
                                    target='_blank' 
                                    title='Copyleft 2023 - General Public License 3.0'
                                    class='copyleft'
                                    color='text'
                                >
                                    <v-icon size='x-large'>mdi-copyleft</v-icon>
                                </a>
                            </small>
                        </v-footer>
                    </div>
                </template>
            </v-navigation-drawer>

            <v-main min-height='100vh' @click='collapsed = true'>
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

export default {
    components: { },

    props: {
    },

    data() {
        return {
            drawer: true,
            items: [
            { title: 'Home', icon: 'mdi-home-city' },
            { title: 'My Account', icon: 'mdi-account' },
            { title: 'Users', icon: 'mdi-account-group-outline' },
            ],
            collapsed: true,
        }
    },

    created() {

    },

    methods: {

    },

    computed: {
        user() {
            return usePage().props.auth.user
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