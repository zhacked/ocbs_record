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


							<v-simple-table class=" table-hover elevation-1">
								<thead >
									<tr class="text-center text-bold">
										<td>Arena Name</td>
										<td>Address</td>
										<td>Operator</td>
                                        <td>Contact</td>
										<td>Modify</td>
                                        <td>Action</td>

									</tr>
								</thead>
								<tbody>
									<!-- <tr v-if="users.data.length == 0">
										<td colspan="7" class="text-center"> <h3>No Data Available</h3> </td>
									</tr> -->
									<tr  v-for="arenas in arena.data" :key="arenas.id" class="text-center">
										<td>{{arenas.arena}}</td>
										<td>{{arenas.address}}</td>
										<td>{{arenas.operator}}</td>
										<td>{{arenas.contact_number}}</td>
										<td>{{arenas.email}}</td>

										<td>
											<button class="btn btn-primary"  @click="editModal(arenas)">
												<i class="fa fa-edit"></i> Update
											</button>

												<button class="btn btn-danger"  @click="deleteUser(arenas.id)">
												<i class="fa fa-trash"></i> Delete
											</button>
										</td>
									</tr>
								</tbody>
							</v-simple-table>

						<v-card-title class="ma-0">
							<pagination  :data="arena" @pagination-change-page="getResults"></pagination>
						</v-card-title>
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
							<div class="form-group">
								<input v-model="form.arena" type="text" name="arena"
									placeholder="Name"
									class="form-control" :class="{ 'is-invalid': form.errors.has('arena') }">
								<has-error :form="form" field="arena"></has-error>
							</div>

							<div class="form-group">
								<input v-model="form.address" type="text" name="address"
									placeholder="Arena Address"
									class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
								<has-error :form="form" field="address"></has-error>
							</div>

							<div class="form-group">
								<textarea v-model="form.operator" name="operator" id="operator"
								placeholder="operator name"
								class="form-control" :class="{ 'is-invalid': form.errors.has('operator') }"></textarea>
								<has-error :form="form" field="operator"></has-error>
							</div>

							<div class="form-group">
								<input v-model="form.contact_number" type="number" name="contact_number" id="contact_number"
								class="form-control" :class="{ 'is-invalid': form.errors.has('contact_number') }">
								<has-error :form="form" field="contact_number"></has-error>
							</div>

                            <div class="form-group">
								<input v-model="form.email" type="email" name="email" id="email"
								class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
								<has-error :form="form" field="email"></has-error>
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
                editmode: false,
                arena : {},
                length: '',
                form: new Form({
                    id:'',
                    arena : '',
                    address: '',
                    operator: '',
                    contact_number: '',
                    email: '',
                })
            }
        },
        methods: {
            getResults(page = 1) {
                        axios.get('api/arena?page=' + page)
                            .then(response => {
                                this.arena = response.data;
                            });
                },
            updateArena(){
                this.$Progress.start();
                console.log('Editing data');
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
            editModal(arenas){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(arenas);
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
                                    swal.fire("Failed!", "There was something wrong.", "warning");
                                });
                         }
                    })
            },
            loadArena(){
                    axios.get("api/arena").then(({ data }) => (this.arena = data));
            },
            createArena(){
                this.$Progress.start();
                this.form.post('api/arena')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    toast({
                        type: 'success',
                        title: 'Arena Created in successfully'
                        })
                    this.$Progress.finish();
                })
                .catch(()=>{
                     toast({
                        type: 'error',
                        title: 'something went wrong'
                        })
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
