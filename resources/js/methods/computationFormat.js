const computationSoa = (data) => {
    const totalMWBets = data.total_meron_wala;
    const drawCancelled = data.draw_cancelled;
    const totalPayoutPaid = data.total_payout_paid;
    const cdPaid = data.draw_cancelled_paid;
    const drawPaid = data.draw_paid;
    const cUnpaid = data.cancelled_unpaid;
    const salesDeduction = data.salesDeductionTablet;
    const otherCommissionIntel05 = data.otherCommissionIntel05;
    const totalMWMobile = data.total_win_mobile;
    const drawMobile = data.draw_mobile;
    const depositReplenish = data.for_total;
    const totalCommission = data.totalCommission;
    const netOpCommission = data.netOperatorsCommission;
    const consolidatorsCommission = data.consolidatorsCommission;
    const paymentForOutstandingBalance = data.paymentForOutstandingBalance;
    const safetyFund = data.safetyFund;
    const safetyFundMob = data.safetyFundMob;
    const otherCommIntMob = data.otherCommIntMob;
    const consolCommMob = data.consolCommMob;
    const payOutsBalMob = data.payOutsBalMob;
    const totalSafetyFund = parseFloat(safetyFund) + parseFloat(safetyFundMob);
    const totalOtherCommIntel =
        parseFloat(otherCommissionIntel05) + parseFloat(otherCommIntMob);
    const totalConsolComm =
        parseFloat(consolidatorsCommission) + parseFloat(consolCommMob);
    const totalPayOutBal =
        parseFloat(paymentForOutstandingBalance) + parseFloat(payOutsBalMob);
    const computation = {
        totalMWBets,
        drawCancelled,
        totalPayoutPaid,
        cdPaid,
        drawPaid,
        cUnpaid,
        salesDeduction,
        netOpCommission,
        totalCommission,
        depositReplenish,
        drawMobile,
        totalMWMobile,
        otherCommissionIntel05: totalOtherCommIntel,
        safetyFund: totalSafetyFund,
        consolidatorsCommission: totalConsolComm,
        paymentForOutstandingBalance: totalPayOutBal,
        ...data,
    };

    return computation;
};

export { computationSoa };
