<template>
<div >
<div id="carouselExampleIndicators" class="carousel slide mx-1 my-2" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" style="max-width:1000;height:500px;" src="storage/img/carousel1.png" alt="First slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" style="max-width:1000;height:500px;" src="storage/img/carousel2.png" alt="Second slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" style="max-width:1000;height:500px;" src="storage/img/carousel3.png"  alt="Third slide">
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
            <!-- CATEGORY BAR -->
<div class="text-center" style="background-color:white;display:flex;justify-content:center">
<button disabled="disabled">Categories:</button>
 <button style="overflow:hidden;border-radius:0px;" class="form-control" @click="cat='All'">All products </button>
<button style="overflow:hidden;border-radius:0px;" class="form-control" @click="cat='Mens'"> Mens clothes </button>
<button style="overflow:hidden;border-radius:0px;" class="form-control" @click="cat='Womens'"> Womens clothes </button>
<button style="overflow:hidden;border-radius:0px;" class="form-control" @click="cat='child'"> Childrens clothing</button>
  </div>
  <!-- category bar end -->
<div class="mb-5 mx-2" style="display:flex;flex-wrap:wrap;justify-content:center;" >
    <div v-if="items[0]==null" style="height:1800px;">
     
      </div>  <!-- ^^ have full height before data loads ^^ -->
    <div v-else class="mx-2 my-2 rounded itemas"  v-for="(item, indexas) in items" :key="indexas">
      
      <div>
        <strong style="font-size:25px;">{{item.name}}</strong><hr>
        <img v-bind:src="'storage/img/'+item.picture" style="width:500px;height:500px;"/>  <!--  style="max-width:600px;max-height:300px;"  -->
        <hr>
        
        {{Number(item.price*(1+(0.01*tax))*(1-(0.01*sale))).toFixed(2)}} €<br>
        <a v-show="item.quantity>0" >In stock </a>
        <a v-show="item.quantity<1" style="color:#800000"><strong> Out of stock </strong></a>
        <hr>
        <router-link v-bind:to="'/item/'+item.id"><h3 > Click for more info</h3></router-link>
      </div>
        
     
    </div>
  </div>
       
     
      <div  style="display:flex;justify-content:center;">
        <div>
      <ul class="pagination ">
    <li class="page-item"><button class="page-link" v-bind:disabled="butP" @click="Prev()">&laquo;</button></li>
    <li class="page-item"><input class="page-link text-center" @change="Change()" type="text" style="width:50px;" v-model="pagenum"></li> 
    <li class="page-item"><button class="page-link" v-bind:disabled="butN" @click="Next()">&raquo;</button></li>
  </ul>
  </div>
  </div> 
      
 <div class="py-2 w-100" style="display:flex;justify-content:center;background-color:white;position:relative;bottom:0px;"> 
              <div  class="mx-3 my-2 text-center"  > 
                <strong> <u>About us </u></strong> <br>
                  <i class="fas fa-map-marker-alt"></i> Lietuva, Kaunas, Vytauto pr.36A<br>
                 <i class="fas fa-phone-square-alt"></i> +37061880078<br>
                 <i class="far fa-envelope"></i> Yourbussinessmanager@yourbusiness.com <br>
              </div>
              <div  class="mx-3 text-center" style="float:left;">
                <strong><u>Social media</u></strong><br>
                <i class="fab fa-facebook-square"></i><a href="https://www.facebook.com/yourbussiness" style="color:black;"> Facebook</a><br>
               <i class="fab fa-instagram"></i><a href="https://www.instagram.com/yourbussiness" style="color:black;"> Instagram</a><br>
               <i class="fab fa-twitter-square"></i> <a href="https://www.twitter.com/yourbussiness" style="color:black;"> Twitter</a><br>
               <i class="fab fa-linkedin"></i> <a href="https://www.linkedin.com/yourbussiness" style="color:black;"> LinkedIn</a><br>
                <i class="fab fa-youtube"></i> <a href="https://www.youtube.com/yourbussiness" style="color:black;"> Youtube</a><br>
              </div>
              <div class="mx-3 text-center"  >
                  <strong> <u> Extra</u></strong><br>
               <i class="fas fa-user-secret"></i> <a href="https://www.privacy.com/yourbussiness" style="color:black;"> Privacy policy</a><br>
               <i class="far fa-newspaper"></i> <a href="https://www.newsletter.com/yourbussiness" style="color:black;"> Newsletter</a><br>
              </div>
              <br>
   
  </div>
  <div class="text-center w-100 pb-3" style="position:re;ative;bottom:0px;background-color:white;">
 Copyright © 2019, YourBussiness 
    </div>
  
</div> <!--final component's (closing) div -->
</template>
<script>
export default {
    name: "shopas",
    data(){
        return{
            items:[],
            pagenum:1,
            total:1,
            butP:true,
            butN:true,
            nexturl:null,
            prevurl:null,
            lasturl:null,
            firsturl:null,
            tax:0,
            sale:0,
            cat:'All'
    } 
  },
   watch:{
      cat(){
        this.getinv('api/inventorycat',this.cat)
      }
    },
    created(){
     
        this.getinv('api/inventorycat',this.cat);
       
    },
    methods:{
        getinv(url,categ){
              axios.post(url,{
                cat:categ
              })
             // .then(response=>response.json())
            .then(response=>{
                console.log(response)
                    this.items=response.data.data.data
                    this.pagenum=response.data.data.current_page
                    this.total=response.data.data.total
                    this.nexturl=response.data.data.next_page_url
                    this.prevurl=response.data.data.prev_page_url
                    this.lasturl=response.data.data.last_page_url
                    this.firsturl=response.data.data.first_page_url
                    this.tax=response.data.tax
                    this.sale=response.data.sale
                    if(this.nexturl===null){
                      this.butN=true
                    }else{
                      this.butN=false
                    }
                    if(this.prevurl===null){
                      this.butP=true
                    } else{
                      this.butP=false
                    }
                    }
                )
            .catch((e) => {
                console.error(e)
            })
        },
        Change(){
            if(this.pagenum<1){
              this.getinv(this.firsturl,this.cat)
            }
            else if(this.pagenum>this.total){
              this.getinv(this.lasturl,this.cat)
            } else{
              this.getinv('api/inventorycat?page='+this.pagenum,this.cat)
            }
      
          },
       
        Prev(){
          if(this.prevurl!==null){//verification if client removes "disabled" attribute from the button
              this.getinv(this.prevurl,this.cat)
          }
        },
        Next(){
          if(this.nexturl!==null){ //verification if client removes "disabled" attribute from the button
            this.getinv(this.nexturl,this.cat)
          }
        }
        
    }
}
</script>