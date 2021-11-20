<template >
    <v-app>
		<v-container>
			<v-row class="mt-5">
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
                                        <v-btn icon  v-bind="attrs" v-on="on"  color="red" @click="deleteUser(item.id)">
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


					<!-- Modal -->
			<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
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
                                    placeholder="0912-123-4567"
                                    outlined
                                    v-model="form.contact_number"
                                    :rules="[() => !!form.contact_number || 'This field is required']"
                                ></v-text-field>
				
                                <v-text-field
                                    label="Email"
                                     placeholder="sample@gmail.com"
                                    outlined
                                   
                                    v-model="form.email"
                                    :rules="[() => !!form.email || 'This field is required']"
                                ></v-text-field>
							
	
                            <hr>
                            <p>
                               <strong>Add Bank Details</strong>  <span><button  type="button" class="btn btn-success text-white" style="border-radius:50%"  @click="addField()"><i class="fas fa-plus" aria-hidden="true"></i></button></span>
                            </p>
                            <v-container >
                                 <v-row fluid class="add" v-for="(input,index) in inputs" :key="index">
                                                <v-col class="col-5">
                                                    <v-text-field
                                                        label="Bank Name"
                                                        placeholder="BDO"
                                                        outlined
                                                         v-model="input.bank_name" 
                                                        :rules="[() => !!input.bank_name || 'This field is required']"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col  class="col-6">
                                                    <v-text-field
                                                        label="Bank Number"
                                                        placeholder="xxx-xxx-xxx"
                                                        outlined
                                                        v-model="input.bank_number"
                                                        :rules="[() => !!input.bank_number || 'This field is required']"
                                                    ></v-text-field>
                                                   
                                                </v-col>
                                                <v-col  class="col-1">
                                                    <span class="d-flex justify-content-center align-items-center h-100 d-inline-block" tabindex="0"  @click="removeField(index)" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" title="Remove column"><i class="fas fa-trash text-danger" aria-hidden="true"></i></span> 
                                                </v-col>
                                    
                                </v-row>
                            </v-container>
                           
                          

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
                inputs: [{
                    bank_name: null,
                    bank_number: null,
                }],
                headers: [
                    { text: "Arena Name", value: "arena" },
                    { text: "Address", value: "address" },
                    { text: "Operator", value: "operator" },
                    { text: "", value: "actions", sortable: false },
                ],
                errorMessages: '',
                formHasErrors: false,
                editmode: false,
                arena : {},
                search: '',
                input: '',
                form: new Form({
                    id:'',
                    arena : '',
                    address: '',
                    operator: '',
                    contact_number: '',
                    email: '',
                }),
               
                
            }
        },
        methods: {
            
            addField(index) {
                 
                    this.inputs.push({
                        bank_name: "",
                        bank_number: "",
                      
                    });
                },
            removeField(index) {
                  
                    swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                         if (result.value) {
                               let x =  this.inputs.splice(index, 1);
                                this.form.delete('api/bankaccount/'+x[0].id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                   this.inputs.splice(index, 1);
                                });
                         }
                    })
                   
                },
            getResults(page = 1) {
                        axios.get('api/arena?page=' + page)
                            .then(response => {
                                this.arena = response.data;
                            });
                },
            updateArena(){
                this.$Progress.start();
                this.form.bank_details = this.inputs
                this.form.put('api/arena/'+this.form.id)
                .then(() => {
                    $('#addNew').modal('hide');
                     swal.fire(
                        'Updated!',
                        'Information has been updated.',
                        'success'
                        )
                        this.$Progress.finish();
                         Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            deleteColum(){

            },
            editModal(arenas){
                this.editmode = true;
                this.form.reset();
                this.inputs= '';
                $('#addNew').modal('show');
                this.form.fill(arenas);

                this.inputs = arenas.bank_details;
            },
            openModal(){
                this.editmode = false;
                this.inputs== '';
                this.form.reset();
                
                $('#addNew').modal('show');
            },
            deleteArena(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
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
                    axios.get("api/arena").then(({ data }) => (
                        this.arena = data
                        ));
            },
            createArena(){
                this.$Progress.start();
                this.form.bank_details = this.inputs
                this.form.post('api/arena')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                     swal.fire(
                                'Save!',
                                'You create new Arena.',
                                'success'
                        )
                    this.$Progress.finish();
                })
                .catch((e)=>{
                       swal.fire(
                                'Error!',
                                'Bank Detials is Required!',
                                'error'
                        )
                     
                })
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('api/findUser?q=' + query)
                .then((data) => {
                    this.users = data.data
                })
                .catch(() => {
                })
            })
           this.loadArena();
           Fire.$on('AfterCreate',() => {
               this.loadArena();
           });
        }
    }
</script>
