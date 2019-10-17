<template>
    <div>
        <div class="card" ><strong class="text-center" style="font-size:25px;">Shop product list</strong><hr>
        <table class="table table-bordered table-light"><thead class="thead-dark">
            <tr>
            <th> Product</th>
            <th>Quantity in stock</th>
            <th>Mens</th>
            <th>Womens</th>
            <th>Children</th>
            <th>Price</th>
            <th> Functions</th>
            </tr>
            </thead>
            <tbody v-for="(item, index) in items" :key="index"> 
        <tr>          
              
                <td>{{item.name}}</td>
                <td>{{item.quantity}}</td>
                 <td v-if="item.mens">&#10004</td>
                <td v-else> x </td>
                 <td v-if="item.womens">&#10004</td>
                <td v-else> x </td>
                <td v-if="item.children">&#10004</td>
                <td v-else> x </td>
                <td>{{item.price}} €</td>
                <td><button class="button btn-warning" @click="openclose(item.id)"> Edit</button> <button class="button btn-danger" @click="purge(item.id)">Remove from store</button></td>
                </tr> <tr v-show="showup==item.id"><td colspan="7">
      <form class="text-center" @submit.prevent="updatedis(index)">
          Name
<input class="form-control text-center mx-auto w-50" v-model="item.name" type="text">
Price (€)
<input class="form-control text-center mx-auto w-50"  v-model="item.price" type="number" step="0.01">
Description
<input class="form-control text-center mx-auto w-50"  v-model="item.desc" type="text">
<div class="d-inline-flex ">
    <div clas="align-items-center" style="margin:5px 15px;">
Mens
<input class="form-control " v-model="item.mens" :true-value="1" :false-value="0" type="checkbox">
</div>
<div style="margin:5px 15px;">
Womens
<input class="form-control"  v-model="item.womens" :true-value="1" :false-value="0" type="checkbox">
</div> 
<div style="margin:5px 15px;">
Children
<input class="form-control"  v-model="item.children" :true-value="1" :false-value="0" type="checkbox">
</div>
</div><br>
<input type="file" class="form-control mx-auto w-50"  @change="imgfunc"><br>
<input type="submit" class="form-control mx-auto button btn-success" style="width:100px;" value="Issaugoti"><br>
          </form> <br><div class="d-flex flex-container justify-content-center"><br>
          <form class="text-center" @submit.prevent="PlusMinus(item.id)">
              Dabartinis kiekis: {{item.quantity}}<br>
Prideti:<input type="number" class="form-control" v-model="plus"><br>
Atimti:<input type="number" class=" form-control" v-model="minus"><br>
<input type="submit" class="button form-control btn-success" value="Modifikuoti kieki">
              </form>
              </div>
  </td>
      </tr>
     

        <!-- LISTAS => V-sHOW=forma onclick issiskleidzia -->
              </tbody>
            </table>
        <div v-if="err1!==null">
{{err1}}
            </div>
            </div>
        </div>
</template>
<script>
export default {
    name:"list",
    data(){
        return{
            items:[],
            err1:null,
            showup:null,
            plus:0,
            minus:0,
            img:null
            
        }
    },
    created(){
        this.fetchInv()
    },
    methods:{
        imgfunc(e){
            let file = e.target.files[0];
                console.log(e.target.files[0])
                let reader= new FileReader();
                reader.onload=(file)=>{
                    console.log('RESULT1:',reader.result)
                    this.img=reader.result
                }
                reader.readAsDataURL(file);
        },
        fetchInv(){
            fetch('api/inventoryfull')
            .then(response=>response.json())
            .then(response=>{
                console.log(response);
                this.items=response.data;
                if(response.data===null){
                    this.err1="There are no items in the store yet!";
                };
            })
            .catch(error=>{
                console.log(error);
            })
        },
        openclose(id){
            if(this.showup===id){
                this.showup=null;
                this.minus=0;
                this.plus=0;
                this.img=null;
                this.fetchInv();
            }else {
            this.showup=id;
            };
        },
        updatedis(idd){

           // console.log(this.items[id-1].womens);
            axios.put('api/inventory',{
                name:this.items[idd].name,
                desc:this.items[idd].desc,
                mens:this.items[idd].mens,
                womens:this.items[idd].womens,
                children:this.items[idd].children,
                price:this.items[idd].price,
                itemid:this.items[idd].id,
                img:this.img})
            //    .then(response=>text())
            //    .then(text=>{
             //       console.log(text)
             //   })
           //.then(response=>response.json())
            .then(response=>{
                console.log(response)
            })
            .catch(error=>{
                console.log(error)
            })
        },
         purge(id){
          axios.put('api/remove/'+id)
        .then(response=>{
            console.log(response)
            this.err1=response.err1
            this.fetchInv()
        })
    },
    PlusMinus(id){
       axios.put('api/plusminus/'+id,{
           plus:this.plus,
           minus:this.minus
       })
       .then(response=>{
           console.log(response);
       }).finally(this.fetchInv())
    }
    }
}
</script>