
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
            totalMWBets: moneyFormat(totalMWBets),
            drawCancelled: moneyFormat(drawCancelled),
            draw: moneyFormat(draw),
            totalPayoutPaid: moneyFormat(totalPayoutPaid),
            cdPaid: moneyFormat(cdPaid),
            drawPaid: moneyFormat(drawPaid),
            unclaimed: moneyFormat(unclaimed),
            cUnpaid: moneyFormat(cUnpaid),
            salesDeduction: moneyFormat(salesDeduction),
         
            systemErrorCOArmsi: moneyFormat(systemErrorCOArmsi),
            consolidatorsCommission: moneyFormat(
                consolidatorsCommission
            ),
            safetyFund: moneyFormat(totalSafetyFund),
            paymentForOutstandingBalance: moneyFormat(
                totalPayOutBal
            ),
            otherCommissionIntel05: moneyFormat(totalOtherCommIntel),
            consolidatorsCommission: moneyFormat(totalConsolComm),
            totalMWMobile: moneyFormat(totalMWMobile),
            drawMobile: moneyFormat(drawMobile),
            exempted,
            netWinLoss: moneyFormat(netWinLoss),
            mwTwo: moneyFormat(mwTwo),
            drawTwo: moneyFormat(drawTwo),
            mwTwoMobile: moneyFormat(mwTwoMobile),
            drawTwoMobile: moneyFormat(drawTwoMobile),
            safetyFundMob: moneyFormat(safetyFundMob),
            otherCommIntMob: moneyFormat(otherCommIntMob),
            consolCommMob: moneyFormat(consolCommMob),
            payOutsBalMob: moneyFormat(payOutsBalMob),
            depositReplenish: moneyFormat(parseFloat(depositReplenish)),
            totalCommission: moneyFormat(parseFloat(totalCommission)),
            netOpCommission: moneyFormat(netOpCommission),
    
            mobile: {
                totalMWBets: moneyFormat(totalMWMobile),
                totalDrawBets: moneyFormat(drawMobile),
                cashLoad: moneyFormat(cashLoad),
                cashWithdrawal: moneyFormat(cashWithdrawal),

            },

        };

        return {computation}

}

export { computationOpenSoa }