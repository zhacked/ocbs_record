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
        showData: Function
    },
    data: ()=>({
        menu: false,
        dates: []
    }),
    methods: {
        handleFilterDate(dates) {
            this.$refs.menu.save(dates);
         
            if(dates.length !== 0  ){
                this.$emit('showClearBtn', true)
                this.loadDateRange();
                this.$emit('dates', dates)
            }
            
           
        },
        handleClear() {
            this.menu = false;
            this.$refs.menu.save([]);
            this.showData();
        },

        async loadDateRange() {
            // DATE RANGE
    
            const endDate = moment(this.dates[1], "YYYY-MM-DD")
                .add(1, "days")
                .format("YYYY-MM-DD");
            const depositReplenish = await axios.get(
                `api/importDateRange/${this.dates[0]}/${endDate}`
            );
            
            // const deposit = depositReplenish.data.soa.map(d => ({...d,date_of_soa: moment(d.date_of_soa, 'YYYY-MM-DD HH:mm:ss a').format('MMM DD YYYY LTS') }))
            // const reflenish = depositReplenish.data.fr.map(d => ({...d,date_of_soa: moment(d.date_of_soa, 'YYYY-MM-DD HH:mm:ss a').format('MMM DD YYYY LTS') }))
            // this.arenaData = depositReplenish.data;
            this.$emit('depositReplenish', depositReplenish.data)
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