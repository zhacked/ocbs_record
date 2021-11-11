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
                               <label class="form-control-label"  for="input-file-import">Upload Excel File</label>
                                <!--<input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file"  @change="onFileChange"> -->
                                <input type="file" class="form-control" @change="onFileChange">
                              	<v-btn type="submit" color="success"  elevation="2">send</v-btn>
							</v-card-actions>
                            </form>
						</v-card-title>


							<v-simple-table class="table-bordered table-hover elevation-1">
                              <template v-slot:default>
								<thead >
									<tr class="text-center ">
										<td>SOA #</td>
										<td>Arena/OCBS NAME</td>
                                        <td>MERON</td>
										<td>WALA</td>
										<td>TOTAL</td>
										<td>PAYOUT PAID</td>
                                        <td>UNCLAIMED</td>
                                        <td>RAKE</td>
                                        <td>DRAW/CANCELLED</td>
                                        <td>C/D Paid</td>
                                        <td>C Unpaid</td>
                                        <td>D Unpaid</td>
                                        <td>DRAW</td>
                                        <td>DRAW PAID</td>
                                        <td>DRAW UNCLAIMED</td>
                                        <td>DRAW GAIN/LOSS</td>
                                        <td>DRAW(2%)</td>
                                        <td></td>
									</tr>
								</thead>
                                <tbody >
                                    <tr v-for="ocbs in state.ocbsArrayFiltered" :key="ocbs.key" >
                                        <td>#</td>
                                        <td>{{ ocbs.arenaName }}</td>
                                        <td>{{ ocbs.meron }}</td>
                                        <td>{{ ocbs.wala }}</td>
                                        <td>{{ ocbs.total }}</td>
                                        <td>{{ ocbs.payoutPaid }}</td>
                                        <td>{{ ocbs.unclaimed }}</td>
                                        <td>{{ ocbs.rake }}</td>
                                        <td>{{ ocbs.drawCancelled }}</td>
                                        <td>{{ ocbs.cDPaid }}</td>
                                        <td>{{ ocbs.cUnpaid }}</td>
                                        <td>{{ ocbs.dUnpaid }}</td>
                                        <td>{{ ocbs.draw }}</td>
                                        <td>{{ ocbs.drawPaid }}</td>
                                        <td>{{ ocbs.drawUnclaimed }}</td>
                                        <td>{{ ocbs.drawGainLoss }}</td>
                                        <td>{{ ocbs.draw2 }}</td>
                                        <td>
                                            <button class="btn btn-primary" @click="openModel(ocbs)">
                                                <i class="fa fa-edit"></i> Review
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
								
                                </template>
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
                                                 <input type="text" class="form-control" id="inputName" placeholder="Name" :value="state.ocbs.arenaName">
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
import { reactive } from "@vue/composition-api";
import { camelCase } from "lodash";
import XLSX from "xlsx";
     export default {
        //  data(){
        //      return {
        //         error: {},
        //         import_file: '',
        //      }
        //  },
        // methods: {
        //     openModel(){
        //         $('#addNew').modal('show');
        //     },
        //     onFileChange(e) {
        //          this.import_file = e.target.files[0];
        //     },
        //     proceedAction() {
    
        //         let formData = new FormData();
        //         formData.append('import_file', this.import_file);

        //         axios.post('/api/import', formData, {
        //             headers: { 'content-type': 'multipart/form-data' }
        //             })
        //             .then(response => {
        //                 if(response.status === 200) {
        //                         console.log(response)
        //                 }
        //             })
        //             .catch(error => {
        //                 // code here when an upload is not valid
        //                 this.uploading = false
        //                 this.error = error.response.data
        //                 console.log('check error: ', this.error)
        //             });
        //         }
        // }

        setup() {
 
            let reportCombined = [];
            const state = reactive({
            headers: [],
            ocbsArray: [],
            ocbsArrayFiltered: [],
            dialog: false,
            ocbs: {}
            });

            const onFileChange = (event) => {
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
                    if(Object.keys(r).length === 17) reportCombined.push(Object.assign({}, r))
                })
                

                let objectKeyReplacedArray = [];
                const [, ...headKey] = Object.values(reportCombined[0]);
                const headK = ["key",...headKey]
                
                reportCombined.map((data) => {
                    data = Object.assign({}, ...Object.entries(data)
                    .map(([, prop], index) => ({[camelCase(headK[index])]: prop})));
                    objectKeyReplacedArray.push(data)
                })


                const filterObjectHeader = objectKeyReplacedArray.filter((obk) => {
                    if(obk.arenaName !== 'OCBS NAME' && obk.arenaName !== 'ARENA NAME') return obk;
                });

                const removeKeyReportObject = filterObjectHeader.map(({key, ...rest}) => ({...rest}));

                    state.ocbsArrayFiltered = removeKeyReportObject;
                };

                reader.readAsBinaryString(file);
            }
            };


            return {
            onFileChange,
            state,
            openModel(ocbs){
                // console.log(e.target.value)
                console.log(ocbs)
                state.ocbs = ocbs
                $('#addNew').modal('show');
            },
            };
        },
     }
</script>
