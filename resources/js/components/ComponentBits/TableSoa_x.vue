<template lang="">
<div>

    <v-data-table
        item-key="codeEvent"
        :headers="headers"
        :items="arenaData"
        v-model="selected"
        :loading="loading"
        :search="search"
        :show-select="downloadingReport ? false : true"
        :disable-filtering="downloadingReport ? true : false"
        :disable-sort="downloadingReport ? true : false"
        :single-select="singleSelect"
        class="elevation-1 text-center"
        :footer-props="{
            'items-per-page-options': [5, 10, 20, 30, 40, 50, 100],
            
        }"
        :options="paginationOption"
        :page="page"

        @page-count="handlePageCount"
        :server-items-length="total"
        @pagination="handlePaginate"
         @update:options="handlePageOptions"
        @toggle-select-all="selectAllToggle"
        @input="singleSelected"
    
    >
        <template v-slot:top="{ pagination, options, updateOptions, itemsPerPageOptions }">
            <v-data-footer 
                :items-per-page-options ="[5, 10, 20, 30, 40, 50, 100]"
                :pagination="pagination"
                :options="paginationOption"
                items-per-page-text="$vuetify.dataTable.itemsPerPageText"
            
                @update:options="handlePageOptions"
            />
        </template>
        <template v-slot:item="{item, isSelected, select}">

            <tr>
                <td>
                    <v-simple-checkbox
                        :value="isSelected"
                        :readonly="item.disabled"
                        :disabled="item.arena_details ? false : true"
                        @input="select($event)"
                    ></v-simple-checkbox> 
                </td>
                <td>
                    <p class="font-weight-bold text-left">{{item.date_of_soa}}</p>
                </td>
                 <td>
                    <p class="font-weight-bold text-left">{{item.areaCode}}</p>
                </td>
                <td>
                    <p class="font-weight-bold text-left">{{item.refNo}}</p>
                </td>
                 <td>
                    <p class="font-weight-bold text-left">{{item.arena_name}}</p>
                </td>
                <td>
                    <v-tooltip top color="primary">
                        <template v-slot:activator="{ on, attrs, hover }">
                            <v-btn
                                icon
                                color="primary"
                                dark
                                small
                                v-bind="attrs"
                                v-on="on"
                                @click="openModal(item)"
                                :class="{
                                'on-hover': hover,
                                }"
                                :disabled="downloadingReport"
                            >
                                <v-icon>mdi-eye</v-icon>
                            </v-btn>
                        </template>
                        <span>View Account</span>
                    </v-tooltip> 
                </td>
            </tr>

        </template>
        <!-- <template v-slot:[`item.data-table-select`]="{ item, isSelected, select }">
            <v-simple-checkbox
                :value="isSelected"
                :readonly="item.disabled"
                :disabled="item.arena_details ? false : true"
                @input="select($event)"
            ></v-simple-checkbox>
        </template>  
        <template v-slot:[`item.actions`]="{ item }">
            <v-tooltip top color="primary">
                <template v-slot:activator="{ on, attrs, hover }">
                    <v-btn
                        icon
                        color="primary"
                        dark
                        small
                        v-bind="attrs"
                        v-on="on"
                        @click="openModal(item)"
                        :class="{
                        'on-hover': hover,
                        }"
                        :disabled="downloadingReport"
                    >
                        <v-icon>mdi-eye</v-icon>
                    </v-btn>
                </template>
                <span>View Account</span>
            </v-tooltip> -->
        <!-- </template> -->
    </v-data-table>
    <loading-progress :loading="loading" />    
</div>
</template>
<script>
export default {
    name: "table-soax",
    props: {
        soaLists: Function,
        withStatus: Function,
        loadDateRange: Function,
        handleSearching: Function,
        arenaData: Array,
        downloadingReport: Boolean,
        openModal: Function,
        search: String,
        total: Number,
        page: Number,
        numberOfPages: Number,
        dates: Array,
        tab: String,
        handleNoArenaDetails: Function,
        filteredText: String
    },
    data: () => ({
        headers: [
            { text: "Date", value: "date_of_soa" },
            { text: "Area Code", value: "areaCode" },
            { text: "Reference #", value: "refNo" },
            { text: "Arena Name", value: "arena_name" },
            { text: "", value: "actions", sortable: false },
        ],
        singleSelect: false,
        selectedItems: [],
        selected: [],
        loading: false,
        pagePosition: 1,
        pagination: {
            page: 1,
            itemsPerPage: 10,
        },
        paginationOption: {itemsPerPage: parseInt(localStorage.getItem('itemsPerPage'))}
    }),
    methods: {
        // Select all imports with arena details
        selectAllToggle(props) {
            let dis = 0;
            this.selectedItems = props.items;
            props.items.map((x) => {
                if (!x.arena_details) dis += 1;
            });
            if (this.selected.length != props.items.length - dis) {
                this.selected = [];
                const self = this;
                props.items.forEach((item) => {
                    if (item.arena_details) {
                        self.selected.push(item);
                    }
                });
                console.log('ok',this.selected)
                this.$emit('selectedSoa', this.selected)
            } else {
                this.selected = []
                this.$emit('selectedSoa', [])
            };
        },
        resetTable(){
            console.log('xxxRESETxxxx')
            this.selected = []
        },
        singleSelected(item){
            this.$emit('selectedSoa', item)
        },

        async handlePaginate(e){
            this.pagePosition  = e.page
            
                if(this.dates.length < 1 && this.search) {
                    await this.handleSearching()

                }else if (this.filteredText === 'noArenaDetails' && this.dates.length < 1 && !this.search) {
                 
                    this.$emit('loading', true)
                    await this.handleNoArenaDetails();
                    this.$emit('loading', false)

                }else if(this.tab === 'ongoing' && this.dates.length < 1 && !this.search){ 
                    this.$emit('loading', true)
                    await this.soaLists();
                    this.$emit('loading', false)
                } else if (this.tab === 'converted'&& this.dates.length < 1 && !this.search) { 
                    console.log('converted FETCH DATA')
                    this.$emit('loading', true)
                    await this.withStatus()
                   
                    this.$emit('loading', false)
                } else if(this.dates.length > 1 && !this.search) {
                    this.$emit('loading', true)
                    await this.loadDateRange()
                    this.$emit('loading', false)
                } else {
                  console.log('SEARCH', this.search)
                  
                }
              
               
           
        },
        async handlePageCount(e){
         
            const perPage = Math.ceil((this.total/e))
          
            this.$emit('perPage', perPage)
            //  await this.soaLists(this.pagePosition,perPage); 
            //  if(this.tab === 'ongoing'){ 
            //         await this.soaLists(this.pagePosition,perPage); 
            //         this.loading = false
            //     } else { 
            //         await this.withStatus(this.pagePosition, perPage)
            //         this.loading = false
            //     };
        },
 
        handlePageOptions(e){
        
            localStorage.setItem('itemsPerPage', e.itemsPerPage)
            this.$emit('pageOption', e)
       
            this.paginationOption = {
              itemsPerPage: e.itemsPerPage,
              ...e,
            }


        },
        pageOptions(){
            this.paginationOption = {
              ...this.paginationOption,
              // page: parseInt(localStorage.getItem('page')),
              itemsPerPage: parseInt(localStorage.getItem('itemsPerPage')),
              
            }
        },
        pageReset(){
           return this.paginationOption = {
              ...this.paginationOption,
              page: 1,
              itemsPerPage: parseInt(localStorage.getItem('itemsPerPage')),
              
            }
        }

    },
    created(){
      this.pageReset()
    }
};
</script>
<style lang=""></style>
