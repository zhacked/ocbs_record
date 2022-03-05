<template lang="">
      <v-col class="col-md-2">
                            <v-text-field
                                v-model="search"
                                outlined
                                dense
                                append-icon="mdi-magnify"
                                label="Search"
                                color="primary darken-2"
                                clearable
                               
                            ></v-text-field>
                        </v-col>
                         <!-- @click:append="handleSearch"
                                @click:clear="handleClear" -->
</template>
<script>
import axios from 'axios'
export default {
    name: 'search-soa',
    props: {
        soaLists: Function,
        importWithStatus: Function,
        tab: String
    },
    data:()=>({
        search: ''
    }),
    methods: {
        async handleSearch(){
            console.log(this.search)
            const {data} = await axios.get(`api/searchSoa?search=${this.search}`)

            this.$emit('searchData', data)
        },
        async handleClear(){
            this.tab === 'ongoing' ? await this.soaLists() : await this.importWithStatus()
        }
    }
}
</script>
<style lang="">
    
</style>