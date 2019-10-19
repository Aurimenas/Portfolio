<template>
<div >

   
        <div class=" card m-5 py-4 d-flex flex-container justify-content-center text-center" style="min-width:900px;">
            <p> <strong style="font-size:25px;">Your Cart</strong></p>
             <p  v-if="itemai[0]==null">
      <strong>  Your cart is empty</strong>
        </p>
        <div class="mx-auto px-5 py-1 w-75 rounded bg-secondary my-2" v-for="(item, indexas) in itemai" :key="indexas">
<div class="row">
 <div class="mx-2 my-auto"><img v-bind:src="'storage/img/'+item.product.picture" style="width:50px;height:50px;"/></div>
    <div class="mx-2 my-auto" >
    <strong>{{item.product.name}} <br>Single unit price:  {{Number(item.product.price*(1+(0.01*tax))*(1-(0.01*sale))).toFixed(2)}} € </strong><br>
    </div>
    <div class="mx-auto mr-2 my-auto">
<strong>Order quantity: </strong> <div ><button style="width:40px;display:inline-block;" class="button form-control mr-2"  @click="Minus(indexas)" v-bind:disabled="button[indexas]">- 
 </button>{{item.quantity}} pcs. <button  class="button form-control" style="width:40px;display:inline-block;" @click="Plus(indexas)"> +</button></div> <br>
    </div>
    <div class="my-auto mr-2 my-auto">
            <button class="button mx-auto form-control btn-danger" style="width:100px;" @click="remove(item.id)"> Remove </button>
      </div > 
      <div class=" my-auto">    
 <strong>Total: {{Number(item.product.price*(1+(0.01*tax))*(1-(0.01*sale))*item.quantity).toFixed(2)}} €</strong><br>
 </div>
 </div>
 </div>
       <strong style="font-size:25px;">  Total: {{total}} €</strong>
       <div v-if="itemai[0]">
            <form  action="api/paystart" method="POST">
    <input  type="submit" class="button w-auto mx-auto btn-success form-control" value="Check out now!">
            </form>
            </div>
               </div>
       
    </div>
</template>
<script>
export default {
    name:"cart",
    data(){
        return{
            itemai:[],
            button:[],
            total:0,
            sale:0,
            tax:0
           
        }
    },
    created(){
        this.getmyCart();
    },
  methods:{
        getmyCart(){
             fetch('api/cart')
             .then(response=>response.json())
           //  .then(response=>response.text())
            .then(response=>{
              //  .then(text=>{
              //  console.log(text)
                console.log(response.data);
                    this.itemai=response.cart
                    this.tax=response.tax
                    this.sale=response.sale
                    this.calctotal()
                    }
                )
            .catch((e) => {
                console.error(e)
            })
        },
        Plus(itm){
           
             if(this.itemai[itm].quantity>1){
             this.button[itm]=false
         }
         this.itemai[itm].quantity++
         this.calctotal()
            axios.put('api/cartplus',{
               itemid:this.itemai[itm].id,
                quant:this.itemai[itm].quantity     
            })
            .then(response=>{
              console.log(response)
            })
        },
        Minus(itm){
            
         if(this.itemai[itm].quantity<2){
             this.button[itm]=true

         }else{
         this.itemai[itm].quantity--
        this.calctotal()
         }
         
            axios.put('api/cartminus',{
                itemid:this.itemai[itm].id,
                quant:this.itemai[itm].quantity     
            })
            .then(response=>{
             console.log(response)    
            })
        },
        remove(id){
            axios.delete('api/cartdel/'+id)
           
            .then(response=>{
                console.log(response)
                this.getmyCart()
            })
        },
        calctotal(){
            let tot=0
            for(let i=0; i<this.itemai.length; i++){
                tot=tot+this.itemai[i].quantity*this.itemai[i].product.price*(1+(0.01*this.tax))*(1-(0.01*this.sale))
            }
            this.total=Number(tot).toFixed(2)
        }
    }
}
</script>