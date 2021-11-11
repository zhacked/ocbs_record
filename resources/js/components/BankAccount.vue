<template >
    <v-app>
		<v-container>
			<v-row class="mt-5">
				<v-col class="col-md-12">
					<v-card >
						<v-card-title class="card-header">
							<strong> Bank Detials</strong>
                            <v-spacer></v-spacer>
							<v-card-actions class="card-tools">
								<v-btn color="success"
                                    elevation="2"  @click="openModal">Add Bank Information<i class="fas fa-plus fa-fw"></i></v-btn>
							</v-card-actions>
						</v-card-title>


							<v-simple-table class=" table-hover elevation-1">
								<thead >
									<tr class="text-center text-bold">
									
										<td>Bank Name</td>
                                        <td>Bank Account</td>
                                        <td>Action</td>

									</tr>
								</thead>
								<tbody>
									<tr  v-for="accounts in account.data" :key="accounts.id" class="text-center">
										<td>{{accounts.bank_name}}</td>
										<td>{{accounts.bank_number}}</td>
										<td>
											<button class="btn btn-primary"  @click="editModal(accounts)">
												<i class="fa fa-edit"></i> Update
											</button>

												<button class="btn btn-danger"  @click="deleteAccount(accounts.id)">
												<i class="fa fa-trash"></i> Delete
											</button>
										</td>
									</tr>
								</tbody>
							</v-simple-table>

						<v-card-title class="ma-0 pt-1">
							<pagination  :data="account" @pagination-change-page="getResults"></pagination>
						</v-card-title>
					</v-card>
				</v-col>
			</v-row>


					<!-- Modal -->
			<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" v-show="!editmode" id="addNewLabel">New Bank Information</h5>
						<h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Bank Information</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form @submit.prevent="editmode ? updateBank() : createBank()">
						<div class="modal-body">

                           	<div class="form-group">
								<select name="type" v-model="form.arena_id" id="arena_id" class="form-control" :class="{ 'is-invalid': form.errors.has('arena_id') }">
									<option value="">Select OCBS Name</option>
									<option v-for="arenas in arena_id" :key="arenas.id"  :value="arenas.id" >{{arenas.arena}}</option>
								
								</select>
								<has-error :form="form" field="arena_id"></has-error>
							</div>

							<div class="form-group">
								<input v-model="form.bank_name" type="text" name="bank_name"
									placeholder="Enter Bank Name"
									class="form-control" :class="{ 'is-invalid': form.errors.has('bank_name') }">
								<has-error :form="form" field="bank_name"></has-error>
							</div>

							<div class="form-group">
								<input v-model="form.bank_number" type="text" name="bank_number"
									placeholder="Enter Bank number"
									class="form-control" :class="{ 'is-invalid': form.errors.has('bank_number') }">
								<has-error :form="form" field="bank_number"></has-error>
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
                account : {},
                length: '',
                arena_id:{},
                form: new Form({
                    id:'',
                   arena_id:'',
                   bank_name:'',
                   bank_number:''

                   
                })
            }
        },
        methods: {
             getResults(page = 1) {
                axios.get('api/bankaccount?page=' + page)
                    .then(response => {
                        this.account = response.data;
                    });
            },
            openModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            editModal(accounts){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(accounts);
                this.form.arena_id = accounts.arenas_id;
                console.log(accounts);
                
            },
            loadDetials(){
                    axios.get("api/bankaccount").then(({ data }) => (this.account = data));
            },
            loadArenaId(){
                 axios.get("api/arenaId").then(({ data }) => (
                     this.arena_id = data
                     ));
            },
            createBank(){
                this.$Progress.start();
                this.form.post('api/bankaccount')
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
            },
            updateBank(){
                this.$Progress.start();
                console.log('Editing data');
                this.form.put('api/bankaccount/'+this.form.id)
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
            deleteAccount(id){
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
                                this.form.delete('api/bankaccount/'+id).then(()=>{
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

            }
        },
        created() {
            this.loadDetials();
            this.loadArenaId();
            Fire.$on('AfterCreate',() => {
                this.loadDetials();
            });
        }
    }
</script>
