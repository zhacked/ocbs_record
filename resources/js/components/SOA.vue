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
                                        :loading="loading"
                                    >
                                        <template v-slot:loader>
                                            <span>Preparing...</span>
                                            <span class="custom-loader">
                                                <v-icon light
                                                    >mdi-cached</v-icon
                                                >
                                            </span>
                                        </template>
                                        send</v-btn
                                    >
                                </v-card-actions>
                            </form>
                        </v-card-title>

                        <div
                            class="card card-tabs"
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
                                            @click="() => this.selected = []"
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
                                            @click="() => this.selected = []"
                                            >Converted</a
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
                                            <v-menu
                                               offset-x
                                                v-if="this.selected != 0"
                                                rounded="rounded"
                                                :loading="downloadingReport"
                                                :disabled="downloadingReport"
                                            >
                                                <template
                                                    v-slot:activator="{
                                                        attrs,
                                                        on,
                                                    }"
                                                >
                                                    <v-btn
                                                         color="primary lighten-1"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                         :loading="
                                                                downloadingReport
                                                            "
                                                            :disabled="
                                                                downloadingReport
                                                            "
                                                    >
                                                         <v-icon light
                                                                >mdi-image</v-icon
                                                            > Download
                                                              <template
                                                                v-slot:loader
                                                            >
                                                                <span
                                                                    >Downloading...</span
                                                                >
                                                              
                                                            </template>
                                                    </v-btn>
                                                </template>

                                                <v-list >
                                                    <v-list-item>
                                                        <v-btn
                                                            v-show="
                                                                this.selected !=
                                                                0
                                                            "
                                                            :loading="
                                                                downloadingReport
                                                            "
                                                            :disabled="
                                                                downloadingReport
                                                            "
                                                            color="green lighten-1"
                                                            class="ma-2 white--text allbtn"
                                                            @click="
                                                                multiDownloads
                                                            "
                                                        >
                                                            <v-icon light
                                                                >mdi-download</v-icon
                                                            >
                                                            PNG
                                                           
                                                        </v-btn>
                                                    </v-list-item>
                                                    <v-list-item >
                                                        <v-btn
                                                            v-show="
                                                                this.selected !=
                                                                0
                                                            "
                                                            :loading="
                                                                downloadingReport
                                                            "
                                                            :disabled="
                                                                downloadingReport
                                                            "
                                                            color="yellow darken-3"
                                                            class="ma-2 white--text allbtn"
                                                            @click="
                                                                downloadZip
                                                            "
                                                        >
                                                            <v-icon light
                                                                >mdi-zip-box</v-icon
                                                            >
                                                            Zip
                                                           
                                                        </v-btn>
                                                    </v-list-item>
                                                </v-list>
                                            </v-menu>
                                            <!--  -->
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
                                        <v-data-table
                                            item-key="codeEvent"
                                            :headers="headers"
                                            :items="arenaData.data"
                                            :items-per-page="10"
                                            v-model="selected"
                                            :loading="downloadingReport"
                                            :search="search"
                                            :show-select="
                                                downloadingReport ? false : true
                                            "
                                            :disable-filtering="
                                                downloadingReport ? true : false
                                            "
                                            :disable-sort="
                                                downloadingReport ? true : false
                                            "
                                            :single-select="singleSelect"
                                            class="elevation-1 text-center"
                                            :footer-props="{
                                                'items-per-page-options': [
                                                    10,
                                                    20,
                                                    30,
                                                    40,
                                                    50,
                                                    100,
                                                    500
                                                ],
                                            }"
                                            @toggle-select-all="selectAllToggle"
                                        >
                                       
                                            
                                      
                                            <template
                                                v-slot:[`item.data-table-select`]="{
                                                    item,
                                                    isSelected,
                                                    select,
                                                }"
                                            >
                                                <v-simple-checkbox
                                                    :value="isSelected"
                                                    :readonly="item.disabled"
                                                    :disabled="
                                                        item.arena_details
                                                            ? false
                                                            : true
                                                    "
                                                    @input="select($event)"
                                                ></v-simple-checkbox>
                                            </template>

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
                                                            :disabled="
                                                                downloadingReport
                                                            "
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
                                            v-show="
                                                arenaData.data &&
                                                arenaData.data.length > 0
                                            "
                                            :loading="downloadingReport"
                                            :disabled="downloadingReport"
                                            @click="truncate"
                                            color="red lighten-1"
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
                                             item-key="codeEvent"
                                            :headers="headers"
                                            :items="arenaDatastatus.data"
                                            :items-per-page="10"
                                            v-model="selected"
                                            :loading="downloadingReport"
                                            :search="search"
                                            :show-select="
                                                downloadingReport ? false : true
                                            "
                                            :disable-filtering="
                                                downloadingReport ? true : false
                                            "
                                            :disable-sort="
                                                downloadingReport ? true : false
                                            "
                                            :single-select="singleSelect"
                                            class="elevation-1 text-center"
                                            :footer-props="{
                                                'items-per-page-options': [
                                                    10,
                                                    20,
                                                    30,
                                                    40,
                                                    50,
                                                    100,
                                                    
                                                ],
                                            }"
                                            @toggle-select-all="selectAllToggle"
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
                                :key="item.codeEvent"
                                style="
                                    padding: 5px 30px;
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
                                                          totalText:
                                                              'Replenish',
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
                                            :editmode="false"
                                            :emailFormat="
                                                item.arena_details
                                                    ? defineEmail(
                                                          item.arena_details
                                                              .email_details
                                                      )
                                                    : ''
                                            "
                                            :contactFormat=" item.arena_details
                                                    ? defineContact(
                                                          item.arena_details
                                                              .contact_details
                                                      )
                                                    : ''"
                                        />
                                    </v-row>
                                    <v-row>
                                        <div class="computation-banner">
                                            Computation
                                        </div>
                                    </v-row>
                                    <ComputeBox
                                        :computation="{
                                            totalMWBets: numberFormat(
                                                item.total_meron_wala || 0
                                            ),
                                            drawCancelled: numberFormat(
                                                item.draw_cancelled || 0
                                            ),
                                            draw: numberFormat(item.draw || 0),
                                            totalPayoutPaid: numberFormat(
                                                item.total_payout_paid || 0
                                            ),
                                            cdPaid: numberFormat(
                                                item.draw_cancelled_paid || 0
                                            ),
                                            drawPaid: numberFormat(
                                                item.draw_paid || 0
                                            ),
                                            systemErrorCOArmsi: numberFormat(
                                                item.systemErrorCOArmsi || 0
                                            ),
                                            safetyFund: numberFormat(
                                                item.safetyFund || 0
                                            ),
                                            salesDeduction:
                                                numberFormat(
                                                    item.salesDeductionTablet
                                                ) || 0,
                                            unclaimed: numberFormat(
                                                item.unclaimed || 0
                                            ),
                                            cUnpaid: numberFormat(
                                                item.cancelled_unpaid || 0
                                            ),
                                            otherCommissionIntel05:
                                                numberFormat(
                                                    item.otherCommissionIntel05 ||
                                                        0
                                                ),
                                            consolidatorsCommission:
                                                numberFormat(
                                                    item.consolidatorsCommission ||
                                                        0
                                                ),
                                            paymentForOutstandingBalance:
                                                numberFormat(
                                                    item.paymentForOutstandingBalance ||
                                                        0
                                                ),
                                            mwTotalPercent: numberFormat(
                                                item.mwTwo || 0
                                            ),

                                            mobile: {
                                                totalMWBets: numberFormat(
                                                    item.total_win_mobile || 0
                                                ),
                                                totalDrawBets: numberFormat(
                                                    item.draw_mobile || 0
                                                ),
                                                cashLoad: numberFormat(
                                                    item.cashLoad || 0
                                                ),
                                                cashWithdrawal: numberFormat(
                                                    item.cashWithdraw || 0
                                                ),
                                            },
                                        }"
                                        :computedAve="{
                                            netWinLoss: numberFormat(
                                                item.netWinLoss || 0
                                            ),
                                            mwTotalPercent: numberFormat(
                                                item.mwTwo || 0
                                            ),

                                            totalOthers: numberFormat(
                                                item.totalOthers || 0
                                            ),
                                            totalCommission: numberFormat(
                                                item.totalCommission || 0
                                            ),

                                            depositReplenish: numberFormat(
                                                item.for_total || 0
                                            ),
                                            mwTotalPercent: numberFormat(
                                                item.mwTwo || 0
                                            ),
                                            drawTotalPercent: numberFormat(
                                                item.drawTwo || 0
                                            ),
                                            mwMobileTotalPercent: numberFormat(
                                                item.mwTwoMobile || 0
                                            ),
                                            drawMobileTotalPercent:
                                                numberFormat(
                                                    item.drawMobileTotalPercent ||
                                                        0
                                                ),
                                            netOpCommission: numberFormat(
                                                item.netOperatorsCommission || 0
                                            ),
                                            totalComputationOthers:
                                                item.exempted.toUpperCase() === 'NOT EXEMPTED' ||  item.exempted.toUpperCase() === 'NOT'
                                                    ? numberFormat(
                                                          item.totalOthers || 0
                                                      )
                                                    : numberFormat(
                                                          item.totalCommission ||
                                                              0
                                                      ),
                                        }"
                                        :commissionPercent="commission_percent"
                                        :editmode="editmode"
                                        :depositReplenishTxt="
                                            item.group === 'Replenish'
                                                ? {
                                                      totalText:
                                                          'Replenishment',
                                                  }
                                                : {
                                                      totalText: 'Deposit',
                                                  }
                                        "
                                    />

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
                                                         
                                                          totalText:
                                                              'Replenish',
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
                              

                                    <PreparedChecked
                                        :userPrepared="userPrepared"
                                        :editmode="editmode"
                                    />
                                    {{item.for_total}}
                                </v-card-text>
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
                                                            :contactFormat="contactFormat"
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
                                                        :depositReplenishTxt="
                                                            computedAve.depositReplenishText
                                                        "
                                                        :commissionPercent="
                                                            parseFloat(
                                                                commission_percent
                                                            )
                                                        "
                                                        :editmode="editmode"
                                                        :computedAve="
                                                            computedAve
                                                        "
                                                        :computation="
                                                            computation
                                                        "
                                                    />

                                                    <BankBox
                                                        :bank="bank || {}"
                                                        :banks="banks || []"
                                                        :bankAccounts="
                                                            bankAccounts || []
                                                        "
                                                        :arenaDetails="
                                                            arenaDetails
                                                        "
                                                        :bankId="{ id: bankId }"
                                                        :arenaId="{
                                                            id: arenaId,
                                                        }"
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
             <!-- PLEASE STAND BY -->
           
                    <v-dialog
                                            v-model="dialog2"
                                          
                                            persistent
                                            width="400"
                                        >
                                            <v-card :color="progressvalue === 100 ? 'light-blue darken-3' : 'light-blue accent-3'" dark>
                                                <v-card-text>
                                                    {{downloadingReport ? 'Downloading...' :'Please stand by' }}
                                                   
                                                      <v-progress-linear
                                                        v-model="progressvalue"
                                                        color="light-blue darken-3"
                                                        height="25"
                                                        :buffer-value="progressvalue"
                                                        stream
                                                        >
                                                      
                                                            <template v-slot:default="{ value }">
                                                                <strong>{{ value === 100 ? 'Complete' : `${Math.ceil(value)}%` }}</strong>
                                                            </template>
                                                     
                                                        </v-progress-linear>
                                                </v-card-text>
                                            </v-card>
                                        </v-dialog>

            

                                        
                                        <!-- PLEASE STAND BY -->
        </v-container>
    </v-app>
</template>
<script>
import {
    camelCase,
    groupBy,
    map,
    spread,
    values,
    assign,
    concat,
    sortBy,
} from "lodash";
import XLSX from "xlsx";
import {
    numberFormat,
    numberUnformat,
    mergeObject,
    valueSplit,
} from "../utility";

import VueHtml2pdf from "vue-html2pdf";
import html2canvas from "html2canvas";
import JSZip from "jszip";
import JSZipUtils from "jszip-utils";
import { saveAs } from "file-saver";
import moment from "moment";
import DateSOA from "./DialogPreview/DateSOA.vue";
import ArenaDetails from "./DialogPreview/ArenaDetails.vue";
import ComputeBox from "./DialogPreview/ComputeBox.vue";
import BankBox from "./DialogPreview/BankBox.vue";
import PreparedChecked from "./DialogPreview/PreparedChecked.vue";

import BounceLoader from "vue-spinner/src/BounceLoader.vue";

export default {
    components: {
        VueHtml2pdf,
        DateSOA,
        ArenaDetails,
        ComputeBox,
        BankBox,
        PreparedChecked,

        BounceLoader,
    },
    data() {
        return {
            headers: [
                { text: "#", value: "id" },
                {text: "ref", value: "refNo"},
                { text: "Arena Name", value: "arena_name" },
                { text: "Operator", value: "arena_details.operator" },
              
                { text: "", value: "actions", sortable: false },
            ],
             sortBy: 'refNo',
                keys: [
                'CATEGORY',
               
            ],
            userPrepared: {
                computed: {},
                checked: {},
                prepared: {},
                selectComputed: null,
                selectChecked1: null,
                selectChecked2: null,
                selectPrepared: null,
            },
            
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
            arenaData: {},
            arenaDatastatus: [],
            arenaDetails: {},
            areaCode: "",
            codeEvent: "",
            arenaId: "",
            arena_name: "",
            loading: false,
            loader: null,
            downloadingReport: false,
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
            numberFormat,

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
            selectedItems: [],
            progressvalue: 0,
            arenaSample: [],
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
        arenaSelectedBank(bankId) {
            const bId = bankId;

            axios.get(`api/arenaSelectedBank/${bId}`).then(({ data }) => {
                this.bank = data;
            });
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
                            if (response.data == "success") {
                                Toast.fire({
                                    icon: "success",
                                    title: "Successfully Deleted",
                                });
                                Fire.$emit("AfterCreate");
                                // location.reload(); //to be removed
                            } else {
                                swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Password doesnt match in our database",
                                });
                            }
                        })
                        .catch((error) => {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                                footer: error,
                            });
                            console.log(error);
                        });
                }
            });
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
                let objMobileKiosk = [];
               

                reader.onload = (e) => {
                    // eslint-disable-next-line no-unused-vars

                    const bstr = e.target.result;
                    const wb = XLSX.read(bstr, { type: "binary" });
                   
                    const ws = wb.SheetNames;

                    const filteredWS = ws.filter(function (value, index, arr) {
                        return (
                            value === "Accounts Report (Combined)" ||
                            value === "Summary Report"
                        );
                    });

                    filteredWS.forEach((w) => {
                        const singleSheet = wb.Sheets[w];

                        arrayData.push(
                            XLSX.utils.sheet_to_json(singleSheet, {
                                header: "A",
                                defval: 0,
                            })
                        );
                    });

                    let eventDetailsA = [];

                    arrayData[0].map((r) => {
                        if (Object.keys(r).length >= 17) reportCombined.push(r);
                        
                        if (typeof r.A == "string") eventDetailsA.push(r);
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

                    // date format MM/DD/YYYY || DD/MM/YYYY
                    const dateFormatting = (date) =>
                        moment(date, "MM/DD/YYYY").isValid()
                            ? moment(date, "MM/DD/YYYY").format(
                                  "YYYY-MM-DD LTS"
                              )
                            : moment(date, "DD/MM/YYYY").isValid()
                            ? moment(date, "DD/MM/YYYY").format(
                                  "YYYY-MM-DD LTS"
                              )
                            : moment(date).format("YYYY-MM-DD LTS");

                    // if date is serial
                    const ExcelDateToJSDate = (serial) => {
                        const utc_days = Math.floor(serial - 25569);
                        const utc_value = utc_days * 86400;
                        const date_info = new Date(utc_value * 1000);
                        const fractional_day =
                            serial - Math.floor(serial) + 0.0000001;
                        let total_seconds = Math.floor(86400 * fractional_day);
                        const seconds = total_seconds % 60;
                        total_seconds -= seconds;
                        const hours = Math.floor(total_seconds / (60 * 60));
                        const minutes = Math.floor(total_seconds / 60) % 60;
                        return new Date(
                            date_info.getFullYear(),
                            date_info.getMonth(),
                            date_info.getDate(),
                            hours,
                            minutes,
                            seconds
                        );
                    };

                    const eventCreatedUTC = ExcelDateToJSDate(
                        arrayData[0][2].A
                    );
                    const eventClosedUTC = ExcelDateToJSDate(arrayData[0][4].A);
                    const isValidEventArenaDate = (stringDate) =>
                        moment(stringDate, "MM/DD/YYYY hh:mm:ss a").isValid() ||
                        moment(stringDate, "DD/MM/YYYY hh:mm:ss a").isValid()
                            ? stringDate
                            : null;

                    const eventDateCreated = dateFormatting(
                        mergeObj.dateCreated ||
                            isValidEventArenaDate(eventDetailsA[2]?.A) ||
                            eventCreatedUTC
                    );
                    const eventDateClosed = dateFormatting(
                        mergeObj.dateClosed ||
                            isValidEventArenaDate(eventDetailsA[4]?.A) ||
                            eventClosedUTC
                    );

                    console.log(eventDateCreated);

                    const objectKeyed = (array) => {
                        let objectKeyReplacedArray = [];
                        const keysss = array.find((k) => k.B === "ARENA NAME");

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
                                eventCreated: eventDateCreated,
                                eventClosed: eventDateClosed,
                                type: data.type
                                    ? data.type
                                    : data.classification
                                    ? data.classification
                                    : null,
                                totalCommission: data.totalCommission || 0,
                                totalOthers: data.totalOthers || 0,
                                salesDeductionTablet:
                                    data.salesDeductionTablet || 0,
                                otherCommissionInteldata05:
                                    data.otherCommissionInteldata05 || 0,
                                consolidatorsCommission:
                                    data.consolidatorsCommission || 0,
                                safetyFund: data.safetyFund || 0,
                                paymentForOutstandingBalance:
                                    data.paymentForOutstandingBalance || 0,
                                systemErrorCOArmsi: data.systemErrorCOArmsi
                                    ? data.systemErrorCOArmsi
                                    : 0,
                                cashLoad: data.cashLoad ? data.cashLoad : 0,
                                cashWithdrawal: data.cashWithdrawal || 0,
                                netOperatorsCommission:
                                    data.netOperatorsCommission || 0,
                                otherCommissionIntel05:
                                    data.otherCommissionIntel05 || 0,

                                drawMobile: 0,
                                totalMWMobile: 0,
                                ...data,
                            });
                        });

                        return objectKeyReplacedArray;
                    };

                    const objKeySummary = objectKeyed(summaryReport, 6);

                    objKeySummary.forEach(function (item) {
                        const existing = objMobileKiosk.filter((v, i) => {
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

                    let helper = {};
                    const result = objMobileKiosk.reduce(function (r, o) {
                        let key = o.arenaName;

                        if (!helper[key]) {
                            helper[key] = Object.assign({}, o); // create a copy of o

                            r.push(helper[key]);
                        } else {
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

                            const exempted = rest.exempted;
                            const totalMWBets = rest.meron + rest.wala;
                            const totalCancelledBets = rest.drawCancelled;
                            const totalDrawBets = rest.draw;
                            const totalPayoutPaid = rest.payoutPaid;
                            const totalCDPaid = rest.cDPaid;
                            const totalDrawPaid = rest.drawPaid;
                            const totalMWMobile = rest.totalMWMobile;
                            const totalDrawMobile = rest.drawMobile;
                            const netWinLoss =
                                totalMWBets +
                                totalCancelledBets +
                                totalDrawBets -
                                totalPayoutPaid -
                                totalCDPaid -
                                totalDrawPaid;
                            const mwTwo = totalMWBets * 0.02;
                            const drawTwo = totalDrawBets * 0.02;
                            const mwTwoMobile = totalMWMobile * 0.02;
                            const drawTwoMobile = totalDrawMobile * 0.02;
                            const totalUnclaimed = rest.unclaimed;
                            const totalCUnpaid = rest.cUnpaid;
                            const salesDeduction = rest.salesDeductionTablet;
                            const netOperatorsCommission =
                                parseFloat(mwTwo) +
                                parseFloat(drawTwo) +
                                parseFloat(mwTwoMobile) +
                                parseFloat(drawTwoMobile) +
                                parseFloat(totalUnclaimed) +
                                parseFloat(totalCUnpaid) -
                                parseFloat(salesDeduction);
                            const otherCommissionIntel =
                                rest.otherCommissionIntel05;
                            const consolidatorsCommission =
                                rest.consolidatorsCommission;
                            const safetyFund = rest.safetyFund;
                            const paymentForOutstandingBalance =
                                rest.paymentForOutstandingBalance;

                            const totalCommission =
                                parseFloat(netOperatorsCommission) +
                                parseFloat(otherCommissionIntel) -
                                parseFloat(consolidatorsCommission) -
                                parseFloat(safetyFund) -
                                parseFloat(paymentForOutstandingBalance);

                            const cashLoad = rest.cashLoad;
                            const cashWithdrawal = rest.cashWithdrawal;
                            const totalOthers = rest.totalOthers;
                            const systemErrorCOArmsi = rest.systemErrorCOArmsi;



                            const totalComputationOthers =
                                exempted.toUpperCase() === "NOT EXEMPTED" ||  exempted.toUpperCase() === "NOT"
                                    ? totalOthers
                                    : totalCommission;
                            const depositReplenish =
                                parseFloat(netWinLoss) -
                                parseFloat(totalComputationOthers) -
                                parseFloat(systemErrorCOArmsi) +
                                (parseFloat(cashLoad) - parseFloat(cashWithdrawal));
                            
                           

                            const soaFr =
                                parseFloat(depositReplenish) < 0 ? "fr" : "soa";
                            const group =
                                soaFr === "fr" ? "Replenish" : "Deposit";
                            const arenaName =
                                rest.arenaName.indexOf("/") > -1
                                    ? rest.arenaName.replace(/\//g, "~")
                                    : rest.arenaName;
                            const areaCode =
                                rest.areaCode.indexOf("/") > -1
                                    ? rest.areaCode.replace(/\//g, "~")
                                    : rest.areaCode;
                            const codeEvent = `${areaCode.toLowerCase()}${moment(
                                rest.eventCreated
                            ).format("X")}`;

                            rest = {
                                areaCode,
                                codeEvent,
                                date_of_soa: rest.eventCreated,
                                date_closed: rest.eventClosed,
                                meron: rest.meron,
                                wala: rest.wala,
                                rake: rest.rake,
                                draw_unpaid: rest.dUnpaid,
                                draw_unclaimed: rest.drawUnclaimed,
                                arena_name: arenaName,
                                type,
                                exempted,
                                total_meron_wala: totalMWBets,
                                draw_cancelled: totalCancelledBets,
                                draw: totalDrawBets,
                                total_payout_paid: totalPayoutPaid,
                                draw_cancelled_paid: totalCDPaid,
                                draw_paid: totalDrawPaid,
                                netWinLoss,
                                mwTwo,
                                drawTwo,
                                mwTwoMobile,
                                drawTwoMobile,
                                unclaimed: totalUnclaimed,
                                cancelled_unpaid: totalCUnpaid,
                                salesDeductionTablet: salesDeduction,
                                netOperatorsCommission,
                                otherCommissionIntel05: otherCommissionIntel,
                                consolidatorsCommission,
                                safetyFund,
                                paymentForOutstandingBalance,
                                totalCommission,
                                total_win_mobile: totalMWMobile,
                                draw_mobile: totalDrawMobile,
                                cashLoad,
                                cashWithdrawal,
                                for_total: depositReplenish,
                                totalOthers,
                                systemErrorCOArmsi,
                                soaFr,
                                group,
                            };

                            return { ...rest };
                        }
                    );

                    

                    // group fr and soa
                    const groupSOAFR = removeKeyReportObject.reduce(function (
                        r,
                        a
                    ) {
                        r[a.soaFr] = r[a.soaFr] || [];
                        r[a.soaFr].push(a);
                        return r;
                    },
                    Object.create(null));



                    const moLetter = String.fromCharCode(
                        96 + (moment(eventDateClosed).month() + 1)
                    ).toUpperCase();


                    const sortSoa = sortBy(groupSOAFR.soa, [
                        function (o) {
                            return o.areaCode;
                        },
                    ])

                    const sortFr = sortBy(groupSOAFR.fr, [
                        function (o) {
                            return o.areaCode;
                        },
                    ])

                    const newsoa = sortSoa.map(({ soaFr, ...s }, i) => ({
                        refNo:
                            "SO" +
                            moment(eventDateClosed).format("MMDD") +
                            moLetter +
                            `0000${i + 1}`.slice(-4),
                        ...s,
                    }));
                    const newfr = sortFr.map(({ soaFr, ...f }, i) => ({
                        refNo:
                            "FR" +
                            moment(eventDateClosed).format("MMDD") +
                            moLetter +
                            `0000${i + 1}`.slice(-4),
                        ...f,
                    }));

                    const newSetReport = concat(newsoa, newfr);
                    const sortReport = sortBy(newSetReport, [
                        function (o) {
                            return o.areaCode;
                        },
                    ]);

                    // sortReport.forEach(sr => {
                    //     this.arenaSample.push({
                    //         arenaName: sr.arenaName,
                    //         operator: 'xxxxxxxx',

                    //     })
                    // })

                    this.ocbsArrayFiltered = sortReport;

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
                this.dialog2 = true;
                // const data = await axios.get("api/import");

                //    axios.post("api/import", this.ocbsArrayFiltered)

                axios
                    .post("api/import", this.ocbsArrayFiltered)
                    .then(({ data }) => {
                        (this.dialog2 = false), $("#importData").val("");
                        Fire.$emit("AfterCreate");
                        swal.fire("Successfully!", "Excel Imported", "success");
                        this.$Progress.finish();
                        // location.reload(); // to be removed
                        // this.showData()
                    })
                    .catch((error) => {
                        (this.dialog2 = false),
                            swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                                footer: error,
                            });
                    });


            }
        },
        async importwithstatus() {
            const data = await axios.get("api/importwithstatus");

            const newArray = [];
            data.data.forEach((dObj) => {
                const arenaName =
                    dObj.arena_name.indexOf("~") > -1
                        ? dObj.arena_name.replace(/\~/g, "/")
                        : dObj.arena_name;

                const obj = {
                    ...dObj,
                    arena_name: arenaName,
                };
                newArray.push(obj);
            });

            const obj = {
                data: newArray,
            };
            this.arenaDatastatus = obj;
        },
        async showData() {
            const data = await axios.get("api/import");
          

            const newArray = [];
            data.data.forEach((dObj) => {
                const arenaName =
                    dObj.arena_name.indexOf("~") > -1
                        ? dObj.arena_name.replace(/\~/g, "/")
                        : dObj.arena_name;

                const obj = {
                    ...dObj,
                    arena_name: arenaName,
                };
                newArray.push(obj);
            });

            const obj = {
                data: newArray,
            };

            this.arenaData = obj;
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
                this.form.fill(data.arena_details);
                this.operator_name = data.arena_details.operator;
                this.dateCreated = moment(data.date_closed).format("LL");
                this.dateEvent = moment(data.date_of_soa).format("LL");
                console.log(data.exempted);
                this.refNo = data.refNo;

                this.arenaDetails = data.arena_details;
                this.banks = data.arena_details.bank_details;
                this.arenaId = data.arena_details.id;
                this.bankId = data.arena_details.bank_id;
                this.arena_name = data.arena_name;
                this.areaCode = data.areaCode;
                this.codeEvent = data.codeEvent;
                const totalMWBets = data.total_meron_wala;
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
                const netWinLoss = data.netWinLoss;
                const mwTwo = data.mwTwo;
                const drawTwo = data.drawTwo;
                const mwTwoMobile = data.mwTwoMobile;
                const drawTwoMobile = data.drawTwoMobile;


                this.computation = {
                    totalMWBets: numberFormat(totalMWBets),
                    drawCancelled: numberFormat(drawCancelled),
                    draw: numberFormat(draw),
                    totalPayoutPaid: numberFormat(totalPayoutPaid),
                    cdPaid: numberFormat(cdPaid),
                    drawPaid: numberFormat(drawPaid),
                    unclaimed: numberFormat(unclaimed),
                    cUnpaid: numberFormat(cUnpaid),
                    salesDeduction: numberFormat(salesDeduction),
                    otherCommissionIntel05: numberFormat(
                        otherCommissionIntel05
                    ),
                    systemErrorCOArmsi: numberFormat(systemErrorCOArmsi),
                    consolidatorsCommission: numberFormat(
                        consolidatorsCommission
                    ),
                    safetyFund: numberFormat(safetyFund),
                    paymentForOutstandingBalance: numberFormat(
                        paymentForOutstandingBalance
                    ),
                    totalMWMobile: numberFormat(totalMWMobile),
                    drawMobile: numberFormat(drawMobile),
                    exempted,
                    netWinLoss: numberFormat(netWinLoss),
                    mwTwo: numberFormat(mwTwo),
                    drawTwo: numberFormat(drawTwo),
                    mwTwoMobile: numberFormat(mwTwoMobile),
                    drawTwoMobile: numberFormat(drawTwoMobile),
                    mobile: {
                        totalMWBets: numberFormat(mwTwoMobile),
                        totalDrawBets: numberFormat(drawMobile),
                        cashLoad: numberFormat(cashLoad),
                        cashWithdrawal: numberFormat(cashWithdrawal),
                    },

                };
            }

            this.arenaSelectedBank(
                data && data.arena_details.bank_id
            );


            this.emailFormat = this.defineEmail(
                data && data.arena_details.email_details
            );
          
            this.contactFormat = this.defineContact(data && data.arena_details.contact_details)
           
        

           
        },

        closeDialog() {
            this.dialog = false;
        },
        updateModal() {
            $(".computation").removeAttr("disabled");
            $(".computation").addClass("input-show");

            this.computation = {
                totalMWBets: numberUnformat(this.computation.totalMWBets),
                drawCancelled: numberUnformat(this.computation.drawCancelled),
                draw: numberUnformat(this.computation.draw),
                totalPayoutPaid: numberUnformat(
                    this.computation.totalPayoutPaid
                ),
                cdPaid: numberUnformat(this.computation.cdPaid),
                drawPaid: numberUnformat(this.computation.drawPaid),
                unclaimed: numberUnformat(this.computation.unclaimed),
                cUnpaid: numberUnformat(this.computation.cUnpaid),
                salesDeduction: numberUnformat(this.computation.salesDeduction),
                otherCommissionIntel05: numberUnformat(
                    this.computation.otherCommissionIntel05
                ),
                systemErrorCOArmsi: numberUnformat(
                    this.computation.systemErrorCOArmsi
                ),
                consolidatorsCommission: numberUnformat(
                    this.computation.consolidatorsCommission
                ),
                safetyFund: numberUnformat(this.computation.safetyFund),
                paymentForOutstandingBalance: numberUnformat(
                    this.computation.paymentForOutstandingBalance
                ),
                mwTotalPercent: numberUnformat(this.computation.mwTotalPercent),
                totalMWMobile: numberUnformat(this.computation.totalMWMobile),
                drawMobile: numberUnformat(this.computation.drawMobile),
                exempted: this.computation.exempted,
                netWinLoss: numberUnformat(this.computation.netWinLoss),
                mwTwo: numberUnformat(this.computation.mwTwo),
                drawTwo: numberUnformat(this.computation.drawTwo),
                mwTwoMobile: numberUnformat(this.computation.mwTwoMobile),
                drawTwoMobile: numberUnformat(this.computation.drawTwoMobile),
                mobile: {
                    totalMWBets: numberUnformat(this.computation.totalMWMobile),
                    totalDrawBets: numberUnformat(this.computation.drawMobile),
                    cashLoad: numberUnformat(this.computation.mobile.cashLoad),
                    cashWithdrawal: numberUnformat(
                        this.computation.mobile.cashWithdrawal
                    ),
                },

                netOperatorsCommission: numberUnformat(
                    this.computation.netOperatorsCommission
                ),
            };

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
                totalMWBets: numberFormat(this.computation.totalMWBets),
                drawCancelled: numberFormat(this.computation.drawCancelled),
                draw: numberFormat(this.computation.draw),
                totalPayoutPaid: numberFormat(this.computation.totalPayoutPaid),
                cdPaid: numberFormat(this.computation.cdPaid),
                drawPaid: numberFormat(this.computation.drawPaid),
                unclaimed: numberFormat(this.computation.unclaimed),
                cUnpaid: numberFormat(this.computation.cUnpaid),
                salesDeduction: numberFormat(this.computation.salesDeduction),
                otherCommissionIntel05: numberFormat(
                    this.computation.otherCommissionIntel05
                ),
                systemErrorCOArmsi: numberFormat(
                    this.computation.systemErrorCOArmsi
                ),
                consolidatorsCommission: numberFormat(
                    this.computation.consolidatorsCommission
                ),
                safetyFund: numberFormat(this.computation.safetyFund),
                paymentForOutstandingBalance: numberFormat(
                    this.computation.paymentForOutstandingBalance
                ),
                exempted: this.computation.exempted,
                totalMWMobile: numberFormat(this.computation.totalMWMobile),
                drawMobile: numberFormat(this.computation.drawMobile),

                netWinLoss: numberFormat(this.computation.netWinLoss),
                mwTwo: numberFormat(this.computation.mwTwo),
                drawTwo: numberFormat(this.computation.drawTwo),
                mwTwoMobile: numberFormat(this.computation.mwTwoMobile),
                drawTwoMobile: numberFormat(this.computation.drawTwoMobile),
                mobile: {
                    totalMWBets: numberFormat(
                        this.computation.totalMWMobile || 0
                    ),
                    totalDrawBets: numberFormat(
                        this.computation.drawMobile || 0
                    ),
                    cashLoad: numberFormat(
                        this.computation.mobile.cashLoad || 0
                    ),
                    cashWithdrawal: numberFormat(
                        this.computation.mobile.cashWithdrawal || 0
                    ),
                },

                netOperatorsCommission: numberFormat(
                    this.computation.netOperatorsCommission
                ),
            };

            Fire.$emit("AfterCreate");
        },

        generateReport(codeEvent) {
            console.log("generating pdf..");

            this.$refs.html2Pdf.generatePdf();

            axios
                .put("api/arenaStatus", [{ codeEvent, status: "done" }])
                .then(
                    (data) => (
                        Fire.$emit("AfterCreate"),
                        (this.dialog = false),
                        swal.fire("convert to pdf!", "successfully", "success")
                    )
                );
        },
        async downloadImg(details, codeEvent) {
            const el = this.$refs.soaReport;

            const options = {
                type: "dataURL",
                backgroundColor: "#fafafa",
            };
            const printCanvas = await html2canvas(el, options);

            const link = document.createElement("a");
    

            link.download = `${details.arena}.png`;
            link.href = printCanvas.toDataURL("image/png");
            document.body.appendChild(link);
            link.click();

            setTimeout(() => {
                document.body.removeChild(link); // On modern browsers you can use `tempLink.remove();`
            }, 100);

            axios
                .put("api/arenaStatus", [{ codeEvent, status: "done" }])
                .then(
                    (data) => (
                        Fire.$emit("AfterCreate"),
                        (this.dialog = false),
                        swal.fire("convert to png!", "successfully", "success")
                    )
                );
        },
        async multiDownloads() {
            let statusArenas = [];
            this.downloadingReport = true;
            this.dialog2 = true
            const divsss = document.querySelectorAll(".reportsoaoutput");

            for (let i = 0; i < this.selected.length; i++) {
                this.progressvalue = Math.ceil((parseInt(i+1)/parseInt(this.selected.length))*100)
                statusArenas.push({
                    codeEvent: this.selected[i].codeEvent,
                    status: "done",
                });

                const canvas = await html2canvas(divsss[i], {
                    onclone: function (clonedDoc) {
                        const elems =
                            clonedDoc.getElementsByClassName("reportsoaoutput");
                        for (let i = 0; i < elems.length; i++) {
                            elems[i].style.display = "block";
                        }
                    },
                    type: "dataURL",
                    backgroundColor: "#fafafa",
                });

                const link = document.createElement("a");
                // const soaFr = this.selected[i].group === "Replenish" ? "FR" : "SO"
                link.download = `${this.selected[i].arena_name}.png`;
                link.href = canvas.toDataURL("image/png");
                document.body.appendChild(link);
                link.click();

                await setTimeout(() => {
                    document.body.removeChild(link); // On modern browsers you can use `tempLink.remove();`
                }, 500);

                if (this.selected.length - 1 === i) {
                    await axios.put("api/arenaStatus", statusArenas);
                    const c = this.arenaData.data.filter(
                        (arena) =>
                            !this.selected.find(
                                (select) => select.areaCode === arena.areaCode
                            )
                    );

                    this.arenaData.data = c;

                    setTimeout(async () => {
                        this.downloadingReport = false;
                        this.dialog2 = false
                        console.log("done");
                        this.selected = [];
                    }, 1000);
                     this.importwithstatus()
                }
            }

        },
        async downloadZip() {
            let statusArenas = [];
            this.downloadingReport = true;
            this.dialog2 = true
          
            // // -----------ZIP--------------- // // //
            const divsss = document.querySelectorAll(".reportsoaoutput");
            const zip = new JSZip();

            const urlToPromise = async (url) => {
                return new Promise(function (resolve, reject) {
                    JSZipUtils.getBinaryContent(url, function (err, data) {
                        if (err) {
                            reject(err);
                        } else {
                            resolve(data);
                            console.log(data);
                        }
                    });
                });
            };

            const generateZipFile = async (zip) => {
                const blob = await zip.generateAsync({ type: "blob" });
                await saveAs(
                    blob,
                    `report-${moment(this.selected[0].date_closed).format(
                        "MMDYY"
                    )}.zip`
                );
                console.log("zip generated");
                 await axios.put("api/arenaStatus", statusArenas);
                    const c = this.arenaData.data.filter(
                        (arena) =>
                            !this.selected.find(
                                (select) => select.areaCode === arena.areaCode
                            )
                    );

                    this.arenaData.data = c;
                        if(this.progressvalue === 100) {
                            setTimeout(async () => {
                            this.downloadingReport = false;
                            this.dialog2 = false
                            
                            console.log("done");
                            this.selected = []; 
                        }, 1000);
                   
                    }
                     this.importwithstatus()
                  
            };
            // start benchmark
            const t = new Date();
            // some xml processing

            for (let i = 0; i < this.selected.length; i++) {
                statusArenas.push({
                    codeEvent: this.selected[i].codeEvent,
                    status: "done",
                });

                console.log(`Currently at ${this.selected[i].id}, ${new Date() - t}ms`)
                
                this.progressvalue = Math.ceil((parseInt(i+1)/parseInt(this.selected.length))*100)
               

                const canvas = await html2canvas(divsss[i], {
                    onclone: function (clonedDoc) {
                        const elems =
                            clonedDoc.getElementsByClassName("reportsoaoutput");
                        for (let i = 0; i < elems.length; i++) {
                            elems[i].style.display = "block";
                        }
                    },
                    type: "dataURL",
                    backgroundColor: "#fafafa",
                });

                const link = document.createElement("a");
                // const soaFr = this.selected[i].group === "Replenish" ? "FR" : "SO"
                link.download = `${this.selected[i].arena_name}.png`;
                link.href = await canvas.toDataURL("image/png");
                const url = link.href;

                const folderName =
                    parseFloat(this.selected[i].for_total) < 0 ? "fr" : "soa";

                const arenaName =
                    (await this.selected[i].arena_name.indexOf("/")) > -1
                        ? this.selected[i].arena_name.replace(/\//g, "-")
                        : this.selected[i].arena_name;
                const filename = `${folderName}/${arenaName}.png`;

                await zip.file(filename, await urlToPromise(url), {
                    binary: true,
                }); //Create new zip file with filename and content
            }

            //Generate zip file
            await generateZipFile(zip);
        },
        defineEmail(arrayEmail) {
            console.log(arrayEmail);
            if (arrayEmail != null) {
                const emailMap = arrayEmail.map((ed) => ed["email"]);

                const ee = emailMap.reduce((prev, current) => {
                    return current + " " + prev;
                }, "");
                return ee.trim().replace(/\s/g, " / ");
            }
        },
         defineContact(arrayContact) {
            console.log(arrayContact);
            if (arrayContact != null) {
                const emailMap = arrayContact.map((ed) => ed["contact_number"]);

                const ee = emailMap.reduce((prev, current) => {
                    return current + " " + prev;
                }, "");
                return ee.trim().replace(/\s/g, " / ");
            }
        },

        loadBankDetails() {
            axios.get("api/Companybanks").then(({ data }) => {
                (this.bankAccounts = data), console.log("ACCOUNT", data);
            });
        },
        selectAllToggle(props) {
            let dis = 0;
            this.selectedItems = props.items
            props.items.map(x => {
                if(!x.arena_details) dis+=1;
            })
            if(this.selected.length != (props.items.length - dis)) {
                this.selected = [];
                const self = this;
                props.items.forEach(item => {
                if(item.arena_details) {
                    self.selected.push(item);
                }
                });
            } else this.selected = [];
        },
    },

    computed: {
        computedAve: function () {
            const netWinLoss = numberFormat(
                numberUnformat(this.computation.totalMWBets) +
                    numberUnformat(this.computation.drawCancelled) +
                    numberUnformat(this.computation.draw) -
                    numberUnformat(this.computation.totalPayoutPaid) -
                    numberUnformat(this.computation.cdPaid) -
                    numberUnformat(this.computation.drawPaid) || 0
            );

            const mwTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.totalMWBets) || 0
            );

            const drawTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.draw) || 0
            );
            const mwMobileTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.mobile.totalMWBets) || 0
            );

            const drawMobileTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.mobile.totalDrawBets) || 0
            );
            const netOpCommTotal =
                numberUnformat(mwTotalPercent) +
                numberUnformat(drawTotalPercent) +
                numberUnformat(mwMobileTotalPercent) +
                numberUnformat(drawMobileTotalPercent) +
                numberUnformat(this.computation.unclaimed) +
                numberUnformat(this.computation.cUnpaid) -
                numberUnformat(this.computation.salesDeduction);

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

            const netOpCommission = numberFormat(netOpCommTotal || 0);
            const totalCommission = numberFormat(totalComm || 0);

            const cashLoad = numberFormat(
                this.computation.mobile.cashLoad || 0
            );
            const cashWithdraw = numberFormat(
                this.computation.mobile.cashWithdrawal || 0
            );

            const totalOthers =
                numberUnformat(this.computation.unclaimed) +
                numberUnformat(this.computation.cUnpaid);

            const totalComputationOthers =
                this.computation.exempted.toUpperCase() === "NOT EXEMPTED" ||  this.computation.exempted.toUpperCase() === "NOT"
                    ? numberFormat(totalOthers)
                    : numberFormat(totalCommission);

            const depositReplenish = numberFormat(
                (numberUnformat(netWinLoss) -
                    numberUnformat(totalComputationOthers) ||
                    0 - numberUnformat(this.computation.systemErrorCOArmsi) ||
                    0) +
                    (numberUnformat(this.computation.mobile.cashLoad) -
                        numberUnformat(
                            this.computation.mobile.cashWithdrawal
                        ) || 0)
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

            const totalMWBets = numberFormat(this.computation.totalMWBets || 0);
            const drawCancelled = numberFormat(
                this.computation.drawCancelled || 0
            );
            const draw = numberFormat(this.computation.draw || 0);
            const totalPayoutPaid = numberFormat(
                this.computation.totalPayoutPaid || 0
            );
            const cdPaid = numberFormat(this.computation.cdPaid || 0);
            const drawPaid = numberFormat(this.computation.drawPaid || 0);

            const unclaimed = numberFormat(this.computation.unclaimed || 0);
            const cUnpaid = numberFormat(this.computation.cUnpaid || 0);

            const otherCommissionIntel05 = numberFormat(
                this.computation.otherCommissionIntel05
            );
            const consolidatorsCommission = numberFormat(
                this.computation.consolidatorsCommission
            );
            const paymentForOutstandingBalance = numberFormat(
                this.computation.paymentForOutstandingBalance
            );

            const safetyFund = numberFormat(this.computation.safetyFund);
            const salesDeduction = numberFormat(
                this.computation.salesDeductionTablet
            );
            const systemErrorCOArmsi = numberFormat(
                this.computation.systemErrorCOArmsi
            );
            const totalMWMobile = numberFormat(
                this.computation.mobile.totalMWBets
            );
            const totalDrawMobile = numberFormat(
                this.computation.mobile.totalDrawBets
            );

            return {
                totalMWBets,
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
                salesDeduction,
                systemErrorCOArmsi,
                safetyFund,
                drawCancelled,
                draw,
                totalPayoutPaid,
                cdPaid,
                drawPaid,
                unclaimed,
                cUnpaid,
                otherCommissionIntel05,
                consolidatorsCommission,
                paymentForOutstandingBalance,
                totalMWMobile,
                totalDrawMobile,
            };
        },
    },

    async created() {
        await this.showData();
        this.importwithstatus();
        this.loadEmployee();
        this.loadBankDetails();
        Fire.$on("AfterCreate", () => {
            this.showData();
            this.importwithstatus();
        });
    },
};
</script>
<style scoped>
.nav-tabs .nav-link.active {
    background-color: #00c4f5 !important ;
    color: white !important;
}
</style>
