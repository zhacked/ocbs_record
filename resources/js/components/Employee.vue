<style scoped>
 .nav-tabs .nav-link.active{
    background-color:#00C4F5!important ;
    color:white !important
}
</style>


<template >
    <v-app>
		<v-container>
			<v-row class="mt-5 is-blurred"  v-if="$gate.isAdmin()">
            
				<v-col class="col-md-12">
					<v-card >
						<v-card-title class="card-header">
                             User Management
                             <v-spacer></v-spacer>
                               <v-text-field
                                    v-model="search"
                                    append-icon="mdi-magnify"
                                    label="Search"
                                    class="mx-4"
                                ></v-text-field>
						
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
                                    <li class="nav-item">
                                        <a
                                            class="nav-link "
                                            id="position-tab"
                                            data-toggle="pill"
                                            href="#position"
                                            role="tab"
                                            aria-controls="position"
                                            aria-selected="true"
                                            >Position List</a
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
                                      

                                   <v-data-table
                                            :headers="headers"
                                            :items="employee"
                                            :search="search"
                                            class="elevation-1 text-center"
                                        
                                        >
                                    <template v-slot:top>
                                                <v-toolbar
                                                    flat
                                                >
                                                    <v-toolbar-title>Employee Details</v-toolbar-title>
                                                        <v-divider
                                                        class="mx-4"
                                                        inset
                                                        vertical
                                                    ></v-divider>
                                                    <v-spacer></v-spacer> 
                                                        <v-btn
                                                            color="primary"
                                                            dark
                                                             elevation="2"
                                                            class="mb-2"
                                                            @click="newModal()"
                                                        >
                                                        <i class="fas fa-user-plus fa-fw"></i>
                                                        Register Employee
                                                        </v-btn>
                                                </v-toolbar>
                                    </template>
                                    <template v-slot:[`item.assign`]="{ item }">
                                            <v-icon v-show="item.assign=='1'" large color="green">mdi-check</v-icon>
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
                                                        :value="selectComputed"
                                                        :items="userPrepared.computed"
                                                        name="computed"
                                                        :item-text="item => `${item.name} - ${item.position}`"
                                                        return-object
                                                        @change="selectedrecord(selectComputed, $event)"
                                                    ></v-select>
                                           </v-col>
                                           <v-col>
                                                   <v-select
                                                   
                                                        label="Checked By"
                                                        :value="selectChecked1"
                                                        :items="userPrepared.checked1"
                                                        name="checked1"
                                                        :item-text="item => `${item.name} - ${item.position}`"
                                                    
                                                        return-object
                                                       
                                                        @change="selectedrecord(selectChecked1, $event)"
                                                    ></v-select>
                                           </v-col>
                                       </v-row>
                                        <v-row>
                                           <v-col>
                                                    <v-select
                                                       
                                                        label="Prepared By"
                                                        :value="selectPrepared"
                                                        :items="userPrepared.prepared"
                                                        name="prepared"
                                                       :item-text="item => `${item.name} - ${item.position}`"
                                                      
                                                        return-object
                                                        @change="selectedrecord(selectPrepared, $event)"
                                                    ></v-select>
                                           </v-col>
                                           <v-col>
                                                    <v-select
                                                     
                                                        label="Checked By"
                                                        :value="selectChecked2"
                                                        :items="userPrepared.checked2"
                                                        name="checked2"
                                                        :item-text="item => `${item.name} - ${item.position}`"
                                                       
                                                        return-object
                                                        @change="selectedrecord(selectChecked2, $event)"
                                                    ></v-select>
                                           </v-col>
                                       </v-row>
                                    </div>

                                    <div
                                        class="tab-pane fade"
                                        id="position"
                                        role="tabpanel"
                                        aria-labelledby="position-tab"
                                    >
                                        <v-container>
                                            <v-data-table
                                                :headers="positionHeaders"
                                                :items="position"
                                                :search="search"
                                                sort-by="calories"
                                                class="elevation-1"
                                            >
                                              <template v-slot:top>
                                                    <v-toolbar
                                                        flat
                                                    >
                                                        <v-toolbar-title>Position Details</v-toolbar-title>
                                                         <v-divider
                                                            class="mx-4"
                                                            inset
                                                            vertical
                                                        ></v-divider>
                                                        <v-spacer></v-spacer>
                                                            <v-btn
                                                                color="primary"
                                                                dark
                                                                class="mb-2"
                                                                @click="addnewPostion()"
                                                            >
                                                            Add New Position
                                                            </v-btn>
                                                    </v-toolbar>
                                                    </template>
                                                     <template v-slot:[`item.PositionAction`]="{ item }">

                                                                <v-tooltip bottom>
                                                                    <template v-slot:activator="{ on, attrs }">
                                                                            <v-btn
                                                                            color="primary"
                                                                            class="mx-2"
                                                                            icon
                                                                            dark
                                                                            v-bind="attrs"
                                                                            v-on="on"
                                                                            @click="editPositionModal(item)"
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
                                                                        @click="deletePosition(item.id)"
                                                                        >
                                                                        <i class="fa fa-trash"></i>
                                                                        </v-btn>
                                                                    </template>
                                                                <span>Delete info User</span>
                                                                </v-tooltip>
                                                        </template>
                                            </v-data-table>
                                        </v-container>
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
<!-- 
                            <v-text-field
                                  
                                    prepend-inner-icon="mdi-phone"
                                    label="Contact Number"
                                    placeholder="09123456789"
                                    outlined
                                    dense
                                    v-model="form.contact"
                                    :rules="[
                                        () => !!form.contact || 'This field is required',
                                        () =>   /^\d+$/.test(form.contact) || 'Must be a number',
                                        () =>  form.contact && form.contact.length >= 11 && form.contact.length <= 11 || 'This field must have atleast 11 digits',
                                        
                                    ]"
                                    required
                            ></v-text-field> -->
<!-- 
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
                            ></v-text-field> -->

                            <v-autocomplete
                                :items="teams"
                                chips
                                label="Teams"
                                prepend-inner-icon="mdi-account-group"
                                hide-details
                                hide-no-data
                                hide-selected
                                outlined
                                dense
                                item-text="team"
                                v-model="form.team"
                                 class="pb-4"
                            ></v-autocomplete> 
                            

                            <v-autocomplete
                                :items="assigns"
                                label="Assign"
                                prepend-inner-icon="mdi-clipboard-account"
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
                                item-text="position"
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
            
                <!-- Position Modal -->
            <div class="modal fade" id="addPostion" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add  Position</h5>
						<h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Position</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form @submit.prevent="editmode ? updatePosition() : createPosition()">
						<div class="modal-body">
                             <v-text-field
                                    prepend-inner-icon="mdi-crosshairs"
                                    label="Position"
                                    placeholder="user position"
                                    outlined
                                    dense
                                    v-model="positionform.position"
                                    :rules="[
                                        () => !!positionform.position || 'This field is required',
    
                                    ]"
                                    required
                            ></v-text-field>
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
                    { text: 'Name', value: 'name' },
                    { text: 'Email', value: 'email' },
                    // { text: 'Number', value: 'contact'},
                    {text: 'Team', value: 'team'},
                    { text: 'Position', value: 'position'},
                    {text:'Assign', value: 'group'},

                    { text: '', value: 'actions', sortable: false },
                ],
                positionHeaders : [
                  
                    { text: 'Position', value: 'position' },
                    { text: '', value: 'PositionAction', sortable: false},
                ],
                editmode: false,
                employee : [],
                length: '',
                search: '',
                assigns:[
                    'computed',
                    'checked',
                    'prepared'
                ],
                selected: [],
                check: false,
                position:[],
                positionNew:'',
                form: new Form({
                    id:'',
                    name : '',
                    email: '',
                    address: '',
                    contact: '',
                    position: '',
                    group:'',
                }),
                positionform: new Form({
                    id:'',
                    position: '',
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
            selectedrecord(val, event){
                console.log('old',val);
                console.log('new',event);
               axios.put(`api/selected/${val?.id}`, {
                   new: event.id
               }).then((data)=>{
                    Toast.fire({
                        icon: 'success',
                        title: 'User Created in successfully'
                        })
                    Fire.$emit('AfterCreate');
               });

          
            },
            addnewPostion(){
                $('#addPostion').modal('show');
                 this.positionform.reset();
                   this.editmode = false;
            },
            createPosition(){
                this.positionform.post('api/saveposition').then((data)=> {
                    console.log(data)
                      Fire.$emit('AfterCreate');
                      Toast.fire({
                        icon: 'success',
                        title: 'Position Added in successfully'
                        })
                         $('#addPostion').modal('hide');
                });
            },
            updatePosition(){
                this.positionform.put('api/updateposition/'+this.positionform.id).then((data)=> {
             
                      Fire.$emit('AfterCreate');
                      Toast.fire({
                        icon: 'success',
                        title: 'Position Added in Updated'
                        })
                         $('#addPostion').modal('hide');
                });
            },
            editPositionModal(data){
                this.editmode = true;
                this.positionform.reset();
                $('#addPostion').modal('show');
                this.positionform.fill(data);
            },
            loadPosition(){
                axios.get('api/getposition').then((data)=>{
                    this.position = data.data;
                    
                });
            },
            deletePosition(id){
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
                              axios.get('api/deletePosition/'+id).then((data)=> {
                                    swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    Fire.$emit('AfterCreate');
                                });
                         }
                    })
               
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
                        this.userPrepared.prepared = data.prepared;
                        this.userPrepared.checked1 = data.checked.filter(c => c.id !== checks[1]?.id);
                        this.userPrepared.checked2 = data.checked.filter(c => c.id !== checks[0]?.id);

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
            this.loadPosition();
           Fire.$on('AfterCreate',() => {
               this.loadUsers();
               this.loadEmployee();
                this.loadPosition();
           });
        }
    }
</script>
