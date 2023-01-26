<template>
    <v-list density="compact" nav>
        <v-list-item
            v-for='(item, index) in menuItems'
            :key='index' 
            :prepend-icon="item.icon" 
            :title="item.title" 
            @click.stop="sendNavigate(item.route)"
        />
    </v-list>
</template>

<script>

export default {
    props: {
        menuItems: {
            required: true,
            type: Array,
            // default: [
            //     {
            //         icon: '',
            //         title: '',
            //         route: ''
            //     }
            // ]
        }
    },

    methods: {
        sendNavigate(route)
        {
            this.$emit('navigate', route)
        }
    }
}
</script>