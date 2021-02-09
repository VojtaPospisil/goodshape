<template>
    <div class="data-table" v-if="showTable">
        <div class="main-table">
            <table class="table">
                <thead>
                <tr>
                    <th class="table-head">#</th>
                    <th v-for="column in columns" :key="column.name"
                        class="table-head">
                        {{ column.label | columnHead }}
                        <span v-if="column.orderable">
                            <i v-if="searchParams[column.name] === 'asc' " class="fa fa-sort-up" @click="sortByColumn(column.name, 'desc')"/>
                            <i v-else-if="searchParams[column.name] === 'desc' " class="fa fa-sort-desc" @click="sortByColumn(column.name, '')"/>
                            <i v-else class="fa fa-sort" aria-hidden="true" @click="sortByColumn(column.name, 'asc')"/>
                        </span>
                        <span v-if="column.searchable">
                            <input type="text" placeholder="Search" @keyup="searchText($event.target)">
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="" v-if="tableData.data.length === 0">
                    <td class="lead text-center" :colspan="columns.length + 1">No data found.</td>
                </tr>
                <tr v-for="(data, key1) in tableData.data" :key="data.id" class="m-datatable__row" v-else>
                    <td>{{ serialNumber(key1) }}</td>
                    <td v-for="(value, key) in data">{{ value }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <nav v-if="tableData.data.length > 0">
            <ul class="pagination">
                <li class="page-item" :class="{'disabled' : tableData.currentPage === 1}">
                    <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">Previous</a>
                </li>
                <li v-for="page in pagesNumber" class="page-item"
                    :class="{'active': page == tableData.current_page}">
                    <a href="javascript:void(0)" @click.prevent="changePage(page)" class="page-link">{{ page }}</a>
                </li>
                <li class="page-item" :class="{'disabled': currentPage === tableData.last_page }">
                    <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Next</a>
                </li>
                <span style="margin-top: 8px;"> &nbsp; <i>Displaying {{ tableData.data.length }} of {{ tableData.total }} entries.</i></span>
            </ul>
        </nav>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
        props: {
            trigger: {},
            formData: {},
            columns: { type: Array, required: true },
        },
        data() {
            return {
                showTable: false,
                tableData: {},
                offset: 4,
                currentPage: 1,
                sortedColumn: this.columns[0].name,
                searchParams: {
                },
                sortColumns: {}
            }
        },
        watch: {
            trigger: function(newVal, oldVal) {
                this.searchParams.gps = this.formData.location;
                this.searchParams.radius = this.formData.radius;
                if (newVal === true) {
                    this.getParkingPlaces();
                    this.showTable = true;
                }
            },
            fetchUrl: {
                handler: function(fetchUrl) {
                    this.url = fetchUrl
                },
                immediate: true
            }
        },
        computed: {
            /**
             * Get the pages number array for displaying in the pagination.
             * */
            pagesNumber() {
                if (!this.tableData.to) {
                    return []
                }
                let from = this.tableData.current_page - this.offset
                if (from < 1) {
                    from = 1
                }
                let to = from + (this.offset * 2)
                if (to >= this.tableData.last_page) {
                    to = this.tableData.last_page
                }
                let pagesArray = []
                for (let page = from; page <= to; page++) {
                    pagesArray.push(page)
                }
                return pagesArray
            },
        },
        methods: {
            /**
             * Get the serial number.
             * @param key
             * */
            serialNumber(key) {
                return (this.tableData.current_page - 1) * 5 + 1 + key
            },
            /**
             * Change the page.
             * @param pageNumber
             */
            changePage(pageNumber) {
                this.searchParams.page = pageNumber;
                this.currentPage = pageNumber;
                // this.fetchData()
                this.getParkingPlaces()
            },
            /**
             * Sort the data by column.
             * */
            sortByColumn(column, order) {
                if (order === '' && this.searchParams[column]) {
                   delete this.searchParams[column];
                } else {
                    this.searchParams[column] = order;
                }
                this.getParkingPlaces();
            },

            searchText(e) {
                if (e.value.length > 2) {
                    this.searchParams.searchName = e.value
                    delete this.searchParams.page;
                    this.getParkingPlaces();

                } else {
                    if (this.searchParams.searchName) {
                        delete this.searchParams.searchName;
                        this.getParkingPlaces();
                    }
                }
            },

            getParkingPlaces: function () {
                console.log(this.searchParams);
                axios.get(`/GoodShape/public/api/getParking`, {
                    params: this.searchParams
                }).then((response) => {
                        this.tableData = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        },
        filters: {
            columnHead(value) {
                return value.split('_').join(' ').toUpperCase()
            }
        },
        name: 'DataTable'
    }
</script>

<style scoped>
</style>
