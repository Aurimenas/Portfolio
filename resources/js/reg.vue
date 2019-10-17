<template>
    <div class="text-center">
    <form class="newline" @submit.prevent="newReg()"> <!--function to submit registration data--><br>
             Username
                <input type="text"  class="form-control has-error" v-bind:style="{border:BC}" v-model="usn" >
                <small style="color:red;">{{err6}} </small><br>
                Password<br>
                <input type="password"  class="form-control" v-bind:style="{border:BCp1}" v-model="pwd1" >
                 <small style="color:red;">{{err7}} </small><br>
                Repeat your password<br>
                <input type="password" class="form-control" v-bind:style="{border:BCp2}" v-model="pwd2">
                <small style="color:red;">{{err8}} </small><br>
                <button type="submit" class="form-control btn-success btn"  v-bind:disabled="but">Registruotis</button>
                </form>
   

        </div>
</template>
<script>
export default {
    name:"reg",
      data(){
        return{
            pwd1:'',
            pwd2:'',
            usn:'',
              err6:null, //Username taken/empty
            err7:null, //pwd1 empty
            err8:null, //pwd2 empty or not a match
            err9:null, //success (registered successfully)
            BC:"solid 2px black",
            BCp1:"solid 2px black",
            BCp2:"solid 2px black",
            but:true
    }
  },
  watch:{
      usn(){
            if(this.usn.length>=5){//black border
                this.BC="solid 2px black";
                this.err6=null
            } else{//red border
                this.BC="solid 2px red";
                this.err6="Your username is too short"
            };
            if(this.usn.length>=5 && this.pwd1.length>=5 &&this.pwd2.length>=5){
                 this.but=false;            
            }else{
                this.but=true;
            };
    },
    pwd1(){
            if(this.pwd1.length>=5){//black border
                this.BCp1="solid 2px black"
                this.err7=null
                this.checkEQ() 
            } else{//red border
                this.BCp1="solid 2px red";
                this.err7="Your password is too short"
            };
            if(this.usn.length>=5 && this.pwd1.length>=5 &&this.pwd2.length>=5){
                  this.checkEQ()          
            }else{
                this.but=true;
            };
    },
    pwd2(){
            if(this.pwd2.length>=5){//black border
                this.BCp2="solid 2px black"
                this.err8=null
                this.checkEQ() 
            } else{//red border
                this.BCp2="solid 2px red"
                this.err8="Your password is too short"
            };
            if(this.usn.length>=5 && this.pwd1.length>=5 &&this.pwd2.length>=5){
                 this.checkEQ()          
            }else{
                this.but=true
            };
    }
  },
  methods:{
    redir(){
             window.location.href = '/portfolio/public/';
        },
        newReg(){
             axios.post('api/register', {
            usn: this.usn1,
            pwd1: this.pwd1,
            pwd2: this.pwd2
            })
            .then(
                response=>{
                this.err6=response.data.err6;
                this.err7=response.data.err7;
                this.err8=response.data.err8;
                console.log(response);
                      if(response.data.err9!==null){
                          this.redir();
                      } 
           
                }
         
            )
            .catch((e) => {
                console.error(e)
            })
        },
        checkEQ(){
          if(this.pwd1===this.pwd2){
            this.BCp2="solid 2px black"
            this.BCp1="solid 2px black"
            this.err8=null
            this.but=false
          }else{
            this.but=true
            this.err8="Your passwords do not match"
            this.BCp2="solid 2px red"
            this.BCp1="solid 2px red"
          }
        }
  }
}

</script>