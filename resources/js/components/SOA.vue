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
                                        accept=".xlsx, .xls, .csv"
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
                            class="card card-primary card-outline card-tabs"
                            style="overflow: auto; !important"
                        >
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul
                                    class="nav nav-tabs"
                                    id="custom-tabs-three-tab"
                                    role="tablist"
                                >
                                    <li class="nav-item">
                                        <a
                                            class="nav-link active"
                                            id="custom-tabs-three-home-tab"
                                            data-toggle="pill"
                                            href="#custom-tabs-three-home"
                                            role="tab"
                                            aria-controls="custom-tabs-three-home"
                                            aria-selected="true"
                                            >On Going</a
                                        >
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            id="custom-tabs-three-profile-tab"
                                            data-toggle="pill"
                                            href="#custom-tabs-three-profile"
                                            role="tab"
                                            aria-controls="custom-tabs-three-profile"
                                            aria-selected="false"
                                            >Back up</a
                                        >
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div
                                    class="tab-content"
                                    id="custom-tabs-three-tabContent active show"
                                >
                                    <v-row>
                                        <v-col>
                                            <v-btn
                                                :loading="loading"
                                                :disabled="loading"
                                                color="green lighten-1"
                                                class="ma-2 white--text"
                                                @click="multiDownloads"
                                            >
                                                Convert all
                                                <template v-slot:loader>
                                                    <span>Preparing...</span>
                                                </template>
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

                                    <div
                                        class="tab-pane fade active show"
                                        id="custom-tabs-three-home"
                                        role="tabpanel"
                                        aria-labelledby="custom-tabs-three-home-tab"
                                    >
                                        <template> </template>
                                        <!-- <img class="ls-heart" src="your-loader-url"/> -->
                                        <v-data-table
                                            v-model="selected"
                                            :headers="headers"
                                            :items="arenaData.data"
                                            :items-per-page="10"
                                            :footer-props="{
                                                'items-per-page-options': [
                                                    5, 10, 20,
                                                ],
                                            }"
                                            :search="search"
                                            show-select
                                            :single-select="singleSelect"
                                            class="elevation-1 text-center"
                                        >
                                            <template
                                                v-slot:[`item.actions`]="{
                                                    item,
                                                }"
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
                                                            @click="
                                                                openModel(item)
                                                            "
                                                            :class="{
                                                                'on-hover':
                                                                    hover,
                                                            }"
                                                        >
                                                            <v-icon
                                                                >mdi-eye</v-icon
                                                            >
                                                        </v-btn>
                                                    </template>
                                                    <span>View Account</span>
                                                </v-tooltip>
                                            </template>
                                        </v-data-table>
                                        <v-btn
                                            :loading="loading"
                                            :disabled="loading"
                                            @click="truncate"
                                            color="light-blue lighten-1"
                                            class="ma-2 white--text"
                                        >
                                            Clear Data
                                            <v-icon right dark>
                                                mdi-backspace
                                            </v-icon>
                                        </v-btn>
                                    </div>

                                    <div
                                        class="tab-pane fade"
                                        id="custom-tabs-three-profile"
                                        role="tabpanel"
                                        aria-labelledby="custom-tabs-three-profile-tab"
                                    >
                                        <v-data-table
                                            :headers="headers"
                                            :items="arenaDatastatus.data"
                                            :items-per-page="10"
                                            :search="search"
                                            class="elevation-1 text-center"
                                        >
                                            <template
                                                v-slot:[`item.actions`]="{
                                                    item,
                                                }"
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
                                                            @click="
                                                                openModel(item)
                                                            "
                                                            :class="{
                                                                'on-hover':
                                                                    hover,
                                                            }"
                                                        >
                                                            <v-icon
                                                                >mdi-eye</v-icon
                                                            >
                                                        </v-btn>
                                                    </template>
                                                    <span>View Account</span>
                                                </v-tooltip>
                                            </template>
                                        </v-data-table>
                                    </div>
                                </div>
                            </div>

                            <div
                                v-for="item in selected"
                                :key="item.id"
                                style="
                                    padding: 1px;
                                    width: 800px;
                                    display: none;
                                "
                                ref="soaReport"
                                id="reportsoaoutput"
                                class="reportsoaoutput"
                            >
                                <v-card-title
                                    class="text-h5 text-center font-weight-medium d-flex justify-center align-center pdf-title"
                                >
                                    <span>{{ item.total_meron_wala }}</span>
                                </v-card-title>
                                <v-card-text class="text-sm-body-2">
                                    <v-row>
                                        <v-spacer></v-spacer>
                                        <v-spacer></v-spacer>
                                        <DateSOA
                                            :depositReplenishText="
                                                computedAve.depositReplenishText
                                            "
                                            :dateEvent="
                                                moment(item.date_of_soa).format(
                                                    'LL'
                                                )
                                            "
                                            :dateSoa="moment().format('LL')"
                                        />
                                    </v-row>
                                    <v-row>
                                        <ArenaDetails
                                            :arenaDetails="arenaDetails"
                                            :editmode="editmode"
                                        />
                                    </v-row>
                                    <v-row>
                                        <div class="computation-banner">
                                            Computation
                                        </div>
                                    </v-row>
                                    <ComputeBox
                                        :computation="computation"
                                        :commissionPercent="commission_percent"
                                        :editmode="editmode"
                                        :computedAve="computedAve"
                                    />

                                    <BankBox
                                        :bank="bank"
                                        :operatorName="operator_name"
                                        :editmode="editmode"
                                        :depositReplenishText="
                                            computedAve.depositReplenishText
                                        "
                                    />

                                    <PreparedChecked
                                        :userPrepared="userPrepared"
                                        :editmode="editmode"
                                    />
                                </v-card-text>
                            </div>
                        </div>
                    </v-card>
                </v-col>
                {{ this.selected }}

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
                                            :enable-download="true"
                                            :preview-modal="false"
                                            :paginate-elements-by-height="2000"
                                            :filename="arenaDetails.arena"
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
                                                    class="text-h5 text-center font-weight-medium d-flex justify-center align-center pdf-title"
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
                                                        <DateSOA
                                                            :depositReplenishText="
                                                                computedAve.depositReplenishText
                                                            "
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
                                                        />
                                                    </v-row>
                                                    <v-row>
                                                        <div
                                                            class="computation-banner"
                                                        >
                                                            Computation
                                                        </div>
                                                    </v-row>
                                                    <ComputeBox
                                                        :computation="
                                                            computation
                                                        "
                                                        :commissionPercent="
                                                            commission_percent
                                                        "
                                                        :editmode="editmode"
                                                        :computedAve="
                                                            computedAve
                                                        "
                                                    />

                                                    <BankBox
                                                        :bank="bank"
                                                        :operatorName="
                                                            operator_name
                                                        "
                                                        :editmode="editmode"
                                                        :depositReplenishText="
                                                            computedAve.depositReplenishText
                                                        "
                                                    />

                                                    <PreparedChecked
                                                        :userPrepared="
                                                            userPrepared
                                                        "
                                                        :editmode="editmode"
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
                                                    color="green"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    @click="
                                                        downloadImg(
                                                            arenaDetails
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
                                                    :color="
                                                        !editmode
                                                            ? 'blue'
                                                            : 'green'
                                                    "
                                                    small
                                                    outlined
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    @click="
                                                        !editmode
                                                            ? updateModal()
                                                            : saveModal()
                                                    "
                                                >
                                                    {{
                                                        editmode
                                                            ? "Save"
                                                            : "Update"
                                                    }}

                                                    <v-icon small>{{
                                                        !editmode
                                                            ? "mdi-square-edit-outline"
                                                            : "mdi-content-save"
                                                    }}</v-icon>
                                                </v-chip>
                                            </template>
                                            <span>{{
                                                !editmode
                                                    ? "Edit Infomation"
                                                    : "Save Information"
                                            }}</span>
                                        </v-tooltip>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-dialog>

                <!-- </v-col> -->
            </v-row>
            <v-overlay :z-index="zIndex" :value="overlay"> </v-overlay>
        </v-container>
    </v-app>
</template>
<script>
import { camelCase, groupBy, map, spread, values, assign, concat } from "lodash";
import XLSX from "xlsx";
import JSZip from "jszip";
import { saveAs } from "file-saver";
import {
    numberFormat,
    numberUnformat,
    mergeObject,
    valueSplit,
} from "../utility";
import fileChange from "../methods/onFileChange.js";
import VueHtml2pdf from "vue-html2pdf";
import html2canvas from "html2canvas";
import moment from "moment";
import DateSOA from "./DialogPreview/DateSOA.vue";
import ArenaDetails from "./DialogPreview/ArenaDetails.vue";
import ComputeBox from "./DialogPreview/ComputeBox.vue";
import BankBox from "./DialogPreview/BankBox.vue";
import PreparedChecked from "./DialogPreview/PreparedChecked.vue";
// import Spinner from "";
export default {
    components: {
        VueHtml2pdf,
        DateSOA,
        ArenaDetails,
        ComputeBox,
        BankBox,
        PreparedChecked,
    },
    data() {
        return {
            headers: [
                { text: "#", value: "id" },
                { text: "Arena Name", value: "arena_name" },
                { text: "Operator", value: "arena_details.operator" },
                { text: "Contact", value: "arena_details.contact_number" },
                { text: "", value: "actions", sortable: false },
            ],
            userPrepared: {
                computed: {},
                checked: {},
                prepared: {},
            },
            overlay: false,
            zIndex: 0,
            perPageOptions: [10, 15, 20, 30],
            singleSelect: false,
            selected: [],
            dialog: false,
            search: "",
            ocbsArray: [],
            ocbsArrayFiltered: [],
            editmode: false,
            commission_percent: 0.02,
            status: "Reflenish",
            ocbs: {},
            bankDetails: {},
            bank: {
                all: {},
                bank_id: "",
                bank_name: "",
                bank_number: "",
                selected: [],
            },

            operator_name: "",
            sofrNumSeq: 0,
            arenaData: [],
            arenaDatastatus: [],
            arenaDetails: {},

            arena_id: "",
            arena_name: "",
            loading: false,
            loader: null,

            fileUpload: "",
            form: new Form({
                id: "",
                arena: "",
                address: "",
                operator: "",
                contact_number: "",
                email: "",
            }),

            moment,

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
                otherCommissionIntel05: 0,
                consolidatorsCommission: 0,
                paymentForOutstandingBalance: 0,
                safetyFund: 0,
                salesDeductionTablet: 0,
                systemErrorCOArmsi: 0,
                totalOthers: 0,
                totalCommission: 0,
                exempted: "",
                mobile: {
                    totalMWBet: 0,
                    totalDrawBet: 0,
                    cashLoad: 0,
                    cashWithdraw: 0,
                },
            },
            soa: true,
            dateCreated: "",
            dateEvent: "",
            depositReplenishTxt: {},
            pictures: [],
        };
    },
    methods: {
        loadEmployee() {
            axios
                .get("api/employees")
                .then(
                    ({ data }) => (
                        (this.userPrepared.computed = data.computed),
                        (this.userPrepared.checked = data.checked),
                        (this.userPrepared.prepared = data.prepared)
                    )
                );
        },

        truncate() {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                input: "password",
                inputPlaceholder: "Enter Your Password",
                inputAttributes: {
                    autocapitalize: "off",
                    autocorrect: "off",
                },
                customClass: {
                    input: "form-control",
                },
                inputAttributes: {
                    autocapitalize: "off",
                },
                showClass: {
                    popup: "animate__animated animate__fadeInDown",
                },
                hideClass: {
                    popup: "animate__animated animate__fadeOutUp",
                },
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Clear All!",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                showLoaderOnConfirm: true,

                preConfirm: (login) => {
                    if (login == "") {
                        swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Please Enter Valid Password",
                        });
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .get("api/validate/" + result.value)
                        .then((response) => {
                            console.log(response);
                            if (response.data == "success") {
                                Toast.fire({
                                    icon: "success",
                                    title: "Successfully Deleted",
                                });
                                Fire.$emit("AfterCreate");
                            } else {
                                swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Password doesnt match in our database",
                                });
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            });
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

            // console.log(obj.data)

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

            duplicateObj.forEach((item) => {});
        },
        closeDialog() {
            this.dialog = false;
        },
        updateModal() {
            $(".computation").removeAttr("disabled");
            $(".computation").addClass("input-show");

            this.computation = {
                totalMWBet: numberUnformat(this.computation.totalMWBet),
                drawCancelled: numberUnformat(this.computation.drawCancelled),
                draw: numberUnformat(this.computation.draw),
                totalPayoutPaid: numberUnformat(
                    this.computation.totalPayoutPaid
                ),
                cdPaid: numberUnformat(this.computation.cdPaid),
                drawPaid: numberUnformat(this.computation.drawPaid),
                netWinLoss: numberFormat(this.computation.netWinLoss),
                unclaimed: numberUnformat(this.computation.unclaimed),
                cUnpaid: numberUnformat(this.computation.cUnpaid),
                totalMWBetPercent: numberUnformat(
                    this.computation.totalMWBetPercent
                ),
                operatorExpenses: numberUnformat(
                    this.computation.operatorExpenses
                ),
                otherCommissionIntel05: numberUnformat(
                    this.computation.otherCommissionIntel05
                ),
                consolidatorsCommission: numberUnformat(
                    this.computation.consolidatorsCommission
                ),
                paymentForOutstandingBalance: numberUnformat(
                    this.computation.paymentForOutstandingBalance
                ),
                safetyFund: numberUnformat(this.computation.safetyFund),
                salesDeductionTablet: numberUnformat(
                    this.computation.salesDeductionTablet
                ),
                systemErrorCOArmsi: numberUnformat(
                    this.computation.systemErrorCOArmsi
                ),
                totalOthers: numberUnformat(this.computation.totalOthers),

                mobile: {
                    cashLoad: numberUnformat(this.computation.mobile.cashLoad),
                    cashWithdraw: numberUnformat(
                        this.computation.mobile.cashWithdraw
                    ),
                    totalMWBet: numberUnformat(
                        this.computation.totalMobileMWBets || "0.00"
                    ),
                    totalDrawBet: numberUnformat(
                        this.computation.totalMobileDrawBets || "0.00"
                    ),
                },
            };

            axios
                .get("api/selectedbank/" + this.arena_id)
                .then(({ data }) => (this.bank.all = data));
            this.editmode = !this.editmode;
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
                totalMWBet: numberFormat(this.computation.totalMWBet || 0),
                drawCancelled: numberFormat(
                    this.computation.drawCancelled || 0
                ),
                draw: numberFormat(this.computation.draw),
                totalPayoutPaid: numberFormat(
                    this.computation.totalPayoutPaid || 0
                ),
                cdPaid: numberFormat(this.computation.cdPaid || 0),
                drawPaid: numberFormat(this.computation.drawPaid || 0),
                netWinLoss: numberFormat(this.computation.netWinLoss || 0),
                unclaimed: numberFormat(this.computation.unclaimed || 0),
                cUnpaid: numberFormat(this.computation.cUnpaid || 0),
                totalMWBetPercent: numberFormat(
                    this.computation.totalMWBetPercent || 0
                ),
                operatorExpenses: numberFormat(
                    this.computation.operatorExpenses || 0
                ),
                otherCommissionIntel05: numberFormat(
                    this.computation.otherCommissionIntel05 || 0
                ),
                consolidatorsCommission: numberFormat(
                    this.computation.consolidatorsCommission || 0
                ),
                paymentForOutstandingBalance: numberFormat(
                    this.computation.paymentForOutstandingBalance || 0
                ),
                safetyFund: numberFormat(this.computation.safetyFund || 0),
                salesDeductionTablet: numberFormat(
                    this.computation.salesDeductionTablet || 0
                ),
                systemErrorCOArmsi: numberFormat(
                    this.computation.systemErrorCOArmsi || 0
                ),
                totalOthers: numberFormat(this.computation.totalOthers || 0),
                totalCommission: numberFormat(
                    this.computation.totalCommission || 0
                ),
                mobile: {
                    cashLoad: numberFormat(
                        this.computation.mobile.cashLoad || 0
                    ),
                    cashWithdraw: numberFormat(
                        this.computation.mobile.cashWithdraw || 0
                    ),
                    totalMWBet: numberFormat(
                        this.computation.totalMobileMWBets || 0
                    ),
                    totalDrawBet: numberFormat(
                        this.computation.totalMobileDrawBets || 0
                    ),
                },
            };
        },

        proceedAction() {
            this.$Progress.start();
            // var result = $('#importData').val().split('.');

            if (
                $("#importData").val() === "" ||
                !this.fileUpload.name.includes("xlsx")
            ) {
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
            if (data.arena_details == null) {
                swal.fire({
                    icon: "warning",
                    title: "Missing",
                    text: "Add Arena Details",
                    footer: '<a href="/arena">Click here to Add Arena</a>',
                });
            } else {
                this.dialog = true;

                this.form.reset();
                this.operator_name = data.arena_details.operator;
                this.dateCreated = moment().format("ll");
                this.dateEvent = moment(data.date_of_soa).format("ll");
                this.sofrNumSeq = ("00000" + data.id).slice(-5);

                this.form.fill(data.arena_details);
                this.arenaDetails = data.arena_details;
                this.arena_id = data.arena_details.id;
                this.arena_name = data.arena_name;
                const totalMWBet = data.total_meron_wala;
                const drawCancelled = data.draw_cancelled;
                const draw = data.draw;
                const totalPayoutPaid = data.total_payout_paid;
                const cdPaid = data.draw_cancelled_paid;
                const drawPaid = data.draw_paid;
                const unclaimed = data.unclaimed;
                const cUnpaid = data.cancelled_unpaid;
                const salesDeduction = data.salesDeductionTablet;
                const otherCommissionIntel05 = data.otherCommissionIntel05;
                const systemErrorCOArmsi = data.systemErrorCOArmsi;
                const consolidatorsCommission = data.consolidatorsCommission;
                const safetyFund = data.safetyFund;
                const paymentForOutstandingBalance =
                    data.paymentForOutstandingBalance;
                const cashLoad = data.cashLoad;
                const cashWithdrawal = data.cashWithdrawal;
                const totalMWMobile = data.total_win_mobile;
                const drawMobile = data.draw_mobile;
                const exempted = data.exempted;

                const totalMWBetPercent =
                    parseFloat(totalMWBet) *
                    parseFloat(this.commission_percent);

                this.computation = {
                    totalMWBet: numberFormat(totalMWBet),
                    drawCancelled: numberFormat(drawCancelled),
                    draw: numberFormat(draw),
                    totalPayoutPaid: numberFormat(totalPayoutPaid),
                    cdPaid: numberFormat(cdPaid),
                    drawPaid: numberFormat(drawPaid),
                    // netWinLoss: numberFormat(netWinLoss),
                    unclaimed: numberFormat(unclaimed),
                    cUnpaid: numberFormat(cUnpaid),
                    totalMWBetPercent: numberFormat(totalMWBetPercent),
                    operatorExpenses: numberFormat(
                        this.computation.operatorExpenses
                    ),
                    otherCommissionIntel05: numberFormat(
                        otherCommissionIntel05
                    ),
                    consolidatorsCommission: numberFormat(
                        consolidatorsCommission
                    ),
                    paymentForOutstandingBalance: numberFormat(
                        paymentForOutstandingBalance
                    ),
                    safetyFund: numberFormat(safetyFund),
                    salesDeductionTablet: numberFormat(salesDeduction),
                    systemErrorCOArmsi: numberFormat(systemErrorCOArmsi),
                    exempted,

                    mobile: {
                        cashLoad: numberFormat(cashLoad),
                        cashWithdraw: numberFormat(cashWithdrawal),
                        totalMWBet: numberFormat(totalMWMobile),
                        totalDrawBet: numberFormat(drawMobile),
                    },
                };
            }
        },

        onFileChange(event) {
            const file = event.target.files ? event.target.files[0] : null;
            this.fileUpload = file;
            const checkfile =
                file.name.includes("xlsx") || file.name.includes("csv");
            if (file && checkfile) {
                const reader = new FileReader();
                let arrayData = [];
                let reportCombined = [];
                let eventsCombined = [];
                let summaryReport = [];
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
                    const filteredWS = ws.filter(function (value, index, arr) {
                        return (
                            value === "Accounts Report (Combined)" ||
                            value === "Summary Report"
                        );
                    });
                    // console.log(filtered)
                    filteredWS.forEach((w) => {
                        const singleSheet = wb.Sheets[w];

                        const hhh = XLSX.utils.sheet_to_json(singleSheet, {
                            header: "A",
                            defval: 0,
                        });

                        arrayData.push(
                            XLSX.utils.sheet_to_json(singleSheet, {
                                header: "A",
                                defval: 0,
                            })
                        );
                    });

                    arrayData[0].map((r) => {
                        if (Object.keys(r).length >= 17) reportCombined.push(r);
                        // console.log('>>>>',r)
                        if (
                            typeof r.A == "string" &&
                            r.A.indexOf("Date") > -1
                        ) {
                            eventsCombined.push(valueSplit(r.A));
                        }
                    });

                    arrayData[1].map((sr) => {
                        if (Object.keys(sr).length >= 20)
                            summaryReport.push(sr);
                    });

                    // Merge Object
                    const mergeObj = mergeObject(eventsCombined);

                    console.log(eventsCombined);

                    const objectKeyed = (array) => {
                        let objectKeyReplacedArray = [];
                        const keysss = array.find((k) => k.B === "ARENA NAME");
                        console.log("FINDING KEY>>>", keysss);
                        const [, ...headKey] = Object.values(keysss);
                        const headK = ["key", ...headKey];

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
                                eventCreated:
                                    mergeObj.dateCreated ||
                                    moment().format("LL"),
                                type: data.type
                                    ? data.type
                                    : data.classification
                                    ? data.classification
                                    : null,
                                totalCommission: data.totalCommission
                                    ? data.totalCommission
                                    : 0,
                                totalOthers: data.totalOthers
                                    ? data.totalOthers
                                    : 0,
                                salesDeductionTablet: data.salesDeductionTablet
                                    ? data.salesDeductionTablet
                                    : 0,
                                otherCommissionInteldata05:
                                    data.otherCommissionInteldata05
                                        ? data.otherCommissionInteldata05
                                        : 0,
                                consolidatorsCommission:
                                    data.consolidatorsCommission
                                        ? data.consolidatorsCommission
                                        : 0,
                                safetyFund: data.safetyFund
                                    ? data.safetyFund
                                    : 0,
                                paymentForOutstandingBalance:
                                    data.paymentForOutstandingBalance
                                        ? data.paymentForOutstandingBalance
                                        : 0,
                                systemErrorCOArmsi: data.systemErrorCOArmsi
                                    ? data.systemErrorCOArmsi
                                    : 0,
                                cashLoad: data.cashLoad ? data.cashLoad : 0,
                                cashWithdrawal: data.cashWithdrawal
                                    ? data.cashWithdrawal
                                    : 0,
                                netOperatorsCommission:
                                    data.netOperatorsCommission
                                        ? data.netOperatorsCommission
                                        : 0,
                                otherCommissionIntel05:
                                    data.otherCommissionIntel05
                                        ? data.otherCommissionIntel05
                                        : 0,

                                drawMobile: 0,
                                totalMWMobile: 0,
                                ...data,
                            });
                        });

                        return objectKeyReplacedArray;
                    };

                    const objKeyRep = objectKeyed(reportCombined, 5);
                    const objKeySummary = objectKeyed(summaryReport, 6);

                    let objMobileKiosk = [];

                    objKeySummary.forEach(function (item) {
                        const existing = objMobileKiosk.filter((v, i) => {
                            // if (v.arenaName == item.arenaName) console.log(v);
                            if (
                                v.type === "KIOSK" &&
                                v.arenaName == item.arenaName
                            )
                                return v.arenaName == item.arenaName;
                        });

                        if (existing.length) {
                            const m = item.type.toLowerCase();
                            const existingIndex = objMobileKiosk.indexOf(
                                existing[0]
                            );

                            objMobileKiosk[existingIndex].totalMWMobile =
                                item.total;
                            objMobileKiosk[existingIndex].drawMobile =
                                item.draw;
                        } else {
                            if (typeof item.value == "string")
                                item.value = [item.value];
                            objMobileKiosk.push(item);
                        }
                    });

                    // console.log('OBJMK>>>',objMobileKiosk)

                    let helper = {};
                    const result = objMobileKiosk.reduce(function (r, o) {
                        let key = o.arenaName;

                        if (!helper[key]) {
                            helper[key] = Object.assign({}, o); // create a copy of o

                            r.push(helper[key]);
                        } else {
                            // helper[key].mobile = {
                            //     totalMW: o.total,
                            //     draw: o.draw
                            // }

                            helper[key].totalMWMobile = o.total;
                            helper[key].drawMobile = o.draw;
                        }

                        return r;
                    }, []);

                    const accountsReportSummaryCombined = [...result];

                    const arsc = values(
                        map(
                            groupBy(accountsReportSummaryCombined, "arenaName"),
                            spread(assign)
                        )
                    );

                    const filterObjectHeader = arsc.filter((obk) => {
                        if (
                            obk.arenaName !== "OCBS NAME" &&
                            obk.arenaName !== "ARENA NAME" &&
                            obk.arenaName !== "Over All Total:" &&
                            obk.arenaName !== "Grand Total:" &&
                            obk.arenaName !== 0
                        )
                            return obk;
                    });

                    const removeKeyReportObject = filterObjectHeader.map(
                        ({ key, ...rest }) => {
							
							const type = rest.type || rest.classification;
							const arenaName = rest.arenaName;
							const exempted = rest.exempted;
                            const totalMWBets = rest.meron + rest.wala;
                            const totalCancelledBets = rest.drawCancelled;
                            const totalDrawBets = rest.draw;
                            const totalPayoutPaid = rest.payoutPaid;
                            const totalCDPaid = rest.cDPaid;
                            const totalDrawPaid = rest.drawPaid;
                            const totalMWMobile = rest.totalMWMobile;
                            const totalDrawMobile = rest.drawMobile;
                            const netWinLoss = totalMWBets + totalCancelledBets + totalDrawBets - totalPayoutPaid - totalCDPaid - totalDrawPaid;
                            const mwTwo = totalMWBets * 0.02;
                            const drawTwo = totalDrawBets * 0.02;
                            const mwTwoMobile = totalMWMobile * 0.02;
                            const drawTwoMobile = totalDrawMobile * 0.02;
                            const totalUnclaimed = rest.unclaimed;
                            const totalCUnpaid = rest.cUnpaid;
                            const salesDeduction = rest.salesDeductionTablet;
                            const netOperatorsCommission = mwTwo + drawTwo + mwTwoMobile + drawTwoMobile + totalUnclaimed +totalCUnpaid - salesDeduction;
                            const otherCommissionIntel = rest.otherCommissionIntel05;
                            const consolidatorsCommission = rest.consolidatorsCommission;
                            const safetyFund = rest.safetyFund;
                            const paymentForOutstandingBalance = rest.paymentForOutstandingBalance;
                            const totalCommission = netOperatorsCommission + otherCommissionIntel - consolidatorsCommission - safetyFund - paymentForOutstandingBalance;
							const cashLoad = rest.cashLoad;
							const cashWithdrawal = rest.cashWithdrawal;
							const totalOthers = rest.totalOthers
							const systemErrorCOArmsi = rest.systemErrorCOArmsi
							const totalComputationOthers = exempted === "NOT" ? totalOthers : totalCommission;					
							const depositReplenish = (netWinLoss - totalComputationOthers- systemErrorCOArmsi) + (cashLoad - cashWithdrawal);
							const soaFr = parseFloat(depositReplenish) < 0 ? "fr" : "soa";

                            rest = {
								areaCode: rest.areaCode,
								eventDate: rest.eventCreated,
								arenaName,
								type,
								exempted,								
                                totalMWBets,
                                totalCancelledBets,
                                totalDrawBets,
                                totalPayoutPaid,
                                totalCDPaid,
                                totalDrawPaid,
                                netWinLoss,
                                mwTwo,
                                drawTwo,
								mwTwoMobile,
								drawTwoMobile,
								totalUnclaimed,
								totalCUnpaid,
								salesDeduction,
								netOperatorsCommission,
								otherCommissionIntel,
								consolidatorsCommission,
								safetyFund,
								paymentForOutstandingBalance,
								totalCommission,
								totalMWMobile,
								totalDrawMobile,
								cashLoad,
								cashWithdrawal,
								depositReplenish,
								totalOthers,
								systemErrorCOArmsi,
								soaFr
							
                            };

                            return {...rest};
                        }
                    );

					// group fr and soa
					 const groupSOAFR = removeKeyReportObject.reduce(function (r, a) {
						r[a.soaFr] = r[a.soaFr] || [];
						r[a.soaFr].push(a);
						return r;
					}, Object.create(null));
					
					const newsoa = groupSOAFR.soa.map((s, i) => ({refNo: "SOA"+moment().format("MMDYY")+(`00000${i+1}`).slice(-5), ...s}));
					const newfr = groupSOAFR.fr.map((f, i) => ({refNo: "FR"+moment().format("MMDYY")+(`00000${i+1}`).slice(-5), ...f}));

					const newSetReport = concat(newsoa, newfr);
	
					console.log('new set soafr>>>',newSetReport);
					
                    this.ocbsArrayFiltered = newSetReport;

                   
                };
                reader.readAsBinaryString(file);
            } else {
                Fire.$emit("AfterCreate"),
                    swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "Make sure you insert correct excel data!",
                    });
                $("#importData").val("");
            }
        },
        generateReport() {
            console.log("generating pdf..");

            this.$refs.html2Pdf.generatePdf();

            axios
                .get("api/arenaStatus/" + this.arena_name)
                .then(
                    (data) => (
                        Fire.$emit("AfterCreate"),
                        (this.dialog = false),
                        swal.fire("convert to pdf!", "successfully", "success")
                    )
                );
        },
        async downloadImg(details) {
            console.log("printing..");
            const el = this.$refs.soaReport;

            const options = {
                type: "dataURL",
                backgroundColor: "#fafafa",
            };
            const printCanvas = await html2canvas(el, options);

            const link = document.createElement("a");
            link.setAttribute("download", `${details.arena}.png`);
            link.setAttribute(
                "href",
                printCanvas
                    .toDataURL("image/png")
                    .replace("image/png", "image/octet-stream")
            );
            link.click();

            axios
                .put("api/arenaStatus/" + this.arena_name, {
                    data: this.computedAve,
                })
                .then(
                    (data) => (
                        Fire.$emit("AfterCreate"),
                        (this.dialog = false),
                        swal.fire("convert to png!", "successfully", "success")
                    )
                );
            console.log("done");
        },
        multiDownloads() {
            // this.overlay = true;
            this.loading = true;

            const divsss = document.querySelectorAll(".reportsoaoutput");

            for (let i = 0; i < this.selected.length; i++) {
                html2canvas(divsss[i], {
                    onclone: function (clonedDoc) {
                        const elems =
                            clonedDoc.getElementsByClassName("reportsoaoutput");
                        for (let i = 0; i < elems.length; i++) {
                            elems[i].style.display = "block";
                        }
                    },
                    type: "dataURL",
                    backgroundColor: "#fafafa",
                }).then((canvas) => {
                    //your onrendered function code here
                    if (
                        navigator.userAgent.indexOf("MSIE ") > 0 ||
                        navigator.userAgent.match(/Trident.*rv\:11\./)
                    ) {
                        const blob = canvas.msToBlob();

                        window.navigator.msSaveBlob(
                            blob,
                            `${this.selected[i].arena_name}.png`
                        );
                    } else {
                        const link = document.createElement("a");
                        link.download = `${this.selected[i].arena_name}.png`;
                        link.href = canvas.toDataURL("image/png");

                        link.click();
                        this.loading = false;
                    }
                });
            }

            // // // -----------ZIP--------------- // // //
            //  const zip = new JSZip();
            // const getBase64Image = (img) => {
            // 	return img.replace(/^data:image\/(png|jpg);base64,/, "");
            // }

            //  const doSomeAsyncStuffWith = async(item, i) => {

            // 	const aaa = await html2canvas(divsss[i],{
            // 			onclone: function (clonedDoc) {
            // 				const elems = clonedDoc.getElementsByClassName('reportsoaoutput');
            // 				for(let i = 0; i < elems.length; i++) {
            // 					elems[i].style.display = 'block';
            // 				}

            // 			},
            // 			type: "dataURL",
            // 			backgroundColor: "#fafafa"

            // 		})

            // 		const dataURL = await aaa.toDataURL("image/png");

            // 		return Promise.resolve({arenaName: item.arena_name, dataURL});
            // }

            // const awaitAll = (list, asyncFn) => {
            // 	const promises = [];

            // 	list.forEach((value, index) => {

            // 		promises.push(asyncFn(value, index));

            // 	});

            // 	return Promise.all(promises);
            // }

            // awaitAll(this.selected, doSomeAsyncStuffWith)
            // 	.then((results) => {

            // 			console.log(
            // 				"doSomeStuffOnlyWhenTheAsyncStuffIsFinished",
            // 				results
            // 			)

            // 			results.forEach((value) => {
            // 				const arenaName = value.arenaName.indexOf('/') > -1 ? value.arenaName.replace(/\//g, '-') : value.arenaName;
            // 				zip.file(`${arenaName}.png`, getBase64Image(value.dataURL), {base64: true})

            // 			})

            // 			zip.generateAsync({
            // 				type: "blob"
            // 			}).then(function(content) {
            // 				saveAs(content, `soafr-${new Date().toLocaleDateString()}.zip`)
            // 			})

            // 			this.loading = false;
            // 		}

            // 	)
            // 	.catch((e) => console.error(e));

            console.log("done");
        },
    },

    computed: {
        computedAve: function () {
            const netWinLoss = numberFormat(
                numberUnformat(this.computation.totalMWBet) +
                    numberUnformat(this.computation.drawCancelled) +
                    numberUnformat(this.computation.draw) -
                    numberUnformat(this.computation.totalPayoutPaid) -
                    numberUnformat(this.computation.cdPaid) -
                    numberUnformat(this.computation.drawPaid) || 0
            );

            this.netWinLoss = netWinLoss;

            const mwTotalPercent = numberFormat(
                numberUnformat(this.commission_percent) *
                    numberUnformat(this.computation.totalMWBet) || 0
            );
            const drawTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.draw) || 0
            );
            const mwMobileTotalPercent = numberFormat(
                numberUnformat(this.commission_percent) *
                    numberUnformat(this.computation.mobile.totalMWBet) || 0
            );
            const drawMobileTotalPercent = numberFormat(
                numberUnformat(this.commission_percent) *
                    numberUnformat(this.computation.mobile.totalDrawBet) || 0
            );
            const netOpCommTotal =
                numberUnformat(mwTotalPercent) +
                numberUnformat(drawTotalPercent) +
                numberUnformat(mwMobileTotalPercent) +
                numberUnformat(drawMobileTotalPercent) +
                numberUnformat(this.computation.unclaimed) +
                numberUnformat(this.computation.cUnpaid) -
                numberUnformat(this.computation.salesDeductionTablet);

            const totalComm =
                numberUnformat(netOpCommTotal) +
                numberUnformat(
                    this.computation.otherCommissionIntel05 || "0.00"
                ) -
                numberUnformat(
                    this.computation.consolidatorsCommission || "0.00"
                ) -
                numberUnformat(this.computation.safetyFund || "0.00") -
                numberUnformat(
                    this.computation.paymentForOutstandingBalance || "0.00"
                );

            const netOpCommission = numberFormat(netOpCommTotal) || 0;
            const totalCommission = numberFormat(totalComm) || 0;

            const cashLoad = this.computation.mobile.cashLoad;
            const cashWithdraw = this.computation.mobile.cashWithdraw || 0;
            const totalOthers =
                numberUnformat(this.computation.unclaimed) +
                numberUnformat(this.computation.cUnpaid);
            const totalComputationOthers =
                this.computation.exempted === "NOT"
                    ? numberFormat(totalOthers)
                    : numberFormat(totalCommission);
            console.log(this.computation.exempted);

            const depositReplenish = numberFormat(
                (numberUnformat(netWinLoss) -
                    numberUnformat(totalComputationOthers) ||
                    0 - numberUnformat(this.computation.systemErrorCOArmsi) ||
                    0) +
                    (numberUnformat(cashLoad) - numberUnformat(cashWithdraw) ||
                        0)
            );

            const depositReplenishText =
                numberUnformat(depositReplenish) < 0
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
            this.depositReplenishTxt = depositReplenishText;

            return {
                netWinLoss,
                mwTotalPercent,
                drawTotalPercent,
                mwMobileTotalPercent,
                drawMobileTotalPercent,
                netOpCommission,
                totalComputationOthers,
                totalCommission,
                cashLoad,
                cashWithdraw,
                depositReplenish,
                depositReplenishText,
            };
        },
    },
    watch: {
        loader() {
            const l = this.loader;
            this[l] = !this[l];

            setTimeout(() => (this[l] = false), 3000);

            this.loader = null;
        },
    },
    created() {
        this.showData();
        this.importwithstatus();
        this.loadEmployee();
        // this.loadbank();
        Fire.$on("AfterCreate", () => {
            this.showData();
            this.importwithstatus();
        });
    },
};
</script>
