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
                    </v-card>
                </v-col>

                <!-- <v-col class="col-md-12"> -->
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
                                                                    <span
                                                                        >000,000.00</span
                                                                    >
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
                                                                    <span
                                                                        >dasdasd</span
                                                                    >
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
                                                                    <span
                                                                        >dasdasd</span
                                                                    >
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
                                                                    >Arena /
                                                                    OCBS
                                                                    Name:</span
                                                                >
                                                                 <div
                                                                    class="
                                                                        custom-span
                                                                        caption
                                                                        fullspan
                                                                        d-flex
                                                                        align-center
                                                                    "
                                                                    :class="{'editmode-span': editmode}"
                                                                >
                                                                    <input type="text" disabled class="input-field_report computation" placeholder="0"/>
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
                                                                    :class="{'editmode-span': editmode}"
                                                                >
                                                                    <input type="text" disabled class="input-field_report computation" placeholder="0"/>
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
                                                                    :class="{'editmode-span': editmode}"
                                                                >
                                                                    <input type="text" disabled class="input-field_report computation" placeholder="0"/>
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
                                                                    >Contact
                                                                    Number:</span
                                                                >
                                                                <div
                                                                    class="
                                                                        custom-span
                                                                        caption
                                                                        fullspan
                                                                        d-flex
                                                                        align-center
                                                                    "
                                                                    :class="{'editmode-span': editmode}"
                                                                >
                                                                    <input type="text" disabled class="input-field_report computation" placeholder="0"/>
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
                                                                    >Email
                                                                    Address:</span
                                                                >
                                                                <div
                                                                    class="
                                                                        custom-span
                                                                        caption
                                                                        fullspan
                                                                        d-flex
                                                                        align-center
                                                                    "
                                                                    :class="{'editmode-span': editmode}"
                                                                >
                                                                    <input type="text" disabled class="input-field_report computation" placeholder="0"/>
                                                                </div>
                                                            </div>
                                                        </v-col>
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
                                                    <v-row>
                                                        <div
                                                            class="
                                                                d-flex
                                                                my-2
                                                                px-1
                                                                py-1
                                                                flex-lg-row
                                                                flex-md-column
                                                              
                                                            "
                                                            style="margin-right: 7px; width: 100%; justify-content: space-between"
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
                                                                    <span
                                                                        >( Kiosk
                                                                        )</span
                                                                    >
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
                                                                        >Total
                                                                        M/W
                                                                        Bets:</span
                                                                    >
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
                                                                    
                                                                        <input type="text" disabled class="input-field_report computation" v-model="this
                                                                                .computation
                                                                                .totalMWBet"/>
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
                                                                        >Total
                                                                        Cancelled
                                                                        Bets:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                             :class="{'editmode-span': editmode}"
                                                                        >
                                                                          
                                                                              <input type="text" disabled class="input-field_report computation" v-model="this
                                                                                        .computation
                                                                                        .drawCancelled"/>
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
                                                                        >Total
                                                                        Draw
                                                                        Bets:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                             :class="{'editmode-span': editmode}"
                                                                        >
                                                                        
                                                                            <input type="text" disabled class="input-field_report computation" v-model="this
                                                                                        .computation
                                                                                        .draw"/>
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
                                                                        >Total
                                                                        Payout
                                                                        Paid:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            :class="{'editmode-span': editmode}"
                                                                        >
                                                                       
                                                                            <input type="text" disabled class="input-field_report computation" v-model="this
                                                                                        .computation
                                                                                        .totalPayoutPaid"/>
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
                                                                        >Total
                                                                        C/D
                                                                        Paid:</span
                                                                    >

                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            :class="{'editmode-span': editmode}"
                                                                        >
                                                                         
                                                                            <input type="text" disabled class="input-field_report computation" v-model="this
                                                                                        .computation
                                                                                        .cdPaid"/>
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
                                                                        >Total
                                                                        Draw
                                                                        Paid:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            :class="{'editmode-span': editmode}"
                                                                        >
                                                                       
                                                                             <input type="text" disabled class="input-field_report computation" v-model="this
                                                                                        .computation
                                                                                        .drawPaid"/>
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
                                                                        >Net
                                                                        Win/Loss:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                            bordertop
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                        >Net
                                                                        Win/Loss:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                            borderbottom
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                        >M/W*2%
                                                                        (kiosk):</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            <span
                                                                                >{{
                                                                                    computedAve.mwTotalPercent
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
                                                                        >Draw*2%
                                                                        (kiosk):</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            <span
                                                                                >{{
                                                                                    computedAve.drawTotalPercent
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
                                                                        >M/W*2%
                                                                        (mobile):</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            <span
                                                                                >{{
                                                                                    computedAve.mwMobileTotalPercent
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
                                                                        >Draw*2%
                                                                        (mobile):</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            <span
                                                                                >{{
                                                                                    computedAve.drawMobileTotalPercent
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
                                                                        >Total
                                                                        Unclaimed:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            :class="{'editmode-span': editmode}"
                                                                        >
                                                                            <span
                                                                                >{{
                                                                                    this
                                                                                        .computation
                                                                                        .unclaimed
                                                                                }}</span
                                                                            >
                                                                             <input type="text" disabled class="input-field_report computation" v-model="this
                                                                                        .computation
                                                                                        .unclaimed"/>
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
                                                                        >Total C
                                                                        Unpaid:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                             :class="{'editmode-span': editmode}"
                                                                        >
                                                                       

                                                                            <input type="text" disabled class="input-field_report computation" v-model="this
                                                                                        .computation
                                                                                        .cUnpaid"/>
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
                                                                        >Sales
                                                                        Deduction:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            :class="{'editmode-span': editmode}"
                                                                        >
                                                                            <input type="text" disabled class="input-field_report computation" value="0"/>
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
                                                                        >Net
                                                                        Operator's
                                                                        Commission:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            <span
                                                                                >{{
                                                                                    computedAve.netOpCommission
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
                                                                        >Other
                                                                        Commission
                                                                        -
                                                                        M:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            :class="{'editmode-span': editmode}"
                                                                        >
                                                                            <input type="text" disabled class="input-field_report computation" value="0"/>
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
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            :class="{'editmode-span': editmode}"
                                                                        >
                                                                            <input type="text" disabled class="input-field_report computation" value="0"/>
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
                                                                        >Safety
                                                                        Fund:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            :class="{'editmode-span': editmode}"
                                                                        >
                                                                            <input type="text" disabled class="input-field_report computation" value="0"/>
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
                                                                        >Payment
                                                                        for
                                                                        outstanding
                                                                        balance:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                                            :class="{'editmode-span': editmode}"
                                                                        >
                                                                            <input type="text" disabled class="input-field_report computation" value="0"/>
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
                                                                        >Total
                                                                        Commission:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            d-flex
                                                                            align-center
                                                                            computation-container_field
                                                                            bordertop
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                operation
                                                                            "
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
                                                        style="
                                                            margin: 0;
                                                            padding: 0;
                                                        "
                                                    >
                                                        <v-col
                                                            class="ma-0 pa-0"
                                                            style="
                                                                margin: 0;
                                                                padding: 0;
                                                            "
                                                        >
                                                            <div
                                                                class="
                                                                    d-flex
                                                                    justify-center
                                                                    align-center
                                                                    kiosk-mobile_text
                                                                "
                                                            >
                                                                <span
                                                                    >(Mobile)</span
                                                                >
                                                            </div>
                                                            <div
                                                                class="
                                                                    d-flex
                                                                    align-center
                                                                    justify-end
                                                                    computation-wrapper_field
                                                                "
                                                                style="
                                                                    margin-right: 2rem;
                                                                "
                                                            >
                                                                <span
                                                                    class="
                                                                        text-caption
                                                                        custom-label
                                                                    "
                                                                    >Total M/W
                                                                    Bets:</span
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
                                                                        :class="{'editmode-span': editmode}"
                                                                    >
                                                                     

                                                                         <input type="text" disabled class="input-field_report computation" v-model=" this
                                                                                .computation
                                                                                .mobile
                                                                                .totalMWBet"/>
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
                                                                style="
                                                                    margin-right: 2rem;
                                                                "
                                                            >
                                                                <span
                                                                    class="
                                                                        text-caption
                                                                        custom-label
                                                                    "
                                                                    >Total Draw
                                                                    Bets:</span
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
                                                                       :class="{'editmode-span': editmode}"
                                                                    >
                                                                     

                                                                         <input type="text" disabled class="input-field_report computation" v-model=" this
                                                                                .computation
                                                                                .mobile
                                                                                .totalDrawBet"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </v-col>
                                                        <v-col
                                                            class="ma-0 pa-0"
                                                            style="
                                                                margin: 0;
                                                                padding: 0;
                                                            "
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
                                                                    >Cash Load
                                                                    from
                                                                    Mobile:</span
                                                                >
                                                                <div
                                                                    class="
                                                                        d-flex
                                                                        align-center
                                                                        computation-container_field
                                                                    "
                                                                >
                                                                    <span
                                                                        class="
                                                                            operation
                                                                        "
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
                                                                       :class="{'editmode-span': editmode}"
                                                                    >
                                                                         <input type="text" disabled class="input-field_report computation" v-model="computedAve.cashLoad"/>
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
                                                                    >Cash
                                                                    Withdrawal
                                                                    from
                                                                    Mobile:</span
                                                                >
                                                                <div
                                                                    class="
                                                                        d-flex
                                                                        align-center
                                                                        computation-container_field
                                                                    "
                                                                >
                                                                    <span
                                                                        class="
                                                                            operation
                                                                        "
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
                                                                      :class="{'editmode-span': editmode}"
                                                                    >
                                                                         <input type="text" disabled class="input-field_report computation" v-model="computedAve.cashWithdraw"/>
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
                                                                    <span
                                                                        class="
                                                                            operation
                                                                        "
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
                                                                            class="
                                                                                ctotal-text
                                                                            "
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
                                                        <div
                                                            class="bank-wrapper"
                                                        >
                                                            <div
                                                                class="
                                                                    bank-headline
                                                                "
                                                            >
                                                                <span
                                                                    >Kindly
                                                                    deposit
                                                                    to:</span
                                                                >
                                                            </div>
                                                            <div
                                                                class="
                                                                    bank-container
                                                                "
                                                            >
                                                                <div
                                                                    class="
                                                                        bank
                                                                        bank1
                                                                    "
                                                                >
                                                                    <span
                                                                        >LUCKY 8
                                                                        STAR
                                                                        QUEST
                                                                        INC.</span
                                                                    >
                                                                    <span
                                                                        >PBB</span
                                                                    >
                                                                    <span
                                                                        >0050-1001-5156</span
                                                                    >
                                                                </div>
                                                                <div class="or">
                                                                    OR
                                                                </div>
                                                                <div
                                                                    class="
                                                                        bank
                                                                        bank2
                                                                    "
                                                                >
                                                                    <span
                                                                        >LUCKY 8
                                                                        STAR
                                                                        QUEST
                                                                        INC.</span
                                                                    >
                                                                    <span
                                                                        >PBB</span
                                                                    >
                                                                    <span
                                                                        >123-1232-1232</span
                                                                    >
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                                        <span
                                                                            class="
                                                                                sign-name
                                                                            "
                                                                            >Billy
                                                                            Joe
                                                                            Isidoro</span
                                                                        >

                                                                        <span
                                                                            >Quality
                                                                            Assurance
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
                                                                    <span
                                                                        >Prepared
                                                                        by:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            sign-container
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                sign-name
                                                                            "
                                                                            >Billy
                                                                            Joe
                                                                            Isidoro</span
                                                                        >

                                                                        <span
                                                                            >Quality
                                                                            Assurance
                                                                            Staff</span
                                                                        >
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
                                                                    <span
                                                                        >Checked
                                                                        by:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            sign-container
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                sign-name
                                                                            "
                                                                            >Billy
                                                                            Joe
                                                                            Isidoro</span
                                                                        >

                                                                        <span
                                                                            >Quality
                                                                            Assurance
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
                                                                    <span
                                                                        >Checked
                                                                        by:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            sign-container
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="
                                                                                sign-name
                                                                            "
                                                                            >Billy
                                                                            Joe
                                                                            Isidoro</span
                                                                        >
                                                                        <span
                                                                            >Quality
                                                                            Assurance
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
                                                   @click="editmode ? updateModal() : saveModal()"
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
                            <!--
                            <v-col class="cols-5 pa-0">
                                <v-card
                                    class="pa-4 overflow-auto report-preview"
                                    rounded="false"
                                    style="height: 100%"
                                    width="100%"
                                >
                                    <v-card-title class="text-h5 my-5">
                                        <span
                                            class="
                                                text-center
                                                font-weight-medium
                                            "
                                            >Computation</span
                                        >
                                        <v-spacer></v-spacer>

                                        <v-tooltip bottom>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
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
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    icon
                                                    color="red darken-2"
                                                    v-bind="attrs"
                                                    v-on="on"
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
                                                <v-btn
                                                    icon
                                                    color="blue"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                >
                                                    <v-icon size="22px"
                                                        >mdi-pencil-outline</v-icon
                                                    >
                                                </v-btn>
                                            </template>
                                            <span>Update Data</span>
                                        </v-tooltip>
                                        <v-tooltip bottom>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    icon
                                                    color="pink"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    @click="closeDialog"
                                                >
                                                    <v-icon>mdi-close</v-icon>
                                                </v-btn>
                                            </template>
                                            <span>Close</span>
                                        </v-tooltip>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    label="Commission"
                                                    placeholder="Enter Percentage"
                                                    outlined
                                                    
                                                    dense
                                                    clearable
                                                    class="mb-0"
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Total M/W Bets"
                                                    placeholder="0"
                                                    outlined
                                                    clearable
                                                    
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Total Cacelled Bets"
                                                    placeholder="0"
                                                    outlined
                                                    clearable
                                                    
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Total Draw Bets"
                                                    placeholder="0"
                                                    outlined
                                                    clearable
                                                    
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Total Payout Paid"
                                                    placeholder="0"
                                                    outlined
                                                    clearable
                                                    
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Total C/D Paid"
                                                    placeholder="0"
                                                    outlined
                                                    clearable
                                                    dense
                                                    
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Total Draw Paid"
                                                    placeholder="0"
                                                    outlined
                                                    
                                                    clearable
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Total Unclaimed"
                                                    placeholder="0"
                                                    outlined
                                                    clearable
                                                    
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Total C Unpaid"
                                                    placeholder="Enter Percentage"
                                                    outlined
                                                    clearable
                                                    
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Sales Deduction"
                                                    placeholder="0"
                                                    outlined
                                                    clearable
                                                    
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                          
                                          
                                            <v-col>
                                                <v-text-field
                                                    label="Other's Commission - M"
                                                    placeholder="0"
                                                    outlined
                                                    clearable
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Consolidator's Commission"
                                                    placeholder="0"
                                                    outlined
                                                    
                                                    clearable
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Safety Fund"
                                                    placeholder="0"
                                                    outlined
                                                    
                                                    clearable
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Payment for outstading balance"
                                                    placeholder="0"
                                                    outlined
                                                    
                                                    clearable
                                                    dense
                                                ></v-text-field>

                                                <h4 class="mt-4 pt-4">
                                                    M O B I L E
                                                </h4>
                                                <v-text-field
                                                    label="Total M/W Bets"
                                                    placeholder="0"
                                                    outlined
                                                    clearable
                                                    dense
                                                    
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Total Draw Bets"
                                                    placeholder="0"
                                                    outlined
                                                    clearable
                                                    
                                                    dense
                                                    value="0"
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Cash Load"
                                                    placeholder="0"
                                                    outlined
                                                    clearable
                                                    
                                                    dense
                                                ></v-text-field>
                                                <v-text-field
                                                    label="Cash Withdraw"
                                                    placeholder="0"
                                                    outlined
                                                    clearable
                                                    
                                                    dense
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <h4>B A N K</h4>
                                                <span class="no-gutters"
                                                    >Text Name</span
                                                >
                                                <v-autocomplete
                                                    ref="country"
                                                    v-model="bank_account"
                                                    outlined
                                                    dense
                                                    hide-details
                                                    hide-no-data
                                                    hide-selected
                                                    :rules="[
                                                        () =>
                                                            !!bank_account ||
                                                            'This field is required',
                                                    ]"
                                                    :items="bank_account"
                                                    label="Bank Details"
                                                    placeholder="Select..."
                                                    required
                                                ></v-autocomplete>
                                                <p>bank number</p>
                                            </v-col>
                                            <v-col></v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <label>Computed By:</label>
                                                <v-autocomplete
                                                    v-model="bank_account"
                                                    outlined
                                                    dense
                                                    :rules="[
                                                        () =>
                                                            !!bank_account ||
                                                            'This field is required',
                                                    ]"
                                                    hide-details
                                                    hide-no-data
                                                    clearable
                                                    hide-selected
                                                    :items="bank_account"
                                                    label="Bank Details"
                                                    placeholder="Select..."
                                                    required
                                                ></v-autocomplete>
                                                <label>Prepared By:</label>
                                                <v-autocomplete
                                                    v-model="bank_account"
                                                    outlined
                                                    dense
                                                    clearable
                                                    hide-details
                                                    hide-no-data
                                                    hide-selected
                                                    :rules="[
                                                        () =>
                                                            !!bank_account ||
                                                            'This field is required',
                                                    ]"
                                                    :items="bank_account"
                                                    label="Bank Details"
                                                    placeholder="Select..."
                                                    required
                                                ></v-autocomplete>
                                            </v-col>
                                            <v-col>
                                                <label>Checked By:</label>
                                                <v-autocomplete
                                                    v-model="bank_account"
                                                    outlined
                                                    dense
                                                    clearable
                                                    hide-details
                                                    hide-no-data
                                                    hide-selected
                                                    :rules="[
                                                        () =>
                                                            !!bank_account ||
                                                            'This field is required',
                                                    ]"
                                                    :items="bank_account"
                                                    label="Bank Details"
                                                    placeholder="Select..."
                                                    required
                                                ></v-autocomplete>
                                                <label>Checked By:</label>
                                                <v-autocomplete
                                                    v-model="bank_account"
                                                    outlined
                                                    dense
                                                    clearable
                                                    hide-details
                                                    hide-no-data
                                                    hide-selected
                                                    :rules="[
                                                        () =>
                                                            !!bank_account ||
                                                            'This field is required',
                                                    ]"
                                                    :items="bank_account"
                                                    label="Bank Details"
                                                    placeholder="Select..."
                                                    required
                                                ></v-autocomplete>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                            -->
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

export default {
    components: {
        VueHtml2pdf
    },
    data() {
        return {
            headers: [
                { text: "Arena Name", value: "arena_name" },
                { text: "Operator", value: "arena_details.operator" },
                { text: "Contact", value: "arena_details.contact_number" },
                { text: "", value: "actions", sortable: false },
            ],
            bank_account: ["test1", "test2"],
            dialog: false,
            notifications: false,
            sound: true,
            widgets: false,
            search: "",
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
        closeDialog() {
            this.dialog = false;
        },
        updateModal() {
            $(".computation").attr("disabled", false);
              $(".computation").addClass("input-show")
            this.editmode = !this.editmode;
        },
        closeDialog() {
            this.editmode = false;
            this.dialog = false;
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
            if ($("#importData").val() === "") {
                Fire.$emit("AfterCreate");
                swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="">Please contact developer</a>',
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
        // handleCommissionPercent(e) {
        //     this.commission_percent = e.target.value;
        // },
        openModel(data) {
            console.log(data);
            this.form.reset();
            this.dialog = true;
            $("#addNew").modal("show");

            this.form.fill(data.arena_details);
            this.arenaDetails = data.arena_details;
            this.arena_id = data.id;
            $(".computation").attr("disabled", true);
            // this.editmode = false;
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
