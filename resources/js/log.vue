<template><div class=" d-flex justify-content-center">
  
    <form class="newline" @submit.prevent="newlogin()"> <!--function to submit login data-->
    <br>
               <div class="newline"> Username<br>
                <input type="text" class="form-control" style="min-width:350px;" v-bind:style="{border:BC}" v-model="usn" name="usn"/>
         
<a style="color:red;">{{err1}}</a>
<a style="color:red;">{{err4}}</a>
      <br>
                Password<br>
                <input type="password" class="form-control" v-bind:style="{border:BCp}" v-model="pwd" name="pwd"/>
        
<a  style="color:red;">{{err3}}</a>
                    </div> 
                

                 <br>
                <button type="submit" class="form-control btn-success btn"  v-bind:disabled="but">Prisijungti</button>
              
                </form>
    </div> 

              
</template>
<script>
export default {
    name:"log",
    data(){
        return{    
            pwd:null,
            usn:null,
            err5:null,
            usn1:null,
            pwd1:null,
            pwd2:null,
            err1:null,
            err2:null,
            err3:null,
            err4:null,
            but:true,
            BC:"solid 2px black",
            BCp:"solid 2px black"
    }
    },
    watch:{
        err5(err5){
            this.redir();
        },
        usn(){
            if(this.usn.length>=5){//black border
                this.BC="solid 2px black"
                this.err1=null
            } else{//red border
                this.BC="solid 2px red"
                this.err1="Your username must be at least 5 characters long"
            };
            if(this.usn.length>=5 && this.pwd.length>=5){
                 this.but=false          
            }else{
                this.but=true
            };


        },
        pwd(){
            if(this.pwd.length>=5){//black border
                this.BCp="solid 2px black";
                this.err3=null
            } else{//red border
                this.BCp="solid 2px red";
                this.err3="Your password must be at least 5 characters long"
            };
            if(this.usn.length>=5 && this.pwd.length>=5){
                this.but=false         
            }else{
                this.but=true
            };
        }
    },
    methods:
    {
        newlogin(){
            axios.post('api/login', {
            usn: this.usn,
            pwd: this.pwd
            })
            .then(response=>{
                this.err1=response.data.err1;
                this.err3=response.data.err2;
                this.err3=response.data.err3;
                this.err1=response.data.err4;
                console.log(this.err4);                       
            if(response.data.err5!==null){
                window.location.href = ''
            };
                }   
            )
            .catch((e) => {
                console.error(e)
            })
        },
        redir(){
             window.location.href = ''
        }  

}
}
</script>