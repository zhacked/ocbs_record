
import {
    numberFormat,
    numberUnformat,
    moneyFormat
} from "../utility";
const computationOpenSoa = (data) =>  {

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
        const safetyFundMob = data.safetyFundMob;
        const otherCommIntMob = data.otherCommIntMob;
        const consolCommMob = data.consolCommMob;
        const payOutsBalMob = data.payOutsBalMob;
        const depositReplenish = data.for_total
        const totalCommission = data.totalCommission
        const netOpCommission = data.netOperatorsCommission
        const totalSafetyFund = parseFloat(safetyFund)+parseFloat(safetyFundMob)
        const totalOtherCommIntel = parseFloat(otherCommissionIntel05)+parseFloat(otherCommIntMob)
        const totalConsolComm = parseFloat(consolidatorsCommission)+parseFloat(consolCommMob)
        const totalPayOutBal = parseFloat(paymentForOutstandingBalance)+parseFloat(payOutsBalMob)

        
        const computation = {
            totalMWBets: numberFormat(totalMWBets),
            drawCancelled: numberFormat(drawCancelled),
            draw: numberFormat(draw),
            totalPayoutPaid: numberFormat(totalPayoutPaid),
            cdPaid: numberFormat(cdPaid),
            drawPaid: numberFormat(drawPaid),
            unclaimed: numberFormat(unclaimed),
            cUnpaid: numberFormat(cUnpaid),
            salesDeduction: numberFormat(salesDeduction),
         
            systemErrorCOArmsi: numberFormat(systemErrorCOArmsi),
            consolidatorsCommission: numberFormat(
                consolidatorsCommission
            ),
            safetyFund: numberFormat(totalSafetyFund),
            paymentForOutstandingBalance: numberFormat(
                totalPayOutBal
            ),
            otherCommissionIntel05: numberFormat(totalOtherCommIntel),
            consolidatorsCommission: numberFormat(totalConsolComm),
            totalMWMobile: numberFormat(totalMWMobile),
            drawMobile: numberFormat(drawMobile),
            exempted,
            netWinLoss: numberFormat(netWinLoss),
            mwTwo: numberFormat(mwTwo),
            drawTwo: numberFormat(drawTwo),
            mwTwoMobile: numberFormat(mwTwoMobile),
            drawTwoMobile: numberFormat(drawTwoMobile),
            safetyFundMob: numberFormat(safetyFundMob),
            otherCommIntMob: numberFormat(otherCommIntMob),
            consolCommMob: numberFormat(consolCommMob),
            payOutsBalMob: numberFormat(payOutsBalMob),
            depositReplenish: numberFormat(moneyFormat(numberUnformat(numberFormat(parseFloat(depositReplenish),3)))),
            totalCommission: numberFormat(moneyFormat(numberUnformat(numberFormat(parseFloat(totalCommission),3)))),
            netOpCommission: numberFormat(netOpCommission),
    
            mobile: {
                totalMWBets: numberFormat(totalMWMobile),
                totalDrawBets: numberFormat(drawMobile),
                cashLoad: numberFormat(cashLoad),
                cashWithdrawal: numberFormat(cashWithdrawal),

            },

        };

        return {computation}

}

export { computationOpenSoa }