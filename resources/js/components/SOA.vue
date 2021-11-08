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
											<button class="btn btn-primary">
												<i class="fa fa-edit"></i> Review
											</button>
										</td>
									</tr>
								</tbody>
							</v-simple-table>


					</v-card>
				</v-col>
			</v-row>

        
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
