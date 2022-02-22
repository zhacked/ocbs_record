<template lang="">
    <v-col class="col-md-3">
        <v-select
            :items="arenaItemsSelection"
            label="Filter arena"
            dense
            outlined
            item-text="text"
            item-value="key"
            @change="handleSelectionFilterArena"
        ></v-select>
        <loading-progress :loading="loading" />
    </v-col>
</template>
<script>
export default {
    name: 'filter-arena',
    props: {
        arenaData: Array,
        soaLists: Function,
        importWithStatus: Function,
        dates: Array,
        tab: String,
        loadDateRange: Function
    },
    data: () => ({
           arenaItemsSelection: [
                {
                    key: "all",
                    text: "All",
                },
                {
                    key: "noArenaDetails",
                    text: "No Arena",
                },
            ],
            loading: false
    }),
    methods: {
        filterNoArenaDetails() {
            this.loading = true
            let arenaNoDetais = [];
            this.arenaData.forEach((arena) => {
                if (!arena.arena_details) {
                    arenaNoDetais.push(arena);
                }
            });
            this.arenaData.length = 0;
            this.arenaData.splice(0, Infinity, ...arenaNoDetais);

            this.$emit('newSetArrayArena', this.arenaData)
            this.loading = false
        },

        handleSelectionFilterArena(item) {
            this.loading = true
            item === "noArenaDetails"
                ? this.filterNoArenaDetails()
                : this.dates.length !== 0 ? this.loadDateRange(this.tab) : this.tab === 'ongoing' ? this.soaLists() : this.importWithStatus();
            this.loading = false
        },
    },
};
</script>
<style lang=""></style>
