<template>
    <v-row>
        <div class="bank-wrapper">
            <div class="bank-headline">
                <span>{{depositReplenishText.bankTitle}}: </span>
            </div>

            
            <div class="bank-container" v-if="depositReplenishText.totalText =='Deposit'">
                <div class="bank bank1">
                    <span>LUCKY 8STAR QUEST INC.</span>
                    <span>PBB</span>
                    <span>0050-1001-5156</span>
                </div>
                <div class="or">
                    OR
                </div>
                <div  class="bank bank2">
                    <span>LUCKY 8 STAR QUEST INC.</span>
                    <span>PBB</span>
                    <span>123-1232-1232</span>
                </div>
            </div>
            <div class="bank-container" v-else>
                <div class="bank bank1">
                    <span>{{operatorName}}</span>
                    <!-- <span>{{bank}}</span> -->
                    <span v-if="bank.bank_id == '' && editmode == false " > {{bank.bank_name}}</span>
                    <span   class="select-field_container" :class="{'editmode-span': editmode}">
                        <select class="small sign-name select-field_report" v-model="bank.bank_id" @change="filterbank()" >
                            <option selected v-for="banks in bank.all" :key="banks.id"  :value="banks.id" >{{banks.bank_name}}</option>
                        </select>
                    </span>
                    <span>{{bank.bank_number}}</span>
                </div>
                
            </div>

        </div>
    </v-row>
</template>
<script>
    export default {
        name: "BankBox",
        props:{
            bank:Object,
            operatorName: String,
            editmode: Boolean,
            depositReplenishText: Object
        },
        methods: {
           
            filterbank(){
         
              axios.get("api/filterBank/"+ this.bank.bank_id).then(({data}) => (
                   this.bank.bank_name = data.bank_name,
                    this.bank.bank_number = data.bank_number
                ));
            }
        }
    }
</script>