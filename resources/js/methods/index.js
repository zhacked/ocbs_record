import { imageDownload } from "../methods/downloads";
import { readSoa } from "../methods/readSoa";
import { beforeDownload } from "../methods/beforeDownload";
import { defineEmail, defineContact } from "../methods/defineEmailContacts";
import { truncate } from "../methods/truncate";
import { withStatus, soa } from "../methods/soaList";
import { reportGenerate } from "../methods/generateReport";
import { computationSoa } from "../methods/computationFormat";
import { printSoa } from "../methods/print";

export {
    imageDownload,
    readSoa,
    truncate,
    beforeDownload,
    defineEmail,
    defineContact,
    withStatus,
    soa,
    reportGenerate,
    computationSoa,
    printSoa,
};
