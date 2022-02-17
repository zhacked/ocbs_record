<template>
    <v-col>
        <v-row class="row-compute">
            <div class="compute-container-box">
                <div>
                    <div
                        class="d-flex justify-center align-center kiosk-mobile_text"
                    >
                        <span>( Kiosk )</span>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label">Total M/W Bets:</span>
                        <div
                            class="custom-span computation-span d-flex align-center"
                            :class="{ 'editmode-span': editmode }"
                        >
                            <span>{{ computation.totalMWBets }}</span>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label">Total Cancelled Bets:</span>
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">+</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{ computation.drawCancelled }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label">Total Draw Bets:</span>
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">+</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{ computation.draw }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label">Total Payout Paid:</span>
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">-</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{ computation.totalPayoutPaid }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label">Total C/D Paid:</span>

                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">-</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{ computation.cdPaid }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label">Total Draw Paid:</span>
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">-</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                            >
                                <!-- <input
                                    type="text"
                                    disabled
                                    class="input-field_report computation comp"
                                    v-model="computation.drawPaid"
                                    @focus="handleCleanZeroOnFocus($event)"
                                    @blur="handleCleanZeroOnBlur($event)"
                                /> -->

                                <span>{{ computation.drawPaid }}</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="font-weight-bold custom-label ctotal-label"
                            >Net Win/Loss:</span
                        >
                        <div
                            class="d-flex align-center computation-container_field bordertop"
                        >
                            <span class="operation">=</span>
                            <div
                                class="custom-span computation-span d-flex align-center computation-total"
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
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="font-weight-bold custom-label ctotal-label"
                            >Net Win/Loss:</span
                        >
                        <div
                            class="d-flex align-center computation-container_field borderbottom computation"
                        >
                            <span class="operation">=</span>
                            <div
                                class="custom-span computation-span d-flex align-center computation-total"
                            >
                                <span class="ctotal-text">{{
                                    computation.netWinLoss
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label"
                            >M/W*{{ commissionPercent * 100 }}% (kiosk):</span
                        >
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">+</span>
                            <div
                                class="custom-span computation-span d-flex align-center computation"
                            >
                                <span>{{ computedAve.mwTotalPercent }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label"
                            >Draw*{{ commissionPercent * 100 }}% (kiosk):</span
                        >
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">+</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                            >
                                <span>{{ computedAve.drawTotalPercent }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label"
                            >M/W*{{ commissionPercent * 100 }}% (mobile):</span
                        >
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">+</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                            >
                                <span>{{
                                    computedAve.mwMobileTotalPercent
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label"
                            >Draw*{{ commissionPercent * 100 }}% (mobile):</span
                        >
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">+</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                            >
                                <span>{{
                                    computedAve.drawMobileTotalPercent
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label">Total Unclaimed:</span>
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">+</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{ computation.unclaimed }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label">Total C Unpaid:</span>
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">+</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{ computation.cUnpaid }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label">Sales Deduction:</span>
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">-</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{ computation.salesDeduction }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="font-weight-bold custom-label ctotal-label"
                            >Net Operator's Commission:</span
                        >
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">=</span>
                            <div
                                class="custom-span computation-span d-flex align-center computation-total"
                            >
                                <span>{{ computation.netOpCommission }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label">Other Commission - M:</span>
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">+</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{
                                    computation.otherCommissionIntel05
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label"
                            >Consolidator's Commission:</span
                        >
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">-</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{
                                    computation.consolidatorsCommission
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label">Safety Fund:</span>
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">-</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{ computation.safetyFund }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label"
                            >Payment for outstanding balance:</span
                        >
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">-</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{
                                    computation.paymentForOutstandingBalance
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="font-weight-bold custom-label ctotal-label"
                            >Total Commission:</span
                        >
                        <div
                            class="d-flex align-center computation-container_field bordertop"
                        >
                            <span class="operation">=</span>
                            <div
                                class="custom-span computation-span d-flex align-center computation-total"
                            >
                                <span class="ctotal-text">{{
                                    computation.totalCommission
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </v-row>
        <v-row class="row-compute">
            <div class="d-flex mobile-computebox">
                <div>
                    <div
                        class="d-flex justify-center align-center kiosk-mobile_text"
                    >
                        <span>(Mobile)</span>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                        style="margin-right: 2rem"
                    >
                        <span class="custom-label">Total M/W Bets:</span>
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{
                                    computation.mobile.totalMWBets
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                        style="margin-right: 2rem"
                    >
                        <span class="custom-label">Total Draw Bets:</span>
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{
                                    computation.mobile.totalDrawBets
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ma-0 pa-0" style="margin: 0; padding: 0">
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label">Cash Load from Mobile:</span>
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">+</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{ computation.mobile.cashLoad }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="custom-label"
                            >Cash Withdrawal from Mobile:</span
                        >
                        <div
                            class="d-flex align-center computation-container_field"
                        >
                            <span class="operation">-</span>
                            <div
                                class="custom-span computation-span d-flex align-center"
                                :class="{ 'editmode-span': editmode }"
                            >
                                <span>{{
                                    computation.mobile.cashWithdrawal
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-center justify-end computation-wrapper_field"
                    >
                        <span class="font-weight-bold custom-label ctotal-label"
                            >For {{ depositReplenishTxt.totalText }}:</span
                        >
                        <div
                            class="d-flex align-center computation-container_field bordertop"
                        >
                            <span class="operation">=</span>
                            <div
                                class="custom-span computation-span d-flex align-center overtotal"
                            >
                                <span class="ctotal-text">{{
                                    computation.depositReplenish
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </v-row>
    </v-col>
</template>

<script>
export default {
    name: "ComputeBox",
    props: {
        computation: Object,
        computedAve: Object,
        editmode: Boolean,
        commissionPercent: Number,
        depositReplenishTxt: Object,
    },
};
</script>
