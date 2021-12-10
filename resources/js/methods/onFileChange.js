import {
    numberFormat,
    numberUnformat,
    mergeObject,
    valueSplit,
} from "../utility";

import { camelCase, groupBy, map, spread, values, assign } from "lodash";
import XLSX from "xlsx";

const onFileChange = (event) => {
    const file = event.target.files ? event.target.files[0] : null;
   
    const checkfile =
        file.name.includes("xlsx") || file.name.includes("csv");
    
    let f;
    let rKeyReportObj;
    if (file && checkfile) {
        const reader = new FileReader();
        let arrayData = [];
        let reportCombined = [];
        let eventsCombined = [];
        let summaryReport = [];
        // let objectKeyReplacedArray = [];

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
            const filteredWS = ws.filter(function (value, index, arr) {
                return (
                    value === "Accounts Report (Combined)" ||
                    value === "Summary Report"
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

         

            arrayData[0].map((r) => {
                if (Object.keys(r).length >= 17) reportCombined.push(r);
          
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
                        eventCreated:
                            mergeObj.dateCreated ||
                            moment().format("LLL"),
                        type: data.type
                            ? data.type
                            : data.classification
                            ? data.classification
                            : null,
                        totalCommission: data.totalCommission
                            ? data.totalCommission
                            : 0,
                        totalOthers: data.totalOthers
                            ? data.totalOthers
                            : 0,
                        salesDeductionTablet: data.salesDeductionTablet
                            ? data.salesDeductionTablet
                            : 0,
                        otherCommissionInteldata05:
                            data.otherCommissionInteldata05
                                ? data.otherCommissionInteldata05
                                : 0,
                        consolidatorsCommission:
                            data.consolidatorsCommission
                                ? data.consolidatorsCommission
                                : 0,
                        safetyFund: data.safetyFund
                            ? data.safetyFund
                            : 0,
                        paymentForOutstandingBalance:
                            data.paymentForOutstandingBalance
                                ? data.paymentForOutstandingBalance
                                : 0,
                        systemErrorCOArmsi: data.systemErrorCOArmsi
                            ? data.systemErrorCOArmsi
                            : 0,
                        cashLoad: data.cashLoad ? data.cashLoad : 0,
                        cashWithdrawal: data.cashWithdrawal
                            ? data.cashWithdrawal
                            : 0,
                        netOperatorsCommission:
                            data.netOperatorsCommission
                                ? data.netOperatorsCommission
                                : 0,
                        otherCommissionIntel05:
                            data.otherCommissionIntel05
                                ? data.otherCommissionIntel05
                                : 0,

                        drawMobile: 0,
                        totalMWMobile: 0,
                        ...data,
                    });
                });

                return objectKeyReplacedArray;
            };

          
            const objKeyRep = objectKeyed(reportCombined, 5);
            const objKeySummary = objectKeyed(summaryReport, 6);
           

            let objMobileKiosk = [];

            objKeySummary.forEach(function (item) {
                const existing = objMobileKiosk.filter((v, i) => {
                   
                    if (
                        v.type === "KIOSK" &&
                        v.arenaName == item.arenaName
                    )
                        return v.arenaName == item.arenaName;
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
                } else {
                    if (typeof item.value == "string")
                        item.value = [item.value];
                    objMobileKiosk.push(item);
                }
            });

         

            let helper = {};
            const result = objMobileKiosk.reduce(function (r, o) {
                let key = o.arenaName;

                if (!helper[key]) {
                    helper[key] = Object.assign({}, o); // create a copy of o

                    r.push(helper[key]);
                } else {
                 

                    helper[key].totalMWMobile = o.total;
                    helper[key].drawMobile = o.draw;
                }

                return r;
            }, []);

         

            const accountsReportSummaryCombined = [
          
                ...result,
            ];

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
                ({ key, ...rest }) => ({ ...rest })
            );
          
                f = file;
                rKeyReportObj = removeKeyReportObject;
         
        };
        reader.readAsBinaryString(file);

        return {
            f,
            rKeyReportObj
        }
    } else {
        Fire.$emit("AfterCreate"),
            swal.fire({
                icon: "warning",
                title: "Oops...",
                text: "Make sure you insert correct excel data!",
            });
        $("#importData").val("");
    }
}

export default onFileChange