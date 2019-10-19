<template>
    <div class="card py-5 text-center align-items-center">
        <form @submit.prevent="submitas()" style="display:block;" enctype="multipart/form-data">
        New product name:
      
        <input type="text" class="text-center form-control" v-model="name">
         <a style="color:red;"> {{err1}}</a><br>
        New product's base price (€):<br>
        <input type="number" class="text-center form-control" step="0.01" v-model="price">
       <a style="color:red;"> {{err2}}</a>
        <br>Initial quantity:<br>
        <input type="number" class="text-center form-control"  v-model="quant">
        <a style="color:red;"> {{err4}}</a>
        <br>Categories:<br>
         <div class="d-inline-flex">
        <div style="padding:10px 15px;">
             Mens
        <input type="checkbox" class="form-control"  :true-value="1" :false-value="0" v-model="mens">
        </div>
        <div style="padding:10px 15px;">
            Womens
        <input type="checkbox" class="form-control"  :true-value="1" :false-value="0" v-model="womens"> 
        </div>
        <div style="padding:10px 15px;">
            Childrens
        <input type="checkbox" class=" form-control"  :true-value="1" :false-value="0" v-model="children"> 
        </div>
        </div>
        <br>
        Product photo<br>
<input type="file" name="fileToUpload" class="form-control"  @change="onImageChange" id="fileToUpload"><a style="color:red;"> {{errimg}}</a>
<br>Product description: <br>
<textarea class="form-control text-center" v-model="desc"> </textarea><a style="color:red;"> {{err3}}</a><br>
<input type="submit" class="form-control my-4 button btn-success" value="Registruoti nauja produkta">
            </form>
        </div>
</template>
<script>
export default {
    name:"newprod",
    data(){
        return{
            desc:'',
            children:0,
            womens:0,
            mens:0,
            price:0,
            name:'',
            quant:0,
            image:null,
            err1:null,
            err2:null,
            err3:null,
            err4:null,
            errimg:null
        }
    }, 
    methods:{
        submitas(){
            axios.post('api/inventory',{
                price:this.price,
                name:this.name,
                womens:this.womens,
                mens:this.mens,
                children:this.children,
                desc:this.desc,
                quant:this.quant,
                img:this.image
            })
            //.then(response=>response.json())
            .then(response=>{
                console.log(response)
                this.err1=response.data.err1
                this.err2=response.data.err2
                this.err3=response.data.err3
                this.err4=response.data.err4
                this.errimg=response.data.errimg
            })
        },
        onImageChange(e){
                let file = e.target.files[0];
                console.log(e.target.files[0])
                let reader= new FileReader();
                reader.onload=(file)=>{
                    console.log('RESULT:',reader.result)
                    this.image=reader.result
                }
                reader.readAsDataURL(file);
            }
    }
}
</script>