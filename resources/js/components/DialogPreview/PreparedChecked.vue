<template>
    <v-row>
        <v-col>
            <v-row>
                <div class="sign-wrapper d-flex align-center mt-2"  style="display: flex; align-items: center; margin-top: 8px">
                    <span class="signedBy">Computed by:</span>
                    <div
                        class="sign-container d-flex justify-center align-center flex-column"
                    >
                        <span
                            class="select-field_container d-flex justify-center align-center"
                            :class="{ 'editmode-span': editmode }"
                        >
                            <span class="text-sm-body-2">{{
                                arenaDetails.user_team &&
                                arenaDetails.user_team.user_details
                                    ? arenaDetails.user_team.user_details.name
                                    : ""
                            }}</span>
                        </span>

                        <span class="signed-title text-sm-body-2">
                            {{
                                arenaDetails.user_team &&
                                arenaDetails.user_team.user_details &&
                                arenaDetails.user_team.user_details
                                    .position_details
                                    ? arenaDetails.user_team.user_details
                                          .position_details.position
                                    : " "
                            }}
                        </span>
                    </div>
                </div>
            </v-row>
            <v-row>
                <div class="sign-wrapper scbottom d-flex align-center mt-5" style="display: flex; align-items: center; margin-top: 20px">
                    <span class="signedBy">Prepared by:</span>
                    <div
                        class="sign-container d-flex justify-center align-center flex-column"
                    >
                        <span
                            class="select-field_container d-flex justify-center align-center"
                            :class="{ 'editmode-span': editmode }"
                        >
                            <span class="text-sm-body-2" v-if="!editmode">{{
                                this.selectedPreparedName || "Clarise A. Valles"
                            }}</span>
                            <!-- <select v-else class="sign-name select-field_report computation" name="prepared" disabled @change="handlePreparedBy($event)">
                                                                                <option v-for="prepared_by in userPrepared.prepared"  :value="`${prepared_by.name} | ${prepared_by.position}`" :key="prepared_by.id">{{prepared_by.name}}</option>
                                                                            </select> -->
                        </span>

                        <span class="signed-title text-sm-body-2">
                            <!-- {{preparedPosition ? preparedPosition : userPrepared.prepared.length > 0 ? userPrepared.prepared[0].position : "Finance Assistant - Kiosk" }} -->
                            {{
                                this.selectedPreparedPosition ||
                                "Finance Assistant - Kiosk"
                            }}
                        </span>
                    </div>
                </div>
            </v-row>
        </v-col>
        <v-col>
            <v-row>
                <div class="sign-wrapper d-flex mt-2 align-center" style="display: flex; align-items: center; margin-top: 8px">
                    <span class="signedBy">Checked by:</span>
                    <div
                        class="sign-container d-flex justify-center align-center flex-column"
                    >
                        <span
                            class="select-field_container d-flex justify-center align-center"
                            :class="{ 'editmode-span': editmode }"
                        >
                            <span class="text-sm-body-2" v-if="!editmode">{{
                                this.selectedCheckedNameOne ||
                                "Ma. Lourdes Anoba/Leo Tampilic Jr."
                            }}</span>
                            <!-- <select v-else class="sign-name select-field_report computation" name="checkedOne" disabled @change="handleCheckedOneBy($event)">
                                                                         
                                                                                <option v-for="checked_by in userPrepared.checked" :value="`${checked_by.name} | ${checked_by.position}`" :key="checked_by.id">{{checked_by.name}}</option>
                                                                            </select> -->
                        </span>

                        <span class="signed-title text-sm-body-2">
                            <!-- {{checkedOnePosition ? checkedOnePosition : userPrepared.checked.length > 0 ? userPrepared.checked[0].position : "QA - Team Leader"}} -->
                            {{
                                this.selectedCheckedNameOnePosition ||
                                "QA - Team Leader"
                            }}
                        </span>
                    </div>
                </div>
            </v-row>
            <v-row>
                <div class="sign-wrapper scbottom d-flex mt-5 align-center"  style="display: flex; align-items: center; margin-top: 20px">
                    <span class="signedBy">Checked by:</span>
                    <div
                        class="sign-container d-flex justify-center align-center flex-column"
                    >
                        <span
                            class="select-field_container d-flex justify-center align-center"
                            :class="{ 'editmode-span': editmode }"
                        >
                            <span class="text-sm-body-2" v-if="!editmode">{{
                                this.selectedCheckedNameTwo ||
                                "Mariel Pilotos/Jonalyn Bonares"
                            }}</span>
                            <!-- <select v-else class="sign-name select-field_report computation" name="checkedTwo" disabled @change="handleCheckedTwoBy($event)">
                                                                                <option v-for="checked_by in userPrepared.checked" :value="`${checked_by.name} | ${checked_by.position}`" :key="checked_by.id">{{checked_by.name}}</option>
                                                                            </select> -->
                        </span>

                        <span class="signed-title text-sm-body-2">
                            <!-- {{checkedTwoPosition ? checkedTwoPosition : userPrepared.checked.length ? userPrepared.checked[1].position : "Supervisor - Arena/OCBS"}} -->
                            {{
                                this.selectedCheckedNameTwoPosition ||
                                "Supervisor - Arena/OCBS"
                            }}
                        </span>
                    </div>
                </div>
            </v-row>
        </v-col>
    </v-row>
</template>
<script>
export default {
    name: "PreparedChecked",
    props: {
        userPrepared: Object,
        editmode: Boolean,
        arenaDetails: Object,
    },
    data() {
        return {
            selectedComputedName: "",
            selectedComputedPosition: "",

            selectedPreparedName: "",
            selectedPreparedPosition: "",

            selectedCheckedNameOne: "",
            selectedCheckedNameOnePosition: "",

            selectedCheckedNameTwo: "",
            selectedCheckedNameTwoPosition: "",

            preparedPosition: "",
            computedPosition: "",
            checkedOnePosition: "",
            checkedTwoPosition: "",
        };
    },
    methods: {
        selectedComputed() {
            const cc = this.userPrepared.computed.filter((c) => c.assign !== 0);
            this.selectedComputedName = cc[0]?.name;
            this.selectedComputedPosition = cc[0]?.position;
        },
        selectedPrepared() {
            const cc = this.userPrepared.prepared.filter((c) => c.assign !== 0);
            this.selectedPreparedName = cc[0]?.name;
            this.selectedPreparedPosition = cc[0]?.position;
        },
        selectedCheckedOne() {
            const cc = this.userPrepared.checked.filter((c) => c.assign !== 0);
            this.selectedCheckedNameOne = cc[0]?.name;
            this.selectedCheckedNameOnePosition = cc[0]?.position;
        },
        selectedCheckedTwo() {
            const cc = this.userPrepared.checked.filter((c) => c.assign !== 0);
            this.selectedCheckedNameTwo = cc[1]?.name;
            this.selectedCheckedNameTwoPosition = cc[1]?.position;
        },

        handlePreparedBy(event) {
            const positionPrepared = event.target.value.split(" | ");

            this.preparedPosition =
                (positionPrepared && positionPrepared[1]) || "";
        },
        handleComputedBy(event) {
            const positionComputed = event.target.value.split(" | ");

            this.computedPosition =
                (positionComputed && positionComputed[1]) || "";
        },
        handleCheckedOneBy(event) {
            const positionCheckedOne = event.target.value.split(" | ");
            this.checkedOnePosition =
                (positionCheckedOne && positionCheckedOne[1]) || "";
        },
        handleCheckedTwoBy(event) {
            const positionCheckedTwo = event.target.value.split(" | ");

            this.checkedTwoPosition =
                (positionCheckedTwo && positionCheckedTwo[1]) || "";
        },
    },
    created() {
        this.selectedComputed();
        this.selectedPrepared();
        this.selectedCheckedOne();
        this.selectedCheckedTwo();
    },
};
</script>
