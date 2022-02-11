<template>
    <v-col style="margin: 0 !important; padding: 1px 10px !important">
        <div class="d-flex align-center arenaInfo">
            <span class="custom-label arenaLabel" 
                >Arena / OCBS Name:</span
            >
            <div
                class="custom-span fullspan d-flex align-center"
                :class="{ 'editmode-span': editmode }"
            >
                <!-- <input type="text" style="text-transform: uppercase;" disabled class="input-field_report computation font-weight-bold" v-model="arenaDetails.arena"/> -->
                <span
                    style="text-transform: uppercase; font-weight: 900"
                    class="input-field_report computation"
                    >{{ arenaDetails.arena }}</span
                >
            </div>
        </div>
        <div class="d-flex align-center arenaInfo">
            <span class="custom-label arenaLabel" 
                >Address:</span
            >
            <div
                class="custom-span fullspan d-flex align-center custom-textarea"
                :class="{ 'editmode-span': editmode }"
            >
                <!-- <textarea type="text" style="text-transform: uppercase;" disabled class="input-field_report computation custom-textarea_field" v-model="arenaDetails.address"></textarea> -->
                <span
                    style="text-transform: uppercase;"
                    class="input-field_report computation arenaLabel"
                    >{{ arenaDetails.address }}</span
                >
            </div>
        </div>
        <div class="d-flex align-center arenaInfo">
            <span class="custom-label arenaLabel" 
                >Operator:</span
            >
            <div
                class="custom-span fullspan d-flex align-center"
                :class="{ 'editmode-span': editmode }"
            >
                <span
                    style="text-transform: uppercase;"
                    class="input-field_report computation arenaLabel"
                    >{{ arenaDetails.operator }}</span
                >
            </div>
        </div>
        <div class="d-flex align-center arenaInfo">
            <span class="custom-label arenaLabel" 
                >Contact Number:</span
            >
            <div
                class="custom-span fullspan d-flex align-center"
                :class="{ 'editmode-span': editmode }"
            >
                <!-- <input type="text" disabled class="input-field_report computation" v-model="arenaDetails.contact_number"/> -->
                <span class="input-field_report computation arenaLabel">{{
                    contactFormat
                }}</span>
            </div>
        </div>
        <div class="d-flex align-center arenaInfo">
            <span class="custom-label arenaLabel">Email Address:</span>
            <div
                class="custom-span text-small fullspan d-flex align-center"
                :class="{ 'editmode-span': editmode }"
            >
                <!-- <input type="text" disabled class="input-field_report computation" v-model="emailFormat"/> -->
                <span class="input-field_report computation emailFormat">{{
                    emailFormat
                }}</span>
            </div>
        </div>
    </v-col>
</template>
<script>
export default {
    name: "ArenaDetails",
    props: {
        arenaDetails: Object,
        editmode: Boolean,
        emailFormat: String,
        contactFormat: String,
    },
};
</script>
<style scoped>
.emailFormat {
    color: rgb(0, 123, 238);
}
</style>
