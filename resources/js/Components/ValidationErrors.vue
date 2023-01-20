<template>
    <div>
        <ul class='text-error'>
            <li v-for='error of errors'>
                {{error}}
            </li>
        </ul>
    </div>
</template>

<script>
// import Component from './Component.vue'; //Import Example

export default {
    components: { },

    props: {
        errors: {
            type: Array,
            required: false
        }
    },
}
</script>