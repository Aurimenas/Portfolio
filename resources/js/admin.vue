<template>
<div v-if="au===true" class="row ml-2 my-3" style="height:100vh;min-width:525px;" >  <!-- v-if="$session.get('id')=='1'" -->
    
<div class="col-2 text-center rounded mr-2" style="background-color:white;min-height:80%;min-width:120px;border:solid 2px #0a0a29;border-radius:2px;" >
    <br><strong style="font-size:25px;">Control Panel</strong><br><hr style="background-color:#141452;height:2px;border-radius:2px;">
    <div class=" text-center">
    <button type=" row button" class="form-control" @click="component='stats'" style="border:none;"> <strong>Stats</strong></button><hr style="background-color:#33ccff;height:1px;">
    </div>
    <div class=" text-center">
    <button type="button" class="form-control" @click="component='sales'" style="border:none;"> <strong>Sales</strong></button><hr style="background-color:#33ccff;height:1px;">
    </div>
    <div class=" text-center">
    <button type="button" class="form-control" @click="component='newprod'" style="border:none;"><strong> New product</strong></button><hr style="background-color:#33ccff;height:1px;">
    </div>
    <div class=" text-center">
    <button type="button" class="form-control" @click="component='list'" style="border:none;"> <strong>Manage products</strong></button><hr style="background-color:#33ccff;height:1px;">
    </div>
    <div class=" text-center">
    <button type="button" class="form-control" @click="component='settings'" style="border:none;"> <strong>Store settings</strong></button><hr style="background-color:#33ccff;height:1px;">
    </div>
    </div>
    <div class="col-9" >
        
<component v-bind:is="component"></component>
</div>
</div>


</template>
       
     

<script>

import stats from './stats.vue';
import sales from './sales.vue';
import settings from './settings.vue';
import list from './list.vue';
import newprod from './newprod.vue';
import Vue from "vue"
//import Trend from "vuetrend"

//Vue.use(Trend)

export default {
    name:"admin",
    components:{
        'stats':stats,
        'sales':sales,
        'settings':settings,
        'list':list,
        'newprod':newprod
        
    },
    data(){
        return{
        component:'stats',
        au:false
        }
    },
    created(){
        axios.post('api/auth')
        .then(response=>{
            if(response.data.re==="Authenticated"){
                this.au=true
            }else{
                window.location.href=''
            }
        })
    }
}

</script>