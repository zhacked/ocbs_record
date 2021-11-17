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
                                    <v-data-table
                                        :headers="headers"
                                        :items="arenaData.data"
                                        :items-per-page="10"
                                        class="elevation-1 text-center"
                                    >
                                <template v-slot:[`item.actions`]="{ item }">
                                        <button class="btn btn-primary" @click="openModel(item)">
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
			<div class="modal fade" id="addNew" tabindex="-1" width="100" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true"  >
				<div class="modal-dialog modal-xl modal-dialog-centered " role="document"  >
					<div class="modal-content" style="padding:80px 100px;" >
                        <div class="text-align-center" >
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button> -->
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
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Cancelled Bets : <span class="text-success text-bold"> + </span>&nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Draw Bets : <span class="text-success text-bold"> + </span> &nbsp;
                                                </v-col> 
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Payout Paid : <span class="text-danger text-bold"> - </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total C/D Paid : <span class="text-danger text-bold"> - </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Total Draw Paid : <span class="text-danger text-bold"> - </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <hr>
                                            <v-row  class=" mb-1 no-gutters pb-5" >
                                                <v-col class="col-sm-6 mt-2">
                                                    Net Win/Loss : <span class="text-primary text-bold"> = </span> &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="" >
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
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
                                                </v-col>
                                            </v-row>
                                            <hr>
                                            <v-row  class=" mb-1 no-gutters" >
                                                <v-col class="col-sm-6 mt-2">
                                                    M/W * {{this.commission_percent}} (kiosk) : &nbsp;
                                                </v-col>
                                                <v-col class="col-sm-6" >
                                                        <input type="text" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
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
                                                        <span v-if="editmode" >!Select bank name by click edit button</span>

                                                         <select v-else name="type" id="arena_id" class="form-control form-control-sm pa-0" >
                                                            <option value="">Select Bank</option>
                                                            <option v-for="bank in bankDetials" :key="bank.id"  :value="bank.id" >{{bank.bank_name}}</option>
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
                                                        <span v-if="editmode" >!Select bank number by click edit button</span>

                                                         <select v-else name="type" id="arena_id" class="form-control form-control-sm" >
                                                            <option value="">Select Bank</option>
                                                            <option v-for="bank in bankDetials" :key="bank.id"  :value="bank.id" >{{bank.bank_number}}</option>
                                                        </select>
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
                                        <input type="text"   v-model="this.commission_percent" class="form-control form-control-sm computation" id="inputName" placeholder="0" >
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
            commission_percent:'0.02',
            status:'Deposit',
            ocbs: {},
            bankDetials: {},
            arenaData: [],
            form: new Form({
                    id:'',
                    arena: '',
                    address : '',
                    operator: '',
                    contact_number: '',
                    email: '',
                })
        

            }
        },
        methods: {
            
           showData(){
                axios.get("api/import").then((data) => ( this.arenaData = data,console.log(data.data)));
            },
            updateModal(){
                $('.computation').attr("disabled", false);
                this.editmode = false;

            },
            saveModal(){
                $('.computation').attr("disabled", true);
                this.editmode = true;
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
            openModel(data){
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(data.arena_details);
                this.bankDetials = data.bank_details;
                $('.computation').attr("disabled", true);
                this.editmode = true;
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

                        
                    
                    // For Kiosk-MObile wth same Arena Name
                    let helper = {};
                    const duplicateObj = removeKeyReportObject.reduce(function (r, obj) {
                        const key = obj.arenaName;
                        
                        if (!helper[key]) {
                        helper[key] = Object.assign({}, obj); // create a copy of o

                        r.push(helper[key]);
                        } else {
                            const {arenaName, ...o} = obj;
                        helper[key].mobile = { ...o };
                        }

                        return r;
                    }, []);

                    this.ocbsArrayFiltered = duplicateObj;

                    };

                    reader.readAsBinaryString(file);

                    
                }

            },

        },
        created() {
           this.showData();
           Fire.$on('AfterCreate',() => {
                  this.showData();
            });
        }
    }
</script>

