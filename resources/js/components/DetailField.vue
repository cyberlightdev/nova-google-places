<template>
  <PanelItem :index="index" :field="getField" />
</template>

<script>

export default {
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
    computed: {
        getField() {
            let address = this.field.value;
            this.field.value = `${address.address}<br />${address.city}, ${address.state}  ${address.postalCode}<br />${address.country}`
            this.field.asHtml = true;
            return this.field;
        }
    }
}
</script>
