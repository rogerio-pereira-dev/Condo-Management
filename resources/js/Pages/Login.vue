<template>
    <v-scroll-y-transition appear>
        <v-col md='4' sm='6' xs='12' class='mx-auto'>
            <v-card>
                <v-card-title class='mb-6 text-h4 text-center bg-deep-purple bg-lighten-2 elevation-2'>
                    Login
                </v-card-title>
                
                <v-card-text >
                    <v-text-field
                        v-model="form.email"
                        class="mb-2"
                        clearable
                        label="Email"
                        variant='solo'
                    ></v-text-field>

                    <v-text-field
                        v-model="form.password"
                        class="mb-2"
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

                    <v-btn color="primary" @click='login' class='d-flex mx-auto'>
                        Login
                    </v-btn>
                </v-card-text>  
            </v-card>
        </v-col>
    </v-scroll-y-transition>
</template>

<script>
// import Component from './Component.vue'; //Import Example

export default {
    components: { },

    props: {
        
    },

    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            showPassword: false,

        }
    },

    created() {

    },

    methods: {
        toggleShowPassword()
        {
            this.showPassword = !this.showPassword
        }
    },
}
</script>

<style scoped>

</style>