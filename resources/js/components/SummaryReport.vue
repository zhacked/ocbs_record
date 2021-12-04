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
                                            >Reflenish</a
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
                                            :items-per-page="10"
                                            :search="search"
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
                                            class="elevation-1 text-center"
                                        >
                                            <template
                                                v-slot:[`item.actions`]="{
                                                    item,
                                                }"
                                            >
                                                <v-tooltip top>
                                                    <template
                                                        v-slot:activator="{
                                                            on,
                                                            attrs,
                                                            hover,
                                                        }"
                                                    >
                                                        <v-btn
                                                            icon
                                                            color="primary"
                                                            dark
                                                            small
                                                            v-bind="attrs"
                                                            v-on="on"
                                                            @click="
                                                                openModel(item)
                                                            "
                                                            :class="{
                                                                'on-hover':
                                                                    hover,
                                                            }"
                                                        >
                                                            <v-icon
                                                                >mdi-eye</v-icon
                                                            >
                                                        </v-btn>
                                                    </template>
                                                    <span>View Account</span>
                                                </v-tooltip>
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

export default {
    data() {
        return {
            headers: [
                { text: "#", value: "id" },
                { text: "SAO#", value: "Soa_number" },
                { text: "OCBS Name", value: "arena_name" },
                { text: "Amount", value: "for_total" },

                { text: "date", value: "updated_at" },
         
              
            ],
            deposit:[],
            reflenish:[],
            search:'',
        };  
    },
    methods: {
      
        loadSummary() {
            axios
                .get("api/depositeandreflenish")
                .then(({ data }) => (
                    console.log(data.dp),
                    this.deposit = data.dp,
                    this.reflenish = data.rf
                ));
        },
      
       
       
    },
    created() {
        this.loadSummary();
    }
};
</script>
