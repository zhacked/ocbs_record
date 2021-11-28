<template>
    <fragment>
        <v-row>
            <div
                class="d-flex my-2 px-1 py-1 flex-lg-row flex-md-column"
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
                                class="input-field_report computation"
                                v-model="computation.totalMWBet"
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
                                    class="input-field_report computation"
                                    v-model="computation.drawCancelled"
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
                                    class="input-field_report computation"
                                    v-model="computation.draw"
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
                                    class="input-field_report computation"
                                    v-model="computation.totalPayoutPaid"
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
                                    class="input-field_report computation"
                                    v-model="computation.cdPaid"
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
                                    class="input-field_report computation"
                                    v-model="computation.drawPaid"
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
                                    computation.netWinLoss
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
                                    computation.netWinLoss
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
                                    class="input-field_report computation"
                                    v-model="computation.unclaimed"
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
                                    class="input-field_report computation"
                                    v-model="computation.cUnpaid"
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
                                    class="input-field_report computation"
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
                                    class="input-field_report computation"
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
                                    class="input-field_report computation"
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
                                    class="input-field_report computation"
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
                                    class="input-field_report computation"
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
                                <span class="ctotal-text">0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </v-row>
        <v-row class="ma-0 pa-0" style="margin: 0; padding: 0">
            <v-col class="ma-0 pa-0" style="margin: 0; padding: 0">
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
                                class="input-field_report computation"
                                v-model="computation.mobile.totalMWBet"
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
                                class="input-field_report computation"
                                v-model="computation.mobile.totalDrawBet"
                            />
                        </div>
                    </div>
                </div>
            </v-col>
            <v-col class="ma-0 pa-0" style="margin: 0; padding: 0">
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
                                class="input-field_report computation"
                                v-model="computation.mobile.cashLoad"
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
                                class="input-field_report computation"
                                v-model="computation.mobile.cashWithdraw"
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
                        {{ computedAve.depositReplenishText.totalText }}:</span
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
            </v-col>
        </v-row>
    </fragment>
</template>

<script>
export default {
    name: "ComputeBox",
    props: {
        computedAve: Object,
        computation: Object,
        editmode: Boolean,
        commissionPercent: Number,
    },
};
</script>
