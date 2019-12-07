<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <script> window.Laravel = {csrfToken: '{{csrf_token()}}'}</script>
        <title>Aurimo portfolio mock-up shop</title>

        <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
        <!--custom css -->
        <link href="{{asset('css.css')}}" rel="stylesheet" type="text/css">
        <!--boostrap-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <!-- ^icons -->
        <!-- Styles -->
      
    </head>
    <body>

        <div id="shopas" style="min-height:100%;">
            <div>
                <strong><nav class="text-center navbar navbar-expand navbar-dark ">
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown" style="min-width:525px;">
                        <ul class="navbar-nav">
                    <navbaras></navbaras>
                    @if(!empty(session('id')))
                    <li class="nav-item">
                      <router-link  class="nav-link" to="/my">My orders</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link  class="nav-link" to="/cart">Cart</router-link>
                   </li>
                    @endif
            @if(empty(session('id')))
            <li class="nav-item">
               <a class="nav-link"  data-toggle="modal" style="cursor:pointer;" data-target="#exampleModal">Sign in/Register</a>
            </li>
          @else
          <li class="nav-item">
            <router-link  class="nav-link" to="/account">Account</router-link>
          </li> 
          @if(session('grp')=="Admin")
          <li class="nav-item">
             <router-link  class="nav-link" to="/My-store">My store</router-link>
          </li>
          @endif
            <li class="nav-item">
               <a class="nav-link" href="logout">Sign out</a>
            </li>
          @endif
         
          </ul>
          
      </div>
        </nav>
      </strong>
    </div>
    <div class="modal"  id="exampleModal" tabindex="-1" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="height:400px;">
            <div class="modal-body">
                <login></login>
            
            </div>
            <button type="button" class="btn btn-dark" style="margin-bottom:0;padding-bottom:5px;" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

         
                <router-view></router-view>
               
          </div> 
               
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
