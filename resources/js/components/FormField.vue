<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">

    <template #field>
        <input type="hidden" :id="field.attribute">

        <vue-google-autocomplete
            :classname="classes"
            :id="field.attribute + '-search'"
            ref="search"
            placeholder="Search For An Address..."
            :disabled="showEdit"
            v-on:placechanged="getAddressData"
            v-on:no-results-found="noResults">
        </vue-google-autocomplete>
        <div class="px-6 py-2 rounded cursor-pointer text-slate-100"
                @click="showEdit = !showEdit"
                v-text="(showEdit)?'Hide Manual Editing':'Show Manual Editing'" />
        <div v-show="showEdit">
            <!--    Street    -->
            <input type="text"
                   placeholder="Street Number"
                   style="margin-top:1rem;"
                   :class="classes"
                   v-model="address.street_number"/>

            <!--    City    -->
            <input type="text"
                   placeholder="City"
                   style="margin-top:1rem;"
                   :class="classes"
                   v-model="address.city"/>

            <!--    State    -->
            <input type="text"
                   placeholder="State"
                   style="margin-top:1rem;"
                   :class="classes"
                   v-model="address.state"/>

            <!--    Postal Code    -->
            <input type="text"
                   placeholder="Postal Code"
                   style="margin-top:1rem;"
                   :class="classes"
                   v-model="address.postalCode"/>

            <!--    Country    -->
            <input type="text"
                   placeholder="Country"
                   style="margin-top:1rem;"
                   :class="classes"
                   v-model="address.country"/>
        </div>
<!--        <div v-show="!showEdit && address.street_number !== ''" v-html="address.prettyPrint(true)">

        </div>-->
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import VueGoogleAutocomplete from "vue-google-autocomplete";


export default {
    components: {VueGoogleAutocomplete},
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data: function () {
        return {
            classes: 'w-full form-control form-input form-input-bordered',
            showEdit: false,
            address: {
                street_number: '',
                city: '',
                state: '',
                postalCode: '',
                country: '',
            }
        }
    },

    methods: {
        /*
     * Set the initial, internal value for the field.
     */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            console.log(this.address.street_number);
            formData.append(this.field.attribute + "-address", this.address.street_number + "");
            formData.append(this.field.attribute + "-city", this.address.city);
            formData.append(this.field.attribute + "-state", this.address.state);
            formData.append(this.field.attribute + "-postalCode", this.address.postalCode);
            formData.append(this.field.attribute + "-country", this.address.country);


        },

        noResults() {
            [
                this.address.street_number,
                this.address.city,
                this.address.state,
                this.address.postalCode,
                this.address.country
            ] = this.$refs.search.autocompleteText.split(", ");
        },

        getAddressData(addressData, placeRecord) {
            console.log(addressData);
            let street = '';
            if(addressData.street_number !== undefined) {
                street = addressData.street_number + " ";
            }
            street += addressData.route ?? '';

            this.address.street_number = street;
            this.address.city = addressData.locality ?? '';
            this.address.state = addressData.administrative_area_level_1 ?? '';
            this.address.postalCode = addressData.postal_code ?? '';
            this.address.country = addressData.country;

        }
    }
}
</script>
