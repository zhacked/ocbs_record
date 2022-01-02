<template>
     <v-col>
                <div
                    class="
                        d-flex
                        align-center
                        arenaInfo
                    "
                >
                    <span
                        class="
                            text-caption
                            custom-label
                            arenaLabel
                        "
                        >Arena /
                        OCBS
                        Name:</span
                    >
                        <div
                        class="
                            custom-span
                            caption
                            fullspan
                            d-flex
                            align-center
                        "
                        :class="{'editmode-span': editmode}"
                    >
                        <input type="text" disabled class="input-field_report computation" v-model="arenaDetails.arena"/>
                    </div>
                </div>
                <div
                    class="
                        d-flex
                        align-center
                        arenaInfo
                    "
                >
                    <span
                        class="
                            text-caption
                            custom-label
                            arenaLabel
                        "
                        >Address:</span
                    >
                    <div
                        class="
                            custom-span
                            caption
                            fullspan
                            d-flex
                            align-center
                        "
                        :class="{'editmode-span': editmode}"
                    >
                        <input type="text" disabled class="input-field_report computation" v-model="arenaDetails.address"/>
                    </div>
                </div>
                <div
                    class="
                        d-flex
                        align-center
                        arenaInfo
                    "
                >
                    <span
                        class="
                            text-caption
                            custom-label
                            arenaLabel
                        "
                        >Operator:</span
                    >
                        <div
                        class="
                            custom-span
                            caption
                            fullspan
                            d-flex
                            align-center
                        "
                        :class="{'editmode-span': editmode}"
                    >
                        <input type="text" disabled class="input-field_report computation" v-model="arenaDetails.operator"/>
                    </div>
                </div>
                <div
                    class="
                        d-flex
                        align-center
                        arenaInfo
                    "
                >
                    <span
                        class="
                            text-caption
                            custom-label
                            arenaLabel
                        "
                        >Contact
                        Number:</span
                    >
                    <div
                        class="
                            custom-span
                            caption
                            fullspan
                            d-flex
                            align-center
                        "
                        :class="{'editmode-span': editmode}"
                    >
                        <input type="text" disabled class="input-field_report computation" v-model="arenaDetails.contact_number"/>
                    </div>
                </div>
                <div
                    class="
                        d-flex
                        align-center
                        arenaInfo
                    "
                >
                    <span
                        class="
                            text-caption
                            custom-label
                            arenaLabel
                        "
                        >Email
                        Address:</span
                    >
                    <div
                        class="
                            custom-span
                            caption
                            fullspan
                            d-flex
                            align-center
                        "
                        :class="{'editmode-span': editmode}"
                    >
                        <input type="text" disabled class="input-field_report computation" v-model="arenaDetails.email_details"/>
                    </div>
                </div>
            </v-col>
</template>
<script>
    export default {
        name: "ArenaDetails",
        props: {
            arenaDetails: Object,
            editmode: Boolean
        }
    }
</script>