<template>
    <v-row>
        
        <div class="bank-wrapper"  style="padding-left:30px; padding-right:30px; !important;">
            <div class="bank-headline mr-6">
                <span>{{depositReplenishText.bankTitle}}: </span>
            </div>

            <div   class="bank-container" v-if="depositReplenishText.totalText =='Deposit'">
                <div class="bank bank1">
                  
                      <span>{{account.length > 0 ? account[0].account_name: 'LUCKY 8 STAR QUEST INC.'}}</span>
                    <span>{{account.length > 0 ? account[0].bank_name: 'PBB'}}</span>
                    <span>{{account.length > 0 ? account[0].bank_number: '0050-1001-5156'}}</span>
                </div>
                <div v-if="account.length > 1" class="or">
                    OR
                </div>
                <div v-if="account.length > 1"  class="bank bank2">
                  
                     <span>{{account.length > 1 ? account[1].account_name: 'LUCKY 8 STAR QUEST INC.'}}</span>
                    <span>{{account.length > 1 ? account[1].bank_name: 'PBB'}}</span>
                    <span>{{account.length > 1 ? account[1].bank_number: '123-1232-1232'}}</span>
                </div>
            </div>
         
            <div class="bank-container d-flex justify-center align-center" v-else >
                <div class="bank bank1">  
                    <span class="text-sm font-weight-medium">{{operatorName}}</span>
                   
                    <span v-if="!editmode" class="text-sm font-weight-medium"> {{ Object.values(bankTarget).length ? bankTarget.bank_name : bank.bank_name || 'No Bank' }}</span>
                    <span  class="select-field_container" :class="{'editmode-span': editmode}">
                        <select v-if="editmode"  class="text-sm font-weight-medium medium sign-name select-field_report"  @change="filterbank($event)" >
                            <option selected disabled>Select Bank</option>
                            <option v-for="b in arenaDetails.bank_details" :key="b.id"  :value="b.id" >{{b.bank_name}}</option>
                        </select>
                    </span>
                    <span class="text-sm font-weight-medium">{{  Object.values(bankTarget).length ? bankTarget.bank_number : bank.bank_number || 'No Bank' }}</span>
                   
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
                account: []
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
                        bank_name: selectedBank.bank_name,
                        bank_number: selectedBank.bank_number
                    }
                })

                Fire.$emit('AfterCreated')
            },
          loadDetials(){
                    axios.get("api/Companybanks").then(({ data }) => {
                        this.account = data,
                        console.log('ACCOUNT',data);
                        });
            },
        },
        created(){
            this.loadDetials()
        }
    }
</script>