<template>
    <div class="card py-5 text-center align-items-center">
        <form @submit.prevent="submitas()" enctype="multipart/form-data">
        New product name:<br>
        <input type="text" class="text-center form-control" v-model="name"><br>
        New product price (€):<br>
        <input type="number" class="text-center form-control" step="0.01" v-model="price"><br>
        Initial quantity:<br>
        <input type="number" class="text-center form-control"  v-model="quant"><br>
        Categories:<br>
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
<input type="file" name="fileToUpload" class="form-control"  @change="onImageChange" id="fileToUpload"><br>
Product description: <br>
<textarea class="form-control text-center" v-model="desc"> </textarea><br>
<input type="submit" class="form-control button btn-success" value="Registruoti nauja produkta">
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
            image:null
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
                console.log(response);
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