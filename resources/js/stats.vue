<template>
<div id="tests" class="card" >
    <table class="table text-center table-bordered">
        <thead class="thead-dark">
            <tr>
            <th>Completed sales</th>
            <th>Sales revenue</th>
            <th>Sales this year</th>
            <th>Sale revenue this year</th>
            </tr>
            </thead>
            <tbody>
                <tr >
                <td>{{sal}}</td>
                <td>{{rev}} €</td>
                <td>{{yearsal}}</td>
                <td>{{revyear}} €</td>
                </tr>
                </tbody>
   
    </table>


    <canvas id="chart"></canvas>
    </div>
</template>
<script>
import Chart from 'chart.js';
export default {
    name:"stats",
    data(){
        return{
            ChData:{
            type:'line',
            data:{
               labels: ['Sausis', 'Vasaris', 'Kovas', 'Balandis', 'Geguze', 'Birzelis', 'Liepa', 'Rugpjutis','Rugsejis','Spalis','Lapkritis','Gruodis'],
                datasets: [
                 { // one line graph
                    label: 'Completed Sales (this year)',
                    data: [],
                    backgroundColor: [
                    'rgba(54,73,93,.5)', // Blue
                    'rgba(54,73,93,.5)',
                    'rgba(54,73,93,.5)',
                    'rgba(54,73,93,.5)',
                    'rgba(54,73,93,.5)',
                    'rgba(54,73,93,.5)',
                    'rgba(54,73,93,.5)',
                    'rgba(54,73,93,.5)'
                    ],
                    borderColor: 
                    ['#36495d',
                    '#36495d',
                    '#36495d',
                    '#36495d',
                    '#36495d',
                    '#36495d',
                    '#36495d',
                    '#36495d',],
                    borderWidth: 3}],
                
            },
            options: {
                responsive: true,
                lineTension: 1,
                scales: {
                yAxes: [{
                    ticks: {
                    beginAtZero: true,
                    padding: 25,
                    }
                }]
                }
            }
        },
        rev:'',
        revyear:'',
        yearsal:'',
        sal:''
    }
        },
        created(){
            this.FetchSales()
        },
        methods:{
            createChart(chartId, chartData) {
                const ctx = document.getElementById(chartId);
                const myChart = new Chart(ctx, {
                type: chartData.type,
                data: chartData.data,
                options: chartData.options,
                });
            },
            FetchSales(){
                axios.post('api/stats')
           
            .then(response=>{
                console.log(response.data)
            
               // .then(response=>{
                    //console.log(response.data)
                    this.rev=response.data.revtot
                    this.revyear=response.data.revyear
                    this.yearsal=response.data.salesyear
                  
                   // console.log(this.yearsal)
                    this.sal=response.data.salestot
                    this.ChData.data.datasets[0].data=response.data.month
                    console.log(this.ChData.data.datasets[0])
                    this.createChart('chart',this.ChData)
               // }) 
               })
            }
        },
        
}
</script>