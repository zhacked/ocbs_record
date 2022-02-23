<template>
    <v-app>
        <v-container :class="{ 'blur-content': dialog }">
            <h1 class="h3">Statement of Accounts</h1>
            <arena-modal
                :arenaNames="arenaNames"
            >
            </arena-modal>
            <v-row class="mt-3">
                <v-col class="col-md-12">
                    <v-row>
                        <!-- DATE RANGE -->
                        <date-range @depositReplenish="handleFilterDate" :soaLists="soaLists" @dates="getDates" @tabs="revertTab" ref="dateRange" :tab.sync="tab" @showClearBtn="handleClearBtn"></date-range>
                        <!-- Search Input -->
                           <v-col class="col-md-2">
                                <v-text-field
                                    v-model="search"
                                    outlined
                                    dense
                                    append-icon="mdi-magnify"
                                    label="Search"
                                    color="primary darken-2"
                                ></v-text-field>
                            </v-col>
                             <!-- Filter WIth/Without ARENA Details -->
                        <filter-arena :arenaData="arenaData" :loadDateRange="loadDateRange" :tab="tab" :dates="dates" :soaLists="soaLists" :importWithStatus="importWithStatus"></filter-arena>
                        
                        <v-spacer></v-spacer>
                        <!-- FILE INPUT -->
                        <soa-input :soaLists="soaLists"></soa-input>
             
                    </v-row>
                    <v-card>
                        <v-card-title>
                                <v-row>
                                    <v-col class="col-md-6">
                                        <v-switch
                                            v-model="switchPrepared"
                                            :label="`Signatory ${
                                                switchPrepared ? 'On' : 'Off'
                                            }`"
                                            @change="handleSwitchPrepared"
                                        ></v-switch>
                                    </v-col>
                                    <!-- Downloads and Clear Buttons -->
                                   <actions-buttons 
                                        :selected="selected" 
                                        :showClear="showClear" 
                                        :dates="dates" 
                                        :tab="tab" 
                                        :arenaData="arenaData"
                                        @arenaDownload="handleArenaDownload" 
                                        :soaLists="soaLists" 
                                        :importWithStatus="importWithStatus"
                                        :loadDateRange="loadDateRange"
                                    />

                                  
                                </v-row>
                        </v-card-title>
                            <v-tabs
                                v-model="tab"
                                align-with-title
                                @change="handleChangeTab"
                                >
                                <v-tabs-slider color="primary"></v-tabs-slider>
                                    <v-tab
                                        v-for="item in items"
                                        :key="item.tabItem"
                                        :href="`#${item.tabItem}`"
                                         @click="handleSwitchTab"
                                    >
                                        {{ item.text }}
                                    </v-tab>
                            </v-tabs>
                            <v-card-text>
                                <v-tabs-items v-model="tab" >
                                    <v-tab-item id="ongoing" >
                                        <!-- Table for ongoing soa -->
                                        <table-soa :arenaData="arenaData" :downloadingReport="downloadingReport" @selectedSoa="handleSelected" :search="search" :openModel="openModel" ref="tableArenaOnGoing" :selected.sync="selected"></table-soa>
                                    </v-tab-item>
                                     <v-tab-item  id="converted" >
                                          <!-- Table for converted soa -->
                                        <table-soa :arenaData="arenaData" :downloadingReport.sync="downloadingReport" @selectedSoa="handleSelected" :search.sync="search" :openModel="openModel" ref="tableArenaConverted" :selected.sync="selected"></table-soa>
                                    </v-tab-item>
                                </v-tabs-items>
                            </v-card-text>
                    </v-card>
                </v-col>
                <div
                            v-for="item in selected"
                            :key="item.codeEvent"
                        
                            ref="soaReport"
                            id="reportsoaoutput"
                            class="reportsoaoutput"
                            style="display: none;"
                        >
                            <v-card-title
                                class="text-h5 text-center font-weight-medium d-flex justify-center align-center pdf-title"
                            >
                                <span>{{
                                    item.group === "Replenish"
                                        ? "For Replenishment"
                                        : "Statement of Account"
                                }}</span>
                            </v-card-title>
                            <v-card-text class="text-sm-body-2">
                                <v-row>
                                    <v-spacer></v-spacer>
                                    <v-spacer></v-spacer>
                                    <DateSOA
                                        :depositReplenishText="
                                            item.group === 'Replenish'
                                                ? {
                                                      title: 'For Replenishment',
                                                      dateText: 'FR',
                                                      totalText: 'Replenish',
                                                      bankTitle:
                                                          'We will replenish to',
                                                  }
                                                : {
                                                      title: 'Statement of Account',
                                                      dateText: 'SOA',
                                                      totalText: 'Deposit',
                                                      bankTitle:
                                                          'Kindly Deposit to',
                                                  }
                                        "
                                        :refNo="item.refNo"
                                        :dateEvent="
                                            moment(item.date_of_soa).format(
                                                'LL'
                                            )
                                        "
                                        :dateSoa="
                                            moment(item.date_closed).format(
                                                'LL'
                                            )
                                        "
                                    />
                                </v-row>
                                <v-row>
                                    <ArenaDetails
                                        :arenaDetails="
                                            item.arena_details
                                                ? item.arena_details
                                                : { arena: item.arena_name }
                                        "
                                        :editmode="false"
                                        :emailFormat="
                                            item.arena_details
                                                ? defineEmail(
                                                      item.arena_details
                                                          .email_details
                                                  )
                                                : ''
                                        "
                                        :contactFormat="
                                            item.arena_details
                                                ? defineContact(
                                                      item.arena_details
                                                          .contact_details
                                                  )
                                                : ''
                                        "
                                    />
                                </v-row>
                                <v-row>
                                    <div class="computation-banner">
                                        Computation
                                    </div>
                                </v-row>
                                <ComputeBox
                                    :computation="{
                                        totalMWBets: moneyFormat(item.total_meron_wala || 0),
                                        drawCancelled: moneyFormat(item.draw_cancelled || 0),
                                        draw: moneyFormat(item.draw || 0),
                                        totalPayoutPaid: moneyFormat(item.total_payout_paid || 0),
                                        cdPaid: moneyFormat(item.draw_cancelled_paid || 0),
                                        drawPaid: moneyFormat(item.draw_paid || 0),
                                        systemErrorCOArmsi: moneyFormat(item.systemErrorCOArmsi || 0),
                                        safetyFund: moneyFormat(item.safetyFund || 0),
                                        salesDeduction: moneyFormat(item.salesDeductionTablet) || 0,
                                        unclaimed: moneyFormat(item.unclaimed || 0),
                                        cUnpaid: moneyFormat(item.cancelled_unpaid || 0),
                                        otherCommissionIntel05: moneyFormat(item.otherCommissionIntel05 || 0 ),
                                        consolidatorsCommission: moneyFormat(item.consolidatorsCommission || 0 ),
                                        paymentForOutstandingBalance: moneyFormat(item.paymentForOutstandingBalance || 0 ),
                                        totalCommission: moneyFormat(parseFloat(item.totalCommission) || 0),
                                        mwTotalPercent: moneyFormat(item.mwTwo || 0),
                                        depositReplenish: moneyFormat(parseFloat(item.for_total) || 0),
                                        netWinLoss: moneyFormat(item.netWinLoss || 0),
                                        safetyFund: moneyFormat(parseFloat(item.safetyFund) + parseFloat(item.safetyFundMob) || 0),
                                        otherCommissionIntel05: moneyFormat(parseFloat(item.otherCommissionIntel05) + parseFloat(item.otherCommIntMob) || 0),
                                        consolidatorsCommission: moneyFormat(parseFloat(item.consolidatorsCommission) + parseFloat(item.consolCommMob) || 0),
                                        paymentForOutstandingBalance: moneyFormat(parseFloat(item.paymentForOutstandingBalance) + parseFloat(item.payOutsBalMob) || 0),
                                        netOpCommission: moneyFormat(item.netOperatorsCommission || 0),
                                        mwTwo: moneyFormat(item.mwTwo || 0),
                                        drawTwo: moneyFormat(item.drawTwo || 0),
                                        mwTwoMobile: moneyFormat(item.mwTwoMobile || 0 ),
                                        drawTwoMobile: moneyFormat(item.drawTwoMobile || 0),
                                        mobile: {
                                            totalMWBets: moneyFormat(item.total_win_mobile || 0),
                                            totalDrawBets: moneyFormat(item.draw_mobile || 0),
                                            cashLoad: moneyFormat(item.cashLoad || 0),
                                            cashWithdrawal: moneyFormat(item.cashWithdrawal || 0),
                                        },
                                    }"
                           
                                    :commissionPercent="commission_percent"
                                    :editmode="editmode"
                                    :depositReplenishTxt="
                                        item.group === 'Replenish'
                                            ? {
                                                  totalText: 'Replenishment',
                                              }
                                            : {
                                                  totalText: 'Deposit',
                                              }
                                    "
                                />
                                <span
                                    v-if="item.group === 'Replenish'"
                                    class="text-xs my-2"
                                    style="color: #e64a19"
                                    >Please be advised that replenishment are
                                    only available during banking days. We allow
                                    off setting of pending remittances and
                                    replenishments during non-banking
                                    days.</span
                                >

                                <BankBox
                                    :bank="bank"
                                    :banks="banks || []"
                                    :bankAccounts="bankAccounts || []"
                                    :arenaDetails="item.arena_details"
                                    :bankId="{ id: bankId }"
                                    :arenaId="{ id: arenaId }"
                                    :operatorName="
                                        item.arena_details
                                            ? item.arena_details.operator
                                            : ''
                                    "
                                    :editmode="editmode"
                                    :depositReplenishText="
                                        item.group === 'Replenish'
                                            ? {
                                                  totalText: 'Replenish',
                                                  bankTitle:
                                                      'We will replenish to',
                                              }
                                            : {
                                                  totalText: 'Deposit',
                                                  bankTitle:
                                                      'Kindly Deposit to',
                                              }
                                    "
                                />

                                <SignatoryBox
                                    v-show="switchPrepared"
                                   
                                    :arenaDetails="item.arena_details"
                               
                                />
                            </v-card-text>
                        </div>

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

                                        <div
                                            style="
                                                position: absolute;
                                                right: 10px;
                                                top: 15px;
                                            "
                                        >
                                            <v-tooltip bottom>
                                                <template
                                                    v-slot:activator="{
                                                        on,
                                                        attrs,
                                                    }"
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
                                            :enable-download="false"
                                            :preview-modal="false"
                                            :filename="arenaDetails.arena"
                                            :pdf-quality="2"
                                            :image="{ type: 'jpeg', quality: 1 }"
                                            :manual-pagination="true"
                                            pdf-format="letter"
                                            pdf-orientation="portrait"
                                            pdf-content-width="90%"
                                            ref="html2Pdf"
                                            class="vuehtmlpdf"
                                            @beforeDownload="
                                                beforeDownload($event)
                                            "
                                        >
                                            <section
                                                slot="pdf-content"
                                                class="pdf-content"
                                               id="printingSOA"
                                            >
                                               
                                                       <v-card-title
                                                    class="text-h5 text-center font-weight-medium d-flex justify-center align-center pdf-title"
                                                >
                                                    <span>{{
                                                        depRep
                                                            .depositReplenishText
                                                            .title
                                                    }}</span>
                                                </v-card-title>
                                                <v-card-text
                                                    
                                                >
                                                    <v-row>
                                                        <v-spacer></v-spacer>
                                                        <v-spacer></v-spacer>
                                                        <DateSOA
                                                            :depositReplenishText="
                                                                depRep.depositReplenishText
                                                            "
                                                            :refNo="refNo"
                                                            :dateEvent="
                                                                dateEvent
                                                            "
                                                            :dateSoa="
                                                                dateCreated
                                                            "
                                                        />
                                                    </v-row>
                                                    <v-row>
                                                        <ArenaDetails
                                                            :arenaDetails="
                                                                arenaDetails
                                                            "
                                                            :editmode="editmode"
                                                            :emailFormat="
                                                                emailFormat
                                                            "
                                                            :contactFormat="
                                                                contactFormat
                                                            "
                                                        />
                                                    </v-row>
                                                    <v-row>
                                                        <div
                                                            class="computation-banner"
                                                        >
                                                            Computation
                                                        </div>
                                                    </v-row>
                                                    <v-row>
                                                    <ComputeBox
                                                        :depositReplenishTxt="
                                                            depRep.depositReplenishText
                                                        "
                                                        :commissionPercent="
                                                            parseFloat(
                                                                commission_percent
                                                            )
                                                        "
                                                        :editmode="editmode"
                                                    
                                                        :computation="
                                                            computation
                                                        "
                                                    />
                                                    </v-row>

                                                    <v-row>

                                                    <span
                                                        v-if="
                                                            depRep
                                                                .depositReplenishText
                                                                .dateText ===
                                                            'FR'
                                                        "
                                                    
                                                        class="fr-notif"
                                                        >Please be advised that
                                                        replenishment are only
                                                        available during banking
                                                        days. We allow
                                                        offsetting of pending
                                                        remittances and
                                                        replenishments during
                                                        non-banking days.</span
                                                    >
                                                    <BankBox
                                                        :bank="bank || {}"
                                                        :banks="banks || []"
                                                        :bankAccounts="bankAccounts || []"
                                                        :arenaDetails="arenaDetails"
                                                        :bankId="{ id: bankId } || {}"
                                                        :arenaId="{id: arenaId}"
                                                        :operatorName="operator_name"
                                                        :editmode="editmode"
                                                        :depositReplenishText="
                                                            depRep.depositReplenishText
                                                        "
                                                    />
                                                    </v-row>

                                                    <SignatoryBox
                                                        v-if="switchPrepared"
                                                        
                                                        :arenaDetails="
                                                            arenaDetails
                                                        "
                                                       
                                                    />
                                                </v-card-text>
                                            
                                               
                                            </section>
                                        </vue-html2pdf>
                                    </div>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <div
                                            v-if="editmode"
                                            class="d-flex align-center computation-container_field mr-2"
                                        >
                                            <label class="mr-2"
                                                >Commission Percent ({{
                                                    commission_percent * 100
                                                }}%) :</label
                                            >
                                            <div
                                                class="custom-span caption computation-span d-flex align-center"
                                                :class="{
                                                    'editmode-span': editmode,
                                                }"
                                            >
                                                <input
                                                    type="text"
                                                    class="input-field_report"
                                                    v-model="commission_percent"
                                                />
                                            </div>
                                        </div>
                                        <v-spacer></v-spacer>

                                        <v-tooltip bottom>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    v-show="!editmode"
                                                    icon
                                                     large
                                                    color="green"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    @click="
                                                        downloadImg(
                                                            arenaDetails,
                                                            codeEvent
                                                        )
                                                    "
                                                >
                                                    <v-icon>mdi-image</v-icon>
                                                </v-btn>
                                            </template>
                                            <span>Download as PNG</span>
                                        </v-tooltip>
                                        <v-tooltip bottom>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    v-show="!editmode"
                                                    icon
                                                     large
                                                    color="red darken-2"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    :loading="loading"
                                                    :disabled="loading"
                                                    @click="
                                                        generateReport(
                                                            codeEvent
                                                        )
                                                    "
                                                >
                                                    <v-icon
                                                        >mdi-file-pdf-box</v-icon
                                                    >
                                                </v-btn>
                                            </template>
                                            <span>Download as PDF</span>
                                        </v-tooltip>
                                                <v-tooltip bottom>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    v-show="!editmode"
                                                    icon
                                                    large
                                                    color="primary"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    :loading="loading"
                                                    :disabled="loading"
                                                    @click="
                                                        printSoa(
                                                            'printingSOA'
                                                        )
                                                    "
                                                >
                                                    <v-icon
                                                        >mdi-printer</v-icon
                                                    >
                                                </v-btn>
                                            </template>
                                            <span>PRINT</span>
                                        </v-tooltip>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-dialog>

                <!-- </v-col> -->
            </v-row>
            <loading-progress :loading="dialog2"></loading-progress>
        </v-container>
    </v-app>
</template>
<script>
import { numberFormat, numberUnformat, moneyFormat } from "../utility";
import VueHtml2pdf from "vue-html2pdf";
import moment from "moment";
import DateSOA from "./SoaComponents/DateSOA.vue";
import ArenaDetails from "./SoaComponents/ArenaDetails.vue";
import ComputeBox from "./SoaComponents/ComputeBox.vue";
import BankBox from "./SoaComponents/BankBox.vue";
import SignatoryBox from "./SoaComponents/SignatoryBox.vue";
import DateRange from "./ComponentBits/DateRange.vue";
import TableSoa from "./ComponentBits/TableSoa.vue";
import SoaInput from "./ComponentBits/SoaInput.vue";
import ActionsButtons from "./ComponentBits/ActionsButtons.vue";

import {
    imageDownload,
    truncate,
    beforeDownload,
    defineEmail,
    defineContact,
    withStatus,
    soa,
    reportGenerate,
    computationOpenSoa,
    printSoa
} from "../methods";

import ArenaModal from "./modal/ArenaModal.vue"
import FilterArena from './ComponentBits/FilterArena.vue';
import { orderBy } from 'lodash'

export default {
    components: {
        VueHtml2pdf,
        DateSOA,
        ArenaDetails,
        ComputeBox,
        BankBox,
        SignatoryBox,
        ArenaModal,
        DateRange,
        TableSoa,
        FilterArena,
        SoaInput,
        ActionsButtons
       
    },
    data() {
        return {
            tab: null,
            items: [
                {
                    text: 'On going',
                    tabItem: 'ongoing'
                },
                  {
                    text: 'converted',
                    tabItem: 'converted'
                },
            ],
         
            sortBy: "refNo",
            keys: ["CATEGORY"],
           
            computedPerTeam: {},
            group: {
                header: {
                    isOpen: false,
                },
            },
         
            arenaNames:'',
            zIndex: 0,
            perPageOptions: [10, 15, 20, 30],
            singleSelect: false,
            selected: [],
            dialog: false,
            dialog2: false,
            search: "",
            ocbsArray: [],
            ocbsArrayFiltered: [],
            editmode: false,
            commission_percent: 0.02,
            status: "Reflenish",
            ocbs: {},
            bankDetails: {},
            bank: {},
            bankId: null,
            banks: [],
            bankAccounts: [],
            operator_name: "",
            sofrNumSeq: 0,
            arenaData: [],
            arenaOnGoing: [],
            arenaDatastatus: [],
            arenaDetails: {},
            areaCode: "",
            codeEvent: "",
            arenaId: "",
            arena_name: "",
            loading: false,
            loader: null,
            downloadingReport: false,
            fileUpload: null,
            form: new Form({
                id: "",
                arena: "",
                address: "",
                operator: "",
                contact_number: "",
                email: "",
            }),

            moment,
            numberFormat,
            numberUnformat,
            moneyFormat,
            defineEmail,
            defineContact,
            computation: {
                totalMWBets: 0,
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
                otherCommissionIntel05: 0,
                consolidatorsCommission: 0,
                paymentForOutstandingBalance: 0,
                safetyFund: 0,
                salesDeduction: 0,
                systemErrorCOArmsi: 0,
                totalOthers: 0,
                totalCommission: 0,
                exempted: "",
                mwTotalPercent: 0,
                drawTotalPercent: 0,
                safetyFundMob: 0,
                otherCommIntMob: 0,
                consolCommMob: 0,
                payOutsBalMob: 0,
                mobile: {
                    totalMWBets: 0,
                    totalDrawBets: 0,
                    cashLoad: 0,
                    cashWithdrawal: 0,
                },
                depositReplenish: 0,
                mwTwo: 0,
                drawTwo: 0,
                mwTwoMobile: 0,
                drawTwoMobile: 0,
                netOpCommission: 0,
                totalComputationOthers: 0,
            },
            refNo: "",
            soa: true,
            dateCreated: "",
            dateEvent: "",
            emailFormat: "",
            contactFormat: "",
            depositReplenishTxt: {},
            pictures: [],
            disabledCount: 0,
            printSoa,
    
            arenaSample: [],
            switchPrepared: false,
        
            menu: false,
            dates: [],
            showClear: false,
        };
    },
    methods: {
        backmeup() {
            axios.get("api/backup").then(({ data }) => {
                console.log(data);
            });
        },
        arenaSelectedBank(bankId) {
            const bId = bankId;

            axios.get(`api/arenaSelectedBank/${bId}`).then(({ data }) => {
                this.bank = data;
            });
        },
        handleSwitchPrepared() {
            localStorage.setItem("prepared", this.switchPrepared);
        },
        truncate,
        async soaLists(){
         
            const soaLists = await soa();
            const ordered = orderBy(soaLists, ['date_of_soa'], ['desc'])
            const soaListing = ordered.map(o => ({ ...o, date_of_soa: moment(o.date_of_soa).format('DD MMM YYYY')}))
            this.arenaData = soaListing
         
           
        },
        async importWithStatus() {
         
            const withStatusData = await withStatus(this.arenaData);
            const ordered = orderBy(withStatusData, ['date_of_soa'], ['desc'])
            const soaListing = ordered.map(o => ({ ...o, date_of_soa: moment(o.date_of_soa).format('DD MMM YYYY')}))
            this.arenaData = soaListing
         
         
        },
       
        openModel(data) {
            if (data.arena_details === null) {
                $("#addNew").modal("show");
                this.arenaNames = data.arena_name
               
            } else {
                this.dialog = true;
                this.form.reset();
                this.form.fill(data.arena_details);
                this.operator_name = data.arena_details.operator;
                this.dateCreated = moment(data.date_closed).format("LL");
                this.dateEvent = moment(data.date_of_soa).format("LL");
                this.refNo = data.refNo;
                this.arenaDetails = data.arena_details;
                this.banks = data.arena_details.bank_details;
                this.arenaId = data.arena_details.id;
                this.bankId = data.arena_details.bank_id;
                this.arena_name = data.arena_details.arena;
                this.areaCode = data.areaCode;
                this.codeEvent = data.codeEvent;

                const { computation } = computationOpenSoa(data);

                this.computation = { ...computation };
            }

            this.emailFormat =
                data.arena_details &&
                data.arena_details.email_details &&
                this.defineEmail(data && data.arena_details.email_details);

            this.contactFormat =
                data.arena_details &&
                data.arena_details.contact_details &&
                this.defineContact(data && data.arena_details.contact_details);
        },
        closeDialog() {
            this.editmode = false;
            this.dialog = false;
            this.banks = [];
            this.arenaDetails = {};
            this.operator_name = "";
            this.form.reset();
            $(".computation").attr("disabled", true);
        },

        generateReport(codeEvent) {
            const { dialog } = reportGenerate(codeEvent, this.$refs.html2Pdf);
            this.dialog = dialog;
        },
        beforeDownload,

        async downloadImg(details, codeEvent) {
            const el = this.$refs.soaReport;
            const imgdl = await imageDownload(details, codeEvent, el);

            if(imgdl.status === 200) {
                this.dialog = false;
                this.banks = [];
                this.arenaDetails = {};
          
                Fire.$emit("AfterCreate");
                swal.fire("convert to png!", "successfully", "success");
            }
        },
        
        loadBankDetails() {
            axios.get("api/Companybanks").then(({ data }) => {
                this.bankAccounts = data;
            });
        },

        filterNoArenaDetails(){
            let arenaNoDetais = []
            this.arenaData.forEach(arena => {
                if(!arena.arena_details) {
                    console.log(arena)
                    arenaNoDetais.push(arena)
                }
            })
            this.arenaData.length = 0
            this.arenaData.splice(0, this.arenaData.length, ...arenaNoDetais)
        },
        
        async handleSelectionFilterArena(item){
            console.log(item)
            item === 'noArenaDetails' ? this.filterNoArenaDetails() : this.arenaData = await soa()
        },
        handleClear(){
            this.menu = false;
            this.$refs.menu.save([]);
            this.arenaData = soa()
        },
        handleFilterDate(value){
            this.arenaData = value
            if(value.length === 0 ) this.showClear = false
        },
        handleClearBtn(value){
            this.showClear = value
        },
        handleSelected(value){
            this.selected = value
        },
        getDates(value){
            this.dates = value
        },
        revertTab(item){
            this.tab = item
        },
        handleSwitchTab(){
           this.$refs.tableArenaOnGoing && this.$refs.tableArenaOnGoing.emptySelect();
            this.$refs.tableArenaConverted && this.$refs.tableArenaConverted.emptySelect();
        },
        handleArenaDownload(value){
            this.selected = value.selected
        },
        async loadDateRange(item){
            this.$refs.dateRange && await this.$refs.dateRange.loadDateRange(item);
        },
        async handleChangeTab(item){
            this.dialog2 = true
            this.dates.length !== 0 ? this.loadDateRange(item) : item === 'ongoing' ? await this.soaLists() : await this.importWithStatus();
            this.loadBankDetails()
            this.dialog2 = false
        }
    },

    computed: {  
        dateRangeText () {
        const dateRange = this.dates.length > 1 ? this.dates.sort() : null
        return dateRange ? dateRange.join(' ~ ') : null
      },
        depRep: function () {
 
            const depositReplenishText =
                numberUnformat(this.computation.depositReplenish) < 0
                    ? {
                          title: "For Replenishment",
                          dateText: "FR",
                          totalText: "Replenish",
                          number:
                              "FR" + moment().format("MMDYY") + this.sofrNumSeq,
                          bankTitle: "We will replenish to",
                      }
                    : {
                          title: "Statement of Account",
                          dateText: "SOA",
                          totalText: "Deposit",
                          number:
                              "SOA" +
                              moment().format("MMDYY") +
                              this.sofrNumSeq,
                          bankTitle: "Kindly Deposit to",
                      };

            return {
                depositReplenishText,
            };
        },
    },

    mounted() {
        if (localStorage.getItem("prepared")) {
            try {
                this.switchPrepared = JSON.parse(
                    localStorage.getItem("prepared")
                );
            } catch (e) {
                localStorage.removeItem("prepared");
            }
        }
    },
};
</script>
<style scoped>
.nav-tabs .nav-link.active {
    background-color: #00c4f5 !important ;
    color: white !important;
}
</style>
