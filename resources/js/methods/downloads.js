import html2canvas from "html2canvas";
import JSZip from "jszip";
import JSZipUtils from "jszip-utils";
import moment from 'moment'


const downloadZipping = async (selected, div, downloadingReport, dialog2, progressvalue, arenaData, importwithstatus) => {
    let statusArenas = [];
    // downloadingReport = true;
    // dialog2 = true

    // // -----------ZIP--------------- // // //
    const divsss = div;
    const zip = new JSZip();

    const urlToPromise = async (url) => {
        return new Promise(function (resolve, reject) {
            JSZipUtils.getBinaryContent(url, function (err, data) {
                if (err) {
                    reject(err);
                } else {
                    resolve(data);
                    console.log(data);
                }
            });
        });
    };

    const generateZipFile = async (zip) => {
        const blob = await zip.generateAsync({ type: "blob" });
        await saveAs(
            blob,
            `report-${moment(selected[0].date_closed).format(
                "MMDYY"
            )}.zip`
        );
        console.log("zip generated");
         await axios.put("api/arenaStatus", statusArenas);
            const c = arenaData.data.filter(
                (arena) =>
                    !selected.find(
                        (select) => select.areaCode === arena.areaCode
                    )
            );

            arenaData.data = c;
            //     if(progressvalue === 100) {
            //         setTimeout(async () => {
            //         downloadingReport = false;
            //         dialog2 = false

            //         console.log("done");
            //         selected = [];
            //     }, 1000);

            // }
             importwithstatus()

    };
    // start benchmark
    const t = new Date();
    // some xml processing

    for (let i = 0; i < selected.length; i++) {
        statusArenas.push({
            codeEvent: selected[i].codeEvent,
            status: "done",
        });

        console.log(`Currently at ${i}, ${(new Date() - t) / 1000} secs`)

        progressvalue = Math.ceil((parseInt(i+1)/parseInt(selected.length))*100)


        const canvas = await html2canvas(divsss[i], {
            onclone: function (clonedDoc) {
                const elems =
                    clonedDoc.getElementsByClassName("reportsoaoutput");
                for (let i = 0; i < elems.length; i++) {
                    elems[i].style.display = "block";
                }
            },
            type: "dataURL",
            backgroundColor: "transparent",
            scale: 0.9
        });

        const link = document.createElement("a");
        // const soaFr = this.selected[i].group === "Replenish" ? "FR" : "SO"
        link.download = `${selected[i].arena_name}.png`;
        link.href = await canvas.toDataURL("image/png");
        const url = link.href;

        const folderName =
            parseFloat(selected[i].for_total) < 0 ? "fr" : "soa";

        const arenaName =
            (await selected[i].arena_name.indexOf("/")) > -1
                ? selected[i].arena_name.replace(/\//g, "-")
                : selected[i].arena_name;
        const filename = `${folderName}/${arenaName}.png`;

        await zip.file(filename, await urlToPromise(url), {
            binary: true,
        }); //Create new zip file with filename and content
    }

    //Generate zip file
    await generateZipFile(zip);

    return {
     selected, downloadingReport, dialog2, progressvalue
    }
}


const imageDownload = async(details, codeEvent, el) => {
    // const el = this.$refs.soaReport;
    
    const options = {
        type: "dataURL",
        backgroundColor: "transparent",
        
    };
    const printCanvas = await html2canvas(el, options);

    const link = document.createElement("a");


    link.download = `${details.arena}.png`;
    link.href = printCanvas.toDataURL("image/png");
    document.body.appendChild(link);
    link.click();

    setTimeout(() => {
        document.body.removeChild(link); // On modern browsers you can use `tempLink.remove();`
    }, 100);

    const arenaStatus = await axios
        .put("api/arenaStatus", [{ codeEvent, status: "done" }])
       
        return arenaStatus

}

export {
    downloadZipping,
    imageDownload
}