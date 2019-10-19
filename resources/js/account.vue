<template>
<div class="d-flex m-5 py-3 align-items-center flex-cont text-center card">
    <form class="mx-auto" @submit.prevent="send()">
        <strong>Your username</strong> <br>
        <input type="text" style="min-width:350px;" class="form-control text-center"  v-bind:style="{border:BC}" v-model="usn">
        <a style="color:red;">{{err1}} </a><br>
        <strong>Your current password </strong><br>
        <input type="password" class="form-control text-center" v-bind:style="{border:BCog}" v-model="og" >
         <a style="color:red;">{{err2}} </a><br>
        <strong>Your new password</strong> <br>
        <input type="password" class="form-control text-center" v-bind:style="{border:BCp1}" v-model="pwd1">
         <a style="color:red;">{{err3}} </a><br>
        <strong>Repeat your new password</strong> <br>
        <input type="password" class="form-control text-center" v-bind:style="{border:BCp2}" v-model="pwd2"> 
         <a style="color:red;">{{err4}} </a><br><br>
      <input type="submit" class="form-control button btn-success" v-bind:disabled="but" value="Issaugoti"><br>
       <a style="color:green;">{{err5}}</a>
    
    </form>
    </div>
</template>
<script>
export default{
name:"acc",
 data(){
    return{
        og:'',
        pwd1:'',
        pwd2:'',
        usn:'',
        err1:null,
        err2:null,
        err3:null,
        err4:null,
        err5:null,
        BC:"solid 2px black",
        BCp1:"solid 2px black",
        BCp2:"solid 2px black",
        BCog:"solid 2px black",
        but:true
    }
},
created(){

this.receive()

},
watch:{
        usn(){
            if(this.usn.length>=5){//black border
                this.BC="solid 2px black";
                 this.err1=null;
            } else{//red border
                this.BC="solid 2px red";
                this.err1="Your username must be at least 5 characters long";
            };
            this.AllFilled();
        },
        pwd1(){
            if(this.pwd1.length>=5){//black border
                this.BCp1="solid 2px black";
                this.err3=null;
            } else{//red border
                this.BCp1="solid 2px red";
                 this.err3="Your password must be at least 5 characters long";
            };
            this.matches()
            this.AllFilled();
        },
        pwd2(){
            if(this.pwd2.length>=5){//black border
                this.BCp2="solid 2px black";
                this.err4=null;
            } else{//red border
                this.BCp2="solid 2px red";
                 this.err4="Your username must be at least 5 characters long";
            };
            this.matches();
            this.AllFilled();
        },
        og(){
            if(this.og.length>=5){//black border
                this.BCog="solid 2px black";
                this.err2=null;
            } else{//red border
                this.BCog="solid 2px red";
                this.err2="Your password must be at least 5 characters long";
            };
            this.AllFilled();
        }
},
methods:{
    send(){
 axios.put('api/account', {
            usn: this.usn,
            pwd1: this.pwd1,
            pwd2: this.pwd2,
            ogpwd: this.og
            })
           // .then(response=>response.json())       
            .then(response=> {
               console.log(response);
             this.err1=response.data.err1 //empty usn or taken usn
              this.err2=response.data.err2 //empty pwd or wrong pwd
               this.err3=response.data.err3 //empty pwd1 
                this.err4=response.data.err4 //empty pwd2 or doesnt match
                this.err5=response.data.err5 //success mesage
            })
            .catch((e) => {
                console.error(e)
            })
    },
    receive(){
        fetch('api/account')
        .then(response=>response.json())
        .then(response=>{
            console.log(response);
            this.usn=response.usn;
        })
        .catch((error)=>{
            console.error(error)
            })
        },
        AllFilled(){
            if(this.usn.length>=5 && this.pwd1.length>=5 && this.pwd2.length>=5 && this.og.length>=5 && this.pwd1===this.pwd2){
                 this.but=false;           
            }else{
                this.but=true;
            };
        },
        matches(){
            if(this.pwd1!==this.pwd2){
                this.err4="Your new password inputs must match!";
            };
        }
    }

}
</script>