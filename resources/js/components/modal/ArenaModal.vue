
<template>
    <div class="container">
        <div class="row justify-content-center">
                <div
                class="modal fade"
                id="addNew"
                data-backdrop="static"
                tabindex="-1"
                role="dialog"
                aria-labelledby="addNewLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5
                                class="modal-title"
                                v-show="!editmode"
                                id="addNewLabel"
                            >
                                New Arena
                            </h5>
                            <h5
                                class="modal-title"
                                v-show="editmode"
                                id="addNewLabel"
                            >
                                Update Arena
                            </h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form
                            @submit.prevent="
                                editmode ? updateArena() : createArena()
                            "
                        >
                            <div class="modal-body">
                                <v-text-field
                                    label="Arena Name"
                                    outlined
                                    v-model="form.arena"
                                    :rules="[
                                        () =>
                                            !!form.arena ||
                                            'This field is required',
                                    ]"
                                    :error-messages="errors.areaCode"
                                ></v-text-field>

                                <v-text-field
                                    label="Arena Address"
                                    outlined
                                    v-model="form.address"
                                    :rules="[
                                        () =>
                                            !!form.address ||
                                            'This field is required',
                                    ]"
                                    :class="{
                                        'is-invalid':
                                            form.errors.has('address'),
                                    }"
                                ></v-text-field>

                                <v-text-field
                                    label="Operator Name"
                                    placeholder="john Doe"
                                    outlined
                                    v-model="form.operator"
                                    :rules="[
                                        () =>
                                            !!form.operator ||
                                            'This field is required',
                                    ]"
                                ></v-text-field>

                                <v-combobox
                                    v-model="contactNos"
                                    :items="contacts"
                                    label="Contact Number"
                                    hint="Must be 11 digits"
                                    multiple
                                    outlined
                                    deletable-chips
                                    chips
                                    item-text="contact_number"   
                                >
                                </v-combobox>

                                <v-combobox
                                    v-model="emailsArr"
                                    :items="emails"
                                    label="Email Address"
                                    hint="Maximum of 5 Emails"
                                    multiple
                                    chips
                                    outlined
                                    deletable-chips
                                    item-text="email"
                                    
                                >
                                
                                </v-combobox>
                            </div>
                            <div class="modal-footer">
                                
                                <v-btn
                                    v-show="editmode"
                                    type="submit"
                                    color="primary"
                                    elevation="2"
                                    >Update</v-btn
                                >
                                <v-btn
                                    v-show="!editmode"
                                    type="submit"
                                    color="success"
                                    elevation="2"
                                    >Create</v-btn
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
        return {
            select: [],
            emailRules: [],
            errorMessages: "",
            formHasErrors: false,
            editmode: false,
            arena: [],
            emails: [],
            contacts: [],
            arenalogs:[],
            search: "",
            searchlogs:'',
            searchbank: "",
            input: "",
            loading: false,
            arenaLoading: false,
            show: false,
            bankDetails: [],
            form: new Form({
                area_code: "",
                id: "",
                arena: "",
                address: "",
                operator: "",
                contact_number: [],
                email: []
            }),
            Bankform: new Form({
                id: "",
                account_name: "",
                arenas_id: "",
                bank_name: "",
                bank_number: "",
            }),

            contactNumbers: [],
            contactNos: [], // to removed
            emailsArr: [],
            emailList: [],
            arenaList: [],
            bankList: [],
            fileUpload: null,
            isExcel: false,
            errors: {
                areaCode: ''
                }
            };
        },
        mounted() {
            
        }
    }
</script>





