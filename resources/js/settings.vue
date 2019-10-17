<template>
    <div class="card py-5 text-center">
        <form class="mx-auto" @submit.prevent="updateSett()">
            Tax rate applied to your store items( % ):
<input type="number"  class="form-control text-center" v-model="tax"><br>
Global discount( % ):
<input type="number"  class="form-control text-center" v-model="glob"><br>
Carousel #1 ad Display image:<br>
<input type="file" name="fileToUpload" class="form-control text-center"  @change="onImageChange1" id="fileToUpload"><br>
Carousel #2 ad Display image:<br>
<input type="file" name="fileToUpload" class="form-control text-center "  @change="onImageChange2" id="fileToUpload"><br>
Carousel #3 ad Display image:<br>
<input type="file" name="fileToUpload" class="form-control0 text-center"  @change="onImageChange3" id="fileToUpload"><br>
<input type="submit" class="form-control my-1 button btn-success" value="Save settings">
            </form>
        </div>
</template>
<script>
export default {
    name:"settings",
    data(){
        return{
            tax:0,
            glob:0,
            img1:null,
            img2:null,
            img3:null
    }
    },
    created(){
        this.fetchSett();
    },
    methods:{
        fetchSett(){
            fetch('api/settings')
            .then(response=>response.json())
            .then(response=>{
                this.tax=response.settings.tax;
                this.glob=response.settings.globalSale;
                console.log(response);
            }
            )
        },
        updateSett(){
            axios.put('api/settings',{
                tax:this.tax,
                glob:this.glob,
                img1:this.img1,
                img2:this.img2,
                img3:this.img3
            }).then(response=>{
                this.tax=response.data.settings.tax;
                this.glob=response.data.settings.globalSale;
                console.log(response);
                
                })
        },
        onImageChange1(e){
                let file = e.target.files[0];
                console.log(e.target.files[0])
                let reader= new FileReader();
                reader.onload=(file)=>{
                    console.log('RESULT1:',reader.result)
                    this.img1=reader.result
                }
                reader.readAsDataURL(file);
        },
        onImageChange2(e){
                let file = e.target.files[0];
                console.log(e.target.files[0])
                let reader= new FileReader();
                reader.onload=(file)=>{
                    console.log('RESULT2:',reader.result)
                    this.img2=reader.result
                }
                reader.readAsDataURL(file);
        },
        onImageChange3(e){
                let file = e.target.files[0];
                console.log(e.target.files[0])
                let reader= new FileReader();
                reader.onload=(file)=>{
                    console.log('RESULT3:',reader.result)
                    this.img3=reader.result
                }
                reader.readAsDataURL(file);
        }
    }
}
</script>