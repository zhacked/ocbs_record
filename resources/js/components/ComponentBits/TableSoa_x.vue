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
            'items-per-page-options': [10, 20, 30, 40, 50, 100],
        }"
        :page="page"
        @page-count="handlePageCount"
        :server-items-length="total"
        @pagination="handlePaginate"
        @toggle-select-all="selectAllToggle"
        @input="singleSelected"
        @update:page="handlePage"
        @update:options="handlePageOptions"
        
    >
        <template v-slot:[`item.data-table-select`]="{ item, isSelected, select }">
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
            </v-tooltip>
        </template>
    </v-data-table>
    <loading-progress :loading="loading" />    
</div>
</template>
<script>
export default {
    name: "table-soa",
    props: {
        soaLists: Function,
        withStatus: Function,
        arenaData: Array,
        downloadingReport: Boolean,
        openModal: Function,
        search: String,
        total: Number,
        page: Number,
        numberOfPages: Number,
        dates: Array,
        tab: String
    },
    data: () => ({
        headers: [
            { text: "Date", value: "date_of_soa" },
            { text: "CODE", value: "areaCode" },
            { text: "ref", value: "refNo" },
            { text: "Arena Name", value: "arena_name" },
            { text: "", value: "actions", sortable: false },
        ],
        singleSelect: false,
        selectedItems: [],
        selected: [],
        loading: false,
        pagePosition: 1,
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
        emptySelect(){
            this.selected = []
        },
        singleSelected(item){
            this.$emit('selectedSoa', item)
        },

        async handlePaginate(e){
            this.pagePosition  = e.page
                if(this.tab === 'ongoing' && this.dates.length < 1){ 
                    this.$emit('loading', true)
                    await this.soaLists(e.page);

                    this.$emit('loading', false)
                } else if (this.tab === 'converted'&& this.dates.length < 1) { 
                    this.$emit('loading', true)
                    await this.withStatus(e.page)
                    this.$emit('loading', false)
                };
           
        },
        async handlePageCount(e){
            console.log(e)
            const perPage = Math.ceil((this.total/e)+1)
            console.log('PAGE COUNT',perPage)
            // this.$emit('perPage', perPage)
            //  await this.soaLists(this.pagePosition,perPage); 
            //  if(this.tab === 'ongoing'){ 
            //         await this.soaLists(this.pagePosition,perPage); 
            //         this.loading = false
            //     } else { 
            //         await this.withStatus(this.pagePosition, perPage)
            //         this.loading = false
            //     };
        },
        handlePage(e){
            console.log('PAGE', e)
        },
        handlePageOptions(e){
           
            console.log('OPTIONS>>>',e)
            this.$emit('perPage', e.itemsPerPage)
            this.$emit('pageOption', e)
            
        }

    },
};
</script>
<style lang=""></style>
