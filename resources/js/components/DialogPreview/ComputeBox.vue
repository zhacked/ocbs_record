<template>
    <fragment>
        <v-row>
            <div
                class="d-flex mt-1 mb-0 px-1 py-1"
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
                        <span class="text-caption custom-label"
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
                            :class="{ 'editmode-span': editmode }"
                        >
                            <input
                                type="text"
                                disabled="disabled"
                                class="input-field_report computation comp"
                                v-model="computation.totalMWBets"
                                @focus="handleCleanZeroOnFocus($event)"
                                @blur="handleCleanZeroOnBlur($event)"
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
                        <span class="text-caption custom-label"
                            >Total Cancelled Bets:</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">+</span>
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
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.drawCancelled"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
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
                        <span class="text-caption custom-label"
                            >Total Draw Bets:</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">+</span>
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
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.draw"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
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
                        <span class="text-caption custom-label"
                            >Total Payout Paid:</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">-</span>
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
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.totalPayoutPaid"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
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
                        <span class="text-caption custom-label"
                            >Total C/D Paid:</span
                        >

                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">-</span>
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
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.cdPaid"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
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
                        <span class="text-caption custom-label"
                            >Total Draw Paid:</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">-</span>
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
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.drawPaid"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
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
                            <span class="operation">=</span>
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
                                <span class="ctotal-text">{{
                                    computedAve.netWinLoss
                                }}</span>
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
                            <span class="operation">=</span>
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
                                <span class="ctotal-text">{{
                                     computedAve.netWinLoss
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
                        <span class="text-caption custom-label"
                            >M/W*{{ commissionPercent * 100 }}% (kiosk):</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">+</span>
                            <div
                                class="
                                    custom-span
                                    caption
                                    computation-span
                                    d-flex
                                    align-center
                                "
                            >
                                <span>{{ computedAve.mwTotalPercent }}</span>
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
                        <span class="text-caption custom-label"
                            >Draw*{{ commissionPercent * 100 }}% (kiosk):</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">+</span>
                            <div
                                class="
                                    custom-span
                                    caption
                                    computation-span
                                    d-flex
                                    align-center
                                "
                            >
                                <span>{{ computedAve.drawTotalPercent }}</span>
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
                        <span class="text-caption custom-label"
                            >M/W*{{ commissionPercent * 100 }}% (mobile):</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">+</span>
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
                        <span class="text-caption custom-label"
                            >Draw*{{ commissionPercent * 100 }}% (mobile):</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">+</span>
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
                        <span class="text-caption custom-label"
                            >Total Unclaimed:</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">+</span>
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
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.unclaimed"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
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
                        <span class="text-caption custom-label"
                            >Total C Unpaid:</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">+</span>
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
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.cUnpaid"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
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
                        <span class="text-caption custom-label"
                            >Sales Deduction:</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">-</span>
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
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.salesDeduction"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
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
                            >Net Operator's Commission:</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">=</span>
                            <div
                                class="
                                    custom-span
                                    caption
                                    computation-span
                                    d-flex
                                    align-center
                                "
                            >
                                <span>{{ computedAve.netOpCommission }}</span>
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
                        <span class="text-caption custom-label"
                            >Other Commission - M:</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">+</span>
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
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.otherCommissionIntel05"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
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
                        <span class="text-caption custom-label"
                            >Consolidator's Commission:</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">-</span>
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
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.consolidatorsCommission"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
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
                        <span class="text-caption custom-label"
                            >Safety Fund:</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">-</span>
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
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.safetyFund"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
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
                        <span class="text-caption custom-label"
                            >Payment for outstanding balance:</span
                        >
                        <div
                            class="
                                d-flex
                                align-center
                                computation-container_field
                            "
                        >
                            <span class="operation">-</span>
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
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.paymentForOutstandingBalance"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
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
                            <span class="operation">=</span>
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
                                <span class="ctotal-text">{{computedAve.totalComputationOthers}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </v-row>
        <v-row class="ma-0 pa-0" style="margin: 0; padding: 0">
          <div
                class="d-flex my-2 py-1"
                style="
                    margin-right: 0px;
                    width: 100%;
                    justify-content: space-between;
                "
            >
            <div>
                <div
                    class="d-flex justify-center align-center kiosk-mobile_text"
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
                    <span class="text-caption custom-label"
                        >Total M/W Bets:</span
                    >
                    <div
                        class="d-flex align-center computation-container_field"
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
                                disabled
                                class="input-field_report computation comp"
                                v-model="computation.mobile.totalMWBets"
                                @focus="handleCleanZeroOnFocus($event)"
                                @blur="handleCleanZeroOnBlur($event)"
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
                    <span class="text-caption custom-label"
                        >Total Draw Bets:</span
                    >
                    <div
                        class="d-flex align-center computation-container_field"
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
                                disabled
                                class="input-field_report computation comp"
                                v-model="computation.mobile.totalDrawBets"
                                 @focus="handleCleanZeroOnFocus($event)"
                                @blur="handleCleanZeroOnBlur($event)"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="ma-0 pa-0" style="margin: 0; padding: 0">
                <div
                    class="
                        d-flex
                        align-center
                        justify-end
                        computation-wrapper_field
                    "
                >
                    <span class="text-caption custom-label"
                        >Cash Load from Mobile:</span
                    >
                    <div
                        class="d-flex align-center computation-container_field"
                    >
                        <span class="operation">+</span>
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
                                disabled
                                class="input-field_report computation comp"
                                v-model="computation.mobile.cashLoad"
                                @focus="handleCleanZeroOnFocus($event)"
                                @blur="handleCleanZeroOnBlur($event)"
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
                    <span class="text-caption custom-label"
                        >Cash Withdrawal from Mobile:</span
                    >
                    <div
                        class="d-flex align-center computation-container_field"
                    >
                        <span class="operation">-</span>
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
                                disabled
                                class="input-field_report computation comp"
                                v-model="computation.mobile.cashWithdrawal"
                                @focus="handleCleanZeroOnFocus($event)"
                                @blur="handleCleanZeroOnBlur($event)"
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
                        {{ depositReplenishTxt.totalText }}:</span
                    >
                    <div
                        class="
                            d-flex
                            align-center
                            computation-container_field
                            bordertop
                        "
                    >
                        <span class="operation">=</span>
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
                            <span class="ctotal-text">{{
                                computedAve.depositReplenish
                            }}</span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </v-row>
    </fragment>
</template>

<script>
import {
    numberFormat,
    numberUnformat,
 
} from "../../utility";
export default {
    name: "ComputeBox",
    props: {
        
        computation: Object,
        computedAve: Object,
        editmode: Boolean,
        commissionPercent: Number,
        depositReplenishTxt: Object
    },
    methods: {
        handleCleanZeroOnFocus(event) {
            // const targetEvent = {[event.target.name]: event.target.value};
            
            if(event.target.value === "0") event.target.value = ""
                

            return numberUnformat(event.target.value)
        },
        handleCleanZeroOnBlur(event) {
            
            if(event.target.value === "") event.target.value = 0
                
        },
    }
};
</script>
