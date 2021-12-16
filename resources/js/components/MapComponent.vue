<template>
    <div class="w-100">
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="#" method="POST">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <span class=" text-gray-900" >{{ numberOfRecords }}</span>
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="first-name" class="block text-sm font-medium text-gray-700">First name / Last Name : </label>
                                <input v-model="txt" @keyup="updateMap" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <select class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="city" @change="updateMap" v-model="city">
                                    <option value="">All Cities</option>
                                    <option value="51.5072,0.1276">London</option>
                                    <option value="48.8566,2.3522">Paris</option>
                                    <option value="39.0119,-94.578331">Kansas</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                                <select class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" @change="updateMap" id="gender" v-model="gender">
                                    <option value="">All</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                        </div>

                        <div id="map" class="w-100" style="height:60vh" ref="map"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
var markers = [];
function pinSymbol(color) {
    return {
        path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
        fillColor: color,
        fillOpacity: 0.9,
        strokeColor: '#3d3d3d',
        strokeWeight: 1,
        scale: 1,
    };
}
export default {
    name: 'map-component',
    props:['apiRoute'],
    data () {
        return {
            city:'51.5072,0.1276',
            msg: 'Welcome to Your Vue.js App',
            ppl :[],
            gender : '',
            txt:'',
            numberOfRecords:0
        }
        },
    methods:{
        updateMap:function(val){
            let latLon = this.city.split(',');
            this.map.setCenter(new window.google.maps.LatLng(latLon[0],latLon[1]));
            this.updatePoints();
        },
        updatePoints:async function(){
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers=[];
            const params = {
                filter:
                    {
                        city:this.city,
                        gender:this.gender,
                        txt:this.txt
                    }};
            const response = await axios.post(this.apiRoute,params);
            let map = this.map;

            response.data.data.map(function(item){

                markers.push(new window.google.maps.Marker({
                    position: new window.google.maps.LatLng(item.lat,item.lon),
                    map:map,
                    title: item.first_name + ' ' + item.last_name,
                    icon: pinSymbol(item.gender=='Female'?"#c93d81":"#0656bd"),
                }));

            })
            this.numberOfRecords = markers.length;
        }
    },
    mounted: function() {

        this.map = new window.google.maps.Map(this.$refs['map'], {
            center: {lat:51.5072, lng: 0.1276},
            scrollwheel: false,
            zoom: 5
        })

        this.updateMap();
    }

}
</script>
