<template lang="">
    <v-app>
        <v-container class="ma-4 mx-auto">
            <h1 class="h2 font-weight-bold pa-8">CONFIGURE DETAILS</h1>
        <v-row dense >
            <v-col class="col-lg-4">
                <position></position>
            </v-col>
            <v-col class="col-lg-4">
                <bank-account></bank-account>
            </v-col>
            <v-col class="col-lg-4">
                <signatory></signatory>
            </v-col>
        </v-row>
        </v-container>
    </v-app>
</template>
<script>
import Position from './Position.vue'
import BankAccount from './BankAccount.vue'
import Signatory from './Signatory.vue'
export default {
    components: {
        Position,
        BankAccount,
        Signatory,
    }
}
</script>
<style lang="">
    
</style>