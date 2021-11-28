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
                                                 
                                                    <v-row>
                                                        <!--<div class="bank-wrapper">
                                                            <div class="bank-headline">
                                                                <span>Kindly deposit to:</span>
                                                            </div>

                                                            
                                                            <div class="bank-container" v-if="status=='Deposit'">
                                                                <div class="bank bank1">
                                                                    <span>LUCKY 8STAR QUEST INC.</span>
                                                                    <span>PBB</span>
                                                                    <span>0050-1001-5156</span>
                                                                </div>
                                                                <div class="or">
                                                                    OR
                                                                </div>
                                                                <div  class="bank bank2">
                                                                    <span>LUCKY 8 STAR QUEST INC.</span>
                                                                    <span>PBB</span>
                                                                    <span>123-1232-1232</span>
                                                                </div>
                                                            </div>
                                                            <div class="bank-container" v-else>
                                                                <div class="bank bank1">
                                                                    <span>{{operator_name}}</span>
                                                                    <span v-if="bank_id == '' && editmode == false " > {{bank_name}}</span>
                                                                    <span  v-else class="select-field_container" :class="{'editmode-span': editmode}">
                                                                        <select class="small sign-name select-field_report" v-model="bank_id" @change="filterbank()" >
                                                                            <option selected v-for="banks in bank" :key="banks.id"  :value="banks.id" >{{banks.bank_name}}</option>
                                                                        </select>
                                                                    </span>
                                                                    <span>{{bank_number}}</span>
                                                                </div>
                                                                
                                                            </div>

                                                        </div>-->
                                                    </v-row>
                                                    <v-row>
                                                        <v-col>
                                                            <v-row>
                                                                <div
                                                                    class="
                                                                        sign-wrapper
                                                                    "
                                                                >
                                                                    <span
                                                                        >Computed
                                                                        by:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            sign-container
                                                                        "
                                                                    >
                                                                       <span class="select-field_container  " :class="{'editmode-span': editmode}">
                                                                            <select class="sign-name select-field_report computation " disabled>
                                                                                <option v-for="computed_by in computed" :key="computed_by.id">{{computed_by.name}}</option>
                                                                            </select>
                                                                        </span>


                                                                        <span class="signed-title">
                                                                            <select class="sign-name select-field_report">
                                                                                <option v-for="computed_by in computed" :key="computed_by.id">{{computed_by.position}}</option>
                                                                            </select>
                                                                        </span >
                                                                    </div>
                                                                </div>
                                                            </v-row>
                                                            <v-row>
                                                                <div
                                                                    class="
                                                                        sign-wrapper
                                                                        scbottom
                                                                    "
                                                                >
                                                                    <span
                                                                        >Prepared
                                                                        by:</span
                                                                    >
                                                                    <div class="sign-container">
                                                                         <span class="select-field_container" :class="{'editmode-span': editmode}">
                                                                            <select class="sign-name select-field_report computation" disabled>
                                                                                <option v-for="prepared_by in prepared" :key="prepared_by.id">{{prepared_by.name}}</option>
                                                                            </select>
                                                                        </span>
                                                                        

                                                                        <span class="signed-title">
                                                                            <select class="sign-name select-field_report">
                                                                                <option v-for="prepared_by in prepared" :key="prepared_by.id">{{prepared_by.position}}</option>
                                                                            </select>
                                                                        </span >
                                                                    </div>
                                                                </div>
                                                            </v-row>
                                                        </v-col>
                                                        <v-col>
                                                            <v-row>
                                                                <div
                                                                    class="
                                                                        sign-wrapper
                                                                    "
                                                                >
                                                                    <span class="mr-2"
                                                                        >Checked
                                                                        by:</span
                                                                    >
                                                                    <div class="sign-container">
                                                                         <span class="select-field_container" :class="{'editmode-span': editmode}">
                                                                            <select class="sign-name select-field_report computation" disabled>
                                                                                <option v-for="checked_by in checked" :key="checked_by.id">{{checked_by.name}}</option>
                                                                            </select>
                                                                        </span>
                                                                        

                                                                        <span class="signed-title">
                                                                            <select class="sign-name select-field_report">
                                                                                <option v-for="checked_by in checked" :key="checked_by.id">{{checked_by.position}}</option>
                                                                            </select>
                                                                        </span >
                                                                    </div>
                                                                </div>
                                                            </v-row>
                                                            <v-row>
                                                                <div class="sign-wrapper scbottom">
                                                                    <span>Checked by:</span>
                                                                    <div class="sign-container">
                                                                         <span class="select-field_container" :class="{'editmode-span': editmode}">
                                                                            <select class="sign-name select-field_report computation" disabled>
                                                                                <option v-for="checked_by in checked" :key="checked_by.id">{{checked_by.name}}</option>
                                                                            </select>
                                                                        </span>
                                                                        

                                                                        <span class="signed-title">
                                                                            <select class="sign-name select-field_report">
                                                                                <option v-for="checked_by in checked" :key="checked_by.id">{{checked_by.position}}</option>
                                                                            </select>
                                                                        </span >
                                                                    </div>
                                                                </div>
                                                            </v-row>
                                                        </v-col>
                                                    </v-row>
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
import { camelCase } from "lodash";
import XLSX from "xlsx";
import {
    numberFormat,
    numberUnformat,
    mergeObject,
    valueSplit,
} from "../utility";
import VueHtml2pdf from "vue-html2pdf";
import html2canvas from "html2canvas";
import moment from 'moment';
import DateSOA from "./DialogPreview/DateSoa.vue"
import ArenaDetails from "./DialogPreview/ArenaDetails.vue"
import ComputeBox from "./DialogPreview/ComputeBox.vue"

export default {
    components: {
        VueHtml2pdf,
        DateSOA,
        ArenaDetails,
        ComputeBox
    },
    data() {
        return {
            headers: [
                { text: "Arena Name", value: "arena_name" },
                { text: "Operator", value: "arena_details.operator" },
                { text: "Contact", value: "arena_details.contact_number" },
                { text: "", value: "actions", sortable: false },
            ],
            computed:{},
            checked:{},
            prepared:{},
            computed_by:'',
            checked_by_1:'',
            checked_by_2:'',
            prepared_by:'',
            bank_details:'',
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
            bank:{},
            bank_id:'',
            bank_name:'',
            bank_number:'',
            operator_name:'',
            randomNumber:0,
            arenaData: [],
            arenaDatastatus:[],
            arenaDetails: {},
            selectedbank: [],
            arena_id: "",
            arena_name:'',
            loading: false,
            loader: null,
            form: new Form({
                id: "",
                arena: "",
                address: "",
                operator: "",
                contact_number: "",
                email: "",
            }),
            bankaccount_id: "",
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

                this.computed = data.computed,
                this.checked = data.checked,
                this.prepared = data.prepared
               
               ));
        },
        loadbank(){
            axios.get("api/bankaccount").then(({data}) => (
                    this.bank = data
                ));
        },
        filterbank(){
              axios.get("api/selectedbank/"+ this.bank_id).then(({data}) => (
                    this.bank_name = data.bank_name,
                    this.bank_number = data.bank_number
                ));
        },
   
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
            if ($("#importData").val() === "") {
                Fire.$emit("AfterCreate");
                swal.fire({
                    icon: "waarning",
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
            this.bank_name = data.bank_details.length != 0 ? data.bank_details[0].bank_name : 'No Bank Name found !' ;
            this.bank_number = data.bank_details.length != 0 ? data.bank_details[0].bank_number : 'No Bank Number found !' ;
            this.form.reset();
            this.dialog = true;
            this.date_created = moment(data.date_of_soa).format('ll');
            this.date_event = moment().format('ll');
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
            if (file) {
                const reader = new FileReader();
                let arrayData = [];
                let reportCombined = [];
                let eventsCombined = [];
                let objectKeyReplacedArray = [];

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

                    ws.forEach((w) => {
                        const singleSheet = wb.Sheets[w];
                        arrayData.push(
                            XLSX.utils.sheet_to_json(singleSheet, { header: 1 })
                        );
                    });
                    /* Convert array of arrays */
                    // const data = XLSX.utils.sheet_to_json(ws, {header: 1});

                    arrayData[0].map((r) => {
                        // console.log(Object.assign({}, dataSplit(r)))
                        if (Object.keys(r).length >= 17)
                            reportCombined.push(Object.assign({}, r));
                        if (Object.keys(r).length === 1) {
                            // assign new key and delete oldkey
                            const newObject = {};
                            delete Object.assign(newObject, r, {
                                ["A"]: r[0],
                            })[0];
                            eventsCombined.push(
                                Object.assign({}, valueSplit(newObject.A))
                            );
                        }
                    });

                    // Merge Object
                    const mergeObj = mergeObject(eventsCombined);

                    const combinedEvent = eventsCombined.reduce(function (
                        result,
                        current
                    ) {
                        return Object.assign(result, current);
                    },
                    {});

                    const [, ...headKey] = Object.values(reportCombined[0]);
                    const headK = ["key", ...headKey];

                    reportCombined.map((data) => {
                        data = Object.assign(
                            {},
                            ...Object.entries(data).map(([, prop], index) => ({
                                [camelCase(headK[index])]: prop,
                            }))
                        );
                        objectKeyReplacedArray.push({
                            eventCreated: mergeObj.dateCreated,
                            ...data,
                        });
                    });

                    const filterObjectHeader = objectKeyReplacedArray.filter(
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
                        
                      }
                    : {
                          title: "Statement of Account",
                          dateText: "SOA",
                          totalText: "Deposit",
                          number:'SOA'+moment().format('MMDYY')+this.randomNumber,
                         
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
