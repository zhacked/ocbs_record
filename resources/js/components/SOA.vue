<template>
    <v-app>
        <v-container :class="{'blur-content': dialog}">
            <v-row class="mt-5">
                <v-col class="col-md-12">
                    <v-card>
                        <v-card-title class="card-header">
                            <strong> Statement of Account</strong>
                            <v-spacer></v-spacer>
                            <form @submit.prevent="proceedAction()">
                                <v-card-actions class="card-tools">
                                    <label
                                        class="form-control-label"
                                        for="input-file-import"
                                    ></label>
                                    <!--<input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file"  @change="onFileChange"> -->
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

                        <div
                            class="card card-primary card-outline"
                            style="overflow: auto; !important"
                        >
                            <div class="card-body">
                                 <v-row>
                                    <v-col>

                                    </v-col>
                                    <v-col>
                                        <v-text-field
                                            v-model="search"
                                            append-icon="mdi-magnify"
                                            label="Search"
                                    
                                            color="primary darken-2"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                     
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
                                        <button
                                            class="btn btn-primary"
                                            id="dialog-mask"
                                            @click="openModel(item)"
                                        >
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                    </template>
                                </v-data-table>
                            </div>
                        </div>
                    </v-card>
                </v-col>

                <v-col class="col-md-12">
             
                    <v-dialog
                        v-model="dialog"
                        hide-overlay
                        transition="dialog-bottom-transition"
                        content-class="my-custom-dialog"
                        scrollable
                        persistent
                        >
                   
                    <v-card>        
                        <v-toolbar dark color="primary" >
                            <h1 class="modal-title w-100 text-center">
                                {{ depositReplenishTxt.title || "State of Account" }}
                            </h1>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                                <v-btn
                                dark
                                text
                                @click="dialog = false"
                                >
                                <v-icon>mdi-close</v-icon>
                                </v-btn>
                            </v-toolbar-items>
                        </v-toolbar>
                        <v-row >
                            <v-col  class="col-lg-6 col-md-12 col-sm-12">
                              <v-card  style="padding:10px 100px 100px 100px;" >
                                    <div class="text-right" >
                                        <v-row class="mb-1 no-gutters">
                                            <v-col class="col-sm-10 ">
                                                SOA # : &nbsp;
                                            </v-col>
                                            <v-col class="col-sm-2 text-left ">
                                                <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                            </v-col>
                                            <v-col class="col-sm-10 ">
                                                Date of SOA : &nbsp;
                                            </v-col>
                                            <v-col class="col-sm-1 text-left ">
                                                <v-chip   class="pa-2 " x-small color="gray" label> test</v-chip>
                                            </v-col>
                                            <v-col class="col-sm-10 ">
                                                Date of Event : &nbsp;
                                            </v-col>
                                            <v-col class="col-sm-1 text-left">
                                                <v-chip   class="pa-2"  x-small color="gray" label> test</v-chip>
                                            </v-col>
                                        </v-row>
                                    </div>
                                    <!-- personal details -->
                                    <div>
                                        <v-row class="mb-1 no-gutters">
                                            <v-col class="col-sm-2 ">
                                                Arean/OCBS Name : &nbsp;
                                            </v-col>
                                            <v-col class="col-sm-10 ">
                                                <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                            </v-col>
                                            <v-col class="col-sm-2 ">
                                                Address : : &nbsp;
                                            </v-col>
                                            <v-col class="col-sm-10 ">
                                                <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                            </v-col>
                                            <v-col class="col-sm-2 ">
                                                Operator : &nbsp;
                                            </v-col>
                                            <v-col class="col-sm-10 ">
                                                <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                            </v-col>
                                            <v-col class="col-sm-2 ">
                                                Contact Number : &nbsp;
                                            </v-col>
                                            <v-col class="col-sm-10 ">
                                                <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                            </v-col>
                                            <v-col class="col-sm-2 ">
                                                 Email Address : &nbsp;
                                            </v-col>
                                            <v-col class="col-sm-10 ">
                                                <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                            </v-col>
                                        </v-row>
                                    </div>
                                      <!-- computation -->
                                    <div
                                        style="border: 1px solid black"
                                        class="mt-2"
                                    >
                                        <h5 class="w-100 text-center pt-1">
                                            Computation
                                        </h5>
                                    </div>
                                    <div class="mt-5">
                                        <v-row>
                                            <v-col >
                                                <p
                                                    class="
                                                        w-100
                                                        text-center
                                                        pa-0
                                                        mx-0
                                                    "
                                                >
                                                    (Kiosk)
                                                </p>
                                                <v-row class="mb-1 no-gutters">
                                                    <v-col class="col-sm-6 text-right">
                                                        Total M/W Bets :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left ">
                                                    <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Total Cancelled Bets : &nbsp;
                                                        
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-success text-bold">+ </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Total Draw Bets :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-success text-bold">+ </span>   <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Total Payout Paid :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left ">
                                                        <span class="text-danger text-bold"> - </span>   <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Total C/D Paid :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left ">
                                                        <span class="text-danger text-bold"> - </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Total Draw Paid :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-danger text-bold"> - </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Net Win/Loss :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-primary text-bold"> = </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                </v-row>
                                                <div class="mt-5 pt-4">
                                                <p
                                                    class="
                                                        w-100
                                                        text-center
                                                        pa-0
                                                        mx-0
                                                    "
                                                >
                                                    (Mobile)
                                                </p>
                                                <v-row class="mb-1 no-gutters">
                                                    <v-col class="col-sm-6 text-right">
                                                        Total M/W Bets :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Total Draw Bets :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                         <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                </v-row>
                                                </div>
                                                
                                            </v-col>
                                            <v-col>
                                                <v-row class="mb-1 no-gutters">
                                                  <v-col class="col-sm-6 text-right">
                                                       M/W * 2% (kiosk) :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left ">
                                                    <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                          Draw * 2% (kiosk)  : &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                         <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                         M/W * 2% (mobile) :   &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                         <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                          Draw * 2% (kiosk)  :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left ">
                                                        <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Total Unclaimed :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left ">
                                                         <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Total C Paid :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                         <span class="text-primary text-bold"> = </span>   <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Sales Deduction :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-primary text-bold"> = </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                       <b>Net Operator's Commission</b>  :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-primary text-bold"> = </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                     <v-col class="col-sm-6 text-right">
                                                        Other's Commisison - M :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-primary text-bold"> = </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Consolidator's Commisison :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-primary text-bold"> = </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                     <v-col class="col-sm-6 text-right">
                                                       Safety Fund :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-primary text-bold"> = </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Payment for outstading balance :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-primary text-bold"> = </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                     <v-col class="col-sm-6 text-right">
                                                      <b>Total Commisison </b> :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-primary text-bold"> = </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        Cash Load from Mobile :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-primary text-bold"> = </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                     <v-col class="col-sm-6 text-right">
                                                        Cash Withdrawal from Mobile :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-primary text-bold"> = </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-right">
                                                        For Deposit :  &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6 text-left  ">
                                                        <span class="text-primary text-bold"> = </span>  <v-chip  class="pa-2" x-small color="gray" label> test</v-chip>
                                                    </v-col>
                                                </v-row>
                                            </v-col>
                                        </v-row>
                                    </div>
                                         <!-- kindly deposit -->
                                <v-row>
                                    <v-col class="col-sm-9">
                                        <div
                                            style="border: 1px solid black"
                                            class="mt-5 pl-5 text-left"
                                        >
                                            <v-row class="no-gutters">
                                                <v-col class="col-sm-3">
                                                    Kindly Deposit To : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-9">
                                                    <span>
                                                        {{
                                                            this.status ==
                                                            "Deposit"
                                                                ? "LUCKY 8 STAR QUEST INC"
                                                                : ""
                                                        }}</span
                                                    >
                                                </v-col>
                                            </v-row>
                                            <v-row class="no-gutters pa-0">
                                                <v-col class="col-sm-3">
                                                    &nbsp;
                                                </v-col>
                                                <v-col
                                                    class="col-sm-9 no-gutters"
                                                >
                                                    <v-col class="col-sm-6">
                                                        <span v-if="editmode">{{
                                                            selectedbank.bank_name
                                                        }}</span>

                                                        <select
                                                            v-else
                                                            name="type"
                                                            v-model="
                                                                bankaccount_id
                                                            "
                                                            id="arena_id"
                                                            class="
                                                                form-control
                                                                form-control-sm
                                                                pa-0
                                                            "
                                                        >
                                                            <option
                                                                v-for="banks in bank"
                                                                :key="banks.id"
                                                                :value="
                                                                    banks.id
                                                                "
                                                            >
                                                                {{
                                                                    banks.bank_name
                                                                }}
                                                            </option>
                                                        </select>
                                                    </v-col>
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters pa-0">
                                                <v-col class="col-sm-3">
                                                    &nbsp;
                                                </v-col>
                                                <v-col
                                                    class="col-sm-9 no-gutters"
                                                >
                                                    <v-col class="col-sm-6">
                                                        <span v-if="editmode">{{
                                                            selectedbank.bank_number
                                                        }}</span>

                                                        <!-- <select  name="type" id="arena_id" class="form-control form-control-sm" >
                                                            <option v-for="bank in bankDetails" :key="bank.id"  :value="bank.id" >{{bank.bank_number}}</option>
                                                        </select> -->
                                                    </v-col>
                                                </v-col>
                                            </v-row>
                                        </div>
                                    </v-col>
                                    <v-col class="col-sm-3"> </v-col>
                                </v-row>

                                 <!-- signiture -->
                                <div class="pb-5">
                                    <v-row>
                                        <!-- left -->
                                        <v-col>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6">
                                                    Computed by : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    name here
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6">
                                                    Prepared by : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                </v-col>
                                            </v-row>
                                        </v-col>

                                        <!-- right -->
                                        <v-col>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6">
                                                    Checked by : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    name here
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6">
                                                    Checked by : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    name here
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                </div>
                       
                              </v-card>
                            </v-col>
                            <v-space></v-space>
                            <v-col class="col-lg-6 col-md-12 col-sm-12">
                                test 2
                            </v-col>
                        </v-row>
                        
                                 
                     </v-card>
                 
                    </v-dialog>
            
               
                </v-col>
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

export default {
    data() {
        return {
            headers: [
                { text: "Arena Name", value: "arena_name" },
                { text: "Operator", value: "arena_details.operator" },
                { text: "Contact", value: "arena_details.contact_number" },
                { text: "", value: "actions", sortable: false },
            ],
            dialog: true,
            notifications: false,
            sound: true,
            widgets: false,
            search:'',
            ocbsArray: [],
            ocbsArrayFiltered: [],
            editmode: false,
            commission_percent: 0.02,
            status: "Deposit",
            ocbs: {},
            bankDetails: {},
            bank: {},
            arenaData: [],
            arenaDetails: {},

            selectedbank: [],
            arena_id: "",
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
            depositReplenishTxt: {},
        };
    },
    methods: {
        async showData() {
            const data = await axios.get("api/import");
            // console.log('DATA',data.data)
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
        updateModal() {
            $(".computation").attr("disabled", false);
            this.editmode = false;
        },
        saveModal() {
            $(".computation").attr("disabled", true);
            this.editmode = true;
            axios
                .get(
                    "api/updateBank/" +
                        this.arena_id +
                        "/" +
                        this.bankaccount_id
                )
                .then((data) => {
                    Fire.$emit("AfterCreate");
                    swal.fire("Successfully!", "Updated", "success");
                });
        },
        test() {
            axios
                .get("api/savePrimaryBank/" + this.arena_id)
                .then(({ data }) => (this.selectedbank = data));
        },
        proceedAction() {
            this.$Progress.start();
            if($('#importData').val() === ''){
                    Fire.$emit("AfterCreate");
                    swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            footer: '<a href="">Please contact developer</a>'
                            });
            }else{
               axios
                .post("api/import", this.ocbsArrayFiltered)
                .then(
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
        // handleCommissionPercent(e) {
        //     this.commission_percent = e.target.value;
        // },
        openModel(data) {
            console.log(data);
            this.form.reset();
            this.dialog =true;
            $("#addNew").modal("show");

            this.form.fill(data.arena_details);
            this.arenaDetails = data.arena_details;
            this.arena_id = data.id;
            $(".computation").attr("disabled", true);
            this.editmode = true;
            Fire.$emit("AfterCreate"),
                axios
                    .get("api/bankfilter/" + data.arena_details.id)
                    .then(({ data }) => (this.bank = data));

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
                    ...this.computation.mobile,
                    totalMWBet: numberFormat(totalMobileMWBets),
                    totalDrawBet: numberFormat(totalMobileDrawBets),
                },
            };
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
    },

    computed: {
        computedAve: function () {
            
            const mwTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.totalMWBet)
            );
            const drawTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.draw)
            );
            const mwMobileTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.mobile.totalMWBet)
            );
            const drawMobileTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.mobile.totalDrawBet)
            );
            const netOpCommTotal =
                numberUnformat(mwTotalPercent) +
                numberUnformat(drawTotalPercent) +
                numberUnformat(this.computation.unclaimed) +
                numberUnformat(this.computation.cUnpaid) +
                numberUnformat(this.computation.operatorExpenses);
            const netOpCommission = numberFormat(netOpCommTotal);
            const cashLoad = this.computation.mobile.cashLoad;
            const cashWithdraw = this.computation.mobile.cashWithdraw;
            const depositReplenish = numberFormat(
                numberUnformat(this.computation.netWinLoss) -
                    numberUnformat(netOpCommission) +
                    numberUnformat(cashLoad) -
                    numberUnformat(cashWithdraw)
            );




            const depositReplenishText =
                numberUnformat(depositReplenish) < 0
                    ? {
                          title: "For Replenishment",
                          dateText: "FR",
                          totalText: "Replenish",
                      }
                    : {
                          title: "Statement of Account",
                          dateText: "SOA",
                          totalText: "Deposit",
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
    created() {
        this.showData();

        Fire.$on("AfterCreate", () => {
            this.showData();
            this.test();
        });
    },
};
</script>
