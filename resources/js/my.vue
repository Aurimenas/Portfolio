<template>
    <div class="m-5 py-2">
        <div class="card text-center"><strong style="font-size:25px;">My orders</strong><hr>
        <table class="table table-light table-checkered table-bordered"><thead class="thead-dark">
            <tr>
            <th>Ordered at</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Shipping address</th>
            <th>Total order price</th>
            </tr>
            </thead>
            <tbody>
        <tr v-for="item in itemai" :key="item.id">          
              
                <td>{{item.created_at}}</td>
                <td>{{item.item.name}}</td>
                <td>{{item.quantity}} pcs.</td>
                <td>{{item.address}}</td>
                <td>{{item.total}} €</td>
                </tr> 
        
              </tbody>
            </table>
        <div class="text-center" v-if="err1!==null">
{{err1}}
            </div>
        </div>
        </div>
</template>
<script>
export default {
    name:"my",
    data(){
        return{
            itemai:[],
            err1:null
        }
    },
    created(){
        this.myOrders();
    },
    methods:{
        myOrders(){
            fetch('api/myorders')
           .then(response=>response.json())
            .then(response=>{
             this.itemai=response.data;
                console.log(response);
                if(response.data==null){
                    this.err1="You have not made any orders yet!";
                };
                }
                
            )
            .catch((e) => {
                console.error(e)
            })
        },
    }
}
</script>