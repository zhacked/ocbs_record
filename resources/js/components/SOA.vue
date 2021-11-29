<template>
    <v-app>
        <v-container :class="{ 'blur-content': dialog }">
            <v-row class="mt-5">
                <v-col class="col-md-12">
                    <v-card>
                        <v-card-title class="card-header">
                            <strong>Statement of Account</strong>
                            <v-spacer></v-spacer>
                            <form @submit.prevent="proceedAction()">
                                <v-card-actions class="card-tools">
                                    <label
                                        class="form-control-label"
                                        for="input-file-import"
                                    ></label>
                                    <input
                                        type="file"
                                        id="importData"
                                        class="form-control"
                                        @change="onFileChange"
                                    />
                                    <v-btn
                                        type="submit"
                                        color="success"
                                        elevation="2"
                                        >send</v-btn
                                    >
                                </v-card-actions>
                            </form>
                        </v-card-title>

                        <div class="card card-primary card-outline card-tabs" style="overflow: auto; !important">
                                <div class="card-header p-0 pt-1 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">On Going</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Back up</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-three-tabContent active show">
                                        <v-row>
                                                <v-col>
                                                    <v-btn
                                                        :loading="loading"
                                                        :disabled="loading"
                                                        @click="loader = 'loading'"
                                                        color="light-blue lighten-1"
                                                        class="ma-2 white--text"
                                                    
                                                        >
                                                        Archive 
                                                            <v-icon
                                                                right
                                                                dark
                                                            >
                                                                mdi-archive-arrow-down
                                                            </v-icon>
                                                        </v-btn>

                                                </v-col>
                                                <v-spacer></v-spacer>
                                                <v-col>
                                                    <v-text-field
                                                        v-model="search"
                                                        append-icon="mdi-magnify"
                                                        label="Search"
                                                        color="primary darken-2"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>

                                    <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                            <v-data-table
                                                    :headers="headers"
                                                    :items="arenaData.data"
                                                    :items-per-page="10"
                                                    :search="search"
                                                    class="elevation-1 text-center"
                                                >
                                                    <template
                                                        v-slot:[`item.actions`]="{ item }"
                                                    >
                                                        <v-tooltip top>
                                                            <template
                                                                v-slot:activator="{
                                                                    on,
                                                                    attrs,
                                                                    hover,
                                                                }"
                                                            >
                                                                <v-btn
                                                                    icon
                                                                    color="primary"
                                                                    dark
                                                                    small
                                                                    v-bind="attrs"
                                                                    v-on="on"
                                                                    @click="openModel(item)"
                                                                    :class="{
                                                                        'on-hover': hover,
                                                                    }"
                                                                >
                                                                    <v-icon>mdi-eye</v-icon>
                                                                </v-btn>
                                                            </template>
                                                            <span>View Account</span>
                                                        </v-tooltip>
                                                    </template>
                                                </v-data-table>
                                        </div>


                                        <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                        <v-data-table
                                                    :headers="headers"
                                                    :items="arenaDatastatus.data"
                                                    :items-per-page="10"
                                                    :search="search"
                                                    class="elevation-1 text-center"
                                                >
                                                    <template
                                                        v-slot:[`item.actions`]="{ item }"
                                                    >
                                                        <v-tooltip top>
                                                            <template
                                                                v-slot:activator="{
                                                                    on,
                                                                    attrs,
                                                                    hover,
                                                                }"
                                                            >
                                                                <v-btn
                                                                    icon
                                                                    color="primary"
                                                                    dark
                                                                    small
                                                                    v-bind="attrs"
                                                                    v-on="on"
                                                                    @click="openModel(item)"
                                                                    :class="{
                                                                        'on-hover': hover,
                                                                    }"
                                                                >
                                                                    <v-icon>mdi-eye</v-icon>
                                                                </v-btn>
                                                            </template>
                                                            <span>View Account</span>
                                                        </v-tooltip>
                                                    </template>
                                                </v-data-table>
                                        </div>
                                </div>                     
                                </div>
                        </div>
                    </v-card>

                    
                </v-col>

                
                <v-dialog
                    v-model="dialog"
                    transition="dialog-bottom-transition"
                    content-class="my-custom-dialog"
                    scrollable
                    persistent
                    
                    width="800px"
                    style="z-index: 9999999999 !important"
                >
                    <v-card
                        class="overflow-y-auto overflow-x-hidden report-preview"
                    >
                        <v-row>
                        
                            <v-col class="cols-12 pa-0">
                                <v-card
                                    class="pa-10 overflow-auto"
                                    rounded="false"
                                    style="height: 100%"
                                >
                                    <div>
                                        <v-spacer></v-spacer>
                                   
                                     <div style="position: absolute; right: 10px; top: 15px;">
                                        <v-tooltip bottom>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-chip
                                                    small
                                                    class="ma-2"
                                                    close
                                                    color="red"
                                                    text-color="white"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                   @click="closeDialog"
                                                    >
                                                    Close
                                                </v-chip>
                                            </template>
                                            <span>Close</span>
                                        </v-tooltip>
                                        </div>
                                    </div>
                                    <div style="padding: 1px" ref="soaReport">
                                        <vue-html2pdf
                                            :show-layout="false"
                                            :float-layout="false"
                                            :enable-download="true"
                                            :preview-modal="false"
                                            :paginate-elements-by-height="2000"
                                            filename="hee hee"
                                            :pdf-quality="2"
                                            :manual-pagination="false"
                                            pdf-format="a4"
                                            pdf-orientation="portrait"
                                            pdf-content-width="90%"
                                            ref="html2Pdf"
                                            class="vuehtmlpdf"
                                        >
                                            <section
                                                slot="pdf-content"
                                                class="pdf-content"
                                            >
                                                <v-card-title
                                                    class="
                                                        text-h5 text-center
                                                        font-weight-medium
                                                        d-flex
                                                        justify-center
                                                        align-center
                                                        pdf-title
                                                    "
                                                >
                                                    <span>{{
                                                        computedAve
                                                            .depositReplenishText
                                                            .title
                                                    }}</span>
                                                </v-card-title>
                                                <v-card-text
                                                    class="text-sm-body-2"
                                                >
                                                    <v-row>
                                                        <v-spacer></v-spacer>
                                                        <v-spacer></v-spacer>
                                                        <DateSOA :depositReplenishText="computedAve.depositReplenishText" :dateEvent="date_event" :dateSoa="date_created" />
                                                       
                                                    </v-row>
                                                    <v-row>
                                                        <ArenaDetails :arenaDetails="arenaDetails" :editmode="editmode" />
                                                      
                                                    </v-row>
                                                    <v-row>
                                                        <div
                                                            class="
                                                                computation-banner
                                                            "
                                                        >
                                                            Computation
                                                        </div>
                                                    </v-row>
                                                        <ComputeBox :computation="computation" :commissionPercent="commission_percent" :editmode="editmode" :computedAve="computedAve" />
                                                                                                    
                                                        <BankBox :bank="bank" :operatorName="operator_name" :editmode="editmode" :depositReplenishText="computedAve.depositReplenishText" />
                                                                                                           
                                                        <PreparedChecked :userPrepared="userPrepared" :editmode="editmode" />
                                                   
                                                </v-card-text>
                                            </section>
                                        </vue-html2pdf>
                                    </div>
                                    <v-card-actions>
                                     <v-spacer></v-spacer>
                                     <div
                                            v-if="editmode"
                                            class="
                                                    d-flex
                                                    align-center
                                                    computation-container_field
                                                    mr-2
                                                    "
                                                    
                                                                >
                                                                 <label class="mr-2">Commission Percent ({{commission_percent*100}}%) :</label>
                                                                    <div
                                                                        class="
                                                                            custom-span
                                                                            caption
                                                                            computation-span
                                                                            d-flex
                                                                            align-center
                                                                        "
                                                                       :class="{'editmode-span': editmode}"
                                                                    >
                                                                       

                                                                         <input type="text" class="input-field_report" v-model="commission_percent"/>
                                                                    </div>
                                                                </div>
                                                                  <v-spacer></v-spacer>
                                       
                                       <v-tooltip  bottom>
                                            <template
                                            
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                v-show="!editmode"
                                                    icon
                                                    color="green"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    @click="downloadImg"
                                                >
                                                    <v-icon>mdi-image</v-icon>
                                                </v-btn>
                                            </template>
                                            <span>Download as PNG</span>
                                        </v-tooltip>
                                        <v-tooltip  bottom>
                                            <template
                                                
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    v-show="!editmode"
                                                    icon
                                                    color="red darken-2"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    :loading="loading"
                                                    :disabled="loading"
                                                    @click="generateReport"
                                                >
                                                    <v-icon
                                                        >mdi-file-pdf-box</v-icon
                                                    >
                                                </v-btn>
                                            </template>
                                            <span>Download as PDF</span>
                                        </v-tooltip>
                                        
                                        <v-divider vertical></v-divider>
                                        <v-tooltip bottom>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                               
                                                 <v-chip
                                                    class="ma-2"
                                                    :color="!editmode ? 'blue' :'green'"
                                                    small
                                                    outlined
                                                    v-bind="attrs"
                                                    v-on="on"
                                                   @click="!editmode ? updateModal() : saveModal()"
                                                    >
                                                    {{editmode ? 'Save': 'Update'}}
                                                    
                                                    <v-icon small
                                                        >{{!editmode ? 'mdi-square-edit-outline' : 'mdi-content-save' }}</v-icon
                                                    >
                                                    </v-chip>
                                            </template>
                                            <span>{{!editmode ? 'Edit Infomation' : 'Save Information' }}</span>
                                        </v-tooltip>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        
                        </v-row>
                    </v-card>
                </v-dialog>

                <!-- </v-col> -->
            </v-row>
        </v-container>
    </v-app>
</template>
<script>
import {camelCase, mapKeys, groupBy, map, spread, values, assign } from "lodash";
import XLSX from "xlsx";
import {
    numberFormat,
    numberUnformat,
    mergeObject,
    valueSplit,
} from "../utility";
import VueHtml2pdf from 'vue-html2pdf'
import html2canvas from "html2canvas";
import moment from 'moment';
import DateSOA from "./DialogPreview/DateSoa.vue"
import ArenaDetails from "./DialogPreview/ArenaDetails.vue"
import ComputeBox from "./DialogPreview/ComputeBox.vue"
import BankBox from "./DialogPreview/BankBox.vue"
import PreparedChecked from "./DialogPreview/PreparedChecked.vue"

export default {
    components: {
        VueHtml2pdf,
        DateSOA,
        ArenaDetails,
        ComputeBox,
        BankBox,
        PreparedChecked
    },
    data() {
        return {
            headers: [
                { text: "Arena Name", value: "arena_name" },
                { text: "Operator", value: "arena_details.operator" },
                { text: "Contact", value: "arena_details.contact_number" },
                { text: "", value: "actions", sortable: false },
            ],
            userPrepared: {
                computed:{},
                checked:{},
                prepared:{},
            },
           
            // computed_by:'',
            // checked_by_1:'',
            // checked_by_2:'',
            // prepared_by:'',
            // bank_details:'',
            dialog: false,
            notifications: false,
            sound: true,
            widgets: false,
            search: "",
            ocbsArray: [],
            ocbsArrayFiltered: [],
            editmode: false,
            commission_percent: 0.02,
            status: "Reflenish",
            ocbs: {},
            bankDetails: {},
            bank:{
                all: {},
                bank_id:'',
                bank_name:'',
                bank_number:'',
                selected: []
            },
          
            operator_name:'',
            randomNumber:0,
            arenaData: [],
            arenaDatastatus:[],
            arenaDetails: {},
            // selectedbank: [],
            arena_id: "",
            arena_name:'',
            loading: false,
            loader: null,
            checkfilename:'',
            form: new Form({
                id: "",
                arena: "",
                address: "",
                operator: "",
                contact_number: "",
                email: "",
            }),
         
            computation: {
                totalMWBet: 0,
                drawCancelled: 0,
                draw: 0,
                totalPayoutPaid: 0,
                cdPaid: 0,
                drawPaid: 0,
                netWinLoss: 0,
                totalMWBetPercent: 0,
                operatorExpenses: 0,
                unclaimed: 0,
                cUnpaid: 0,
                mobile: {
                    totalMWBet: 0,
                    totalDrawBet: 0,
                    cashLoad: 0,
                    cashWithdraw: 0,
                },
            },
            soa: true,
            date_created:'',
            date_event:'',
            depositReplenishTxt: {},
        };
    },
    methods: {
        loadEmployee(){
            axios.get("api/employees").then(({data}) => (

                this.userPrepared.computed = data.computed,
                this.userPrepared.checked = data.checked,
                this.userPrepared.prepared = data.prepared
               
               ));
        },
        loadbank(){
            axios.get("api/bankaccount").then(({data}) => (
                    this.bank.all = data
                ));
        },
        // filterbank(){
        //       axios.get("api/selectedbank/"+ this.bank.bank_id).then(({data}) => (
        //             this.bank.bank_name = data.bank_name,
        //             this.bank.bank_number = data.bank_number
        //         ));
        // },
   
        async importwithstatus() {
            const data = await axios.get("api/importwithstatus");
            let helper = {};

            const duplicateObj = await data.data.reduce(function (r, obj) {
                const key = obj.arena_name;

                if (!helper[key]) {
                    helper[key] = Object.assign({}, obj); // create a copy of o

                    r.push(helper[key]);
                } else {
                    // const {arenaName, ...o} = obj;
                    helper[key].mobile = {
                        ...obj,
                    };
                }

                return r;
            }, []);

            const obj = {
                data: duplicateObj,
            };

            this.arenaDatastatus = obj;
        },
        async showData() {
            const data = await axios.get("api/import");
            let helper = {};

            const duplicateObj = await data.data.reduce(function (r, obj) {
                const key = obj.arena_name;

                if (!helper[key]) {
                    helper[key] = Object.assign({}, obj); // create a copy of o

                    r.push(helper[key]);
                } else {
                    // const {arenaName, ...o} = obj;
                    helper[key].mobile = {
                        ...obj,
                    };
                }

                return r;
            }, []);

            const obj = {
                data: duplicateObj,
            };

            this.arenaData = obj;
        },
        closeDialog() {
            this.dialog = false;
        },
        updateModal() {
            $(".computation").removeAttr("disabled");
            $(".computation").addClass("input-show")
            
              this.computation = {
                totalMWBet: numberUnformat(this.computation.totalMWBet),
                drawCancelled: numberUnformat(this.computation.drawCancelled),
                draw: numberUnformat(this.computation.draw),
                totalPayoutPaid: numberUnformat(this.computation.totalPayoutPaid),
                cdPaid: numberUnformat(this.computation.cdPaid),
                drawPaid: numberUnformat(this.computation.drawPaid),
                netWinLoss: numberFormat(this.computation.netWinLoss),
                unclaimed: numberUnformat(this.computation.unclaimed),
                cUnpaid: numberUnformat(this.computation.cUnpaid),
                totalMWBetPercent: numberUnformat(this.computation.totalMWBetPercent),
                operatorExpenses: numberUnformat(
                    this.computation.operatorExpenses
                ),
                mobile: {
                    cashLoad: numberUnformat(this.computation.mobile.cashLoad),
                    cashWithdraw: numberUnformat(this.computation.mobile.cashWithdraw),
                    totalMWBet: numberUnformat(this.computation.totalMobileMWBets || "0.00"),
                    totalDrawBet: numberUnformat(this.computation.totalMobileDrawBets || "0.00"),
                },
              }

              this.editmode =  !this.editmode;

        },
        closeDialog() {
            this.editmode = false;
            this.dialog = false;
            this.form.reset();
             $(".computation").attr("disabled", true);
        },
      
        saveModal() {
            $(".computation").attr("disabled", true);
            this.editmode = !this.editmode;

             this.computation = {
                totalMWBet: numberFormat(this.computation.totalMWBet),
                drawCancelled: numberFormat(this.computation.drawCancelled),
                draw: numberFormat(this.computation.draw),
                totalPayoutPaid: numberFormat(this.computation.totalPayoutPaid),
                cdPaid: numberFormat(this.computation.cdPaid),
                drawPaid: numberFormat(this.computation.drawPaid),
                netWinLoss: numberFormat(this.computation.netWinLoss),
                unclaimed: numberFormat(this.computation.unclaimed),
                cUnpaid: numberFormat(this.computation.cUnpaid),
                totalMWBetPercent: numberFormat(this.computation.totalMWBetPercent),
                operatorExpenses: numberFormat(
                    this.computation.operatorExpenses
                ),
                mobile: {
                   cashLoad: numberFormat(this.computation.mobile.cashLoad),
                    cashWithdraw: numberFormat(this.computation.mobile.cashWithdraw),
                    totalMWBet: numberFormat(this.computation.totalMobileMWBets || 0),
                    totalDrawBet: numberFormat(this.computation.totalMobileDrawBets || 0),
                },
              } 
        },
     
        proceedAction() {
            this.$Progress.start();
            if ($("#importData").val() === "" || this.checkfilename[1] != 'xlsx') {
                Fire.$emit("AfterCreate");
                swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: "Make sure you insert correct excel data!",
             
                });
            } else {
                axios.post("api/import", this.ocbsArrayFiltered).then(
                    ({ data }) => (
                        $("#importData").val(""),
                        Fire.$emit("AfterCreate"),
                        swal.fire("Successfully!", "Excel Imported", "success"),
                        this.$Progress.finish()
                        // location.reload()
                    )
                );
            }
        },
    
        openModel(data) {
            if(data.arena_details == null){
                swal.fire({
                    icon: "warning",
                    title: "Missing",
                    text: "Add Arena Details",
                    footer: '<a href="/arena">Click here to Add Arena</a>',
                });
            }else{
            this.operator_name = data.arena_details.operator;
            this.bank.bank_name = data.bank_details.length != 0 ? data.bank_details[0].bank_name : 'No Bank Name found !' ;
            this.bank.bank_number = data.bank_details.length != 0 ? data.bank_details[0].bank_number : 'No Bank Number found !' ;
            this.form.reset();
            this.dialog = true;
            this.date_created = moment().format('ll');
            this.date_event = moment(data.date_of_soa).format('ll');
            this.randomNumber =Math.floor(Math.random() * (1000 + 1) + 1);
            // this.editmode = !this.editmode;
            
            this.form.fill(data.arena_details);
            this.arenaDetails = data.arena_details;
            this.arena_id = data.id;
            this.arena_name = data.arena_name;
            const totalMWBet = data.total_meron_wala;
            const drawCancelled = data.draw_cancelled;
            const draw = data.draw;
            const totalPayoutPaid = data.total_payout_paid;
            const cdPaid = data.draw_cancelled_paid;
            const drawPaid = data.draw_paid;
            const unclaimed = data.unclaimed;
            const cUnpaid = data.cancelled_unpaid;
            const netWinLoss =
                parseFloat(totalMWBet) +
                parseFloat(drawCancelled) +
                parseFloat(draw) -
                parseFloat(totalPayoutPaid) -
                parseFloat(cdPaid) -
                parseFloat(drawPaid);
            const totalMWBetPercent =
                parseFloat(totalMWBet) * parseFloat(this.commission_percent);
            // console.log(totalMWBetPercent)
            const totalMobileMWBets = data.mobile
                ? data.mobile.total_meron_wala
                : 0;
            const totalMobileDrawBets = data.mobile ? data.mobile.draw : 0;

            this.computation = {
                totalMWBet: numberFormat(totalMWBet),
                drawCancelled: numberFormat(drawCancelled),
                draw: numberFormat(draw),
                totalPayoutPaid: numberFormat(totalPayoutPaid),
                cdPaid: numberFormat(cdPaid),
                drawPaid: numberFormat(drawPaid),
                netWinLoss: numberFormat(netWinLoss),
                unclaimed: numberFormat(unclaimed),
                cUnpaid: numberFormat(cUnpaid),
                totalMWBetPercent: numberFormat(totalMWBetPercent),
                operatorExpenses: numberFormat(
                    this.computation.operatorExpenses
                ),
                mobile: {
                    cashLoad: numberFormat(this.computation.mobile.cashLoad),
                    cashWithdraw: numberFormat(this.computation.mobile.cashWithdraw),
                    totalMWBet: numberFormat(totalMobileMWBets),
                    totalDrawBet: numberFormat(totalMobileDrawBets),
                },
             };
            }
           
        },

        onFileChange(event) {
            const file = event.target.files ? event.target.files[0] : null;
            this.checkfilename  = file.name.split('.');
            if (file && this.checkfilename[1] == 'xlsx') {
                const reader = new FileReader();
                let arrayData = [];
                let reportCombined = [];
                let eventsCombined = [];
                let summaryReport = []
                // let objectKeyReplacedArray = [];

                reader.onload = (e) => {
                    // eslint-disable-next-line no-unused-vars
                    /* Parse data */
                    const bstr = e.target.result;
                    const wb = XLSX.read(bstr, { type: "binary" });
                    /* Get first worksheet */
                    // const wsname = wb.SheetNames[0];
                    // const wsname = wb.SheetNames;
                    // const ws = wb.Sheets[wsname];
                    const ws = wb.SheetNames;
                    // console.log(wb.Sheets['Accounts Report (Combined)', 'Summary Report'])
                    const  filteredWS = ws.filter(function(value, index, arr){ 
                                return value === 'Accounts Report (Combined)' || value === "Summary Report"
                            });
                    // console.log(filtered)
                    filteredWS.forEach((w) => {
                            console.log(w)
                            const singleSheet = wb.Sheets[w];
                            arrayData.push(
                                XLSX.utils.sheet_to_json(singleSheet, { header: "A" })
                            );
                        
                        
                    });

                //    console.log(arrayData)

                 

                    // const newResult = mapKeys(arrayData, (v, k) => camelCase(k));

                    // console.log(newResult);
                    /* Convert array of arrays */
                    // const data = XLSX.utils.sheet_to_json(ws, {header: 1});

                    arrayData[0].map((r) => {
                       
                        if (Object.keys(r).length >= 17)
                            reportCombined.push(r);
                        if (Object.keys(r).length === 1) {
                            // assign new key and delete oldkey
                            // const newObject = {};
                            // delete Object.assign(newObject, r, {
                            //     ["A"]: r[0],
                            // })[0];

                          
                            eventsCombined.push(
                               valueSplit(r.A)
                            );
                        }
                    });

                    arrayData[1].map((sr) => {
                         if(Object.keys(sr).length >= 35) summaryReport.push(sr)
                    })

               

                    // Merge Object
                    const mergeObj = mergeObject(eventsCombined);

                    const combinedEvent = eventsCombined.reduce(function (
                        result,
                        current
                    ) {
                        return Object.assign(result, current);
                    },
                    {});

                    const objectKeyed = (array) => {
                        let objectKeyReplacedArray = [];
                        const [, ...headKey] = Object.values(array[0]);
                        const headK = ["key",...headKey]
                        // console.log(["key",...headKey]);
                        array.map((data) => {
                            data = Object.assign({}, ...Object.entries(data)
                            .map(([, prop], index) => ({[camelCase(headK[index])]: prop})));
                            
                            objectKeyReplacedArray.push({ eventCreated: mergeObj.dateCreated, ...data})
                        })

                        return objectKeyReplacedArray
                    }



                    // const [, ...headKey] = Object.values(reportCombined[0]);
                    // const headK = ["key", ...headKey];

                    // reportCombined.map((data) => {
                    //     data = Object.assign(
                    //         {},
                    //         ...Object.entries(data).map(([, prop], index) => ({
                    //             [camelCase(headK[index])]: prop,
                    //         }))
                    //     );
                    //     objectKeyReplacedArray.push({
                    //         eventCreated: mergeObj.dateCreated,
                    //         ...data,
                    //     });
                    // });

                    const objKeyRep = objectKeyed(reportCombined);
                    const objKeySummary = objectKeyed(summaryReport);
                    const accountsReportSummaryCombined = [ ...objKeyRep, ...objKeySummary];

                   const arsc = values(map(groupBy(accountsReportSummaryCombined, 'arenaName'), spread(assign)))
                    

                    const filterObjectHeader = arsc.filter(
                        (obk) => {
                            if (
                                obk.arenaName !== "OCBS NAME" &&
                                obk.arenaName !== "ARENA NAME"
                            )
                                return obk;
                        }
                    );



                    

                    const removeKeyReportObject = filterObjectHeader.map(
                        ({ key, ...rest }) => ({ ...rest })
                    );
                    this.ocbsArrayFiltered = removeKeyReportObject;
                    console.log(removeKeyReportObject);
                };
                reader.readAsBinaryString(file);
            }else{
                Fire.$emit("AfterCreate"),
                swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: "Make sure you insert correct excel data!",
             
                })
            }
        },

        handleFormatted() {
            this.computation.mobile = {
                cashLoad: numberFormat(this.computation.mobile.cashLoad),
                cashWithdraw: numberFormat(
                    this.computation.mobile.cashWithdraw
                ),
            };
        },
 
        generateReport() {
            console.log("generating pdf..");
            
            this.$refs.html2Pdf.generatePdf();

            axios.get('api/arenaStatus/'+ this.arena_name).then((data)=>(
                Fire.$emit("AfterCreate"),
                this.dialog = false,
                swal.fire("convert to pdf!", "successfully", "success")
            ));
        },
        async downloadImg() {
            console.log("printing..");
            const el = this.$refs.soaReport;

            const options = {
                type: "dataURL",
                backgroundColor: "#f1f1f1",
            };
            const printCanvas = await html2canvas(el, options);

            const link = document.createElement("a");
            link.setAttribute("download", "soa.png");
            link.setAttribute(
                "href",
                printCanvas
                    .toDataURL("image/png")
                    .replace("image/png", "image/octet-stream")
            );
            link.click();
            axios.get('api/arenaStatus/'+ this.arena_name).then((data)=>(
                Fire.$emit("AfterCreate"),
                this.dialog = false,
                swal.fire("convert to png!", "successfully", "success")
            ));
            console.log("done");
        },
    },

    computed: {
        computedAve: function () {
            const mwTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.totalMWBet) || 0
            );
            const drawTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.draw) || 0
            );
            const mwMobileTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.mobile.totalMWBet) || 0
            );
            const drawMobileTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.mobile.totalDrawBet) || 0
            );
            const netOpCommTotal =
                numberUnformat(mwTotalPercent) +
                numberUnformat(drawTotalPercent) +
                numberUnformat(this.computation.unclaimed) +
                numberUnformat(this.computation.cUnpaid) +
                numberUnformat(this.computation.operatorExpenses);
            const netOpCommission = numberFormat(netOpCommTotal);
            const cashLoad = this.computation.mobile.cashLoad || 0;
            const cashWithdraw = this.computation.mobile.cashWithdraw || 0;
            const depositReplenish = numberFormat(
                numberUnformat(this.computation.netWinLoss) -
                    numberUnformat(netOpCommission) +
                    numberUnformat(cashLoad) -
                    numberUnformat(cashWithdraw) || 0
            );

            const depositReplenishText =
                numberUnformat(depositReplenish) < 0
                    ? {
                          title: "For Replenishment",
                          dateText: "FR",
                          totalText: "Replenish",
                          number:'FR'+moment().format('MMDYY')+this.randomNumber,
                          bankTitle: "We will replenish to" 
                        
                      }
                    : {
                          title: "Statement of Account",
                          dateText: "SOA",
                          totalText: "Deposit",
                          number:'SOA'+moment().format('MMDYY')+this.randomNumber,
                          bankTitle: "Kindly Deposit to"                         
                      };
            this.depositReplenishTxt = depositReplenishText;

            return {
                mwTotalPercent,
                drawTotalPercent,
                mwMobileTotalPercent,
                drawMobileTotalPercent,
                netOpCommission,
                cashLoad,
                cashWithdraw,
                depositReplenish,
                depositReplenishText,
            };
        },
    },
    watch: {
      loader () {
        const l = this.loader
        this[l] = !this[l]

        setTimeout(() => (this[l] = false), 3000)

        this.loader = null
      },
    },
    created() {
        this.showData();
        this.importwithstatus();
        this.loadEmployee();
        this.loadbank();
        Fire.$on("AfterCreate", () => {
            this.showData();
            this.importwithstatus();
           
        });
    },
};
</script>
