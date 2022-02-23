import moment from "moment";
import XLSX from "xlsx";
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

import {
    mergeObject,
    valueSplit,
} from "../utility";



const readSoa = (event, isExcel) => {
    let arenaReportFiltered = []
    const file = event ? event : null;
           
    const checkfile =
        ( event.name.includes("xlsx")) || ( event.name.includes("csv"));
      

    if (event && checkfile) {
        isExcel = true
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
      
                const accReportComb = "Accounts Report Combined"
                const summaryRep = "Summary Report"
                return (
                    camelCase(value) === camelCase(accReportComb) || camelCase(value) === camelCase(summaryRep)
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
                       
                        drawMobile: 0,
                        totalMWMobile: 0,
                        safetyFundMob: 0,
                        otherCommIntMob: 0,
                        consolCommMob: 0,
                        payOutsBalMob: 0,
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
                        v.areaCode == item.areaCode
                    ){
                      
                         return v.areaCode == item.areaCode;
                    }
                       
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

                    objMobileKiosk[existingIndex].safetyFundMob = item.safetyFund;
                    objMobileKiosk[existingIndex].otherCommIntMob = item.otherCommissionIntel05;
                    objMobileKiosk[existingIndex].consolCommMob = item.consolidatorsCommission;
                    objMobileKiosk[existingIndex].payOutsBalMob = item.paymentForOutstandingBalance;
                } else {
                    if (typeof item.value == "string") { 
                        item.value = [item.value];
                        
                    }

                    objMobileKiosk.push(item)
               
                }
            });




            let helper = {};
            const result = objMobileKiosk.reduce(function (r, o) {
                let key = o.areaCode;
       
                if (!helper[key]) {
                    helper[key] = Object.assign({}, o); // create a copy of o

                    r.push(helper[key]);
                } else {

                    helper[key].totalMWMobile = o.total;
                    helper[key].drawMobile = o.draw;
                    helper[key].safetyFundMob = o.safetyFund;
                    helper[key].otherCommIntMob = o.otherCommissionIntel05;
                    helper[key].consolCommMob = o.consolidatorsCommission;
                    helper[key].payOutsBalMob = o.paymentForOutstandingBalance;
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
                    if(rest.arenaName.includes("MA90")) console.log(rest)
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
                    const safetyFundMob = rest.safetyFundMob;
                    const otherCommIntMob = rest.otherCommIntMob;
                    const consolCommMob = rest.consolCommMob;
                    const payOutsBalMob = rest.payOutsBalMob;
                    const netWinLoss = rest.netWinLoss
                   
                    const mwTwo = totalMWBets * 0.02;
                    const drawTwo = totalDrawBets * 0.02;
                    const mwTwoMobile = totalMWMobile * 0.02;
                    const drawTwoMobile = totalDrawMobile * 0.02;
                    const totalUnclaimed = rest.unclaimed;
                    const totalCUnpaid = rest.cUnpaid;
                    const salesDeduction = rest.salesDeductionTablet;
                    const netOperatorsCommission = rest.netOperatorsCommission.toString()
                 
                    const otherCommissionIntel =
                        rest.otherCommissionIntel05;
                    const consolidatorsCommission =
                        rest.consolidatorsCommission;

                    const safetyFund = rest.safetyFund;
                   

                    const paymentForOutstandingBalance =
                        rest.paymentForOutstandingBalance;

                    const totalCommission = rest.totalCommission.toString();
                    const cashLoad = rest.cashLoad;
                    const cashWithdrawal = rest.cashWithdrawal;
                    const totalOthers = rest.totalOthers;
                    const systemErrorCOArmsi = rest.systemErrorCOArmsi;

                    const depositReplenish = rest.forDepositReplenish

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
                        arena_name: arenaName.toUpperCase(),
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
                        for_total: depositReplenish.toString(),
                        totalOthers,
                        systemErrorCOArmsi,
                        safetyFundMob,
                        otherCommIntMob,
                        consolCommMob, 
                        payOutsBalMob,
                        soaFr,
                        group,
                    };

                    return { ...rest };
                }
            );

            const removeLucky = removeKeyReportObject.filter(removeLuck => (removeLuck.areaCode !== 'LUCKY' || removeLuck.arena_name.split(' ')[0] !== 'LUCKY'))

            // group fr and soa
            const groupSOAFR = removeLucky.reduce(function (
                r,
                a
            ) {
                r[a.soaFr] = r[a.soaFr] || [];
                r[a.soaFr].push(a);
                return r;
            },
            Object.create(null));

            const moLetter = String.fromCharCode(
                96 + (moment(eventDateCreated).month() + 1)
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
                    moment(eventDateCreated).format("YYDD") +
                    moLetter +
                    `0000${i + 1}`.slice(-4),
                ...s,
            }));
            const newfr = sortFr.map(({ soaFr, ...f }, i) => ({
                refNo:
                    "FR" +
                    moment(eventDateCreated).format("YYDD") +
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

           

            arenaReportFiltered.push(...sortReport) ;

           

        };
        reader.readAsBinaryString(file);
    } 
    else {
       
        isExcel = false
        Fire.$emit("AfterCreate"),
            Toast.fire({
                icon: "warning",
                title: "Make sure you insert correct excel data!",
                
            });
       
    }
    return {
        arenaReportFiltered,
        isExcel
    }


}

export { readSoa }