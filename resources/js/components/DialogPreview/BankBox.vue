<template>
    <v-row>
        
        <div class="bank-wrapper"  style="padding-left:30px; padding-right:30px; !important;">
            <div class="bank-headline mr-6">
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
                bankTarget: this.bank
             }
        },
        methods: {
           
            filterbank(event){
              
                const bankId = event.target.value

                // this.bank = bank
                console.log(bankId)
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
            // arenaSelectedBank(){
            //     const bb = this.arenaDetails.bank_details.length > 0 ? parseInt(this.arenaDetails.bank_details[0].id) : null
            //     const bId = this.bankId.id ? this.bankId.id : bb
                        
            //     axios.get(`api/arenaSelectedBank/${bId}`).then(({data}) => {
            //         this.bank = data
            //         console.log('BANK ARENA SELECTED',data)
            //     })
            // }
        },
        created(){
            // this.arenaSelectedBank()
        }
    }
</script>