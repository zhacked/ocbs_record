<template>
    <v-app style="height: 100%">
        <v-container style="height: auto">
            <!-- <h1 class="h3">Arena Details</h1> -->
            <v-row class=" is-blurred">
                <v-col class="col-md-12">
                

                    <v-row>
                        <v-col>
                            <h1>Arena Details</h1>
                            <form>
                                <v-row>
                                    <v-col>
                                        <v-btn
                                            color="success"
                                            elevation="2"
                                            @click="openModal"
                                            >Add Arena<i class="fas fa-plus fa-fw"></i>
                                        </v-btn>
                                    </v-col>
                                    <v-col>
                                        <v-file-input
                                          outlined
                                            dense
                                            v-model="fileUpload"
                                            color="deep-purple accent-4"
                                            label="File input"
                                            :clearable="false"
                                            placeholder="Select your file"
                                           counter
                                            append-icon="mdi-file-import"
                                            :show-size="1000"
                                            @change="onFileChange($event)"
                                         
                                        >
                                         <template v-slot:append>
                                            <v-tooltip bottom color="success">
                                                <template v-slot:activator="{ on }">
                                              
                                                <v-icon large :disabled="!isExcel" v-on="on" color="green darken-3" style="cursor: pointer"  @click="proceedAction">
                                                    mdi-file-import
                                                </v-icon>
                                            
                                            </template>
                                            <span>Import File</span>
                                            </v-tooltip>
                                        </template>
                                            <template
                                                v-slot:selection="{
                                                    index,
                                                    text,
                                                }"
                                            >
                                                <v-chip
                                                    v-if="index < 2"
                                                    color="deep-purple accent-4"
                                                    dark
                                                    label
                                                    
                                                    close
                                                    @click:close="clearFile"
                                                >
                                                    {{ text }}
                                                </v-chip>

                                            
                                            </template>
                                        </v-file-input>
                                      
                                    </v-col>
                                 
                                </v-row>
                            </form>
                             
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search Arena"
                                color="purple darken-1"
                                clearable
                            ></v-text-field>
                            <v-data-table
                                :headers="headers"
                                :items="arena"
                                :items-per-page="10"
                                :search="search"
                                class="elevation-1 text-center"
                            >
                                <template v-slot:[`item.team`]="{ item }">
                                    <span>{{item.team && item.team.toUpperCase()}}</span>
                                </template>
                                <template v-slot:[`item.bank`]="{ item }">
                                    <v-tooltip top>
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-btn
                                                icon
                                                v-bind="attrs"
                                                v-on="on"
                                                color="green"
                                                @click="openBankModel(item)"
                                            >
                                                <v-icon small>mdi-bank</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Bank Information</span>
                                    </v-tooltip>
                                </template>
                              
                                <template v-slot:[`item.actions`]="{ item }">
                                    <v-tooltip top>
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-btn
                                                icon
                                                v-bind="attrs"
                                                v-on="on"
                                                color="primary"
                                                @click="editModal(item)"
                                            >
                                                <v-icon small
                                                    >fa fa-edit</v-icon
                                                >
                                            </v-btn>
                                        </template>
                                        <span>Update Arena</span>
                                    </v-tooltip>
                                    <v-tooltip top>
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-btn
                                                icon
                                                v-bind="attrs"
                                                v-on="on"
                                                color="red"
                                                @click="deleteArena(item.id)"
                                            >
                                                <v-icon small
                                                    >fas fa-trash</v-icon
                                                >
                                            </v-btn>
                                        </template>
                                        <span>Delete Arena</span>
                                    </v-tooltip>
                                </template>
                            </v-data-table>
                        </v-col>
                    </v-row>
                    <!-- <v-row>
                           <v-col>
                            <v-container>
                                <h1>Arena Logs</h1>
                                <v-text-field
                                    v-model="searchlogs"
                                    append-icon="mdi-magnify"
                                    label="Search Logs"
                                    color="purple darken-1"
                                    clearable
                                ></v-text-field>
                                <v-data-table
                                    :headers="activityHeaders"
                                    :items="arenalogs"
                                    :items-per-page="10"
                                    :search="searchlogs"
                                    class="elevation-1 text-center"
                                >


                                <template v-slot:[`item.description`]="{ item }">
                                    <p> <strong>{{item.description | upText }} {{item.subject_type}}</strong>  details in {{item.properties !== null ? item.properties : 'some'  }} data on <strong>{{item.created_at | myDatewithtime}}</strong></p>
                                    
                                </template>
                              
                                </v-data-table>
                            </v-container>
 
                        </v-col>
                    </v-row> -->
                </v-col>
            </v-row>

            <!-- Bank Modal -->
            <div
                class="modal fade"
                id="bankModal"
                data-backdrop="static"
                tabindex="-1"
                role="dialog"
                aria-labelledby="addNewLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5
                                class="modal-title"
                                v-show="!editmode"
                                id="addNewLabel"
                            >
                                Bank Details
                            </h5>
                            <h5
                                class="modal-title"
                                v-show="editmode"
                                id="addNewLabel"
                            >
                                Update Bank Details
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

                        <v-data-table
                            :headers="Bankheaders"
                            :items="bankDetails"
                            :items-per-page="5"
                            :search="searchbank"
                            class="elevation-1 text-center"
                        >

                       

                            <template v-slot:top>
                                <v-toolbar flat>
                                    <v-toolbar-title>
                                        <v-btn
                                            color="success"
                                            elevation="2"
                                            @click="openBankDetails"
                                            >Add Bank<i
                                                class="fas fa-plus fa-fw"
                                            ></i>
                                        </v-btn>
                                    </v-toolbar-title>
                                    <v-divider
                                        class="mx-4"
                                        inset
                                        vertical
                                    ></v-divider>
                                    <v-spacer></v-spacer>
                                    <div class="mt-4">
                                        <v-text-field
                                            v-model="searchbank"
                                            append-icon="mdi-magnify"
                                            label="Search"
                                            color="primary darken-2"
                                        ></v-text-field>
                                    </div>
                                </v-toolbar>
                            </template>
                            <template v-slot:[`item.modify`]="{ item }">
                                <!-- {{item.bank_activity.length}} -->
                                <div v-if="item.bank_activity.length >= 1">
                                      <strong>{{item.bank_activity[0].log_name}}</strong>  {{item.bank_activity[0].description}} it on {{item.bank_activity[0].created_at | myDatewithtime}}
                                </div>
                              
                              
                            </template>
                            <template v-slot:[`item.actions`]="{ item }">
                                <v-tooltip top>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            color="primary"
                                            class="mx-2"
                                            icon
                                            dark
                                            v-bind="attrs"
                                            v-on="on"
                                            @click="updateBankDetails(item)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </v-btn>
                                    </template>
                                    <span>Edit Bank Info</span>
                                </v-tooltip>
                                |
                                <v-tooltip top>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            color="red"
                                            dark
                                            icon
                                            v-bind="attrs"
                                            v-on="on"
                                            class="mx-2"
                                            @click="deleteAccount(item.id)"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </v-btn>
                                    </template>
                                    <span>Delete Bank info </span>
                                </v-tooltip>
                            </template>
                        </v-data-table>

                        <v-expand-transition>
                            <div v-show="show">
                                <v-card-title>
                                    <h5
                                        class="modal-title"
                                        v-show="!editmode"
                                        id="addNewLabel"
                                    >
                                        Add Bank Details
                                    </h5>
                                    <h5
                                        class="modal-title"
                                        v-show="editmode"
                                        id="addNewLabel"
                                    >
                                        Update Bank Details
                                    </h5>
                                    <v-spacer></v-spacer>
                                    <v-icon color="red" @click="show = false">
                                        mdi-close
                                    </v-icon>
                                </v-card-title>
                                <v-card-text>
                                    <form
                                        @submit.prevent="
                                            editmode
                                                ? updateBank()
                                                : createBank()
                                        "
                                    >
                                        <div class="modal-body">
                                            <v-text-field
                                                label="Account Name"
                                                placeholder="Enter Account Name"
                                                outlined
                                                dense
                                                v-model="Bankform.account_name"
                                                :rules="[
                                                    () =>
                                                        !!Bankform.account_name ||
                                                        'This field is required',
                                                ]"
                                            ></v-text-field>

                                            <v-text-field
                                                label="Bank Name"
                                                placeholder="Enter Bank Name"
                                                outlined
                                                dense
                                                v-model="Bankform.bank_name"
                                                :rules="[
                                                    () =>
                                                        !!Bankform.bank_name ||
                                                        'This field is required',
                                                ]"
                                            ></v-text-field>

                                            <v-text-field
                                                label="Bank Number"
                                                placeholder="Enter Bank number"
                                                outlined
                                                dense
                                                v-model="Bankform.bank_number"
                                                :rules="[
                                                    () =>
                                                        !!Bankform.bank_number ||
                                                        'This field is required',
                                                ]"
                                            ></v-text-field>
                                        </div>
                                        <div class="modal-footer">
                                            <v-btn
                                                type="button"
                                                color="error"
                                                elevation="2"
                                                data-dismiss="modal"
                                                >Close</v-btn
                                            >
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
                                </v-card-text>
                            </div>
                        </v-expand-transition>
                    </div>
                </div>
            </div>
            <!-- Modal -->
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
                                    v-model="form.contact_number"
                                    :items="contacts.data"
                                    label="Contact Number"
                                    hint="Must be 11 digits"
                                    multiple
                                    chips
                                    outlined
                                    deletable-chips
                                    item-text="contact_number"
                                    @mousedown="testEnter"
                                >
                                    <template
                                        v-slot:selection="{
                                            item,
                                            attrs,
                                            selected,
                                            disabled,
                                            parent,
                                        }"
                                    >
                                        <v-chip
                                            :key="
                                                JSON.stringify(
                                                    item.contact_number
                                                )
                                            "
                                            v-bind="attrs"
                                            :input-value="selected"
                                            :disabled="disabled"
                                        >
                                            <span class="pr-2">
                                                {{
                                                    typeof item === "object"
                                                        ? item.contact_number
                                                        : item
                                                }}
                                            </span>
                                            <v-icon
                                                small
                                                @click="
                                                    item.id
                                                        ? removeContact(item.id)
                                                        : parent.selectItem(
                                                              item
                                                          )
                                                "
                                            >
                                             
                                            </v-icon>
                                        </v-chip>
                                    </template>
                                </v-combobox>

                                <v-combobox
                                    v-model="form.email"
                                    :items="emails.data"
                                    label="Email Address"
                                    hint="Maximum of 5 Emails"
                                    multiple
                                    chips
                                    outlined
                                    deletable-chips
                                    item-text="email"
                                    :rules="[required]"
                                >
                                    <template
                                        v-slot:selection="{
                                            item,
                                            attrs,
                                            selected,
                                            disabled,
                                            parent,
                                        }"
                                    >
                                        <v-chip
                                            :key="JSON.stringify(item.email)"
                                            v-bind="attrs"
                                            :input-value="selected"
                                            :disabled="disabled"
                                        >
                                            <span class="pr-2">
                                                {{
                                                    typeof item === "object"
                                                        ? item.email
                                                        : item
                                                }}
                                            </span>
                                            <v-icon
                                                small
                                                @click="
                                                    item.id
                                                        ? removeEmail(item.id)
                                                        : parent.selectItem(
                                                              item
                                                          )
                                                "
                                            >
                                                
                                            </v-icon>
                                        </v-chip>
                                    </template>
                                </v-combobox>
                            </div>
                            <div class="modal-footer">
                                <v-btn
                                    type="button"
                                    color="error"
                                    elevation="2"
                                    data-dismiss="modal"
                                    >Close</v-btn
                                >
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
        </v-container>
            <v-dialog
                v-model="arenaLoading"
                persistent
                width="300"
                >
                <v-card
                    color="primary"
                    dark
                >
                    <v-card-text>
                    Please stand by
                    <v-progress-linear
                        indeterminate
                        color="white"
                        class="mb-0"
                    ></v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-dialog>
    </v-app>
</template>

<script>
import { camelCase } from "lodash";
import XLSX from "xlsx";

export default {
    data() {
        return {
            headers: [
                { text: "#", value: "index" },
                { text: "Code", value: "area_code" },
                { text: "Arena Name", value: "arena" },
                { text: "Operator", value: "operator" },
                { text: "Team", value: "team" },
                { text: "Bank Details", value: "bank" },
                { text: "", value: "actions", sortable: false },
            ],
    
            Bankheaders: [
                { text: "Account Name", value: "account_name" },
                { text: "Bank Name", value: "bank_name" },
                { text: "Bank Number", value: "bank_number" },
                 { text: "Modify", value: "modify" },
                { text: "", value: "actions", sortable: false },
            ],
            activityHeaders:[
                { text: "Name", value: "log_name" },
                { text: "Description", value: "description"}
            ],
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
                email: [],
            }),
            Bankform: new Form({
                id: "",
                account_name: "",
                arenas_id: "",
                bank_name: "",
                bank_number: "",
            }),

            contactNumbers: [],
            emailList: [],
            arenaList: [],
            bankList: [],
            fileUpload: null,
            isExcel: false
        };
    },
    methods: {
        // loadLogs(){
        //      axios.get("api/Logsindex/").then((data) => {
        //         console.log('Logs>>>',data)
        //         this.arenalogs = data.data
        //     });
        // },
        onFileChange(event) {
            // let arrayNumbers = [];
            // const file = event.target.files ? event.target.files[0] : null;
            // this.fileUpload = file;
            // const file = this.fileUpload ? this.fileUpload[0] : null;
            const file = event ? event : null;

            const checkfile =
                (event.name.includes("xlsx")) || ( event.name.includes("csv"));
           

            if (event && checkfile) {
                this.isExcel = true
                const reader = new FileReader();
                let arrayData = [];

                reader.onload = (e) => {
                    const bstr = e.target.result;
                    const wb = XLSX.read(bstr, { type: "binary" });

                    const ws = wb.SheetNames;

                    const filteredWS = ws.filter(function (value, index, arr) {
                        return value.toLowerCase() === ("DETAILS").toLowerCase();
                    });
                    filteredWS.forEach((w) => {
                        const singleSheet = wb.Sheets[w];

                        arrayData.push(
                            XLSX.utils.sheet_to_json(singleSheet, {
                                header: "A",
                                defval: "",
                            })
                        );
                    });

                    const objectKeyed = (array) => {
                        // console.log('>x>x',array)
                        let objectKeyReplacedArray = [];
                        const keysss = array.find(
                            (k) => k.C === "ARENA NAME" || k.B === "CODE"
                        );

                        const [...headKey] = Object.values(keysss);
                        const headK = [...headKey];

                        array.map((data) => {
                            data = Object.assign(
                                {},
                                ...Object.entries(data).map(
                                    ([, prop], index) => ({
                                        [camelCase(headK[index])]: prop,
                                    })
                                )
                            );

                            objectKeyReplacedArray.push({
                                ...data,
                            });
                        });

                        return objectKeyReplacedArray;
                    };

                    const objk = objectKeyed(arrayData[0]);
                    // console.log(objectKeyed(arrayData[0]));

                    const toArrayContactEmail = (contactString) => {
                        // console.log(typeof contactString)
                        let number = [];
                        // const checkBreak =  typeof contactString == "string" && contactString.indexOf("\r\n") > -1;
                        const checkBreak = contactString
                            .toString()
                            .includes("\r\n");
                        // contactString.includes("\r\n");
                        // const checkForwardSlash = typeof contactString == "string" && contactString.indexOf("/") > -1;
                        const checkForwardSlash = contactString
                            .toString()
                            .includes("/");
                        // contactString.includes("/");

                        if (contactString != null) {
                            if (checkBreak) {
                                const contactSplit =
                                    contactString.split("\r\n");

                                const filteredContact = contactSplit.filter(
                                    function (el) {
                                        return el != "";
                                    }
                                );

                                filteredContact.map((cs) => {
                                    const replaceContact = cs
                                        .replace(/\-/g, "")
                                        .split(/\(.*?\)/g);

                                    // const xxx = replaceContact.filter((ccc) =>
                                    //     ccc.includes("09")
                                    // );
                                    replaceContact.map((x) =>
                                        number.push(x.trim())
                                    );
                                });
                            } else if (checkForwardSlash) {
                                const contactSplit = contactString.split("/");
                                const filteredContact = contactSplit.filter(
                                    function (el) {
                                        return el != "";
                                    }
                                );

                                filteredContact.map((cs) => {
                                    const replaceContact = cs
                                        .replace(/\-/g, "")
                                        .split(/\(.*?\)/g);

                                    // const xxx = replaceContact.filter((ccc) =>
                                    //     ccc.includes("09")
                                    // );
                                    replaceContact.map((x) =>
                                        number.push(x.trim())
                                    );
                                });
                            } else {
                                number.push(contactString);
                            }

                            return number;
                        }
                    };

                    let contactNo = [];
                    let emailList = [];

                    const removeFirstObjectTitle = objk.filter((oj) => {
                        if (oj.arenaName !== "ARENA NAME") {
                            return oj;
                        }
                    });

                    removeFirstObjectTitle.forEach((foh) => {
                        if (foh.bankName !== "" || foh.bankNumber !== "")
                            this.bankList.push({
                                account_name: foh.accountName,
                                bank_name: foh.bankName,
                                bank_number: foh.bankNumber,
                                area_code: foh.code,
                            });

                        this.arenaList.push({
                            arena:
                                foh.arenaName.indexOf("~") > -1
                                    ? foh.arenaName.replace(/\~/g, "/")
                                    : foh.arenaName,
                            area_code: foh.code,
                            address: foh.address,
                            operator: foh.operatorsName,
                            team: foh.team.toLowerCase(),
                            contact_number: "xxxxxxx",
                        });

                        toArrayContactEmail(foh.contactNumber).forEach((cn) => {
                            if (cn !== "") {
                                contactNo.push({
                                    area_code: foh.code,
                                    contact_number: cn,
                                });
                            }
                        });

                        toArrayContactEmail(foh.emailSol).forEach((em) => {
                            // console.log('>>>',foh.code,'>>',em);
                            if (em !== "")
                                emailList.push({
                                    area_code: foh.code,
                                    email: em,
                                });
                        });
                    });

                    this.emailList = emailList;
                    this.contactNumbers = contactNo;
                };
                reader.readAsBinaryString(file);
            } else {
                   this.isExcel = false
                Fire.$emit("AfterCreate"),
                    Toast.fire({
                        icon: "warning",
                        title: "Make sure you insert correct excel data!",
                    });
               
            }
        },
        clearFile(){
               this.isExcel = false
            this.fileUpload = null
        },
        async proceedAction() {
            this.$Progress.start();
            this.arenaLoading = true
            await axios.post("api/importArena", {
               arenaList  : this.arenaList,
               Uploadname :  this.fileUpload.name
            });
            await axios.post("api/contactnumbers", this.contactNumbers);
            await axios.post("api/emails", this.emailList);
            await axios.post("api/bankStore", this.bankList);

            Fire.$emit("AfterCreate");
            swal.fire("Successfully!", "Excel Imported", "success");
            this.$Progress.finish();
            this.arenaLoading = false
            this.fileUpload = null

            this.isExcel = false
        },
        testEnter(item) {
            console.log(item);
        },
        required(value) {
            if (value instanceof Array && value.length == 0) {
                return "Email is Required.";
            }
            return true;
        },
        removeEmail(id) {
            axios.get("api/emailDelete/" + id).then((data) => {
                Fire.$emit("AfterCreate");
                //  $('#addNew').modal('hide');
                // Toast.fire({
                //     icon: 'success',
                //     title: 'Email successfully Deleted'
                //     })
                this.getEmail(this.form.area_code);
            });
        },
        removeContact(id) {
            console.log(this.form.area_code);
            axios.delete("api/deleteContact/" + id).then((data) => {
                Fire.$emit("AfterCreate");
                // $('#addNew').modal('hide');
                // Toast.fire({
                //     icon: 'success',
                //     title: 'Email successfully Deleted'
                //     })
                this.getContacts(this.form.area_code);
            });
        },
        openBankDetails() {
            this.show = true;
            this.editmode = false;
            this.Bankform.bank_name = "";
            this.Bankform.bank_number = "";
        },
        openBankModel(data) {
            this.show = false;
          
            $("#bankModal").modal("show");
              console.log('juny gaGO',data);
            this.bankDetails = data.bank_details;
            this.Bankform.arenas_id = data.id;
            this.Bankform.area_code = data.area_code;
            this.Bankform.account_name = data.operator;
        },
        createBank() {
            this.$Progress.start();
            this.Bankform.post("api/bankaccount")
                .then(({ data }) => {
                    console.log(data);
                    Fire.$emit("AfterCreate");
                    this.bankDetails.push(data);
                    Toast.fire({
                        icon: "success",
                        title: "Bank Created in successfully",
                    });
                    this.show = false;
                    // $('#bankModal').modal('hide');
                    this.$Progress.finish();
                })
                .catch(() => {});
        },
        updateBank() {
            this.$Progress.start();
            this.Bankform.put("api/bankaccount/" + this.Bankform.id)
                .then(() => {
                    swal.fire(
                        "Updated!",
                        "Information has been updated.",
                        "success"
                    );

                    // const foundIndex = this.bankDetails.findIndex(x => x.id === this.Bankform.id);

                    // this.bankDetails[foundIndex] = this.Bankform
                    // console.log(foundIndex)
                    // console.log(this.bankDetails[foundIndex])

                    this.show = false;
                    $("#bankModal").modal("hide");
                    this.$Progress.finish();
                    Fire.$emit("AfterCreate");
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },
        deleteAccount(id) {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.value) {
                    this.Bankform.delete("api/bankaccount/" + id)
                        .then(() => {
                            swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            Fire.$emit("AfterCreate");
                            $("#bankModal").modal("hide");
                        })
                        .catch(() => {
                            swal.fire(
                                "Failed!",
                                "There was something wrong.",
                                "warning"
                            );
                        });
                }
            });
        },
        updateBankDetails(accounts) {
            this.Bankform.reset();
            this.show = true;
            this.editmode = true;
            this.Bankform.fill(accounts);
            this.Bankform.arenas_id = accounts.arenas_id;
        },
        editBankModal(accounts) {
            this.editmode = true;
            this.form.reset();
            $("#addNew").modal("show");
            this.form.fill(accounts);
            this.form.arenas_id = accounts.arenas_id;
        },
        updateArena() {
            this.$Progress.start();
            const areaCode = this.form.arena.split(" ")[0];
            this.form.area_code = areaCode;

            this.form
                .put("api/arena/" + this.form.id)
                .then(() => {
                    $("#addNew").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Successfully Updated",
                    });
                    this.$Progress.finish();
                    Fire.$emit("AfterCreate");
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },
        editModal(arenas) {
            this.editmode = true;
            this.form.reset();

            $("#addNew").modal("show");
            this.form.area_code = arenas.area_code;
            this.form.id = arenas.id;
            this.form.arena = arenas.arena;
            this.form.address = arenas.address;
            this.form.operator = arenas.operator;
            // this.form.contact_number = arenas.contact_number

            this.getEmail(arenas.area_code);
            this.getContacts(arenas.area_code);
        },
        getEmail(areaCode) {
            axios.get("api/getEmails/" + areaCode).then((data) => {
                console.log(data);
                //    this.emails = data
                this.form.email = data.data;
            });
        },
        getContacts(areaCode) {
            axios.get("api/getContacts/" + areaCode).then((data) => {
                console.log('CONTACT>>>',data)

                this.form.contact_number = data.data;
            });
        },
        openModal() {
            this.editmode = false;
            this.form.reset();

            $("#addNew").modal("show");
        },
        deleteArena(id) {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.value) {
                    this.form
                        .delete("api/arena/" + id)
                        .then(() => {
                            swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            Fire.$emit("AfterCreate");
                        })
                        .catch(() => {
                            swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                        });
                }
            });
        },
        loadArena() {
            axios.get("api/arena").then((data) => {
                this.arena = data.data
                
                });
        },
        createArena() {
            console.log(this.form);
            console.log("dsadsa");
            this.$Progress.start();
            const areaCode = this.form.arena.split(" ")[0];
            this.form.area_code = areaCode;
            this.form
                .post("api/arena")
                .then(() => {
                    Fire.$emit("AfterCreate");
                    $("#addNew").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Successfully Created",
                    });

                    this.$Progress.finish();
                })
                .catch((e) => {
                    console.log(e);
                });
        },
    },
    created() {
        this.loadArena();
     
        Fire.$on("AfterCreate", () => {
            this.loadArena();
      
        });
    },
    watch: {
        "form.email": function (val) {
            // val.forEach((x) =>  {
            //     if(!(/.+@.+\..+/.test(x))){
            //       this.$nextTick(() => this.form.email.pop())
            //     }
            // });

            if (val.length > 5) {
                this.$nextTick(() => this.form.email.pop());
            }
        },
        "form.contact_number": function (contacts) {
            // console.log(contacts);
            // contacts.forEach(c => {
            //     if(c.length  !== 11 || !c.startsWith("09")) this.$nextTick(() => this.form.contact_number.pop())
            // })
        },
    },
};
</script>
