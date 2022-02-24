<template>
    <v-app>
        <v-container :class="{ 'blur-content': dialog }">
            <h1 class="h3">Statement of Accounts</h1>
            <arena-modal :arenaNames="arenaNames"> </arena-modal>
            <v-row class="mt-3">
                <v-col class="col-md-12">
                    <v-row>
                        <!-- DATE RANGE -->
                        <date-range
                            @depositReplenish="handleFilterDate"
                            :soaLists="soaLists"
                            @dates="getDates"
                            @tabs="revertTab"
                            ref="dateRange"
                            :tab.sync="tab"
                            @showClearBtn="handleClearBtn"
                        ></date-range>
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
                        <filter-arena
                            :arenaData="arenaData"
                            :loadDateRange="loadDateRange"
                            :tab="tab"
                            :dates="dates"
                            :soaLists="soaLists"
                            :importWithStatus="importWithStatus"
                        ></filter-arena>
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
                                    :handleEmptySelect="handleEmptySelect"
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
                                @click="handleEmptySelect"
                            >
                                {{ item.text }}
                            </v-tab>
                        </v-tabs>
                        <v-card-text>
                            <v-tabs-items v-model="tab">
                                <v-tab-item id="ongoing">
                                    <!-- Table for ongoing soa -->
                                    <table-soa
                                        :arenaData="arenaData"
                                        :downloadingReport="downloadingReport"
                                        @selectedSoa="handleSelected"
                                        :search="search"
                                        :openModel="openModel"
                                        ref="tableArenaOnGoing"
                                    ></table-soa>
                                </v-tab-item>
                                <v-tab-item id="converted">
                                    <!-- Table for converted soa -->
                                    <table-soa
                                        :arenaData="arenaData"
                                        :downloadingReport.sync="
                                            downloadingReport
                                        "
                                        @selectedSoa="handleSelected"
                                        :search.sync="search"
                                        :openModel="openModel"
                                        ref="tableArenaConverted"
                                    ></table-soa>
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
                    style="display: none"
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
                                              bankTitle: 'We will replenish to',
                                          }
                                        : {
                                              title: 'Statement of Account',
                                              dateText: 'SOA',
                                              totalText: 'Deposit',
                                              bankTitle: 'Kindly Deposit to',
                                          }
                                "
                                :refNo="item.refNo"
                                :dateEvent="
                                    moment(item.date_of_soa).format('LL')
                                "
                                :dateSoa="moment(item.date_closed).format('LL')"
                            />
                        </v-row>
                        <v-row>
                            <ArenaDetails
                                :arenaDetails="
                                    item.arena_details
                                        ? item.arena_details
                                        : { arena: item.arena_name }
                                "
                               
                                :emailFormat="
                                    item.arena_details
                                        ? defineEmail(
                                              item.arena_details.email_details
                                          )
                                        : ''
                                "
                                :contactFormat="
                                    item.arena_details
                                        ? defineContact(
                                              item.arena_details.contact_details
                                          )
                                        : ''
                                "
                            />
                        </v-row>
                        <v-row>
                            <div class="computation-banner">Computation</div>
                        </v-row>
                        <ComputeBox
                            :computation="computationSoa(item)"
                            :commissionPercent="commission_percent"
                           
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
                            >Please be advised that replenishment are only
                            available during banking days. We allow off setting
                            of pending remittances and replenishments during
                            non-banking days.</span
                        >

                        <BankBox
                        
                            :bankAccounts="bankAccounts || []"
                            :arenaDetails="item.arena_details"
                           
                            :operatorName="
                                item.arena_details
                                    ? item.arena_details.operator
                                    : ''
                            "
                            
                            :depositReplenishText="
                                item.group === 'Replenish'
                                    ? {
                                          totalText: 'Replenish',
                                          bankTitle: 'We will replenish to',
                                      }
                                    : {
                                          totalText: 'Deposit',
                                          bankTitle: 'Kindly Deposit to',
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
                                            :image="{
                                                type: 'jpeg',
                                                quality: 1,
                                            }"
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
                                                <v-card-text>
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
                                                            >Please be advised
                                                            that replenishment
                                                            are only available
                                                            during banking days.
                                                            We allow offsetting
                                                            of pending
                                                            remittances and
                                                            replenishments
                                                            during non-banking
                                                            days.</span
                                                        >
                                                        <BankBox
                                                        
                                                            :bankAccounts="
                                                                bankAccounts ||
                                                                []
                                                            "
                                                            :arenaDetails="
                                                                arenaDetails
                                                            "
                                                            :operatorName="
                                                                operator_name
                                                            "
                                                           
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
                                      
                                        <v-spacer></v-spacer>

                                        <v-tooltip bottom>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                   
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
                                                   
                                                    icon
                                                    large
                                                    color="primary"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    :loading="loading"
                                                    :disabled="loading"
                                                    @click="
                                                        printSoa('printingSOA')
                                                    "
                                                >
                                                    <v-icon>mdi-printer</v-icon>
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
            </v-row>
            <loading-progress :loading="dialog2"></loading-progress>
        </v-container>
    </v-app>
</template>
<script>
import { numberUnformat, moneyFormat } from "../utility";
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
    computationSoa,
    printSoa,
} from "../methods";

import ArenaModal from "./modal/ArenaModal.vue";
import FilterArena from "./ComponentBits/FilterArena.vue";
import { orderBy } from "lodash";

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
        ActionsButtons,
    },
    data() {
        return {
            tab: null,
            items: [
                {
                    text: "On going",
                    tabItem: "ongoing",
                },
                {
                    text: "converted",
                    tabItem: "converted",
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
            arenaNames: "",
            selected: [],
            dialog: false,
            dialog2: false,
            search: "",
            commission_percent: 0.02,
            status: "Reflenish",
            bankAccounts: [],
            operator_name: "",
            sofrNumSeq: 0,
            arenaData: [],
            arenaOnGoing: [],
            arenaDatastatus: [],
            arenaDetails: {},
            areaCode: "",
            codeEvent: "",
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
            numberUnformat,
            moneyFormat,
            defineEmail,
            defineContact,
            computation: {},
            refNo: "",
            soa: true,
            dateCreated: "",
            dateEvent: "",
            emailFormat: "",
            contactFormat: "",
            depositReplenishTxt: {},
            disabledCount: 0,
            printSoa,
            switchPrepared: false,
            menu: false,
            dates: [],
            showClear: false,
            computationSoa,
        };
    },
    methods: {
 
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
        async soaLists() {
            const soaLists = await soa();
            const ordered = orderBy(soaLists, ["date_of_soa"], ["desc"]);
            const soaListing = ordered.map((o) => ({
                ...o,
                date_of_soa: moment(o.date_of_soa).format("DD MMM YYYY"),
            }));
            this.arenaData = soaListing;
        },
        async importWithStatus() {
            const withStatusData = await withStatus(this.arenaData);
            const ordered = orderBy(withStatusData, ["date_of_soa"], ["desc"]);
            const soaListing = ordered.map((o) => ({
                ...o,
                date_of_soa: moment(o.date_of_soa).format("DD MMM YYYY"),
            }));
            this.arenaData = soaListing;
        },

        openModel(data) {
            if (data.arena_details === null) {
                $("#addNew").modal("show");
                this.arenaNames = data.arena_name;
            } else {
                this.dialog = true;
                this.form.reset();
                this.form.fill(data.arena_details);
                this.operator_name = data.arena_details.operator;
                this.dateCreated = moment(data.date_closed).format("LL");
                this.dateEvent = moment(data.date_of_soa).format("LL");
                this.refNo = data.refNo;
                this.arenaDetails = data.arena_details;
       
           
                this.arenaNames = data.arena_details.arena;
                this.areaCode = data.areaCode;
                this.codeEvent = data.codeEvent;
                const computation = computationSoa(data);
                this.computation = computation;
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
            this.dialog = false;
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

            if (imgdl.status === 200) {
                this.dialog = false;
          
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

        filterNoArenaDetails() {
            let arenaNoDetais = [];
            this.arenaData.forEach((arena) => {
                if (!arena.arena_details) {
                    console.log(arena);
                    arenaNoDetais.push(arena);
                }
            });
            this.arenaData.length = 0;
            this.arenaData.splice(0, this.arenaData.length, ...arenaNoDetais);
        },

        async handleSelectionFilterArena(item) {
            console.log(item);
            item === "noArenaDetails"
                ? this.filterNoArenaDetails()
                : (this.arenaData = await soa());
        },
        handleClear() {
            this.menu = false;
            this.$refs.menu.save([]);
            this.arenaData = soa();
        },
        handleFilterDate(value) {
            this.arenaData = value;
            if (value.length === 0) this.showClear = false;
        },
        handleClearBtn(value) {
            this.showClear = value;
        },
        handleSelected(value) {
            this.selected = value;
        },
        getDates(value) {
            this.dates = value;
        },
        revertTab(item) {
            this.tab = item;
        },
        handleEmptySelect() {
            this.$refs.tableArenaOnGoing &&
                this.$refs.tableArenaOnGoing.emptySelect();
            this.$refs.tableArenaConverted &&
                this.$refs.tableArenaConverted.emptySelect();
        },

        // handleArenaDownload(value) {
        //     this.selected = value;
        //       this.$refs.tableArenaOnGoing &&
        //         this.$refs.tableArenaOnGoing.emptySelect();
        //     this.$refs.tableArenaConverted &&
        //         this.$refs.tableArenaConverted.emptySelect();
        // },
        async loadDateRange(item) {
            this.$refs.dateRange &&
                (await this.$refs.dateRange.loadDateRange(item));
        },
        async handleChangeTab(item) {
            this.dialog2 = true;
            this.dates.length !== 0
                ? this.loadDateRange(item)
                : item === "ongoing"
                ? await this.soaLists()
                : await this.importWithStatus();
            this.loadBankDetails();
            this.dialog2 = false;
        },
    },

    computed: {
        dateRangeText() {
            const dateRange = this.dates.length > 1 ? this.dates.sort() : null;
            return dateRange ? dateRange.join(" ~ ") : null;
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
