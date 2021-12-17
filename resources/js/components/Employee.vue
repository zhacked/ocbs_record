<template >
    <v-app>
		<v-container>
			<v-row class="mt-5 is-blurred"  v-if="$gate.isAdmin()">
            
				<v-col class="col-md-12">
					<v-card >
						<v-card-title class="card-header">
                             User Management
                             <v-spacer></v-spacer>
							<v-card-actions class="card-tools">
								<v-btn color="success"
                                    elevation="2"  @click="newModal">Register Employee <i class="fas fa-user-plus fa-fw"></i></v-btn>
							</v-card-actions>
						</v-card-title>

                           
					 <div
                            class="card card-primary card-outline card-tabs"
                            style="overflow: auto; !important"
                        >
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul
                                    class="nav nav-tabs"
                                    id="custom-tabs-three-tab"
                                    role="tablist"
                                >
                                    <li class="nav-item">
                                        <a
                                            class="nav-link active"
                                            id="custom-tabs-three-home-tab"
                                            data-toggle="pill"
                                            href="#custom-tabs-three-home"
                                            role="tab"
                                            aria-controls="custom-tabs-three-home"
                                            aria-selected="true"
                                            >Employeement Record</a
                                        >
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            id="custom-tabs-three-profile-tab"
                                            data-toggle="pill"
                                            href="#custom-tabs-three-profile"
                                            role="tab"
                                            aria-controls="custom-tabs-three-profile"
                                            aria-selected="false"
                                            >Choose Record</a
                                        >
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent active show">
                                  
                                  
                                    <div
                                        class="tab-pane fade active show"
                                        id="custom-tabs-three-home"
                                        role="tabpanel"
                                        aria-labelledby="custom-tabs-three-home-tab"
                                    >
                                      
                                   <v-row>
                                        <v-col>

                                        </v-col>
                                        <v-col>
                                            <v-text-field
                                                v-model="search"
                                                append-icon="mdi-magnify"
                                                label="Search"
                                                class="mx-4"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                   <v-data-table
                                            :headers="headers"
                                            :items="employee"
                                            :search="search"
                                            class="elevation-1 text-center"
                                        
                                        >
                                    <template v-slot:[`item.assign`]="{ item }">
                                            <v-icon v-show="item.assign=='1'" large color="green">mdi-check</v-icon>
                                            <!-- <v-checkbox
                                            v-model="item.assign"
                                            :false-value="0"
                                            :true-value="1"
                                                color="green"
                                                class="elevation"
                                                @change="checked(item)"
                                            disabled
                                                >
                                            </v-checkbox>     -->
                                    </template>

                                    <template v-slot:[`item.actions`]="{ item }">

                                            <v-tooltip bottom>
                                                <template v-slot:activator="{ on, attrs }">
                                                        <v-btn
                                                        color="primary"
                                                        class="mx-2"
                                                        icon
                                                        dark
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        @click="editModal(item)"
                                                        >
                                                        <i class="fas fa-edit"></i>
                                                        </v-btn>
                                                </template>
                                            <span>Edit User Info</span>
                                            </v-tooltip>
                                            |
                                            <v-tooltip bottom>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-btn
                                                    color="red"
                                                    dark
                                                    icon
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    class="mx-2"
                                                    @click="deleteUser(item.id)"
                                                    >
                                                    <i class="fa fa-trash"></i>
                                                    </v-btn>
                                                </template>
                                            <span>Delete info User</span>
                                            </v-tooltip>
                                    </template>
                                    </v-data-table>
                                      
                                    </div>

                                    <div
                                        class="tab-pane fade"
                                        id="custom-tabs-three-profile"
                                        role="tabpanel"
                                        aria-labelledby="custom-tabs-three-profile-tab"
                                    >
                                       
                                       <v-row>
                                           <v-col>
                                                 <v-select
                                                        label="Computed By"
                                                        v-model="selectComputed"
                                                        :items="userPrepared.computed"
                                                        name="client"
                                                         item-text="name"
                                                        item-value="id"
                                                        return-object
                                                        @change="selectedrecord(selectComputed)"
                                                    ></v-select>
                                           </v-col>
                                           <v-col>
                                                   <v-select
                                                   
                                                        label="Checked By"
                                                        v-model="selectChecked1"
                                                        :items="userPrepared.checked1"
                                                        name="client"
                                                         item-text="name"
                                                        item-value="id"
                                                        return-object
                                                        @change="selectedrecord(selectChecked1)"
                                                    ></v-select>
                                           </v-col>
                                       </v-row>
                                        <v-row>
                                           <v-col>
                                                    <v-select
                                                       
                                                        label="Prepared By"
                                                        v-model="selectPrepared"
                                                        :items="userPrepared.prepared"
                                                        name="client"
                                                         item-text="name"
                                                        item-value="id"
                                                        return-object
                                                        @change="selectedrecord(selectPrepared)"
                                                    ></v-select>
                                           </v-col>
                                           <v-col>
                                                    <v-select
                                                     
                                                        label="Checked By"
                                                        v-model="selectChecked2"
                                                        :items="userPrepared.checked2"
                                                        name="client"
                                                         item-text="name"
                                                        item-value="id"
                                                        return-object
                                                        @change="selectedrecord(selectChecked2)"
                                                    ></v-select>
                                           </v-col>
                                       </v-row>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- {{this.selectComputed}} -->
                    </v-card>
				</v-col>
			</v-row>

            
					<!-- Modal -->
			<div class="modal fade" id="addNew" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
						<h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User's Info</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form @submit.prevent="editmode ? updateUser() : createUser()">
						<div class="modal-body">
                            <v-text-field
                                    label="Full name"
                                    placeholder="John doe Dela Cruz"
                                    outlined
                                    dense
                                    v-model="form.name"
                                    :rules="[() => !!form.name || 'This field is required']"
                                    required
                                     prepend-inner-icon="mdi-account"
                            ></v-text-field>

                            <v-text-field
                                     prepend-inner-icon="mdi-at"
                                    label="Email"
                                    placeholder="doe@gmail.com"
                                    outlined
                                    dense
                                    v-model="form.email"
                                    :rules="[
                                    () => !!form.email || 'This field is required',
                                    () =>  /.+@.+\..+/.test(form.email) || 'E-mail must be valid'
                                    ]"
                            ></v-text-field>

                            <v-text-field
                                    type="number"
                                    prepend-inner-icon="mdi-phone"
                                    label="Contact Number"
                                    placeholder="09123456789"
                                    outlined
                                    dense
                                    v-model="form.contact"
                                    :rules="[
                                    () => !!form.contact || 'This field is required',
                                    () =>  (form.contact  && form.contact.length <= 11 && form.contact.length >= 11) || 'Name must be less than 10 characters',
                                    ]"
                                    required
                            ></v-text-field>

                             <v-text-field
                                    label="Address"
                                     prepend-inner-icon="mdi-home"
                                    placeholder="street,Barangay,City"
                                    outlined
                                    dense
                                    v-model="form.address"
                                    :rules="[
                                        () => !!form.address || 'This field is required',
                                        () => !!form.address && form.address.length <= 25 || 'Address must be less than 25 characters',
                                        ]"
                                    required
                            ></v-text-field>

                            <v-autocomplete
                                :items="groups"
                                label="Group"
                                prepend-inner-icon="mdi-account-switch"
                                hide-details
                                hide-no-data
                                hide-selected
                                outlined
                                dense
                                v-model="form.group"
                                class="pb-4"
                                :rules="[
                                        () => !!form.group || 'This field is required',
                                        ]"
                            ></v-autocomplete>

                            <v-autocomplete
                                :items="position"
                                chips
                                label="Position"
                                prepend-inner-icon="mdi-shield-account"
                                hide-details
                                hide-no-data
                                hide-selected
                                outlined
                                dense
                                v-model="form.position"
                                 :rules="[
                                        () => !!form.position || 'This field is required',
                                        ]"
                            ></v-autocomplete>

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
                    // { text: '', value: 'select', sortable: false },
                    { text: 'Name', value: 'name' },
                    { text: 'Email', value: 'email' },
                    { text: 'Number', value: 'contact'},
                    { text: 'Position', value: 'position'},
                    { text: 'Assign', value: 'assign'},
                    {text:'Group', value: 'group'},

                    { text: '', value: 'actions', sortable: false },
                ],
                editmode: false,
                employee : [],
                length: '',
                search: '',
                groups:[
                    'computed',
                    'checked',
                    'prepared'
                ],
                selected: [],
                check: false,
                position:[
                    'QA Staff',
                    'Finance Assistant-Kiosk Operation',
                    'Team Leader'
                ],
                form: new Form({
                    id:'',
                    name : '',
                    email: '',
                    address: '',
                    contact: '',
                    position: '',
                    group:'',
                }),
                checkbox1: 1,
                checkbox2: 0,
                userPrepared: {
                    computed: [],
                    checked1: [],
                    checked2: [],
                    prepared: [],
                },
                selectComputed:null,
                selectChecked1:null,
                selectChecked2:null,
                selectPrepared:null,
                checks: []
            }
        },
        methods: {
            selectedrecord(val){

                const found = this.checks.some(el => el.id === val.id);
                if(found) {
                    console.log('NOICE')
                }
               
               axios.get('api/selected/'+val.id+'/'+val.group).then((data)=>{
                    Toast.fire({
                        icon: 'success',
                        title: 'User Created in successfully'
                        })
                    Fire.$emit('AfterCreate');
               });

          
            },
           loadEmployee() {
                axios
                .get("api/employees")
                .then(
                    ({data}) => {
                      
                        
                        const selectedCompute = data.computed.filter(c => c.assign !== 0);
                        const selectedPrepared = data.prepared.filter(c => c.assign !== 0);
                         const checks = data.checked.filter(c => c.assign !== 0);
                        this.selectComputed = selectedCompute[0];
                        this.selectPrepared = selectedPrepared[0];
                        this.selectChecked1 = checks[0];
                        this.selectChecked2 = checks[1];
                        this.checks = checks

                        this.userPrepared.computed = data.computed;
                        this.userPrepared.checked1 = data.checked.filter(c => c.id !== checks[1].id);
                        this.userPrepared.checked2 = data.checked.filter(c => c.id !== checks[0].id);
                        this.userPrepared.prepared = data.prepared;
                     

                    }
                );
           },

            updateUser(){
                this.$Progress.start();
                console.log('Editing data');
                this.form.put('api/employees/'+this.form.id)
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
            editModal(user){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
               
            },
            deleteUser(id){
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
                                this.form.delete('api/employees/'+id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                    swal.fire("Failed!", "There was something wrong.", "warning");
                                });
                         }
                    })
            },
            loadUsers(){
                var selected = [];
                if(this.$gate.isAdmin()){
                    axios.get("api/employees").then((data) => (
                        this.employee = data.data.employee,

                        this.employee.forEach((element)=>{
                            selected.push(element.assign)
                            this.selected = element.assign
                        }),
                        this.selected = selected
                       
                    ));
                }
               


            },
            createUser(){
                this.$Progress.start();
                this.form.post('api/employees')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                        type: 'success',
                        title: 'User Created in successfully'
                        })
                    this.$Progress.finish();
                })
                .catch(()=>{
                })
            }
        },
        created() {
           this.loadUsers();
           this.loadEmployee();
           Fire.$on('AfterCreate',() => {
               this.loadUsers();
           });
        }
    }
</script>
