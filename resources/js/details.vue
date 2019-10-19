<template>
    <div class="card m-5 px-5 pb-5" >
        <strong class="text-center" style="font-size:25px">
    {{item.name}}</strong><br>
    <div class="mx-2 " style="display:inline-flex;" >
        <div name="divas pic" >
<img v-bind:src="'storage/img/'+item.picture" style="width:500px;height:500px;"/>
            </div>

            <div name="divas content" style="float:left;" class="ml-2   ">
<strong> Price : </strong>{{Number(item.price*(1+(0.01*tax))*(1-(0.01*sale))).toFixed(2)}}€ ( {{Number(item.price*0.01*tax*(1-(0.01*sale))).toFixed(2)}} € VAT)<br>
             <strong>Units in stock : </strong>{{item.quantity}}<br>
            <div v-if="err3!==null">
             <i><strong>This item is already in your cart!</strong></i>
                    
              </div>
            <div v-else  >
               <div class="d-inline-flex my-2"> <div><button  class="button form-control w-auto" @click="orderQuant--">- </button></div><div class="my-auto">{{orderQuant}} pcs.</div><div> <button class="button w-auto form-control" @click="orderQuant++"> +</button></div>
                  </div> <br>  <button v-bind:disabled="but" class="button form-control btn-warning w-auto" @click="placeInCart()"> Add item to the cart </button>
            </div><br>{{err1}}
            <strong >Description : </strong>{{item.desc}}
           
    
       
        </div>
  
   
   </div>
    
    </div>
</template>
<script>
export default {
    name:"details",
    data(){
        return{
            item:{},
            orderQuant:1,
            but:false,
            err1:null,
            err2:null,
            err3:'',
            tax:0,
            sale:0
        }
    },
    created(){
        this.getTheProduct(this.$route.params.id);
    },
    watch:{
        orderQuant(){
            this.checkquant();
        }
    },
    methods:{
        getTheProduct(id){
             fetch('api/inventory/'+id)
             .then(response=>response.json())    
            // .then(response=>response.text())  debug lines
           //  .then(text=>{console.log(text)})  
            .then(response=>{
                console.log(response);
                    this.item=response.inv
                    this.err3=response.err3
                    this.tax=response.tax
                    this.sale=response.sale
                    }
                )
            .catch((e) => {
                console.error(e)
            })
        },
        checkquant(){
            if(this.item.quantity<this.orderQuant){
                 this.but=true;
            }else{
                this.but=false;
            };
        },
        placeInCart(){
             axios.post('api/cart', {
             id:this.item.id,
             quant:this.orderQuant
            })
            .then(response=>{
                console.log(response);
                this.err1=response.err1
                this.err2=response.err2
                this.getTheProduct(this.$route.params.id)
            })
            .catch((e)=>{
                console.log(e)
            })
        }
    }
}
</script>