<template>
    <v-progress-linear
        :active="active"
        color="primary-lighten-2"
        indeterminate
    ></v-progress-linear>
</template>

<script>
export default {
    props: {
        active: {
            type: Boolean,
            required: true,
        }
    }
}
</script>
