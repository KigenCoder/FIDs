<template>
    <ul>
        <li v-for="zone in zones">
            <input
                    type="radio"
                    v-bind:value="zone.id"
                    v-model="selectedZone"
                    @change="zoneSelected($event)"
            >
            {{zone.zone}}
        </li>
    </ul>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        data() {
            return {
                selectedZone: '',
            }
        },


        computed: {
            ...mapState([
                'zones'
            ])

        },


        methods: {
            zoneSelected() {
                alert(this.selectedZone)
            },
        },
    }
</script>


