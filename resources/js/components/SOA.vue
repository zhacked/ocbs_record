<template>
          <v-app>
		<v-container>
			<v-row class="mt-5">
				<v-col class="col-md-12">
					<v-card >
						<v-card-title class="card-header">
							<strong> Statement of Account</strong>
                            <v-spacer></v-spacer>
                            <form @submit.prevent="proceedAction()">
							<v-card-actions class="card-tools" >
                               <label class="form-control-label"  for="input-file-import"></label>
                                <!--<input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file"  @change="onFileChange"> -->
                                <input type="file" id="importData"  class="form-control" @change="onFileChange">
                              	<v-btn type="submit" color="success"  elevation="2">send</v-btn>
							</v-card-actions>
                            </form>
						</v-card-title>

                            <div class="card card-primary card-outline" style="overflow: auto; !important">
                                
                                <div class="card-body"  >
                                    <v-card-title>
                                        SOA Report
                                        <v-spacer></v-spacer>
                                   
                                        <v-text-field
                                            v-model="search"
                                            append-icon="mdi-magnify"
                                            label="Search"
                                            class="mx-4"
                                        ></v-text-field>
                                
                                    </v-card-title>
                                <v-data-table
                                        :headers="headers"
                                        :items="arenaData.data"
                                        :items-per-page="10"
                                        :search="search"
                                        class="elevation-1 text-center"
                                    >
                                 
                                <template v-slot:[`item.actions`]="{ item }">
                                        <button class="btn btn-primary" @click="openModel(item, commission_percent)">
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
        <v-dialog v-model="dialog" scrollablemax-width="300px">
			<div class="modal fade "    id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true"  >
				<div class="modal-dialog modal-xl modal-dialog-centered overflow-auto" role="document"  >
					<div class="modal-content"  style="padding:80px 100px;" >
                        <div class="text-align-center" >
                                 <div class="modal-header mb-4">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <i class="fas fa-window-close text-danger"></i>
                                    </button>
                                </div>
                            <h1 class="modal-title w-100 text-center">Statement of Account</h1>
                            
                            <div class="modal-body" style="overflow-y: auto;">
                                <div class="text-right ">
                                        <v-row class=" mb-1  no-gutters" >
                                            <v-col class="col-sm-10 mt-2">
                                                SOA # : &nbsp;
                                            </v-col>
                                            <v-col class=" col-sm-2">
                                                 <input type="text" readonly class="form-control form-control-sm" id="inputName" placeholder="SOA-xxxxxxx" >
                                            </v-col>
                                        </v-row>
                                        <v-row class=" mb-1 no-gutters">
                                            <v-col class="col-sm-10  mt-2">
                                               Date of  SOA : &nbsp;
                                            </v-col>
                                            <v-col class="col-sm-2">
                                                 <input type="text" readonly class="form-control form-control-sm" id="inputName" placeholder="" >
                                            </v-col>
                                        </v-row>
                                         <v-row class=" mb-1 no-gutters" >
                                            <v-col class="col-sm-10  mt-2">
                                               Date of Event : &nbsp;
                                            </v-col>
                                            <v-col class="col-sm-2">
                                                 <input type="text" readonly class="form-control form-control-sm" id="inputName" placeholder="" >
                                            </v-col>
                                        </v-row>
                                </div>

                                <div class="mt-5 pt-5">
                                    <v-row  class=" mb-1 no-gutters" >
                                        <v-col class="col-sm-2 mt-2">
                                               Arena / OCBS Name : 
                                        </v-col>
                                        <v-col class="col-sm-10" >
                                             <input type="text" readonly v-model="form.arena" class="form-control form-control-sm" id="inputName" placeholder="Enter OCBS Name" 
                                             :class="{ 'is-invalid': form.errors.has('arena') }" >
                                            <has-error :form="form" field="arena"></has-error>
                                               
                                        </v-col>
                                    </v-row>
                                    <v-row  class=" mb-1 no-gutters" >
                                        <v-col class="col-sm-2 mt-2">
                                               Address : 
                                        </v-col>
                                        <v-col class="col-sm-10" >
                                             <input type="text" readonly v-model="form.address" class="form-control form-control-sm" id="inputName" placeholder="Enter address"
                                             :class="{ 'is-invalid': form.errors.has('address') }" >
                                            <has-error :form="form" field="address"></has-error>
                                        </v-col>
                                    </v-row>
                                    <v-row  class=" mb-1 no-gutters" >
                                        <v-col class="col-sm-2 mt-2">
                                               Operator : 
                                        </v-col>
                                        <v-col class="col-sm-10" >
                                                <input type="text" readonly v-model="form.operator" class="form-control form-control-sm" id="inputName" placeholder="Enter Operator Name" 
                                                :class="{ 'is-invalid': form.errors.has('operator') }" >
                                                <has-error :form="form" field="operator"></has-error>
                                        </v-col>
                                    </v-row>
                                    <v-row   class=" mb-1 no-gutters">
                                        <v-col class="col-sm-2 mt-2">
                                               Contact Number : 
                                        </v-col>
                                        <v-col class="col-sm-10" >
                                            <input type="text" readonly v-model="form.contact_number" class="form-control form-control-sm" id="inputName" placeholder="0912-345-7894" 
                                                :class="{ 'is-invalid': form.errors.has('contact_number') }" >
                                                <has-error :form="form" field="contact_number"></has-error>
                                               
                                        </v-col>
                                    </v-row>
                                    <v-row  class=" mb-1 no-gutters" >
                                        <v-col class="col-sm-2 mt-2">
                                               Email Address :  
                                        </v-col>
                                        <v-col class="col-sm-10" >
                                             <input readonly v-model="form.email" type="email" name="email"
                                                placeholder="sample@gmail.com" 
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                            <has-error :form="form" field="email"></has-error>
                                        </v-col>
                                    </v-row>
                                </div>

                                <!-- computation -->
                                <div style="border:1px solid black;" class="mt-5">
                                    <h5 class="w-100 text-center pt-1">Computation</h5>
                                </div>

                                <div  class="mt-5">
                                    <v-row>
                                        <!-- left -->
                                        <v-col class="text-right">
                                            <p class="w-100 text-center pa-0 mx-0">(Kiosk)</p>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total M/W Bets : &nbsp; &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text"  v-model="computation.totalMWBet" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Cancelled Bets : <span class="text-success text-bold"> + </span>&nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" v-model="computation.drawCancelled" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Draw Bets : <span class="text-success text-bold"> + </span> &nbsp;
                                                </v-col> 
                                                <v-col class="col-sm-6" >
                                                        <input type="text" v-model="computation.draw" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Payout Paid : <span class="text-danger text-bold"> - </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" v-model="computation.totalPayoutPaid" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total C/D Paid : <span class="text-danger text-bold"> - </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" v-model="computation.cdPaid" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Draw Paid : <span class="text-danger text-bold"> - </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" v-model="computation.drawPaid" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <hr>
                                            <v-row  class=" mb-1 no-gutters pb-5" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Net Win/Loss : <span class="text-primary text-bold"> = </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" v-model="computation.netWinLoss" class="form-control form-control-sm computation" id="inputName" placeholder="" >
                                                </v-col>
                                            </v-row>


                                            <!-- mobile -->
                                            <div class="mt-5 pt-4">
                                                <p class="w-100 text-center pa-0 mx-0">(Mobile)</p>
                                                <v-row  class=" mb-1 no-gutters" >
                                                    <v-col class="col-sm-6 mt-2">
                                                        Total M/W Bets : &nbsp; &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6" >
                                                            <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                    </v-col>
                                                </v-row>
                                                <v-row  class=" mb-1 no-gutters" >
                                                    <v-col class="col-sm-6 mt-2">
                                                        Total Draw Bets : &nbsp; &nbsp;
                                                    </v-col>
                                                    <v-col class="col-sm-6" >
                                                            <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                    </v-col>
                                                </v-row>
                                            </div>
                                        </v-col>

                                        <!-- right -->
                                        <v-col class="text-right">
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Net Win/Loss : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" v-model="computation.netWinLoss" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <hr>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    M/W * {{this.commission_percent}} (kiosk) : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" v-model="computation.totalMWBetPercent" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                   Draw * {{this.commission_percent}} (kiosk) : <span class="text-success text-bold"> + </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                     M/W * {{this.commission_percent}} (mobile) : <span class="text-success text-bold"> + </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Draw * {{this.commission_percent}} (mobile) : <span class="text-success text-bold"> + </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Unclaimed : <span class="text-success text-bold"> + </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row><v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total C unpaid : &nbsp; &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Operator Expenses : &nbsp; &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Net operator's Commission : <span class="text-primary text-bold"> = </span> &nbsp; 
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Cash Load from Mobile : <span class="text-success text-bold"> + </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Cash Withdraw from Mobile : <span class="text-danger text-bold"> - </span>  &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <hr>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    For {{this.status}} : <span class="text-primary text-bold"> = </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <hr>
                                            <hr>
                                        </v-col>

                                    </v-row>
                                </div>

                                <!-- kindly deposit -->
                                <v-row>
                                    <v-col class="col-sm-9">
                                        <div  style="border:1px solid black; " class="mt-5 pl-5 text-left">
                                            <v-row  class="no-gutters" >
                                                <v-col class="col-sm-3">
                                                    Kindly Deposit To : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-9" >
                                                    <span> {{this.status == 'Deposit' ? 'LUCKY 8 STAR QUEST INC' : '' }}</span>
                                                   
                                                </v-col>
                                            </v-row>
                                            <v-row  class="no-gutters pa-0" >
                                                <v-col class="col-sm-3 ">
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-9 no-gutters" >
                                                    <v-col class="col-sm-6 ">
                                                        <span v-if="editmode" >{{selectedbank.bank_name}}</span>

                                                         <select v-else name="type"  v-model="bankaccount_id" id="arena_id" class="form-control form-control-sm pa-0" >
                                                            <option v-for="banks in bank" :key="banks.id"  :value="banks.id" >{{banks.bank_name}}</option>
                                                        </select>
                                                    </v-col>
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters pa-0 " >
                                                <v-col class="col-sm-3 ">
                                                    &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-9 no-gutters" >
                                                     <v-col class="col-sm-6 ">
                                                        <span v-if="editmode" >{{ selectedbank.bank_number}}</span>

                                                         <!-- <select  name="type" id="arena_id" class="form-control form-control-sm" >
                                                            <option v-for="bank in bankDetails" :key="bank.id"  :value="bank.id" >{{bank.bank_number}}</option>
                                                        </select> -->
                                                    </v-col>
                                                </v-col>
                                            </v-row>
                                        </div>
                                    </v-col>
                                    <v-col class="col-sm-3">
                                        
                                    </v-col>
                                </v-row>
                                

                                <!-- signiture -->
                                <div  class="mt-5 pl-5 ">
                                    <v-row>
                                        <!-- left -->
                                        <v-col>
                                             <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6">
                                                    Computed by : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                    name here
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 ">
                                                    Prepared by : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                  
                                                </v-col>
                                            </v-row>
                                        </v-col>

                                        <!-- right -->
                                         <v-col>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 ">
                                                    Checked by : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                    name here
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 ">
                                                    Checked by : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                    name here
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                </div>     
                            </div>
                        </div>
                        <div class="modal-footer w-100">
                            <div class="text-left  ">
                                <v-row class=" no-gutters ">
                                    <v-col class="col-md-8">
                                          <span>Select commission % : </span>
                                    </v-col>
                                    <v-col  class="col-md-4">
                                        <input type="text"   v-model="commission_percent" @change="handleCommissionPercent" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                    </v-col>
                                </v-row>
                               
                            </div>
                            <v-spacer></v-spacer>
                            <div class="text-right">
                             
                                    <button type="button" v-show="editmode" class="btn btn-outline-primary" @click="updateModal()">Edit</button>
                                    <button type="button" v-show="!editmode" class="btn btn-outline-primary" @click="saveModal()">Save</button>
                                    <button type="button" class="btn btn-outline-success">Save as PDF</button>
                                   
                            </div>
                          
                        </div>
					</div>
				</div>
                 
                        
			</div>
        </v-dialog>
            
        
		</v-container>
	</v-app>
</template>
<script>
import { camelCase } from "lodash";
import XLSX from "xlsx";
    export default {
        data() {
            return {    
            headers: [
                    { text: 'Arena Name', value: 'arena_name' },
                    { text: 'Operator', value: 'arena_details.operator' },
                    { text: 'Contact', value: 'arena_details.contact_number'},
                    { text: '', value: 'actions', sortable: false },
                ],
            reportCombined: [],
            ocbsArray: [],
            ocbsArrayFiltered: [],
            editmode: false,
            search: '',
            commission_percent:'0.02',
            status:'Deposit',
            ocbs: {},
            bankDetails: {},
            bank:{},
            arenaData: [],
            arenaDetails:{},
            
            selectedbank:[],
            arena_id : '',
            form: new Form({
                    id:'',
                    arena: '',
                    address : '',
                    operator: '',
                    contact_number: '',
                    email: '',
                }),

            bankaccount_id:'',
            computation: {
                totalMWBet: 0,
                drawCancelled: 0,
                draw: 0,
                totalPayoutPaid: 0,
                cdPaid: 0,
                drawPaid: 0,
                netWinLoss: 0,
                totalMWBetPercent: 0

            }

        
            }
        },
        methods: {
<<<<<<< HEAD
            
           showData(){
                axios.get("api/import").then((data) => ( this.arenaData = data));
=======
           async showData(){
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
                            cashWithdrawMobile: 0,
                            cashLoadMobile: 0,
                        };
                    }

                    return r;
                }, []);

                
                const obj = {
                    data: duplicateObj
                }

                this.arenaData = obj;
>>>>>>> eaaaea97be26a46b30e8a8c88edd1cb85b93d8b4
            },
            updateModal(){
                $('.computation').attr("disabled", false);
                this.editmode = false;

            },
            saveModal(){
                $('.computation').attr("disabled", true);
                this.editmode = true;
                axios.get('api/updateBank/' + this.arena_id+'/' + this.bankaccount_id).then((data)=>{
                    Fire.$emit('AfterCreate')
                     swal.fire(
                        'Successfully!',
                        'Updated',
                        'success'
                        )
                })
              
             
            },
            test(){
                 axios.get('api/savePrimaryBank/'+this.arena_id).then(({data}) => (this.selectedbank = data));
            },
            proceedAction(){
                this.$Progress.start();
                axios.post('api/import',this.ocbsArrayFiltered).then(({ data }) => (
                    $('#importData').val(''),
                     Fire.$emit('AfterCreate'),
                      swal.fire(
                        'Successfully!',
                        'Excel Imported',
                        'success'
                        ),
                    this.$Progress.finish()
                   
                ));
            },
            handleCommissionPercent(e) {
                console.log('TARGET',e.target.value)
                this.commission_percent = e.target.value;
                console.log(this.computation.netWinLoss)
                this.computation.totalMWBetPercent = parseFloat(this.computation.netWinLoss) * parseFloat(e.target.value);
                
            },
            openModel(data, commission){
                console.log(commission)
                this.form.reset();
<<<<<<< HEAD
                this.dialog = true;
                // $('#addNew').modal({backdrop: 'static', keyboard: false}, 'show');
                
                this.total_m_w_bet = data.total_meron_wala;
=======
                $('#addNew').modal('show');
              
>>>>>>> eaaaea97be26a46b30e8a8c88edd1cb85b93d8b4
                this.form.fill(data.arena_details);
                this.arenaDetails = data.arena_details;
                this.arena_id = data.id;
                $('.computation').attr("disabled", true);
                this.editmode = true;
                Fire.$emit('AfterCreate'),
                axios.get('api/bankfilter/'+ data.arena_details.id).then(({data}) => ( this.bank = data));
            
                const totalMWBet = data.total_meron_wala;
                const drawCancelled = data.draw_cancelled;
                const draw = data.draw;
                const totalPayoutPaid = data.total_payout_paid;
                const cdPaid = data.draw_cancelled_paid;
                const drawPaid = data.draw_paid
                const netWinLoss = parseFloat(totalMWBet) + parseFloat(drawCancelled) + parseFloat(draw) - parseFloat(totalPayoutPaid) - parseFloat(cdPaid) - parseFloat(drawPaid);
                const totalMWBetPercent = parseFloat(totalMWBet) * parseFloat(this.commission_percent);
                console.log(totalMWBetPercent)


                this.computation = {
                        totalMWBet,
                        drawCancelled,
                        draw,
                        totalPayoutPaid,
                        cdPaid,
                        drawPaid,
                        netWinLoss,
                        totalMWBetPercent
                    }
               
            },
        
            onFileChange(event) {
                const file = event.target.files ? event.target.files[0] : null;
                if (file) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                    // eslint-disable-next-line no-unused-vars
                    /* Parse data */
                    const bstr = e.target.result;
                    const wb = XLSX.read(bstr, { type: "binary" });
                    /* Get first worksheet */
                    const wsname = wb.SheetNames[0];
                    const ws = wb.Sheets[wsname];
                    /* Convert array of arrays */
                    const data = XLSX.utils.sheet_to_json(ws, {header: 1});
                    
                    data.map(r => {
                        if(Object.keys(r).length >= 17) this.reportCombined.push(Object.assign({}, r))
                    })
                    

                    let objectKeyReplacedArray = [];
                    const [, ...headKey] = Object.values(this.reportCombined[0]);
                    const headK = ["key",...headKey]
                    
                    this.reportCombined.map((data) => {
                        data = Object.assign({}, ...Object.entries(data)
                        .map(([, prop], index) => ({[camelCase(headK[index])]: prop})));
                        objectKeyReplacedArray.push(data)
                    })


                    const filterObjectHeader = objectKeyReplacedArray.filter((obk) => {
                        if(obk.arenaName !== 'OCBS NAME' && obk.arenaName !== 'ARENA NAME') return obk;
                    });

                    const removeKeyReportObject = filterObjectHeader.map(({key, ...rest}) => ({...rest}));

                        
            
                    this.ocbsArrayFiltered = removeKeyReportObject;

                    };

                    reader.readAsBinaryString(file);

                    
                }

            },

        },
        created() {
           this.showData();
     
           Fire.$on('AfterCreate',() => {
                  this.showData();
                    this.test();
            });
        }
    }
</script>

