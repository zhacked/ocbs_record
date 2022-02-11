<template>
    <v-row class="bank-container" style="padding: 1px!important; height: auto; margin: 0!important">
        
        <div class="bank-wrapper"  style="padding: 1px 30px; margin: 0 !important">
            <div class="bank-headline mr-6 detailed" style="font-weight: 500">
                <span>{{depositReplenishText.bankTitle}}: </span>
            </div>

            <div   class="bank-content" v-if="depositReplenishText.totalText === 'Deposit'">
                <div class="bank bank1">
                        
                      <span class="bank_account-name detailed">{{bankAccounts.length > 0 ? bankAccounts[0].account_name: 'LUCKY 8 STAR QUEST INC.'}}</span>
                    <span class="detailed">{{bankAccounts.length > 0 ? bankAccounts[0].bank_name: 'PBB'}}</span>
                    <span class="detailed">{{bankAccounts.length > 0 ? bankAccounts[0].bank_number: '0050-1001-5156'}}</span>
                </div>
               
                <div v-show="bankAccounts.length >= 2" class="or">
                    OR
                </div>
                 <div v-show="bankAccounts.length === 0" class="or">
                    OR
                </div>
                <div class="bank bank2">
                  
                     <span class="bank_account-name detailed">{{bankAccounts.length === 0 ? 'LUCKY 8 STAR QUEST INC.' : bankAccounts.length > 1 ? bankAccounts[1].account_name : ''}}</span>
                    <span class="detailed">{{bankAccounts.length === 0 ? 'PBCOM' : bankAccounts.length > 1 ? bankAccounts[1].bank_name : ''}}</span>
                    <span class="detailed">{{bankAccounts.length === 0 ? '0248-20-100964-4' : bankAccounts.length > 1 ? bankAccounts[1].bank_number : ''}}</span>
                </div>
            </div>
         
            <div class="bank-content d-flex justify-center align-center" v-else >
                <div class="bank bank1" >  
                    <!-- Object.values(bankTarget).length ? bankTarget.account_name : banks.length > 0 ? banks[0].account_name : -->
                    <span class="text-sm font-weight-medium bank_account-name detailed" >{{arenaDetails && arenaDetails.bank_details && arenaDetails.bank_details.length > 0 ? arenaDetails.bank_details[0].account_name : ''}}</span>
                   
                    <span v-if="!editmode" class="text-sm font-weight-medium detailed" > {{ arenaDetails && arenaDetails.bank_details && arenaDetails.bank_details.length > 0 ? arenaDetails.bank_details[0].bank_name : '' }}</span>
                    <!-- <span  class="select-field_container" :class="{'editmode-span': editmode}">
                        <select v-if="editmode"  class="text-sm font-weight-medium medium sign-name select-field_report"  @change="filterbank($event)" >
                            <option selected disabled>Select Bank</option>
                            <option v-for="b in arenaDetails.bank_details" :key="b.id"  :value="b.id" >{{b.bank_name}}</option>
                        </select>
                    </span> -->
                    <span class="text-sm font-weight-medium detailed" >{{  arenaDetails && arenaDetails.bank_details && arenaDetails.bank_details.length > 0 ? arenaDetails.bank_details[0].bank_number  : '' }}</span>
    
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
            bankAccounts: Array,
            banks: Array,
            arenaDetails: Object,
            // arenaId: Object,
            // bankId: Object,
           
            operatorName: String,
            editmode: Boolean,
            depositReplenishText: Object
        },
        data(){
            return {
                bankTarget: this.bank,
                // account: []
             }
        },
        methods: {
           
            filterbank(event){
              
                // const bankId = event.target.value

                // axios.put('api/updateBankSelection/'+this.arenaId.id, {
                //     bank_id: bankId
                // }).then(({data}) => {
                //  const selectedBank = data.bank_details.find(sb => sb.id === parseInt(data.bank_id));
              

                //     this.bankTarget = {
                //         account_name: selectedBank.account_name,
                //         bank_name: selectedBank.bank_name,
                //         bank_number: selectedBank.bank_number
                //     }
                // })

                // Fire.$emit('AfterCreated')
            },
        
        },
      
    }
</script>
