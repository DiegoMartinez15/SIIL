<template>
<div>

      <v-container>
        <v-row justify="space-around">
          <v-card width="600 " class="p-10">
            <v-card-title><h1>Login</h1></v-card-title>
              <v-text-field
                  append-icon="mdi-folder-outline"
                  v-model="login.email"
                  @keyup="errorsNombre = []"
                  :rules="[v => !!v || 'Correo es requerido']"
                  label="Email"
                  required
                  
                  ></v-text-field>  
              <v-text-field
                v-model="login.password"
                color="purple darken-2"
                label="Password"
                required
              ></v-text-field>
            <v-btn 
            @click="loginUsuario()">
                Enviar
            </v-btn>

            <v-card-actions>

            <v-btn
             color="purple darken-2"
              primary
              @click="dialog = true"
            >
              Registrase
            </v-btn>
            <v-btn 
            @click="logout()">
                SALIR
            </v-btn>
            </v-card-actions>
            
        </v-card>
        
    </v-row>
  

         
</v-container>
      <!--Hola aqui esta el modal de registro de usuarios // Implementar lo aprendido en diseño-->
      <template>
      <v-row justify="center">
        

        <v-dialog
          v-model="dialog"
          max-width="290"
        >
          <v-card>
            <v-card-title class="headline">
              Formulario de registro
            </v-card-title>

            <v-card-text>
             <v-text-field
                
                v-model="user.name"
                color="purple darken-2"
                label="Name"
                required
              ></v-text-field>
              <v-text-field
                
                v-model="user.email"
                color="purple darken-2"
                label="correo"
                required
              ></v-text-field>
              <v-text-field
                v-model="user.password"
                color="purple darken-2"
                label="Password"
                required
              ></v-text-field>
            
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn 
               @click="fetchUsuarios()">
                Enviar
              </v-btn>

            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
    </template>

  </div>
  
</template>
<script>
import {mapGetters} from 'vuex'
import {mapActions} from 'vuex'
  export default {
    
    data () {
      
      
      return {
        
         dialog: false,
         user: {
             name: "",
             email: "",
             password: "",
             estado: "A",
             idtipo_usuario: 2 
         },
         login:{
             email: "",
             password: "",
         },
      };
    },
    computed: {
      ...mapGetters([
        'accessToken'
       
        
      ])
    },
    
    
    methods: {
      ...mapActions([
      
    ]),
      

      
        //Metodo registro de usuarios con token listo
        fetchUsuarios() {
            let me = this;
            
            me.$http
            .post(`${me.$url}/users`, me.user )
            .then(function(response){
              me.dialog = false
              alert("REGistrado con exito")
                console.log(response.data)
            })
            .catch(function(error){
              console.log(error);
            });
          },
      //Login de usuario por medio de token falta mejorar el la autenticacion agregar estado
      //para implementar la logica
        loginUsuario(){
        let me = this;
        
            me.$http
            .post(`${me.$url}/login`, me.login)
            .then(function(response){
              if(response.status==200){
                let x = response.data.token;
                me.$store.state.token = localStorage.setItem('token',x);
                console.log(response.data);
                console.log(x);
                alert("Bienvenido al sistema");
              }
              
            })
            .catch(function(error){
              console.log(error);
            });
          },
           logout(){
             let x = localStorage.getItem('token');
            let me = this,
            header = {
              headers: {
                "Authorization": "Bearer "+ x,
              },
            };
            
            console.log(x)
             me.$http.get(`${me.$url}/logout`,header)
            .then(function(response){ 
               if(response.status==200){ 
                  localStorage.clear();           
                  alert("Adios");
                console.log(response.data);
               }                        
            })
            .catch(function(error){              
              console.log(error);
            });
          },
          


           
        
    },
    

    mounted(){
     
     
    },
  };
</script>