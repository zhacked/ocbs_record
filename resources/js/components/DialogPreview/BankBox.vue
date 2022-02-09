<template>
    <v-row>
        
        <div class="bank-wrapper mt-3 mb-2"  style="padding-left:30px; padding-right:30px; !important; min-height: 50px;">
            <div class="bank-headline mr-6"     >
                <span>{{depositReplenishText.bankTitle}}: </span>
            </div>

            <div   class="bank-container" v-if="depositReplenishText.totalText === 'Deposit'">
                <div class="bank bank1">
                        
                      <span class="bank_account-name">{{bankAccounts.length > 0 ? bankAccounts[0].account_name: 'LUCKY 8 STAR QUEST INC.'}}</span>
                    <span>{{bankAccounts.length > 0 ? bankAccounts[0].bank_name: 'PBB'}}</span>
                    <span>{{bankAccounts.length > 0 ? bankAccounts[0].bank_number: '0050-1001-5156'}}</span>
                </div>
               
                <div v-show="bankAccounts.length >= 2" class="or">
                    OR
                </div>
                 <div v-show="bankAccounts.length === 0" class="or">
                    OR
                </div>
                <div class="bank bank2">
                  
                     <span class="bank_account-name">{{bankAccounts.length === 0 ? 'LUCKY 8 STAR QUEST INC.' : bankAccounts.length > 1 ? bankAccounts[1].account_name : ''}}</span>
                    <span>{{bankAccounts.length === 0 ? 'PBCOM' : bankAccounts.length > 1 ? bankAccounts[1].bank_name : ''}}</span>
                    <span>{{bankAccounts.length === 0 ? '0248-20-100964-4' : bankAccounts.length > 1 ? bankAccounts[1].bank_number : ''}}</span>
                </div>
            </div>
         
            <div class="bank-container d-flex justify-center align-center" v-else >
                <div class="bank bank1" >  
                    <span class="text-sm font-weight-medium bank_account-name detailed" >{{Object.values(bankTarget).length ? bankTarget.account_name : banks.length > 0 ? banks[0].account_name : arenaDetails.bank_details.length > 0 ? arenaDetails.bank_details[0].account_name : ''}}</span>
                   
                    <span v-if="!editmode" class="text-sm font-weight-medium detailed" > {{ Object.values(bankTarget).length ? bankTarget.bank_name : banks.length > 0 ? banks[0].bank_name : arenaDetails.bank_details.length > 0 ? arenaDetails.bank_details[0].bank_name : '' }}</span>
                    <span  class="select-field_container" :class="{'editmode-span': editmode}">
                        <select v-if="editmode"  class="text-sm font-weight-medium medium sign-name select-field_report"  @change="filterbank($event)" >
                            <option selected disabled>Select Bank</option>
                            <option v-for="b in arenaDetails.bank_details" :key="b.id"  :value="b.id" >{{b.bank_name}}</option>
                        </select>
                    </span>
                    <span class="text-sm font-weight-medium detailed" >{{  Object.values(bankTarget).length ? bankTarget.bank_number : banks.length > 0 ? banks[0].bank_number : arenaDetails.bank_details.length > 0 ? arenaDetails.bank_details[0].bank_number  : '' }}</span>
    
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
            arenaId: Object,
            bankId: Object,
           
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
              
                const bankId = event.target.value

                axios.put('api/updateBankSelection/'+this.arenaId.id, {
                    bank_id: bankId
                }).then(({data}) => {
                 const selectedBank = data.bank_details.find(sb => sb.id === parseInt(data.bank_id));
              

                    this.bankTarget = {
                        account_name: selectedBank.account_name,
                        bank_name: selectedBank.bank_name,
                        bank_number: selectedBank.bank_number
                    }
                })

                Fire.$emit('AfterCreated')
            },
        //   loadDetials(){
        //             axios.get("api/Companybanks").then(({ data }) => {
        //                 this.account = data,
        //                 console.log('ACCOUNT',data);
        //                 });
        //     },
        },
        created(){
            // this.loadDetials()
        }
    }
</script>
<style scoped>
    .detailed{
        text-transform: uppercase; 
        font-weight: bold
    }
</style>