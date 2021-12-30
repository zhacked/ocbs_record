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
                    <!-- <span>{{banks}}</span> -->
                    <span v-if="!editmode" > {{ bankSelected.bank_name || 'No Bank' }}</span>
                    <span  class="select-field_container" :class="{'editmode-span': editmode}">
                        <select v-if="editmode"  class="small sign-name select-field_report"  @change="filterbank($event)" >
                            <!-- <option default disabled :value="banks[0].id" >{{banks[0].bank_name}}</option> -->
                            <option v-for="bank in arenaDetails.bank_details" :key="bank.id"  :value="bank.id" >{{bank.bank_name}}</option>
                        </select>
                    </span>
                    <span>{{ bankSelected.bank_number || 'No Bank' }}</span>
                   
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
            return {bankSelected: {}}
        },
        methods: {
           
            filterbank(event){

                axios.put('api/updateBankSelection/'+this.arenaId.id, {
                    bank_id: event.target.value
                })
            },
            arenaSelectedBank(){
                
                    if(this.bankId.id) {
                        const bb = this.arenaDetails.bank_details.length > 0 ? parseInt(this.arenaDetails.bank_details[0].id) : null
                        const bId = this.bankId.id ? this.bankId.id : bb
                        
                        axios.get(`api/arenaSelectedBank/${bId}`).then(({data}) => {
                            this.bankSelected = data
                            console.log('BANK ARENA SELECTED',data)
                        })
                    }else {
                        this.bankSelected = {
                            name: this.arenaDetails.bank_details.length > 0 ? this.arenaDetails.bank_details[0].bank_name : null,
                            number: this.arenaDetails.bank_details.length > 0 ? this.arenaDetails.bank_details[0].bank_number : null
                        }
                    }
                   
                
                    
            }
        },
        created(){
            this.arenaSelectedBank()
        }
    }
</script>