<template>
    <div>
        <div class="card text-center"><strong style="font-size:25px;">All orders</strong><hr>
        <table class="table table-bordered  table-checkered"><thead class="thead-dark">
            <tr>
            <th> Ordered at</th>
            <th>Product id</th>
            <th>Product name</th> 
            <th>Quantity</th>
            <th>Shipping address</th>
            <th>Ordered by user</th>
            <th> Recipient's name </th>
            </tr>
            </thead>
            <tbody>
                <tr v-show="sales[0]==null">
                        <td colspan="7"> There haven't been any purchases yet </td>
                        </tr>
        <tr v-for="order in sales" :key="order.id">          
              
                <td>{{order.created_at}}</td>
                <td>{{order.item.id}}</td>
                <td>{{order.item.name}}</td>
                <td>{{order.quantity}}</td>
                <td>{{order.address}}</td>
                <td>{{order.account.usn}}</td>
                <td>{{order.Ship_name}}</td>
                </tr> 
        
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
    name:"sales",
    data(){
        return{
            sales:[],
            err1:null
        }
    },
    created(){
        this.fetchSales();
    },
    methods:{
        fetchSales(){
            fetch('api/sales')
           // .then(response=>response.text())
           // .then(text=>{
           //     console.log(text)
           // })
            .then(response=>response.json())
            .then(response=>{
              console.log(response);
              this.sales=response.data;
              if(response.data===null){
                  this.err1="There are no orders yet";
              };
            })
            .catch(error=>{
                console.log(error);
            })
        }
    }
}
</script>