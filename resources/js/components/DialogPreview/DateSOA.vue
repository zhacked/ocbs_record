<template>
           <v-col>
            <div
                class="
                    d-flex
                    align-center
                    fieldDateNumber
                "
            >
                <span
                    class="
                        computation
                        custom-label
                    "
                    >{{
                        depositReplenishText
                            .dateText
                    }}&nbsp;#:</span
                >
                <div
                    class="
                        custom-span
                        
                        d-flex
                        align-center
                    "
                >
                    <span class="computation"
                        >{{refNo}}</span
                    >
                </div>
            </div>
            <div
                class="
                    d-flex
                    align-center
                    fieldDateNumber
                "
            >
                <span
                    class="
                        computation
                        custom-label
                    "
                    >Date&nbsp;of&nbsp;{{
                        depositReplenishText
                            .dateText
                    }}:</span
                >
                <div
                    class="
                        custom-span
                        
                        d-flex
                        align-center
                    "
                >
                    <span class="computation"
                        >{{dateSoa}}</span
                    >
                </div>
            </div>
            <div
                class="
                    d-flex
                    align-center
                    fieldDateNumber
                "
            >
                <span
                    class="
                        computation
                        custom-label
                    "
                    >Date&nbsp;of&nbsp;Event:</span
                >
                <div
                    class="
                        custom-span
                        
                        d-flex
                        align-center
                    "
                >
                    <span
                        class="computation">{{dateEvent}}</span
                    >
                </div>
            </div>
        </v-col>
</template>
<script>
    export default {
        name: "DateSOA",
        props: {
            depositReplenishText: Object,
            dateEvent: String,
            dateSoa: String,
            refNo: String
        }
    }
</script>