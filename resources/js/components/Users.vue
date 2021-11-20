<template >
    <v-app>
		<v-container>
			<v-row class="mt-5" v-if="$gate.isAdmin()">
				<v-col class="col-md-12">
					<v-card >
						<v-card-title class="card-header">
                             User Management
                             <v-spacer></v-spacer>
							<v-card-actions class="card-tools">
								<v-btn color="success"
                                    elevation="2"  @click="newModal">Add New User <i class="fas fa-user-plus fa-fw"></i></v-btn>
							</v-card-actions>
						</v-card-title>

                      
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search"
                                class="mx-4"
                            ></v-text-field>
                   
                            <v-data-table
                                    :headers="headers"
                                    :items="users.data"
                                    :items-per-page="10"
                                    :search="search"
                                    class="elevation-1 text-center"
                                >
                                
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
						
					</v-card>
				</v-col>
			</v-row>


					<!-- Modal -->
			<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
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
							<div class="form-group">
								<input v-model="form.name" type="text" name="name"
									placeholder="Name"
									class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
								<has-error :form="form" field="name"></has-error>
							</div>

							<div class="form-group">
								<input v-model="form.email" type="email" name="email"
									placeholder="Email Address"
									class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
								<has-error :form="form" field="email"></has-error>
							</div>

							<div class="form-group">
								<textarea v-model="form.bio" name="bio" id="bio"
								placeholder="Short bio for user (Optional)"
								class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
								<has-error :form="form" field="bio"></has-error>
							</div>


							<div class="form-group">
								<select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
									<option value="">Select User Role</option>
									<option value="admin">Admin</option>
									<option value="user">Standard User</option>
									<option value="author">Author</option>
								</select>
								<has-error :form="form" field="type"></has-error>
							</div>

							<div class="form-group">
								<input v-model="form.password" type="password" name="password" id="password"
								class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
								<has-error :form="form" field="password"></has-error>
							</div>

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
                    { text: 'Type', value: 'type'},
                    { text: 'Modify', value: 'created_at'},
                    { text: '', value: 'actions', sortable: false },
                ],
                editmode: false,
                users : {},
                length: '',
                search: '',
                form: new Form({
                    id:'',
                    name : '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        methods: {
            getResults(page = 1) {
                        axios.get('api/user?page=' + page)
                            .then(response => {
                                this.users = response.data;
                            });
                },
            updateUser(){
                this.$Progress.start();
                console.log('Editing data');
                this.form.put('api/user/'+this.form.id)
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
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                         if (result.value) {
                                this.form.delete('api/user/'+id).then(()=>{
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
                if(this.$gate.isAdmin()){
                    axios.get("api/user").then(({ data }) => (this.users = data));
                }
            },
            createUser(){
                this.$Progress.start();
                this.form.post('api/user')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    toast({
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
           Fire.$on('AfterCreate',() => {
               this.loadUsers();
           });
        }
    }
</script>
