<template>
    <div>
        <div>

            <select id="city" @change="updateCity" v-model="city">
                <option value="51.5072,0.1276">London</option>
                <option value="48.8566,2.3522">Paris</option>
                <option value="39.0119,-94.578331">Kansas</option>
            </select>
            <span>selected : {{ city }}</span>
        </div>
        <div id="map" class="w-100" style="height:100vh" ref="map"></div>
    </div>
</template>


<script>
import axios from 'axios';
export default {
    name: 'map-component',
    props:['apiRoute'],
    data () {
        return {
            city:'51.5072,0.1276',
            msg: 'Welcome to Your Vue.js App',
            ppl :[],
            filters:[],
        }
        },
    methods:{
        updateCity:function(val){
            let latLon = this.city.split(',');
            this.map.setCenter(new window.google.maps.LatLng(latLon[0],latLon[1]));

            this.updatePoints();
        },
        updatePoints:async function(){
            const response = await axios.get(this.apiRoute);
            let map = this.map;

            response.data.data.map(function(item){

                new window.google.maps.Marker({
                    position: new window.google.maps.LatLng(item.lat,item.lon),
                    map:map,
                    title: "Hello World!",
                });

            })
        }
    },
    mounted: function() {

        this.map = new window.google.maps.Map(this.$refs['map'], {
            center: {lat:51.5072, lng: 0.1276},
            scrollwheel: false,
            zoom: 13
        })
    }

}
</script>
