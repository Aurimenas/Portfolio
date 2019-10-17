<template>
<div>
<div class="w-100" style="display:inline-flex;">
  <div style="flex-grow:1;">
    <button type="button" class="form-control" style="border:none;border-right:1px solid;border-radius:0;" @click="component='log'"> <u>Sign in</u></button>
    </div><div style="flex-grow:1;">
    <button type="button" class="button form-control" style="border:none;border-left:1px solid;border-radius:0;" @click="component='reg'"><u> Sign up</u></button>
</div>
    </div>
    <div class="row text-center d-flex justify-content-center">
<component v-bind:is="component"></component>
</div>
</div>


</template>
       
     

<script>

import log from './log.vue';
import reg from './reg.vue';
export default {
    name:"login",
    components:{
        'reg':reg,
        'log':log
    },
    data(){
        return{
        component:'log'
        }
    }
}

</script>