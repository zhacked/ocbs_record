<template >
    <v-app>
		<v-container>
			<v-row class="mt-5 is-blurred">
				<v-col class="col-md-12">
					<v-card >
						<v-card-title class="card-header">
							<strong> Arena Detials</strong>
                            <v-spacer></v-spacer>
							<v-card-actions class="card-tools">
								<v-btn color="success"
                                    elevation="2"  @click="openModal">Add Arena<i class="fas fa-plus fa-fw"></i></v-btn>
							</v-card-actions>
						</v-card-title>
                        <v-row>
                            <v-col>

                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="search"
                                    append-icon="mdi-magnify"
                                    label="Search"
                                     color="primary darken-2"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                     
                        <v-data-table
                            :headers="headers"
                            :items="arena.data"
                            :items-per-page="10"
                            :search="search"
                            class="elevation-1 text-center"
                        >   
                           
                             <template v-slot:[`item.bank`]="{ item }" >
                                <v-tooltip top>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn icon  v-bind="attrs" v-on="on"  color="green"  @click="openBankModel(item)">
                                            <v-icon small>mdi-bank</v-icon>
                                        </v-btn>
                                     </template>
                                    <span>Bank Information</span>
                                </v-tooltip>
                            </template>

                            <template v-slot:[`item.actions`]="{ item }" >
                                <v-tooltip top>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn icon  v-bind="attrs" v-on="on"  color="primary"  @click="editModal(item)">
                                            <v-icon small>fa fa-edit</v-icon>
                                        </v-btn>
                                     </template>
                                    <span>Update Arena</span>
                                </v-tooltip>
                                <v-tooltip top>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn icon  v-bind="attrs" v-on="on"  color="red" @click="deleteArena(item.id)">
                                          <v-icon small>fas fa-trash</v-icon>
                                        </v-btn>
                                     </template>
                                    <span>Delete Arena</span>
                                </v-tooltip>
                            </template>
                        </v-data-table>
						
					</v-card>
				</v-col>
			</v-row>

            		<!-- Bank Modal -->
			<div class="modal fade" id="bankModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" v-show="!editmode" id="addNewLabel">Bank Details</h5>
						<h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Bank Detials</h5>
                       
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>

                         <v-data-table
                            :headers="Bankheaders"
                            :items="bankDetails"
                            :items-per-page="5"
                            :search="searchbank"
                            class="elevation-1 text-center"
                        >  
                         <template v-slot:top>
                                <v-toolbar flat>
                                    <v-toolbar-title>
                                        <v-btn color="success"
                                            elevation="2"  @click="openBankDetails">Add Bank<i class="fas fa-plus fa-fw"></i>
                                        </v-btn>
                                    </v-toolbar-title>
                                    <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                    ></v-divider>
                                    <v-spacer></v-spacer>
                                    <div class="mt-4">
                                        <v-text-field
                                            v-model="searchbank"
                                            append-icon="mdi-magnify"
                                            label="Search"
                                            color="primary darken-2"
                                        ></v-text-field>
                                    </div>
                                </v-toolbar>
                            </template>

                            <template v-slot:[`item.actions`]="{ item }">
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on, attrs }">
                                                <v-btn
                                                color="primary"
                                                class="mx-2"
                                                icon
                                                dark
                                                v-bind="attrs"
                                                v-on="on"
                                                @click="updateBankDetails(item)"
                                                >
                                                <i class="fas fa-edit"></i>
                                                </v-btn>
                                        </template>
                                    <span>Edit Bank Info</span>
                                    </v-tooltip>
                                    |
                                     <v-tooltip top>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                            color="red"
                                            dark
                                            icon
                                            v-bind="attrs"
                                            v-on="on"
                                            class="mx-2"
                                            @click="deleteAccount(item.id)"
                                            >
                                            <i class="fa fa-trash"></i>
                                            </v-btn>
                                        </template>
                                    <span>Delete Bank info </span>
                                    </v-tooltip>
                            </template>
                         </v-data-table>
                        

                        <v-expand-transition>
                        <div v-show="show">
                             <v-card-title>
                                <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add Bank Details</h5>
                                <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Bank Detials</h5>
                                 <v-spacer></v-spacer>
                                 <v-icon color="red" @click="show=false" >
                                    mdi-close
                                 </v-icon>
                            </v-card-title>
                            <v-card-text>
                                <form @submit.prevent="editmode ? updateBank() : createBank()">
                                    <div class="modal-body">

                                          <v-text-field
                                            label="Account Name"
                                            placeholder="Enter Account Name"
                                            outlined
                                            dense
                                            v-model="Bankform.account_name"
                                             :rules="[() => !!Bankform.account_name || 'This field is required']"
                                        ></v-text-field>

                                        <v-text-field
                                            label="Bank Name"
                                            placeholder="Enter Bank Name"
                                            outlined
                                            dense
                                            v-model="Bankform.bank_name"
                                             :rules="[() => !!Bankform.bank_name || 'This field is required']"
                                        ></v-text-field>

                                        <v-text-field
                                            label="Bank Number"
                                            placeholder="Enter Bank number"
                                            outlined
                                            dense
                                            v-model="Bankform.bank_number"
                                             :rules="[() => !!Bankform.bank_number || 'This field is required']"
                                        ></v-text-field>
                                    </div>
                                    <div class="modal-footer">
                                        <v-btn type="button" color="error" elevation="2" data-dismiss="modal">Close</v-btn>
                                        <v-btn v-show="editmode" type="submit" color="primary" elevation="2">Update</v-btn>
                                        <v-btn v-show="!editmode" type="submit" color="success"  elevation="2">Create</v-btn>
                                    </div>

                                </form>

                            </v-card-text>
                        </div>
                        </v-expand-transition>
					</div>
				</div>
			</div>
					<!-- Modal -->
			<div class="modal fade" id="addNew" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" v-show="!editmode" id="addNewLabel">New Arena</h5>
						<h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Arena</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form @submit.prevent="editmode ? updateArena() : createArena()">
						<div class="modal-body">
                                <v-text-field
                                    label="Arena Name"
                                    outlined
                                    v-model="form.arena"
                                    :rules="[() => !!form.arena || 'This field is required']"
                                ></v-text-field>
							
                                <v-text-field
                                    label="Arena Address"
                                    outlined
                                    v-model="form.address"
                                    :rules="[() => !!form.address || 'This field is required']"
                                   :class="{ 'is-invalid': form.errors.has('address') }"
                                ></v-text-field>
                                 
								
                                 <v-text-field
                                    label="Operator Name"
                                    placeholder="john Doe"
                                    outlined
                                    v-model="form.operator"
                                    :rules="[() => !!form.operator || 'This field is required']"
                                ></v-text-field>
							
                                 <v-text-field
                                    label="Contact Number"
                                    placeholder="09121234567"
                                    outlined
                                    v-model="form.contact_number"
                                    :rules="[
                                        () => !!form.contact_number || 'This field is required',
                                        () =>   /^\d+$/.test(form.contact_number) || 'Must be a number',
                                        () =>  form.contact_number && form.contact_number.length >= 11 && form.contact_number.length <= 11|| 'This field must have atleast 11 digits'
                                    ]"
                                ></v-text-field>
				
                                  <v-combobox
                                    v-model="form.email"
                                    :items="emails.data"
                                    label="Email Address"
                                     hint="Maximum of 5 Emails"
                                    multiple
                                    chips
                                    outlined
                                    auto-select-first
                                    deletable-chips
                                    item-text='email'
                                   hide-selected
                                    :rules="[
                                    () => !!form.email || 'This field is required',
                                 
                                    ]"
                                    >
                                    <template v-slot:selection="data">
                                   
                                        <v-chip
                                        :key="JSON.stringify(data.item.email)"
                                        v-bind="data.attrs"
                                        :input-value="data.selected"
                                        :disabled="data.disabled"
                                        @click:close="selectItem(data.item.id) "
                                        close
                                        v-if="editmode"   
                                        >
                                       
                                        {{typeof data.item === 'object' ? data.item.email : data.item}}
                                        </v-chip>

                                        <v-chip
                                        :key="JSON.stringify(data.item.email)"
                                        v-bind="data.attrs"
                                        :input-value="data.selected"
                                        :disabled="data.disabled"
                                        v-else
                                        >
                                       
                                        {{typeof data.item === 'object' ? data.item.email : data.item}}
                                        </v-chip>
                                    </template>
                                    </v-combobox>


						</div>
						<div class="modal-footer">
							<v-btn type="button" color="error" elevation="2" data-dismiss="modal">Close</v-btn>
							<v-btn v-show="editmode" type="submit" color="primary" elevation="2">Update</v-btn>
							<v-btn v-show="!editmode" type="submit" color="success"  elevation="2">Create</v-btn>
						</div>

					</form>

					</div>
				</div>
			</div>
		</v-container>
	</v-app>
</template>

<script>
    export default {
        data() {
            return {
                
                headers: [
                    { text: "Arena Name", value: "arena" },
                    { text: "Address", value: "address" },
                    { text: "Operator", value: "operator" },
                    { text: "Bank Detials", value: "bank" },
                    { text: "", value: "actions", sortable: false },
                ],

                Bankheaders: [

                    { text: "Bank Name", value: "bank_name" },
                    { text: "Bank Number", value: "bank_number" },
                    { text: "", value: "actions", sortable: false },
                ],
                select: [],
              
                errorMessages: '',
                formHasErrors: false,
                editmode: false,
                arena : [],
                emails:[],
                search: '',
                searchbank:'',
                input: '',
                show:false,
                bankDetails : [],
                form: new Form({
                    id:'',
                    arena : '',
                    address: '',
                    operator: '',
                    contact_number: '',
                    email: [],
                }),
               Bankform: new Form({
                    id:'',
                    account_name:'',
                    arenas_id:'',
                    bank_name:'',
                    bank_number:''

                   
                })
                
            }
        },
        methods: {
           
            selectItem(id){
                
                axios.get('api/emailDelete/'+id).then((data)=>{
                    Fire.$emit('AfterCreate');
                     $('#addNew').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Email successfully Deleted'
                        })
                    });
                    
            },
            openBankDetails(){
                this.show = true;
                this.editmode = false;
                this.Bankform.bank_name = "";
                this.Bankform.bank_number = "";
            },
            openBankModel(data){
           
                this.show = false;
                 $('#bankModal').modal('show');
                this.bankDetails = data.bank_details;
                this.Bankform.arenas_id = data.id;
                this.Bankform.account_name = data.operator;
               
            },
            createBank(){

                this.$Progress.start();
                this.Bankform.post('api/bankaccount')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                 
                    Toast.fire({
                        icon: 'success',
                        title: 'Bank Created in successfully'
                        })
                     this.show = false;
                    $('#bankModal').modal('hide');
                    this.$Progress.finish();
                })
                .catch(()=>{
                })
            },
            updateBank(){
                this.$Progress.start();
                this.Bankform.put('api/bankaccount/'+this.Bankform.id)
                .then(() => {
                          
                     swal.fire(
                        'Updated!',
                        'Information has been updated.',
                        'success'
                        )
                        this.show = false;
                          $('#bankModal').modal('hide');
                        this.$Progress.finish();
                         Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            deleteAccount(id){
                 swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                         if (result.value) {
                                this.Bankform.delete('api/bankaccount/'+id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    Fire.$emit('AfterCreate');
                                    $('#bankModal').modal('hide');
                                }).catch(()=> {
                                    swal.fire("Failed!", "There was something wrong.", "warning");
                                });
                         }
                    })

            },
            updateBankDetails(accounts){
                this.Bankform.reset();
                this.show = true;
                this.editmode = true
                this.Bankform.fill(accounts);
                this.Bankform.arenas_id = accounts.arenas_id;
            },
            editBankModal(accounts){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(accounts);
                this.form.arenas_id = accounts.arenas_id;
               
            },
            updateArena(){
                this.$Progress.start();
                this.form.put('api/arena/'+this.form.id)
                .then(() => {
                    $('#addNew').modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: 'Successfully Updated'
                                
                                })
                        this.$Progress.finish();
                         Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            editModal(arenas){
                this.editmode = true;
                this.form.reset();
            
                $('#addNew').modal('show');
            
                this.form.id = arenas.id
                this.form.arena = arenas.arena
                this.form.address = arenas.address
                this.form.operator = arenas.operator
                this.form.contact_number = arenas.contact_number
               
                axios.get('api/getEmail/'+ arenas.arena).then((data) => {
                   this.emails = data
                   this.form.email = data.data
                    console.log(data.data)
                })

            },
            openModal(){
                
                this.editmode = false;
                this.form.reset();
                
                $('#addNew').modal('show');
            },
            deleteArena(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                      
                         if (result.value) {
                                this.form.delete('api/arena/'+id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                     swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                });
                         }
                    })
            },
            loadArena(){
                    axios.get("api/arena").then((data) => (
                       
                        this.arena = data
                        ));
            },
            createArena(){
                console.log(this.form.email)
                this.$Progress.start();
                this.form.post('api/arena')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                     Toast.fire({
                                icon: 'success',
                                title: 'Successfully Created'
                                
                                })
                
                    this.$Progress.finish();
                })
                .catch((e)=>{
                      console.log(e);
                     
                })
            }
        },
        created() {
           
           this.loadArena();
           Fire.$on('AfterCreate',() => {
               this.loadArena();
           });
        },
         watch: {
             "form.email": function (val) {
                    if (val.length > 5) {
                        this.$nextTick(() => this.form.email.pop())
                    }
                }
           
        }
    }
</script>
