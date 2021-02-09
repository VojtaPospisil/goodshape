<template>
    <div>
        <h2 class="searchSign">Vyhledat parkování</h2>

        <div class="align">

            <div class="grid">

                <form @submit.prevent="getParkingPlaces()" class="form login">

                    <div class="form__field">
                        <select type="select" name="select" class="form__input" required v-model="selected" @input="trigger = false">
                            <option class="form__input" value="0" disabled selected>Najít od</option>
                            <option class="form__input" value="1">Současné polohy</option>
                            <option class="form__input" value="2">Od místa GPS</option>
                        </select>
                    </div>

                    <div class="form__field" v-if="selected == 1">
                        <input type="text" name="ip" :value="ip.regionName + ' ' + ip.zip + ' ' + ip.countryCode " class="form__input" placeholder="ip adresa" required @input="trigger = false">
                    </div>

                    <div class="form__field" v-if="selected == 2">
                        <input v-model="formData.location" type="text" name="location" class="form__input" placeholder="GPS lokace" required @input="trigger = false">
                    </div>

                    <div class="form__field">
                        <input v-model="formData.radius" type="number" name="radius" class="form__input" placeholder="V okolí" required @input="trigger = false">
                    </div>

                    <div class="form__field">
                        <input type="submit" value="Sign In">
                    </div>

                </form>
            </div>
        </div>

        <div>
            <datagrig-component
                :trigger="trigger"
                :formData="formData"
                :columns="columns">
            </datagrig-component>
        </div>
    </div>

</template>

<script>

    export default {
        data: function () {
            return {
                trigger: false,
                paginate: 5,
                perPage: [5, 15, 30],
                data: {},
                formData: {
                    location: '',
                    radius: '',
                },
                selected: '',
                tableProps: {
                    search: '',
                    length: 5,
                    column: 'name',
                    dir: 'asc'
                },
                ip: [],
                columns: [
                    {
                        label: 'Name',
                        name: 'name',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        label: 'Vzdálenost',
                        name: 'distance',
                        orderable: true,
                    },
                    {
                        label: 'Celkově míst',
                        name: 'totalNumOfPlaces',
                    },
                    {
                        label: 'Volných míst',
                        name: 'numOfFreePlaces',
                        orderable: true,
                    },
                ]
            }
        },
        mounted() {
            this.getIpLocation();
        },
        methods: {
            getIpLocation: function() {
                axios.get(`/GoodShape/public/api/getIpLocation`)
                    .then((response) => {
                        this.ip = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getParkingPlaces: function() {
                this.trigger = true;
            },
        },
    }
</script>
