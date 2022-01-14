<style scoped>
 .nav-tabs .nav-link.active{
    background-color:#00C4F5!important ;
    color:white !important
}
</style>

<template>
    <v-app>
        <v-container >
            <v-row class="mt-5">
                <v-col class="col-md-12">
                    <v-card>
                        <v-card-title class="card-header">
                            <strong>Summary Report</strong>
                            <v-spacer></v-spacer>
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
                                            >Deposit</a
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
                                            >Replenish</a
                                        >
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div
                                    class="tab-content"
                                    id="custom-tabs-three-tabContent active show"
                                >
                                    <v-row>
                                       
                                        <v-spacer></v-spacer>
                                        <v-col>
                                            <v-text-field
                                                v-model="search"
                                                append-icon="mdi-magnify"
                                                label="Search"
                                                color="primary darken-2"

                                            ></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <div
                                        class="tab-pane fade active show"
                                        id="custom-tabs-three-home"
                                        role="tabpanel"
                                        aria-labelledby="custom-tabs-three-home-tab"
                                    >
                                        <v-data-table
                                            :headers="headers"
                                            :items="deposit"
                                            :search="search"
                                            sort-by="date_closed"
                                            group-by="date_closed"
                                            class="elevation-1 text-center"
                                             single-expand
                                             :footer-props="{
                                                'items-per-page-options': [
                                                   50
                                                ],
                                            }"
                                        >
                                      <template v-slot:[`group.header`]="{ group, headers, toggle, isOpen }">
                  
                                        <td :colspan="headers.length">
                                                <v-row>
                                                    <v-col class="mt-2 ">
                                                        <div class=" float-left">
                                                            <v-btn @click="toggle" x-small icon :ref="group" class="test"  >
                                                                <v-icon v-if="isOpen">mdi-plus</v-icon>
                                                                <v-icon v-else>mdi-minus</v-icon>
                                                            </v-btn>
                                                            <span class="mx-5 font-weight-bold">{{ group | myDateSummary }} </span>
                                                        </div>  
                                                     
                                                    </v-col>
                                                    <v-col>
                                                      <div class=" float-right">
                                                           <v-btn 
                                                            small  
                                                            @click="convertToExcel(group)"
                                                            outlined
                                                            color="green" 
                                                           >
                                                               <v-icon left>
                                                                    mdi-download
                                                                </v-icon>  Download
                                                            </v-btn>
                                                      </div>
                                                    </v-col>
                                                </v-row>
                                              
                                        </td>
                                        </template>
                                        </v-data-table>
                                    </div>

                                    <div
                                        class="tab-pane fade"
                                        id="custom-tabs-three-profile"
                                        role="tabpanel"
                                        aria-labelledby="custom-tabs-three-profile-tab"
                                    >
                                        <v-data-table
                                            :headers="headers"
                                            :items="reflenish"
                                            :items-per-page="10"
                                            :search="search"
                                            :show-group-by="false"
                                            sort-by="updated_at"
                                            group-by="updated_at"
                                            class="elevation-1 text-center"
                                        >

                                        <template v-slot:[`group.header`]="{ group, headers, toggle, isOpen }">
                                            <td :colspan="headers.length">
                                                    <v-row>
                                                        <v-col class="mt-2 ">
                                                            <div class=" float-left">
                                                                <v-btn @click="toggle" x-small icon :ref="group" class="test" >
                                                                    <v-icon v-if="isOpen">mdi-plus</v-icon>
                                                                    <v-icon v-else>mdi-minus</v-icon>
                                                                </v-btn>
                                                                <span class="mx-5 font-weight-bold">{{ group | myDateSummary }}</span>
                                                            </div>  
                                                        
                                                        </v-col>
                                                        <v-col>
                                                        <div class=" float-right">
                                                            <v-btn 
                                                                small  
                                                                @click="convertToExcel(group )"
                                                                outlined
                                                                color="green" 
                                                            >
                                                                <v-icon left>
                                                                        mdi-download
                                                                    </v-icon>  Download
                                                                </v-btn>
                                                        </div>
                                                        </v-col>
                                                    </v-row>
                                                
                                            </td>
                                        </template>
                                        </v-data-table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-card>
                </v-col>

              
                <!-- </v-col> -->
            </v-row>
        </v-container>
    </v-app>
</template>
<script>
import moment from "moment";
import XLSX from "xlsx";
export default {
    
    data() {
        return {
            headers: [
                { text: "#", value: "id" },
            
                { text: "ref", value: "refNo" },
                { text: "OCBS Name", value: "arena_name" },
                { text: "Amount", value: "for_total" },
         
            ],
            deposit:[],
            reflenish:[],
            search:'',
            myBlob:'',
            filteredData:{},
        };  
    },
    methods: {
      
        loadSummary() {
            axios
                .get("api/depositeandreflenish")
                .then(({ data }) => {
                    this.deposit = data.dp;
                    this.reflenish = data.rf;
                });
        },
        convertToExcel(data){
            
            var value = moment(data).format("YYYY-MM-DD LTS");
            var date = moment(data).format("MMMM-DD-YYYY");
            
            console.log(value + '' + date);

            var workbooks =  XLSX.utils.book_new();
            var worksheet = '';
            let aray = [];
            axios.get("api/convertToExcel/"+ value).then(({ data }) => (
                console.log(data),
                data.forEach((val) => {

                    const test = {
                       'ID': val.id,
                       'Soa Number': val.refNo,
                        'OCBS Name': val.arena_name,
                        'Amount': val.for_total
                    }
                    aray.push(test);

                }),

               worksheet =  XLSX.utils.json_to_sheet(aray),
               
                XLSX.utils.book_append_sheet(workbooks,worksheet,date),

                XLSX.write(workbooks,{bookType:'xlsx',type:'buffer'}),
                XLSX.write(workbooks,{bookType:'xlsx',type:'binary'}),
                
                console.log(worksheet),
                XLSX.writeFile(workbooks,date + ".xlsx")

                ));
            
        }
        
      
       
       
    },
    created() {
        this.loadSummary();
    }
};
</script>
