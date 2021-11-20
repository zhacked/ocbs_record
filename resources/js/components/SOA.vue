<template>
    <v-app>
        <v-container>
            <v-row class="mt-5">
                <v-col class="col-md-12">
                    <v-card>
                        <v-card-title class="card-header">
                            <strong> Statement of Account</strong>
                            <v-spacer></v-spacer>
                            <form @submit.prevent="proceedAction()">
                                <v-card-actions class="card-tools">
                                    <label
                                        class="form-control-label"
                                        for="input-file-import"
                                    ></label>
                                    <!--<input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file"  @change="onFileChange"> -->
                                    <input
                                        type="file"
                                        id="importData"
                                        class="form-control"
                                        @change="onFileChange"
                                    />
                                    <v-btn
                                        type="submit"
                                        color="success"
                                        elevation="2"
                                        >send</v-btn
                                    >
                                </v-card-actions>
                            </form>
                        </v-card-title>

                        <div
                            class="card card-primary card-outline"
                            style="overflow: auto; !important"
                        >
                            <div class="card-body">
                                <v-data-table
                                    :headers="headers"
                                    :items="arenaData.data"
                                    :items-per-page="10"
                                    class="elevation-1 text-center"
                                >
                                    <template
                                        v-slot:[`item.actions`]="{ item }"
                                    >
                                        <button
                                            class="btn btn-primary"
                                            @click="openModel(item)"
                                        >
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                    </template>
                                </v-data-table>
                            </div>
                        </div>
                    </v-card>
                </v-col>
            </v-row>

            <!-- Modal -->
            <div
                class="modal fade"
                id="addNew"
                tabindex="-1"
                role="dialog"
                aria-labelledby="addNewLabel"
                aria-hidden="true"
            >
                <div
                    class="modal-dialog modal-xl modal-dialog-centered"
                    role="document"
                >
                    <div
                        class="modal-content h-100"
                        style="padding: 80px 100px"
                    >
                        <div class="text-align-center">
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button> -->
                            <h1 class="modal-title w-100 text-center">
                                {{ depositReplenishTxt.title || "State of Account" }}
                            </h1>

                            <div class="modal-body" style="overflow-y: auto">
                                <div class="text-right">
                                    <v-row class="mb-1 no-gutters">
                                        <v-col class="col-sm-10 mt-2">
                                            {{ depositReplenishTxt.dateText || "SOA" }} # : &nbsp;
                                        </v-col>
                                        <v-col class="col-sm-2">
                                            <input
                                                type="text"
                                                readonly
                                                class="
                                                    form-control form-control-sm
                                                "
                                                id="inputName"
                                                placeholder="SOA-xxxxxxx"
                                            />
                                        </v-col>
                                    </v-row>
                                    <v-row class="mb-1 no-gutters">
                                        <v-col class="col-sm-10 mt-2">
                                            Date of  {{ depositReplenishTxt.dateText || "SOA" }} : &nbsp;
                                        </v-col>
                                        <v-col class="col-sm-2">
                                            <input
                                                type="text"
                                                readonly
                                                class="
                                                    form-control form-control-sm
                                                "
                                                id="inputName"
                                                placeholder=""
                                            />
                                        </v-col>
                                    </v-row>
                                    <v-row class="mb-1 no-gutters">
                                        <v-col class="col-sm-10 mt-2">
                                            Date of Event : &nbsp;
                                        </v-col>
                                        <v-col class="col-sm-2">
                                            <input
                                                type="text"
                                                readonly
                                                class="
                                                    form-control form-control-sm
                                                "
                                                id="inputName"
                                                placeholder=""
                                            />
                                        </v-col>
                                    </v-row>
                                </div>

                                <div class="mt-5 pt-5">
                                    <v-row class="mb-1 no-gutters">
                                        <v-col class="col-sm-2 mt-2">
                                            Arena / OCBS Name :
                                        </v-col>
                                        <v-col class="col-sm-10">
                                            <input
                                                type="text"
                                                readonly
                                                v-model="form.arena"
                                                class="
                                                    form-control form-control-sm
                                                "
                                                id="inputName"
                                                placeholder="Enter OCBS Name"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has(
                                                            'arena'
                                                        ),
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="arena"
                                            ></has-error>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mb-1 no-gutters">
                                        <v-col class="col-sm-2 mt-2">
                                            Address :
                                        </v-col>
                                        <v-col class="col-sm-10">
                                            <input
                                                type="text"
                                                readonly
                                                v-model="form.address"
                                                class="
                                                    form-control form-control-sm
                                                "
                                                id="inputName"
                                                placeholder="Enter address"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has(
                                                            'address'
                                                        ),
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="address"
                                            ></has-error>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mb-1 no-gutters">
                                        <v-col class="col-sm-2 mt-2">
                                            Operator :
                                        </v-col>
                                        <v-col class="col-sm-10">
                                            <input
                                                type="text"
                                                readonly
                                                v-model="form.operator"
                                                class="
                                                    form-control form-control-sm
                                                "
                                                id="inputName"
                                                placeholder="Enter Operator Name"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has(
                                                            'operator'
                                                        ),
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="operator"
                                            ></has-error>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mb-1 no-gutters">
                                        <v-col class="col-sm-2 mt-2">
                                            Contact Number :
                                        </v-col>
                                        <v-col class="col-sm-10">
                                            <input
                                                type="text"
                                                readonly
                                                v-model="form.contact_number"
                                                class="
                                                    form-control form-control-sm
                                                "
                                                id="inputName"
                                                placeholder="0912-345-7894"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has(
                                                            'contact_number'
                                                        ),
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="contact_number"
                                            ></has-error>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mb-1 no-gutters">
                                        <v-col class="col-sm-2 mt-2">
                                            Email Address :
                                        </v-col>
                                        <v-col class="col-sm-10">
                                            <input
                                                readonly
                                                v-model="form.email"
                                                type="email"
                                                name="email"
                                                placeholder="sample@gmail.com"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.has(
                                                            'email'
                                                        ),
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="email"
                                            ></has-error>
                                        </v-col>
                                    </v-row>
                                </div>

                                <!-- computation -->
                                <div
                                    style="border: 1px solid black"
                                    class="mt-5"
                                >
                                    <h5 class="w-100 text-center pt-1">
                                        Computation
                                    </h5>
                                </div>

                                <div class="mt-5">
                                    <v-row>
                                        <!-- left -->
                                        <v-col class="text-right">
                                            <p
                                                class="
                                                    w-100
                                                    text-center
                                                    pa-0
                                                    mx-0
                                                "
                                            >
                                                (Kiosk)
                                            </p>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Total M/W Bets : &nbsp;
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.totalMWBet
                                                        "
                                                        @blur="handleFormatted"
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Cancelled Bets :
                                                    <span
                                                        class="
                                                            text-success
                                                            text-bold
                                                        "
                                                    >
                                                        + </span
                                                    >&nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.drawCancelled
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Draw Bets :
                                                    <span
                                                        class="
                                                            text-success
                                                            text-bold
                                                        "
                                                    >
                                                        +
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.draw
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Payout Paid :
                                                    <span
                                                        class="
                                                            text-danger
                                                            text-bold
                                                        "
                                                    >
                                                        -
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.totalPayoutPaid
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Total C/D Paid :
                                                    <span
                                                        class="
                                                            text-danger
                                                            text-bold
                                                        "
                                                    >
                                                        -
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.cdPaid
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Draw Paid :
                                                    <span
                                                        class="
                                                            text-danger
                                                            text-bold
                                                        "
                                                    >
                                                        -
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.drawPaid
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <hr />
                                            <v-row class="mb-1 no-gutters pb-5">
                                                <v-col class="col-sm-6 mt-2">
                                                    Net Win/Loss :
                                                    <span
                                                        class="
                                                            text-primary
                                                            text-bold
                                                        "
                                                    >
                                                        =
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.netWinLoss
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder=""
                                                    />
                                                </v-col>
                                            </v-row>

                                            <!-- mobile -->
                                            <div class="mt-5 pt-4">
                                                <p
                                                    class="
                                                        w-100
                                                        text-center
                                                        pa-0
                                                        mx-0
                                                    "
                                                >
                                                    (Mobile)
                                                </p>
                                                <v-row class="mb-1 no-gutters">
                                                    <v-col
                                                        class="col-sm-6 mt-2"
                                                    >
                                                        Total M/W Bets : &nbsp;
                                                        &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6">
                                                        <input
                                                            type="text"
                                                            v-model="
                                                                computation
                                                                    .mobile
                                                                    .totalMWBet
                                                            "
                                                            class="
                                                                form-control
                                                                form-control-sm
                                                                computation
                                                            "
                                                            id="inputName"
                                                            placeholder="0"
                                                        />
                                                    </v-col>
                                                </v-row>
                                                <v-row class="mb-1 no-gutters">
                                                    <v-col
                                                        class="col-sm-6 mt-2"
                                                    >
                                                        Total Draw Bets : &nbsp;
                                                        &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6">
                                                        <input
                                                            type="text"
                                                            v-model="
                                                                computation
                                                                    .mobile
                                                                    .totalDrawBet
                                                            "
                                                            class="
                                                                form-control
                                                                form-control-sm
                                                                computation
                                                            "
                                                            id="inputName"
                                                            placeholder="0"
                                                        />
                                                    </v-col>
                                                </v-row>
                                            </div>
                                        </v-col>

                                        <!-- right -->
                                        <v-col class="text-right">
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Net Win/Loss : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.netWinLoss
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <hr />
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    M/W *
                                                    {{
                                                        this.commission_percent
                                                    }}
                                                    (kiosk) : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computedAve.mwTotalPercent
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Draw *
                                                    {{
                                                        this.commission_percent
                                                    }}
                                                    (kiosk) :
                                                    <span
                                                        class="
                                                            text-success
                                                            text-bold
                                                        "
                                                    >
                                                        +
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computedAve.drawTotalPercent
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    M/W *
                                                    {{
                                                        this.commission_percent
                                                    }}
                                                    (mobile) :
                                                    <span
                                                        class="
                                                            text-success
                                                            text-bold
                                                        "
                                                    >
                                                        +
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computedAve.mwMobileTotalPercent
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Draw *
                                                    {{
                                                        this.commission_percent
                                                    }}
                                                    (mobile) :
                                                    <span
                                                        class="
                                                            text-success
                                                            text-bold
                                                        "
                                                    >
                                                        +
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computedAve.drawMobileTotalPercent
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Unclaimed :
                                                    <span
                                                        class="
                                                            text-success
                                                            text-bold
                                                        "
                                                    >
                                                        +
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.unclaimed
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col> </v-row
                                            ><v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Total C unpaid : &nbsp;
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.cUnpaid
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Operator Expenses : &nbsp;
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.operatorExpenses
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Net operator's Commission :
                                                    <span
                                                        class="
                                                            text-primary
                                                            text-bold
                                                        "
                                                    >
                                                        =
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computedAve.netOpCommission
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Cash Load from Mobile :
                                                    <span
                                                        class="
                                                            text-success
                                                            text-bold
                                                        "
                                                    >
                                                        +
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.mobile
                                                                .cashLoad
                                                        "
                                                        name="cashLoad"
                                                        @blur="handleFormatted"
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    Cash Withdraw from Mobile :
                                                    <span
                                                        class="
                                                            text-danger
                                                            text-bold
                                                        "
                                                    >
                                                        -
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computation.mobile
                                                                .cashWithdraw
                                                        "
                                                        name="cashWithdraw"
                                                        @blur="handleFormatted"
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <hr />
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6 mt-2">
                                                    For {{ depositReplenishTxt.totalText || "Deposit" }} :
                                                    <span
                                                        class="
                                                            text-primary
                                                            text-bold
                                                        "
                                                    >
                                                        =
                                                    </span>
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            computedAve.depositReplenish
                                                        "
                                                        class="
                                                            form-control
                                                            form-control-sm
                                                            computation
                                                        "
                                                        id="inputName"
                                                        placeholder="0"
                                                    />
                                                </v-col>
                                            </v-row>
                                            <hr />
                                            <hr />
                                        </v-col>
                                    </v-row>
                                </div>

                                <!-- kindly deposit -->
                                <v-row>
                                    <v-col class="col-sm-9">
                                        <div
                                            style="border: 1px solid black"
                                            class="mt-5 pl-5 text-left"
                                        >
                                            <v-row class="no-gutters">
                                                <v-col class="col-sm-3">
                                                    Kindly Deposit To : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-9">
                                                    <span>
                                                        {{
                                                            this.status ==
                                                            "Deposit"
                                                                ? "LUCKY 8 STAR QUEST INC"
                                                                : ""
                                                        }}</span
                                                    >
                                                </v-col>
                                            </v-row>
                                            <v-row class="no-gutters pa-0">
                                                <v-col class="col-sm-3">
                                                    &nbsp;
                                                </v-col>
                                                <v-col
                                                    class="col-sm-9 no-gutters"
                                                >
                                                    <v-col class="col-sm-6">
                                                        <span v-if="editmode">{{
                                                            selectedbank.bank_name
                                                        }}</span>

                                                        <select
                                                            v-else
                                                            name="type"
                                                            v-model="
                                                                bankaccount_id
                                                            "
                                                            id="arena_id"
                                                            class="
                                                                form-control
                                                                form-control-sm
                                                                pa-0
                                                            "
                                                        >
                                                            <option
                                                                v-for="banks in bank"
                                                                :key="banks.id"
                                                                :value="
                                                                    banks.id
                                                                "
                                                            >
                                                                {{
                                                                    banks.bank_name
                                                                }}
                                                            </option>
                                                        </select>
                                                    </v-col>
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters pa-0">
                                                <v-col class="col-sm-3">
                                                    &nbsp;
                                                </v-col>
                                                <v-col
                                                    class="col-sm-9 no-gutters"
                                                >
                                                    <v-col class="col-sm-6">
                                                        <span v-if="editmode">{{
                                                            selectedbank.bank_number
                                                        }}</span>

                                                        <!-- <select  name="type" id="arena_id" class="form-control form-control-sm" >
                                                            <option v-for="bank in bankDetails" :key="bank.id"  :value="bank.id" >{{bank.bank_number}}</option>
                                                        </select> -->
                                                    </v-col>
                                                </v-col>
                                            </v-row>
                                        </div>
                                    </v-col>
                                    <v-col class="col-sm-3"> </v-col>
                                </v-row>

                                <!-- signiture -->
                                <div class="mt-5 pl-5">
                                    <v-row>
                                        <!-- left -->
                                        <v-col>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6">
                                                    Computed by : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    name here
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6">
                                                    Prepared by : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                </v-col>
                                            </v-row>
                                        </v-col>

                                        <!-- right -->
                                        <v-col>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6">
                                                    Checked by : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    name here
                                                </v-col>
                                            </v-row>
                                            <v-row class="mb-1 no-gutters">
                                                <v-col class="col-sm-6">
                                                    Checked by : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6">
                                                    name here
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer w-100">
                            <div class="text-left">
                                <v-row class="no-gutters">
                                    <v-col class="col-md-8">
                                        <span>Select commission % : </span>
                                    </v-col>
                                    <v-col class="col-md-4">
                                        <input
                                            type="text"
                                            v-model="commission_percent"
                                            class="
                                                form-control form-control-sm
                                                computation
                                            "
                                            id="inputName"
                                            placeholder="0"
                                        />
                                    </v-col>
                                </v-row>
                            </div>
                            <v-spacer></v-spacer>
                            <div class="text-right">
                                <button
                                    type="button"
                                    v-show="editmode"
                                    class="btn btn-outline-primary"
                                    @click="updateModal()"
                                >
                                    Edit
                                </button>
                                <button
                                    type="button"
                                    v-show="!editmode"
                                    class="btn btn-outline-primary"
                                    @click="saveModal()"
                                >
                                    Save
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-success"
                                >
                                    Save as PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </v-container>
    </v-app>
</template>
<script>
import { camelCase } from "lodash";
import XLSX from "xlsx";
import {
    numberFormat,
    numberUnformat,
    mergeObject,
    valueSplit,
} from "../utility";

export default {
    data() {
        return {
            headers: [
                { text: "Arena Name", value: "arena_name" },
                { text: "Operator", value: "arena_details.operator" },
                { text: "Contact", value: "arena_details.contact_number" },
                { text: "", value: "actions", sortable: false },
            ],

            ocbsArray: [],
            ocbsArrayFiltered: [],
            editmode: false,
            commission_percent: 0.02,
            status: "Deposit",
            ocbs: {},
            bankDetails: {},
            bank: {},
            arenaData: [],
            arenaDetails: {},

            selectedbank: [],
            arena_id: "",
            form: new Form({
                id: "",
                arena: "",
                address: "",
                operator: "",
                contact_number: "",
                email: "",
            }),

            bankaccount_id: "",
            computation: {
                totalMWBet: 0,
                drawCancelled: 0,
                draw: 0,
                totalPayoutPaid: 0,
                cdPaid: 0,
                drawPaid: 0,
                netWinLoss: 0,
                totalMWBetPercent: 0,
                operatorExpenses: 0,
                unclaimed: 0,
                cUnpaid: 0,
                mobile: {
                    totalMWBet: 0,
                    totalDrawBet: 0,
                    cashLoad: 0,
                    cashWithdraw: 0,
                },
            },
            soa: true,
            depositReplenishTxt: {},
        };
    },
    methods: {
        async showData() {
            const data = await axios.get("api/import");
            // console.log('DATA',data.data)
            let helper = {};

            const duplicateObj = await data.data.reduce(function (r, obj) {
                const key = obj.arena_name;

                if (!helper[key]) {
                    helper[key] = Object.assign({}, obj); // create a copy of o

                    r.push(helper[key]);
                } else {
                    // const {arenaName, ...o} = obj;
                    helper[key].mobile = {
                        ...obj,
                    };
                }

                return r;
            }, []);

            const obj = {
                data: duplicateObj,
            };

            this.arenaData = obj;
        },
        updateModal() {
            $(".computation").attr("disabled", false);
            this.editmode = false;
        },
        saveModal() {
            $(".computation").attr("disabled", true);
            this.editmode = true;
            axios
                .get(
                    "api/updateBank/" +
                        this.arena_id +
                        "/" +
                        this.bankaccount_id
                )
                .then((data) => {
                    Fire.$emit("AfterCreate");
                    swal.fire("Successfully!", "Updated", "success");
                });
        },
        test() {
            axios
                .get("api/savePrimaryBank/" + this.arena_id)
                .then(({ data }) => (this.selectedbank = data));
        },
        proceedAction() {
            this.$Progress.start();
            axios
                .post("api/import", this.ocbsArrayFiltered)
                .then(
                    ({ data }) => (
                        $("#importData").val(""),
                        Fire.$emit("AfterCreate"),
                        swal.fire("Successfully!", "Excel Imported", "success"),
                        this.$Progress.finish()
                    )
                );
        },
        // handleCommissionPercent(e) {
        //     this.commission_percent = e.target.value;
        // },
        openModel(data) {
            console.log(data);
            this.form.reset();
            $("#addNew").modal("show");

            this.form.fill(data.arena_details);
            this.arenaDetails = data.arena_details;
            this.arena_id = data.id;
            $(".computation").attr("disabled", true);
            this.editmode = true;
            Fire.$emit("AfterCreate"),
                axios
                    .get("api/bankfilter/" + data.arena_details.id)
                    .then(({ data }) => (this.bank = data));

            const totalMWBet = data.total_meron_wala;
            const drawCancelled = data.draw_cancelled;
            const draw = data.draw;
            const totalPayoutPaid = data.total_payout_paid;
            const cdPaid = data.draw_cancelled_paid;
            const drawPaid = data.draw_paid;
            const unclaimed = data.unclaimed;
            const cUnpaid = data.cancelled_unpaid;
            const netWinLoss =
                parseFloat(totalMWBet) +
                parseFloat(drawCancelled) +
                parseFloat(draw) -
                parseFloat(totalPayoutPaid) -
                parseFloat(cdPaid) -
                parseFloat(drawPaid);
            const totalMWBetPercent =
                parseFloat(totalMWBet) * parseFloat(this.commission_percent);
            // console.log(totalMWBetPercent)
            const totalMobileMWBets = data.mobile
                ? data.mobile.total_meron_wala
                : 0;
            const totalMobileDrawBets = data.mobile ? data.mobile.draw : 0;

            this.computation = {
                totalMWBet: numberFormat(totalMWBet),
                drawCancelled: numberFormat(drawCancelled),
                draw: numberFormat(draw),
                totalPayoutPaid: numberFormat(totalPayoutPaid),
                cdPaid: numberFormat(cdPaid),
                drawPaid: numberFormat(drawPaid),
                netWinLoss: numberFormat(netWinLoss),
                unclaimed: numberFormat(unclaimed),
                cUnpaid: numberFormat(cUnpaid),
                totalMWBetPercent: numberFormat(totalMWBetPercent),
                operatorExpenses: numberFormat(
                    this.computation.operatorExpenses
                ),
                mobile: {
                    ...this.computation.mobile,
                    totalMWBet: numberFormat(totalMobileMWBets),
                    totalDrawBet: numberFormat(totalMobileDrawBets),
                },
            };
        },

        onFileChange(event) {
            const file = event.target.files ? event.target.files[0] : null;
            if (file) {
                const reader = new FileReader();
                let arrayData = [];
                let reportCombined = [];
                let eventsCombined = [];
                let objectKeyReplacedArray = [];

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

                    ws.forEach((w) => {
                        const singleSheet = wb.Sheets[w];
                        arrayData.push(
                            XLSX.utils.sheet_to_json(singleSheet, { header: 1 })
                        );
                    });
                    /* Convert array of arrays */
                    // const data = XLSX.utils.sheet_to_json(ws, {header: 1});

                    arrayData[0].map((r) => {
                        // console.log(Object.assign({}, dataSplit(r)))
                        if (Object.keys(r).length >= 17)
                            reportCombined.push(Object.assign({}, r));
                        if (Object.keys(r).length === 1) {
                            // assign new key and delete oldkey
                            const newObject = {};
                            delete Object.assign(newObject, r, {
                                ["A"]: r[0],
                            })[0];
                            eventsCombined.push(
                                Object.assign({}, valueSplit(newObject.A))
                            );
                        }
                    });

                    // Merge Object
                    const mergeObj = mergeObject(eventsCombined);

                    const combinedEvent = eventsCombined.reduce(function (
                        result,
                        current
                    ) {
                        return Object.assign(result, current);
                    },
                    {});

                    const [, ...headKey] = Object.values(reportCombined[0]);
                    const headK = ["key", ...headKey];

                    reportCombined.map((data) => {
                        data = Object.assign(
                            {},
                            ...Object.entries(data).map(([, prop], index) => ({
                                [camelCase(headK[index])]: prop,
                            }))
                        );
                        objectKeyReplacedArray.push({
                            eventCreated: mergeObj.dateCreated,
                            ...data,
                        });
                    });

                    const filterObjectHeader = objectKeyReplacedArray.filter(
                        (obk) => {
                            if (
                                obk.arenaName !== "OCBS NAME" &&
                                obk.arenaName !== "ARENA NAME"
                            )
                                return obk;
                        }
                    );

                    const removeKeyReportObject = filterObjectHeader.map(
                        ({ key, ...rest }) => ({ ...rest })
                    );
                    this.ocbsArrayFiltered = removeKeyReportObject;
                    console.log(removeKeyReportObject);
                };
                reader.readAsBinaryString(file);
            }
        },

        handleFormatted() {
            this.computation.mobile = {
                cashLoad: numberFormat(this.computation.mobile.cashLoad),
                cashWithdraw: numberFormat(
                    this.computation.mobile.cashWithdraw
                ),
            };
        },
    },

    computed: {
        computedAve: function () {
            
            const mwTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.totalMWBet)
            );
            const drawTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.draw)
            );
            const mwMobileTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.mobile.totalMWBet)
            );
            const drawMobileTotalPercent = numberFormat(
                parseFloat(this.commission_percent) *
                    numberUnformat(this.computation.mobile.totalDrawBet)
            );
            const netOpCommTotal =
                numberUnformat(mwTotalPercent) +
                numberUnformat(drawTotalPercent) +
                numberUnformat(this.computation.unclaimed) +
                numberUnformat(this.computation.cUnpaid) +
                numberUnformat(this.computation.operatorExpenses);
            const netOpCommission = numberFormat(netOpCommTotal);
            const cashLoad = this.computation.mobile.cashLoad;
            const cashWithdraw = this.computation.mobile.cashWithdraw;
            const depositReplenish = numberFormat(
                numberUnformat(this.computation.netWinLoss) -
                    numberUnformat(netOpCommission) +
                    numberUnformat(cashLoad) -
                    numberUnformat(cashWithdraw)
            );




            const depositReplenishText =
                numberUnformat(depositReplenish) < 0
                    ? {
                          title: "For Replenishment",
                          dateText: "FR",
                          totalText: "Replenish",
                      }
                    : {
                          title: "Statement of Account",
                          dateText: "SOA",
                          totalText: "Deposit",
                      };
            this.depositReplenishTxt = depositReplenishText;

            return {
                mwTotalPercent,
                drawTotalPercent,
                mwMobileTotalPercent,
                drawMobileTotalPercent,
                netOpCommission,
                cashLoad,
                cashWithdraw,
                depositReplenish,
                depositReplenishText,
            };
        },
    },
    created() {
        this.showData();

        Fire.$on("AfterCreate", () => {
            this.showData();
            this.test();
        });
    },
};
</script>
