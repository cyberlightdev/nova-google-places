<template>
    <span>{{ fieldShortName }}</span>
</template>

<script>

export default {
    props: ['resourceName', 'field'],
    computed: {
        fieldShortName() {
            if(this.field.value === null || this.field.value.address === null) {
                return "--";
            } else {
                return ` ${this.field.value.city}, ${this.field.value.state}`
            }
        }
    }
}
</script>
