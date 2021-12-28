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
                    <span v-if="!editmode" > {{banks[0].bank_name}}</span>
                    <span  class="select-field_container" :class="{'editmode-span': editmode}">
                        <select v-if="editmode"  class="small sign-name select-field_report"  @change="filterbank($event)" >
                            <!-- <option default disabled :value="banks[0].id" >{{banks[0].bank_name}}</option> -->
                            <option v-for="bank in banks" :key="bank.id"  :value="bank.id" >{{bank.bank_name}}</option>
                        </select>
                    </span>
                    <span>{{banks[0].bank_number}}</span>
                   
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
            banks:Array,
            b: Object,
            arenaId: Number,
            operatorName: String,
            editmode: Boolean,
            depositReplenishText: Object
        },
        methods: {
           
            filterbank(event){
                console.log(event.target.value)
                //   axios.get("api/filterBank/"+ this.bank.bank_id).then(({data}) => (
                //        this.bank.bank_name = data.bank_name,
                //         this.bank.bank_number = data.bank_number
                //     ));

                axios.put('api/updateBankSelection/'+this.arenaId, {
                    bank_id: event.target.value
                })
            }
        }
    }
</script>