<template lang="">
    <fragment>
        <v-data-table
            item-key="codeEvent"
            :headers="headers"
            :items="arenaData"
            :items-per-page="10"
            v-model="selected"
            :loading="downloadingReport"
            :search="search"
            :show-select="downloadingReport ? false : true"
            :disable-filtering="downloadingReport ? true : false"
            :disable-sort="downloadingReport ? true : false"
            :single-select="singleSelect"
            class="elevation-1 text-center"
            :footer-props="{
                'items-per-page-options': [10, 20, 30, 40, 50, 100],
            }"
            @toggle-select-all="selectAllToggle"
        >
        
            <template v-slot:[`item.data-table-select`]="{ item, isSelected, select }">
                <div>
                    <v-simple-checkbox
                        :value="isSelected"
                        :readonly="item.disabled"
                        :disabled="item.arena_details ? false : true"
                        @input="select($event)"
                    ></v-simple-checkbox>
                </div>
            </template>
            <!-- <template v-slot:[`item.areaCode`]="{ item }">
                <div>
                    <span class="font-weight-medium">{{ item.arena_details ? item.arena_details.area_code : item.areaCode}}</span>
                    <span class="font-weight-medium">{{ item.refNo}}</span>
                    <span class="font-weight-medium">{{ item.arena_details ? item.arena_details.arena : item.arena_name}}</span>
                </div>
            </template> -->
          
         
             <template v-slot:[`item.actions`]="{ item }">
                 <div>
                    <v-tooltip top color="primary">
                        <template v-slot:activator="{ on, attrs, hover }">
                            <v-btn
                                icon
                                color="primary"
                                dark
                                small
                                v-bind="attrs"
                                v-on="on"
                                @click="openModel(item)"
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
                    </div>
                </template>
        </v-data-table>
    </fragment>
</template>
<script>
export default {
    name: "table-soa",
    props: {
        arenaData: Array,
        downloadingReport: Boolean,
        openModel: Function,
        search: String,
        handleSwitchTab: Function
    },
    data: () => ({
        headers: [
            { text: "#", value: "id" },
            { text: "CODE", value: "areaCode" },
            { text: "ref", value: "refNo" },
            { text: "Arena Name", value: "arena_name" },

            { text: "", value: "actions", sortable: false },
        ],
        singleSelect: false,
        selectedItems: [],
        selected: []
    }),
    methods: {
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
            } else this.$emit('selectedSoa', []);
        },
        emptySelect(){
            this.selected = []
        }
    },
};
</script>
<style lang=""></style>
