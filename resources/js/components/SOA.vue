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
                     
                        <v-col>
                              <!-- DATE RANGE -->
                        
                                <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :return-value.sync="dates"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="dateRangeText"
                                        label="Picker in menu"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="dates"
                                        no-title
                                        scrollable
                                        range
                                    >
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        text
                                        color="primary"
                                        @click="menu = false"
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        text
                                        color="primary"
                                        @click="handleFilterDate(dates)"
                                    >
                                        OK
                                    </v-btn>
                                    </v-date-picker>
                                </v-menu>            

                        </v-col>
                        <!-- Filter WIth/Without ARENA Details -->
                        <v-col>
                            <v-select
                                :items="arenaItemsSelection"
                                label="Filter arena"
                                dense
                                outlined
                                item-text="text"
                                item-value="key"
                                @change="handleSelectionFilterArena"
                            ></v-select>
                        </v-col>
                        <!-- FILE INPUT -->
                        <v-col v-show="$gate.isAdmin()">
                            <v-file-input
                                outlined
                                dense
                                v-model="fileUpload"
                                color="deep-purple accent-4"
                                label="File input"
                                placeholder="Select your file"
                                :clearable="false"
                                counter
                                
                                append-icon="mdi-file-import"
                                :show-size="1000"
                                @change="onFileChange($event)"
                            >
                                <template v-slot:append>
                                    <v-tooltip bottom color="success">
                                        <template v-slot:activator="{ on }">
                                            <v-icon
                                                large
                                                :disabled="!isExcel"
                                                v-on="on"
                                                color="green darken-3"
                                                style="cursor: pointer"
                                                @click="proceedAction"
                                            >
                                                mdi-file-import
                                            </v-icon>
                                        </template>
                                        <span>Import File</span>
                                    </v-tooltip>
                                </template>
                                <template v-slot:selection="{ index, text }">
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
                                        @click="() => (this.selected = [])"
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
                                        @click="() => (this.selected = [])"
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
                                        <v-switch
                                            v-model="switchPrepared"
                                            :label="`Signatory ${
                                                switchPrepared ? 'On' : 'Off'
                                            }`"
                                            @change="handleSwitchPrepared"
                                        ></v-switch>
                                    </v-col>
                                   
                                    <v-col>
                                        <v-text-field
                                            v-model="search"
                                            append-icon="mdi-magnify"
                                            label="Search"
                                            color="primary darken-2"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col >
                              
                                        <v-menu
                                            class="float-right"
                                            bottom
                                            origin="center center"
                                            transition="scale-transition"
                                            v-if="selected.length !=0"
                                            rounded="rounded"
                                            :loading="downloadingReport"
                                            :disabled="downloadingReport"
                                        >
                                            <template
                                                v-slot:activator="{attrs,on,}"
                                            >
                                                <v-btn
                                                    color="primary lighten-1"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    :loading="downloadingReport"
                                                    :disabled="downloadingReport"
                                                >
                                                    <v-icon
                                                        light
                                                    >mdi-image</v-icon>
                                                    Download
                                                    <template
                                                        v-slot:loader
                                                    >
                                                        <span>Downloading...</span>
                                                    </template>
                                                </v-btn>
                                            </template>
                                                <v-list>
                                                    <v-list-item>
                                                        <v-btn
                                                            :loading="downloadingReport"
                                                            :disabled="downloadingReport"
                                                            color="green lighten-1"
                                                            class="ma-2 white--text allbtn"
                                                            @click="multiDownloads"
                                                        >
                                                            <v-icon
                                                                light
                                                            >mdi-download</v-icon>
                                                                PNG
                                                        </v-btn>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-btn
                                                            :loading="downloadingReport"
                                                            :disabled="downloadingReport"
                                                            color="yellow darken-3"
                                                            class="ma-2 white--text allbtn"
                                                            @click="downloadZip"
                                                        >
                                                            <v-icon
                                                                light
                                                            >mdi-zip-box</v-icon>
                                                            Zip
                                                        </v-btn>
                                                    </v-list-item>
                                                </v-list>
                                        </v-menu>
                                                 
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
                                        :items="arenaData"
                                        :items-per-page="10"
                                        v-model="selected"
                                        :loading="downloadingReport"
                                        ref="table"
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
                                                -1, 10, 20, 30, 40, 50, 100,
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
                                            v-slot:[`item.areaCode`]="{ item }"
                                        >
                                            <span class="font-weight-medium">{{
                                                item.arena_details
                                                    ? item.arena_details
                                                          .area_code
                                                    : item.areaCode
                                            }}</span>
                                        </template>
                                        <template
                                            v-slot:[`item.refNo`]="{ item }"
                                        >
                                            <span class="font-weight-medium">{{
                                                item.refNo
                                            }}</span>
                                        </template>
                                        <template
                                            v-slot:[`item.arena_name`]="{
                                                item,
                                            }"
                                        >
                                            <span class="font-weight-medium">{{
                                                item.arena_details
                                                    ? item.arena_details.arena
                                                    : item.arena_name
                                            }}</span>
                                        </template>

                                        <template
                                            v-slot:[`item.actions`]="{ item }"
                                        >
                                            <v-tooltip top color="primary">
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
                                                        :disabled="
                                                            downloadingReport
                                                        "
                                                    >
                                                        <v-icon>mdi-eye</v-icon>
                                                    </v-btn>
                                                </template>
                                                <span>View Account</span>
                                            </v-tooltip>
                                        </template>
                                    </v-data-table>

                                    <v-tooltip bottom color="error">
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-btn
                                                v-show="
                                                    arenaData &&
                                                    arenaData.length > 0 &&
                                                    $gate.isAdmin()
                                                "
                                                :loading="downloadingReport"
                                                :disabled="downloadingReport"
                                                @click="truncate"
                                                color="red lighten-1"
                                                class="ma-2 white--text"
                                                v-bind="attrs"
                                                v-on="on"
                                            >
                                                Clear Data
                                                <v-icon right dark>
                                                    mdi-backspace
                                                </v-icon>
                                            </v-btn>
                                        </template>
                                        <span
                                            ><v-icon class="white--text"
                                                >mdi-alert-outline</v-icon
                                            >
                                            Please call admin/technical before
                                            to clear all data</span
                                        >
                                    </v-tooltip>
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
                                                -1, 10, 20, 30, 40, 50, 100,
                                            ],
                                        }"
                                        @toggle-select-all="selectAllToggle"
                                    >
                                      
                                        <template
                                            v-slot:[`item.actions`]="{ item }"
                                        >
                                            <v-tooltip top color="primary">
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
                        <!-- MULTIPLE DOWNLOAD  -->
                        <div
                            v-for="item in selected"
                            :key="item.codeEvent"
                        
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
                                        otherCommissionIntel05: numberFormat(
                                            item.otherCommissionIntel05 || 0
                                        ),
                                        consolidatorsCommission: numberFormat(
                                            item.consolidatorsCommission || 0
                                        ),
                                        paymentForOutstandingBalance:
                                            numberFormat(
                                                item.paymentForOutstandingBalance ||
                                                    0
                                            ),
                                        totalCommission: numberFormat(
                                            moneyFormat(
                                                numberUnformat(
                                                    numberFormat(
                                                        parseFloat(
                                                            item.totalCommission
                                                        ),
                                                        3
                                                    )
                                                )
                                            ) || 0
                                        ),
                                        mwTotalPercent: numberFormat(
                                            item.mwTwo || 0
                                        ),
                                        depositReplenish: numberFormat(
                                            moneyFormat(
                                                numberUnformat(
                                                    numberFormat(
                                                        parseFloat(
                                                            item.for_total
                                                        ),
                                                        3
                                                    )
                                                )
                                            ) || 0
                                        ),
                                        netWinLoss: numberFormat(
                                            item.netWinLoss || 0
                                        ),

                                        safetyFund: numberFormat(
                                            parseFloat(item.safetyFund) +
                                                parseFloat(
                                                    item.safetyFundMob
                                                ) || 0
                                        ),
                                        otherCommissionIntel05: numberFormat(
                                            parseFloat(
                                                item.otherCommissionIntel05
                                            ) +
                                                parseFloat(
                                                    item.otherCommIntMob
                                                ) || 0
                                        ),
                                        consolidatorsCommission: numberFormat(
                                            parseFloat(
                                                item.consolidatorsCommission
                                            ) +
                                                parseFloat(
                                                    item.consolCommMob
                                                ) || 0
                                        ),
                                        paymentForOutstandingBalance:
                                            numberFormat(
                                                parseFloat(
                                                    item.paymentForOutstandingBalance
                                                ) +
                                                    parseFloat(
                                                        item.payOutsBalMob
                                                    ) || 0
                                            ),
                                        netOpCommission: numberFormat(
                                            item.netOperatorsCommission || 0
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
                                                item.cashWithdrawal || 0
                                            ),
                                        },
                                    }"
                                    :computedAve="{
                                        depositReplenish: numberFormat(
                                            item.for_total || 0
                                        ),
                                        mwTotalPercent: numberFormat(
                                            item.mwTwo || 0
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
                                        drawMobileTotalPercent: numberFormat(
                                            item.drawTwoMobile || 0
                                        ),
                                        totalComputationOthers:
                                            item.exempted.toUpperCase() ===
                                                'NOT EXEMPTED' ||
                                            item.exempted.toUpperCase() ===
                                                'NOT'
                                                ? numberFormat(
                                                      item.totalOthers || 0
                                                  )
                                                : numberFormat(
                                                      item.totalCommission || 0
                                                  ),
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
                    </div>
                    <!-- </v-card> -->
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
                                                        computedAve
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
                                                    </v-row>

                                                    <v-row>

                                                    <span
                                                        v-if="
                                                            computedAve
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
                                                            computedAve.depositReplenishText
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
                                                        printDiv(
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
            <!-- PLEASE STAND BY -->

            <v-dialog v-model="dialog2" persistent width="400">
                <v-card
                    :color="progressvalue === 100 ? '#6BB3EF' : '#002050'"
                    dark
                >
                    <v-card-text>
                        {{
                            downloadingReport
                                ? "Downloading..."
                                : "Please stand by"
                        }}
                        <v-progress-linear
                            v-model="progressvalue"
                            :color="
                                progressvalue === 100 ? '#6BB3EF' : '#6BB3EF'
                            "
                            class="black--text"
                            :height="downloadingReport ? '14' : '9'"
                            :stream="downloadingReport"
                            :buffer-value="progressvalue"
                            :indeterminate="!downloadingReport"
                        >
                            <template
                                v-if="downloadingReport"
                                v-slot:default="{ value }"
                            >
                                <strong
                                    :class="[
                                        progressvalue > 50
                                            ? 'black--text'
                                            : 'white--text',
                                    ]"
                                    class="text-xs"
                                    >{{
                                        value === 100
                                            ? "Complete"
                                            : `${Math.ceil(value)}%`
                                    }}</strong
                                >
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
import { numberFormat, numberUnformat, moneyFormat } from "../utility";

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
import SignatoryBox from "./DialogPreview/SignatoryBox.vue";

import {
    imageDownload,
    readSoa,
    truncate,
    beforeDownload,
    defineEmail,
    defineContact,
    withStatus,
    reportGenerate,
    computationOpenSoa,
} from "../methods";

import ArenaModal from "./modal/ArenaModal.vue"
export default {
    components: {
        VueHtml2pdf,
        DateSOA,
        ArenaDetails,
        ComputeBox,
        BankBox,
        SignatoryBox,
        ArenaModal
    },
    data() {
        return {
            headers: [
                { text: "#", value: "id" },
                { text: "CODE", value: "areaCode" },
                { text: "ref", value: "refNo" },
                { text: "Arena Name", value: "arena_name" },

                { text: "", value: "actions", sortable: false },
            ],
            arenaItemsSelection: [
                { 
                    key: 'all',
                    text: 'Show All'
                },
                 { 
                    key: 'noArenaDetails',
                    text: 'No Arena Details'
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
            selectedItems: [],
            progressvalue: 0,
            arenaSample: [],
            switchPrepared: false,
            isExcel: false,
            menu: false,
            dates: [],
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

        onFileChange(event) {
            const { arenaReportFiltered, isExcel } = readSoa(
                event,
                this.isExcel
            );
            this.ocbsArrayFiltered = arenaReportFiltered;
            this.isExcel = isExcel;
        },

        proceedAction() {
            this.$Progress.start();
            if (
                $("#importData").val() === "" ||
                !this.fileUpload.name.includes("xlsx")
            ) {
                Fire.$emit("AfterCreate");
                Toast.fire({
                    icon: "warning",
                    title: "Make sure you insert correct excel data!",
                });
            } else {
                this.dialog2 = true;
                axios
                    .post("api/import", this.ocbsArrayFiltered)
                    .then(({ data }) => {
                        (this.dialog2 = false), $("#importData").val("");
                        Fire.$emit("AfterCreate");
                        Toast.fire(
                            "Successfully!",
                            "Excel Imported",
                            "success"
                        );
                        this.$Progress.finish();

                        this.fileUpload = null;
                        this.isExcel = false;
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
            const withStatusData = await withStatus();
            this.arenaDatastatus = withStatusData;
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

            this.arenaData = obj.data;
        },

         async loadDateRange() { // DATE RANGE
            console.log(this.dates)
            console.log(this.dates[0])
            const endDate = moment(this.dates[1], 'YYYY-MM-DD').add(1, 'days').format('YYYY-MM-DD')
            const depositReplenish = await axios.get(`api/importDateRange/${this.dates[0]}/${endDate}`)
            
            // const deposit = depositReplenish.data.soa.map(d => ({...d,date_of_soa: moment(d.date_of_soa, 'YYYY-MM-DD HH:mm:ss a').format('MMM DD YYYY LTS') }))
            // const reflenish = depositReplenish.data.fr.map(d => ({...d,date_of_soa: moment(d.date_of_soa, 'YYYY-MM-DD HH:mm:ss a').format('MMM DD YYYY LTS') }))
            this.arenaData = depositReplenish.data;
         

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

        clearFile(file) {
            console.log(file);
            this.isExcel = false;
            this.fileUpload = null;
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
            console.log(imgdl)

            if(imgdl.status === 200) {
                this.dialog = false;
                this.banks = [];
                this.arenaDetails = {};
          
                Fire.$emit("AfterCreate");
                swal.fire("convert to png!", "successfully", "success");
            }
          
            
               
            
        },
        async multiDownloads() {
            let statusArenas = [];
            this.downloadingReport = true;
            this.dialog2 = true;
            const divsss = document.querySelectorAll(".reportsoaoutput");
            const start = new Date();

            for (let i = 0; i < this.selected.length; i++) {
                this.progressvalue = Math.ceil(
                    (parseInt(i + 1) / parseInt(this.selected.length)) * 100
                );
                console.log(
                    `Currently at ${i}, ${(new Date() - start) / 1000} s`
                );
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
                    backgroundColor: "#ffffff",
                    scale: 0.9,
                });

                const link = document.createElement("a");
                link.download = `${this.selected[i].arena_name}.png`;
                link.href = canvas.toDataURL("image/png");
                document.body.appendChild(link);
                link.click();

                await setTimeout(() => {
                    document.body.removeChild(link); // On modern browsers you can use `tempLink.remove();`
                }, 500);

                if (this.selected.length - 1 === i) {
                    await axios.put("api/arenaStatus", statusArenas);
                    const c = this.arenaData.filter(
                        (arena) =>
                            !this.selected.find(
                                (select) => select.areaCode === arena.areaCode
                            )
                    );

                    this.arenaData = c;

                    setTimeout(async () => {
                        this.downloadingReport = false;
                        this.dialog2 = false;
                        console.log("done");
                        this.selected = [];
                    }, 1000);
                    this.importwithstatus();
                }
            }

            const end = new Date();
            console.log("Without promise.all ", (end - start) / 1000, " secs");
        },
        async downloadZip() {
            let statusArenas = [];
            this.downloadingReport = true;
            this.dialog2 = true;

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
                const c = this.arenaData.filter(
                    (arena) =>
                        !this.selected.find(
                            (select) => select.areaCode === arena.areaCode
                        )
                );

                this.arenaData = c;
                if (this.progressvalue === 100) {
                    setTimeout(async () => {
                        this.downloadingReport = false;
                        this.dialog2 = false;

                        console.log("done");
                        this.selected = [];
                    }, 1000);
                }
                this.importwithstatus();
            };
            // start benchmark
            const t = new Date();
            // some xml processing

            for (let i = 0; i < this.selected.length; i++) {
                statusArenas.push({
                    codeEvent: this.selected[i].codeEvent,
                    status: "done",
                });

                console.log(
                    `Currently at ${i}, ${(new Date() - t) / 1000} secs`
                );

                this.progressvalue = Math.ceil(
                    (parseInt(i + 1) / parseInt(this.selected.length)) * 100
                );

                const canvas = await html2canvas(divsss[i], {
                    onclone: function (clonedDoc) {
                        const elems =
                            clonedDoc.getElementsByClassName("reportsoaoutput");
                        for (let i = 0; i < elems.length; i++) {
                            elems[i].style.display = "block";
                        }
                    },
                    type: "dataURL",
                    backgroundColor: "#ffffff",
                    scale: 0.9,
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

        loadBankDetails() {
            axios.get("api/Companybanks").then(({ data }) => {
                this.bankAccounts = data;
            });
        },
        selectAllToggle(props) {
            let dis = 0;
            this.selectedItems = props.items;
            props.items.map((x) => {
                if (!x.arena_details) dis += 1;
            });
            if (this.selected.length != props.items.length - dis) {
                this.selected = [];
                const self = this;
                props.items.forEach((item) => {
                    if (item.arena_details) {
                        self.selected.push(item);
                    }
                });
            } else this.selected = [];
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
        
        handleFilterDate(dates){
            this.$refs.menu.save(dates);
            this.loadDateRange()
        },

        handleSelectionFilterArena(item){
            console.log(item)
            item === 'noArenaDetails' ? this.filterNoArenaDetails() : this.showData()
        },
        printDiv(divName) {
            this.dialog = false;
            const divContent = document.getElementById(divName)
            const printContents = divContent.innerHTML;
            const originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            window.location.reload()
        }
    },

    computed: {  
        dateRangeText () {
        const dateRange = this.dates.sort()
        return dateRange.join(' ~ ')
      },
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

            const totalCommIntel =
                numberUnformat(this.computation.otherCommissionIntel05) +
                numberUnformat(this.computation.otherCommIntMob);
            const totalConsolComm =
                numberUnformat(this.computation.consolidatorsCommission) +
                numberUnformat(this.computation.consolCommMob);
            const totalPayOutsBal =
                numberUnformat(this.computation.paymentForOutstandingBalance) +
                numberUnformat(this.computation.payOutsBalMob);
            const totalSafetyFund =
                numberUnformat(this.computation.safetyFund) +
                numberUnformat(this.computation.safetyFundMob);

            const totalComm =
                numberUnformat(netOpCommTotal) +
                numberUnformat(totalCommIntel || "0.00") -
                numberUnformat(totalConsolComm || "0.00") -
                numberUnformat(totalSafetyFund || "0.00") -
                numberUnformat(totalPayOutsBal || "0.00");

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
                this.computation.exempted.toUpperCase() === "NOT EXEMPTED" ||
                this.computation.exempted.toUpperCase() === "NOT"
                    ? numberFormat(totalOthers)
                    : numberFormat(this.computation.totalCommission); // to fixed

            const depositReplenish = numberFormat(
                numberUnformat(netWinLoss) -
                    numberUnformat(totalComputationOthers) -
                    numberUnformat(this.computation.systemErrorCOArmsi) +
                    (numberUnformat(this.computation.mobile.cashLoad) -
                        numberUnformat(this.computation.mobile.cashWithdrawal))
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

            const otherCommissionIntel05 = numberFormat(totalCommIntel);
            const consolidatorsCommission = numberFormat(totalConsolComm);
            const paymentForOutstandingBalance = numberFormat(totalPayOutsBal);

            const safetyFund = numberFormat(totalSafetyFund);
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
    async created() {
        await this.showData();
        this.importwithstatus();
       
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
