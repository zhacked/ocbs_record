<template lang="">
   <v-col class="col-md-3">
        <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="false"
            :return-value.sync="dates"
            transition="scale-transition"
            offset-y
            min-width="auto"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    v-model="dateRangeText"
                    outlined
                        dense
                        label="Select Date Range"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                    ></v-text-field>
            </template>
            <v-date-picker
                v-model="dates"
                no-title
                scrollable
                range
            >
                <v-spacer></v-spacer>
                <v-btn
                    text
                    color="primary"
                    @click="handleClear"
                >
                    Clear
                </v-btn>
                <v-btn
                    text
                    color="primary"
                    @click="handleFilterDate(dates)"
                >
                    OK
                </v-btn>
            </v-date-picker>
        </v-menu>
    </v-col>
</template>
<script>
import moment from "moment";
export default {
    name: 'date-range',
    props: {
        soaLists: Function,
        tab: String
    },
    data: ()=>({
        menu: false,
        dates: []
    }),
    methods: {
        handleFilterDate(dates) {
            this.$refs.menu.save(dates);
            this.loadDateRange();
            this.$emit('dates', dates)
        },
        handleClear() {
            this.menu = false;
            this.$refs.menu.save([]);
            this.$emit('dates', [])
            this.$emit('tabs', 'ongoing')
            this.soaLists();
        },

        async loadDateRange(tabItem) {
            // DATE RANGE
            console.log(tabItem)
            const endDate = moment(this.dates[1], "YYYY-MM-DD")
                .add(1, "days")
                .format("YYYY-MM-DD");
            const depositReplenish = await axios.get(
                `api/importDateRange/${this.dates[0]}/${endDate}`
            );

         
            const filteredDepositReplenish = tabItem === 'ongoing' || (!tabItem && this.tab ==='ongoing') ? depositReplenish.data.filter(dr => dr.status === null) : depositReplenish.data.filter(dr => dr.status !== null)
        
            this.$emit('depositReplenish', filteredDepositReplenish)

            return await filteredDepositReplenish
        },
    },
    computed: {
            dateRangeText() {
            const dateRange = this.dates.length > 1 ? this.dates.sort() : null;
            return dateRange ? dateRange.join(" ~ ") : null;
        },
    }
}
</script>
<style lang="">
    
</style>