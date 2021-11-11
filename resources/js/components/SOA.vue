<template>
          <v-app>
		<v-container>
			<v-row class="mt-5" v-if="$gate.isAdmin()">
				<v-col class="col-md-12">
					<v-card >
						<v-card-title class="card-header">
							<strong> Statement of Account</strong>
                            <v-spacer></v-spacer>
                            <form @submit.prevent="proceedAction()">
							<v-card-actions class="card-tools" >
                               <label class="form-control-label"  for="input-file-import">Upload Excel File</label>
                                <input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file"  @change="onFileChange">
                              	<v-btn type="submit" color="success"  elevation="2">send</v-btn>
							</v-card-actions>
                            </form>
						</v-card-title>


							<v-simple-table class="table-bordered table-hover elevation-1">
								<thead >
									<tr class="text-center ">
										<td>SOA #</td>
										<td>Arena</td>
                                        <td>address</td>
										<td>Email</td>
										<td>Operator</td>
										<td>contact</td>
                                        <td>Action</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>SAO2108062</td>
                                        <td>ARENAN TEST</td>
										<td>TEST ADDRESS</td>
										<td>SAMPLE@GMAIL.COM</td>
										<td>TEST OPERATOR</td>
										<td>0902-434-3434</td>


										<td>
											<button class="btn btn-primary" @click="openModel">
												<i class="fa fa-edit"></i> Review
											</button>
										</td>
									</tr>
								</tbody>
							</v-simple-table>


					</v-card>
				</v-col>
			</v-row>

            		<!-- Modal -->
			<div class="modal fade" id="addNew" tabindex="-1" width="100" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
					<div class="modal-content">
                        <div class="text-align-center" >
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <h1 class="modal-title w-100 text-center">Statement of Account</h1>

                            <div class="modal-body">
                                <div class="text-right ">
                                        <v-row class=" mb-1  no-gutters" >
                                            <v-col class="col-sm-10 mt-2">
                                                SOA # : &nbsp;
                                            </v-col>
                                            <v-col class=" col-sm-2">
                                                 <input type="text" class="form-control" id="inputName" placeholder="Name" >
                                            </v-col>
                                        </v-row>
                                        <v-row class=" mb-1 no-gutters">
                                            <v-col class="col-sm-10  mt-2">
                                               Date of  SOA : &nbsp;
                                            </v-col>
                                            <v-col class="col-sm-2">
                                                 <input type="text" class="form-control" id="inputName" placeholder="Name" >
                                            </v-col>
                                        </v-row>
                                         <v-row class=" mb-1 no-gutters" >
                                            <v-col class="col-sm-10  mt-2">
                                               Date of Event : &nbsp;
                                            </v-col>
                                            <v-col class="col-sm-2">
                                                 <input type="text" class="form-control" id="inputName" placeholder="Name" >
                                            </v-col>
                                        </v-row>
                                </div>
                            </div>
                        </div>

                        
					</div>
				</div>
			</div>
        
		</v-container>
	</v-app>
</template>
<script>
     export default {
         data(){
             return {
                error: {},
                import_file: '',
             }
         },
        methods: {
            openModel(){
                $('#addNew').modal('show');
            },
            onFileChange(e) {
                 this.import_file = e.target.files[0];
            },
            proceedAction() {
    
                let formData = new FormData();
                formData.append('import_file', this.import_file);

                axios.post('/api/import', formData, {
                    headers: { 'content-type': 'multipart/form-data' }
                    })
                    .then(response => {
                        if(response.status === 200) {
                                console.log(response)
                        }
                    })
                    .catch(error => {
                        // code here when an upload is not valid
                        this.uploading = false
                        this.error = error.response.data
                        console.log('check error: ', this.error)
                    });
                }
        }
     }
</script>
