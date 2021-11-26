<template>
    <v-card class="overflow-y-auto overflow-x-hidden report-preview">
        <v-row>
            <v-col class="cols-12 pa-0">
                <v-card
                    class="pa-10 overflow-auto"
                    rounded="false"
                    style="height: 100%"
                >
                    <div>
                        <v-spacer></v-spacer>

                        <div style="position: absolute; right: 10px; top: 15px">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-chip
                                        small
                                        class="ma-2"
                                        close
                                        color="red"
                                        text-color="white"
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
                            <section slot="pdf-content" class="pdf-content">
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
                                        computedAve.depositReplenishText.title
                                    }}</span>
                                </v-card-title>
                                <v-card-text class="text-sm-body-2">
                                    <v-row>
                                        <v-spacer></v-spacer>
                                        <v-spacer></v-spacer>
                                        <v-col>
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    fieldDateNumber
                                                "
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        custom-label
                                                    "
                                                    >{{
                                                        computedAve
                                                            .depositReplenishText
                                                            .dateText
                                                    }}&nbsp;#</span
                                                >
                                                <div
                                                    class="
                                                        custom-span
                                                        caption
                                                        d-flex
                                                        align-center
                                                    "
                                                >
                                                    <span>000,000.00</span>
                                                </div>
                                            </div>
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    fieldDateNumber
                                                "
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        custom-label
                                                    "
                                                    >Date&nbsp;of&nbsp;{{
                                                        computedAve
                                                            .depositReplenishText
                                                            .dateText
                                                    }}:</span
                                                >
                                                <div
                                                    class="
                                                        custom-span
                                                        caption
                                                        d-flex
                                                        align-center
                                                    "
                                                >
                                                    <span>dasdasd</span>
                                                </div>
                                            </div>
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    fieldDateNumber
                                                "
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        custom-label
                                                    "
                                                    >Date&nbsp;of&nbsp;Event:</span
                                                >
                                                <div
                                                    class="
                                                        custom-span
                                                        caption
                                                        d-flex
                                                        align-center
                                                    "
                                                >
                                                    <span>dasdasd</span>
                                                </div>
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col>
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    arenaInfo
                                                "
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        custom-label
                                                        arenaLabel
                                                    "
                                                    >Arena / OCBS Name:</span
                                                >
                                                <div
                                                    class="
                                                        custom-span
                                                        caption
                                                        fullspan
                                                        d-flex
                                                        align-center
                                                    "
                                                    :class="{
                                                        'editmode-span':
                                                            editmode,
                                                    }"
                                                >
                                                    <input
                                                        type="text"
                                                        disabled
                                                        class="
                                                            input-field_report
                                                            computation
                                                        "
                                                        v-model="
                                                            arena_details.arena
                                                        "
                                                    />
                                                </div>
                                            </div>
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    arenaInfo
                                                "
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        custom-label
                                                        arenaLabel
                                                    "
                                                    >Address:</span
                                                >
                                                <div
                                                    class="
                                                        custom-span
                                                        caption
                                                        fullspan
                                                        d-flex
                                                        align-center
                                                    "
                                                    :class="{
                                                        'editmode-span':
                                                            editmode,
                                                    }"
                                                >
                                                    <input
                                                        type="text"
                                                        disabled
                                                        class="
                                                            input-field_report
                                                            computation
                                                        "
                                                        placeholder="0"
                                                    />
                                                </div>
                                            </div>
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    arenaInfo
                                                "
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        custom-label
                                                        arenaLabel
                                                    "
                                                    >Operator:</span
                                                >
                                                <div
                                                    class="
                                                        custom-span
                                                        caption
                                                        fullspan
                                                        d-flex
                                                        align-center
                                                    "
                                                    :class="{
                                                        'editmode-span':
                                                            editmode,
                                                    }"
                                                >
                                                    <input
                                                        type="text"
                                                        disabled
                                                        class="
                                                            input-field_report
                                                            computation
                                                        "
                                                        placeholder="0"
                                                    />
                                                </div>
                                            </div>
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    arenaInfo
                                                "
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        custom-label
                                                        arenaLabel
                                                    "
                                                    >Contact Number:</span
                                                >
                                                <div
                                                    class="
                                                        custom-span
                                                        caption
                                                        fullspan
                                                        d-flex
                                                        align-center
                                                    "
                                                    :class="{
                                                        'editmode-span':
                                                            editmode,
                                                    }"
                                                >
                                                    <input
                                                        type="text"
                                                        disabled
                                                        class="
                                                            input-field_report
                                                            computation
                                                        "
                                                        placeholder="0"
                                                    />
                                                </div>
                                            </div>
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    arenaInfo
                                                "
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        custom-label
                                                        arenaLabel
                                                    "
                                                    >Email Address:</span
                                                >
                                                <div
                                                    class="
                                                        custom-span
                                                        caption
                                                        fullspan
                                                        d-flex
                                                        align-center
                                                    "
                                                    :class="{
                                                        'editmode-span':
                                                            editmode,
                                                    }"
                                                >
                                                    <input
                                                        type="text"
                                                        disabled
                                                        class="
                                                            input-field_report
                                                            computation
                                                        "
                                                        placeholder="0"
                                                    />
                                                </div>
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <div class="computation-banner">
                                            Computation
                                        </div>
                                    </v-row>
                                    <v-row>
                                        <div
                                            class="
                                                d-flex
                                                my-2
                                                px-1
                                                py-1
                                                flex-lg-row flex-md-column
                                            "
                                            style="
                                                margin-right: 7px;
                                                width: 100%;
                                                justify-content: space-between;
                                            "
                                        >
                                            <div>
                                                <div
                                                    class="
                                                        d-flex
                                                        justify-center
                                                        align-center
                                                        kiosk-mobile_text
                                                    "
                                                >
                                                    <span>( Kiosk )</span>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Total M/W Bets:</span
                                                    >
                                                    <div
                                                        class="
                                                            custom-span
                                                            caption
                                                            computation-span
                                                            d-flex
                                                            align-center
                                                        "
                                                        :class="{
                                                            'editmode-span':
                                                                editmode,
                                                        }"
                                                    >
                                                        <input
                                                            type="text"
                                                            disabled="disabled"
                                                            class="
                                                                input-field_report
                                                                computation
                                                            "
                                                            v-model="
                                                                computation.totalMWBet
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Total Cancelled
                                                        Bets:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >+</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <input
                                                                type="text"
                                                                disabled
                                                                class="
                                                                    input-field_report
                                                                    computation
                                                                "
                                                                v-model="
                                                                    this
                                                                        .computation
                                                                        .drawCancelled
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Total Draw Bets:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >+</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <input
                                                                type="text"
                                                                disabled
                                                                class="
                                                                    input-field_report
                                                                    computation
                                                                "
                                                                v-model="
                                                                    this
                                                                        .computation
                                                                        .draw
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Total Payout
                                                        Paid:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >-</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <input
                                                                type="text"
                                                                disabled
                                                                class="
                                                                    input-field_report
                                                                    computation
                                                                "
                                                                v-model="
                                                                    this
                                                                        .computation
                                                                        .totalPayoutPaid
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Total C/D Paid:</span
                                                    >

                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >-</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <input
                                                                type="text"
                                                                disabled
                                                                class="
                                                                    input-field_report
                                                                    computation
                                                                "
                                                                v-model="
                                                                    this
                                                                        .computation
                                                                        .cdPaid
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Total Draw Paid:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >-</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <input
                                                                type="text"
                                                                disabled
                                                                class="
                                                                    input-field_report
                                                                    computation
                                                                "
                                                                v-model="
                                                                    this
                                                                        .computation
                                                                        .drawPaid
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            font-weight-bold
                                                            custom-label
                                                            ctotal-label
                                                        "
                                                        >Net Win/Loss:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                            bordertop
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >=</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                                computation-total
                                                            "
                                                        >
                                                            <span
                                                                class="
                                                                    ctotal-text
                                                                "
                                                                >{{
                                                                    this
                                                                        .computation
                                                                        .netWinLoss
                                                                }}</span
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            font-weight-bold
                                                            custom-label
                                                            ctotal-label
                                                        "
                                                        >Net Win/Loss:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                            borderbottom
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >=</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                                computation-total
                                                            "
                                                        >
                                                            <span
                                                                class="
                                                                    ctotal-text
                                                                "
                                                                >{{
                                                                    this
                                                                        .computation
                                                                        .netWinLoss
                                                                }}</span
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >M/W*{{
                                                            commission_percent *
                                                            100
                                                        }}% (kiosk):</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >+</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                        >
                                                            <span>{{
                                                                computedAve.mwTotalPercent
                                                            }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Draw*{{
                                                            commission_percent *
                                                            100
                                                        }}% (kiosk):</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >+</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                        >
                                                            <span>{{
                                                                computedAve.drawTotalPercent
                                                            }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >M/W*{{
                                                            commission_percent *
                                                            100
                                                        }}% (mobile):</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >+</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                        >
                                                            <span>{{
                                                                computedAve.mwMobileTotalPercent
                                                            }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Draw*{{
                                                            commission_percent *
                                                            100
                                                        }}% (mobile):</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >+</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                        >
                                                            <span>{{
                                                                computedAve.drawMobileTotalPercent
                                                            }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Total Unclaimed:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >+</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <input
                                                                type="text"
                                                                disabled
                                                                class="
                                                                    input-field_report
                                                                    computation
                                                                "
                                                                v-model="
                                                                    this
                                                                        .computation
                                                                        .unclaimed
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Total C Unpaid:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >+</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <input
                                                                type="text"
                                                                disabled
                                                                class="
                                                                    input-field_report
                                                                    computation
                                                                "
                                                                v-model="
                                                                    this
                                                                        .computation
                                                                        .cUnpaid
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Sales Deduction:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >-</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <input
                                                                type="text"
                                                                disabled
                                                                class="
                                                                    input-field_report
                                                                    computation
                                                                "
                                                                value="0"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            font-weight-bold
                                                            custom-label
                                                            ctotal-label
                                                        "
                                                        >Net Operator's
                                                        Commission:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >=</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                        >
                                                            <span>{{
                                                                computedAve.netOpCommission
                                                            }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Other Commission -
                                                        M:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >+</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <input
                                                                type="text"
                                                                disabled
                                                                class="
                                                                    input-field_report
                                                                    computation
                                                                "
                                                                value="0"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Consolidator's
                                                        Commission:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >-</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <input
                                                                type="text"
                                                                disabled
                                                                class="
                                                                    input-field_report
                                                                    computation
                                                                "
                                                                value="0"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Safety Fund:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >-</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <input
                                                                type="text"
                                                                disabled
                                                                class="
                                                                    input-field_report
                                                                    computation
                                                                "
                                                                value="0"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            custom-label
                                                        "
                                                        >Payment for outstanding
                                                        balance:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >-</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <input
                                                                type="text"
                                                                disabled
                                                                class="
                                                                    input-field_report
                                                                    computation
                                                                "
                                                                value="0"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        justify-end
                                                        computation-wrapper_field
                                                    "
                                                >
                                                    <span
                                                        class="
                                                            text-caption
                                                            font-weight-bold
                                                            custom-label
                                                            ctotal-label
                                                        "
                                                        >Total Commission:</span
                                                    >
                                                    <div
                                                        class="
                                                            d-flex
                                                            align-center
                                                            computation-container_field
                                                            bordertop
                                                        "
                                                    >
                                                        <span class="operation"
                                                            >=</span
                                                        >
                                                        <div
                                                            class="
                                                                custom-span
                                                                caption
                                                                computation-span
                                                                d-flex
                                                                align-center
                                                                computation-total
                                                            "
                                                        >
                                                            <span
                                                                class="
                                                                    ctotal-text
                                                                "
                                                                >0.00</span
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </v-row>
                                    <v-row
                                        class="ma-0 pa-0"
                                        style="margin: 0; padding: 0"
                                    >
                                        <v-col
                                            class="ma-0 pa-0"
                                            style="margin: 0; padding: 0"
                                        >
                                            <div
                                                class="
                                                    d-flex
                                                    justify-center
                                                    align-center
                                                    kiosk-mobile_text
                                                "
                                            >
                                                <span>(Mobile)</span>
                                            </div>
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    justify-end
                                                    computation-wrapper_field
                                                "
                                                style="margin-right: 2rem"
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        custom-label
                                                    "
                                                    >Total M/W Bets:</span
                                                >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        computation-container_field
                                                    "
                                                >
                                                    <div
                                                        class="
                                                            custom-span
                                                            caption
                                                            computation-span
                                                            d-flex
                                                            align-center
                                                        "
                                                        :class="{
                                                            'editmode-span':
                                                                editmode,
                                                        }"
                                                    >
                                                        <input
                                                            type="text"
                                                            disabled
                                                            class="
                                                                input-field_report
                                                                computation
                                                            "
                                                            v-model="
                                                                this.computation
                                                                    .mobile
                                                                    .totalMWBet
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    justify-end
                                                    computation-wrapper_field
                                                "
                                                style="margin-right: 2rem"
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        custom-label
                                                    "
                                                    >Total Draw Bets:</span
                                                >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        computation-container_field
                                                    "
                                                >
                                                    <div
                                                        class="
                                                            custom-span
                                                            caption
                                                            computation-span
                                                            d-flex
                                                            align-center
                                                        "
                                                        :class="{
                                                            'editmode-span':
                                                                editmode,
                                                        }"
                                                    >
                                                        <input
                                                            type="text"
                                                            disabled
                                                            class="
                                                                input-field_report
                                                                computation
                                                            "
                                                            v-model="
                                                                this.computation
                                                                    .mobile
                                                                    .totalDrawBet
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </v-col>
                                        <v-col
                                            class="ma-0 pa-0"
                                            style="margin: 0; padding: 0"
                                        >
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    justify-end
                                                    computation-wrapper_field
                                                "
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        custom-label
                                                    "
                                                    >Cash Load from
                                                    Mobile:</span
                                                >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        computation-container_field
                                                    "
                                                >
                                                    <span class="operation"
                                                        >+</span
                                                    >
                                                    <div
                                                        class="
                                                            custom-span
                                                            caption
                                                            computation-span
                                                            d-flex
                                                            align-center
                                                        "
                                                        :class="{
                                                            'editmode-span':
                                                                editmode,
                                                        }"
                                                    >
                                                        <input
                                                            type="text"
                                                            disabled
                                                            class="
                                                                input-field_report
                                                                computation
                                                            "
                                                            v-model="
                                                                computation
                                                                    .mobile
                                                                    .cashLoad
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    justify-end
                                                    computation-wrapper_field
                                                "
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        custom-label
                                                    "
                                                    >Cash Withdrawal from
                                                    Mobile:</span
                                                >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        computation-container_field
                                                    "
                                                >
                                                    <span class="operation"
                                                        >-</span
                                                    >
                                                    <div
                                                        class="
                                                            custom-span
                                                            caption
                                                            computation-span
                                                            d-flex
                                                            align-center
                                                        "
                                                        :class="{
                                                            'editmode-span':
                                                                editmode,
                                                        }"
                                                    >
                                                        <input
                                                            type="text"
                                                            disabled
                                                            class="
                                                                input-field_report
                                                                computation
                                                            "
                                                            v-model="
                                                                computation
                                                                    .mobile
                                                                    .cashWithdraw
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="
                                                    d-flex
                                                    align-center
                                                    justify-end
                                                    computation-wrapper_field
                                                "
                                            >
                                                <span
                                                    class="
                                                        text-caption
                                                        font-weight-bold
                                                        custom-label
                                                        ctotal-label
                                                    "
                                                    >For
                                                    {{
                                                        computedAve
                                                            .depositReplenishText
                                                            .totalText
                                                    }}:</span
                                                >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-center
                                                        computation-container_field
                                                        bordertop
                                                    "
                                                >
                                                    <span class="operation"
                                                        >=</span
                                                    >
                                                    <div
                                                        class="
                                                            custom-span
                                                            caption
                                                            computation-span
                                                            d-flex
                                                            align-center
                                                            overtotal
                                                        "
                                                    >
                                                        <span
                                                            class="ctotal-text"
                                                            >{{
                                                                computedAve.depositReplenish
                                                            }}</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <div class="bank-wrapper">
                                            <div class="bank-headline">
                                                <span>Kindly deposit to:</span>
                                            </div>
                                            <div class="bank-container">
                                                <div class="bank bank1">
                                                    <span
                                                        >LUCKY 8 STAR QUEST
                                                        INC.</span
                                                    >
                                                    <span>PBB</span>
                                                    <span>0050-1001-5156</span>
                                                </div>
                                                <div class="or">OR</div>
                                                <div class="bank bank2">
                                                    <span
                                                        >LUCKY 8 STAR QUEST
                                                        INC.</span
                                                    >
                                                    <span>PBB</span>
                                                    <span>123-1232-1232</span>
                                                </div>
                                            </div>
                                        </div>
                                    </v-row>
                                    <v-row>
                                        <v-col>
                                            <v-row>
                                                <div class="sign-wrapper">
                                                    <span>Computed by:</span>
                                                    <div class="sign-container">
                                                        <span
                                                            class="
                                                                select-field_container
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <select
                                                                class="
                                                                    sign-name
                                                                    select-field_report
                                                                "
                                                            >
                                                                <option>
                                                                    Billy Joe
                                                                    Isidoro
                                                                </option>
                                                                <option>
                                                                    Billy
                                                                    Joesdsad
                                                                    Isidoro
                                                                </option>
                                                                <option>
                                                                    Billy Joe
                                                                    Isidadsdsoro
                                                                </option>
                                                            </select>
                                                        </span>

                                                        <span
                                                            class="signed-title"
                                                            >Quality Assurance
                                                            Staff</span
                                                        >
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
                                                    <span>Prepared by:</span>
                                                    <div class="sign-container">
                                                        <span
                                                            class="
                                                                select-field_container
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <select
                                                                class="
                                                                    sign-name
                                                                    select-field_report
                                                                "
                                                            >
                                                                <option>
                                                                    Billy Joe
                                                                    Isidoro
                                                                </option>
                                                            </select>
                                                        </span>

                                                        <span
                                                            class="signed-title"
                                                            >Quality Assurance
                                                            Staff</span
                                                        >
                                                    </div>
                                                </div>
                                            </v-row>
                                        </v-col>
                                        <v-col>
                                            <v-row>
                                                <div class="sign-wrapper">
                                                    <span class="mr-2"
                                                        >Checked by:</span
                                                    >
                                                    <div class="sign-container">
                                                        <span
                                                            class="
                                                                select-field_container
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <select
                                                                class="
                                                                    sign-name
                                                                    select-field_report
                                                                "
                                                            >
                                                                <option>
                                                                    Billy Joe
                                                                    Isidoro
                                                                </option>
                                                            </select>
                                                        </span>

                                                        <span
                                                            class="signed-title"
                                                            >Quality Assurance
                                                            Staff</span
                                                        >
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
                                                    <span>Checked by:</span>
                                                    <div class="sign-container">
                                                        <span
                                                            class="
                                                                select-field_container
                                                            "
                                                            :class="{
                                                                'editmode-span':
                                                                    editmode,
                                                            }"
                                                        >
                                                            <select
                                                                class="
                                                                    sign-name
                                                                    select-field_report
                                                                "
                                                            >
                                                                <option>
                                                                    Billy Joe
                                                                    Isidoro
                                                                </option>
                                                            </select>
                                                        </span>

                                                        <span
                                                            class="signed-title"
                                                            >Quality Assurance
                                                            Staff</span
                                                        >
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
                            <label class="mr-2"
                                >Commission Percent ({{
                                    commission_percent * 100
                                }}%) :</label
                            >
                            <div
                                class="
                                    custom-span
                                    caption
                                    computation-span
                                    d-flex
                                    align-center
                                "
                                :class="{ 'editmode-span': editmode }"
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
                            <template v-slot:activator="{ on, attrs }">
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
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    v-show="!editmode"
                                    icon
                                    color="red darken-2"
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="generateReport"
                                >
                                    <v-icon>mdi-file-pdf-box</v-icon>
                                </v-btn>
                            </template>
                            <span>Download as PDF</span>
                        </v-tooltip>

                        <v-divider vertical></v-divider>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-chip
                                    class="ma-2"
                                    :color="!editmode ? 'blue' : 'green'"
                                    small
                                    outlined
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="
                                        !editmode ? updateModal() : saveModal()
                                    "
                                >
                                    {{ editmode ? "Save" : "Update" }}

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
</template>

<script>
import VueHtml2pdf from "vue-html2pdf";
import html2canvas from "html2canvas";
export default {
    name: "preview-soa",
    props: {
        computation: Object,
        computedAve: Object,
    },
    components: {
        VueHtml2pdf,
    },
    data() {
        return {
            computed: {},
            checked: {},
            prepared: {},
            computed_by: "",
            checked_by_1: "",
            checked_by_2: "",
            prepared_by: "",
            bank_details: "",
            dialog: false,
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
    method: {
        updateModal() {
            $(".computation").attr("disabled", false);
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

            this.editmode = !this.editmode;
        },
        closeDialog() {
            this.editmode = !this.editmode;
            this.dialog = false;
        },

        saveModal() {
            $(".computation").attr("disabled", true);
            this.editmode = !this.editmode;
            console.log(this.editmode);

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
                totalMWBetPercent: numberFormat(
                    this.computation.totalMWBetPercent
                ),
                operatorExpenses: numberFormat(
                    this.computation.operatorExpenses
                ),
                mobile: {
                    cashLoad: numberFormat(this.computation.mobile.cashLoad),
                    cashWithdraw: numberFormat(
                        this.computation.mobile.cashWithdraw
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

        openModel(data) {
            console.log(data);
            this.form.reset();
            this.dialog = true;
            $("#addNew").modal("show");
            //  $(".computation").attr("disabled", false);
            // this.editmode = !this.editmode;

            this.form.fill(data.arena_details);
            this.arenaDetails = data.arena_details;
            this.arena_id = data.id;

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
                    cashLoad: numberFormat(this.computation.mobile.cashLoad),
                    cashWithdraw: numberFormat(
                        this.computation.mobile.cashWithdraw
                    ),
                    totalMWBet: numberFormat(totalMobileMWBets),
                    totalDrawBet: numberFormat(totalMobileDrawBets),
                },
            };
        },
        generateReport() {
            this.$refs.html2Pdf.generatePdf();
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
};
</script>
