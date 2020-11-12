<template>
<div class="content">
  
  <div class="md-layout-item md-medium-size-100 md-xsmall-sixe-100 md-size-100">
    
    <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
    </v-overlay>
    <v-card>
      <v-card-title>
        Listado de Usuarios
       <div class="flex-grow-1"></div>
        <v-text-field
          v-model="searchUsuarios"
          append-icon="search"
          label="Buscar"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        
        :headers="hTBUsuarios"
        :items="arrayUsuarios"
        :footer-props="{
          'items-per-page-options' :[5,10,15,20,30],
          'items-per-page-text' :'Registros por Página'
        }"
        :items-per-page="5"
        :search="searchUsuarios"
        multi-sort
        class="elevation-3 text--center ml-80 "
      >
      <!-- Templeate para form modal para agregar o actualizar categorias-->
    <template v-slot:top>
      <v-toolbar flat color="white">
        <div class="flex-grow-1"></div>
        <v-dialog v-model="modalUsuarios" persistent max-width="700px">
          
          <template v-slot:activator="{ on }">
           <v-btn elevation="10" color="blue darken-1" dark class="mb-2" v-on="on">
              Agregar&nbsp;&nbsp;
              <v-icon>library_add</v-icon>
            </v-btn>
          </template>
          <v-card>
            <v-card-title class="headline light-blue lighten-5" primary-titles>
              <span class="headline" v-text="formTitle"></span>
            </v-card-title>
            <v-card-text>
              <v-container>
               <!--<v-form ref="formUsuarios" v-model="validForm" :lazy-validation="true">
                <v-text-field
                  append-icon="mdi-folder-outline"
                  v-model="Usuarios.nombre"
                  @keyup="errorsNombre = []"
                  :rules="[v => !!v || 'Nombre Es Requerido']"
                  label="Nombre"
                  required
                  :error-messages="errorsNombre"
                  ></v-text-field>  
                </v-form>-->
                <v-form ref="formUsuarios" v-model="validForm" :lazy-validation="true">
                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="usuarios.nombre"
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'Correo Es Requerido']"
                          label="Correo"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>

                        <v-text-field
                          append-icon="mdi-folder-outline"
                          v-model="usuarios.passwd"
                          @keyup="errorsNombre = []"
                          :rules="[v => !!v || 'La clave Es Requerida']"
                          label="Contraseña"
                          required
                          :error-messages="errorsNombre"
                        ></v-text-field>
                        
                      </v-form>
              </v-container>
            </v-card-text>
            <v-divider></v-divider>           
              <v-card-actions>
                <div class="flex-grow-1"></div>
                <v-btn color="red darken-1" text @click="cerrarModal">Cerrar</v-btn>
                <v-btn
                  color="info darken-1"
                  :disabled="!validForm"
                  @click="saveUsuario()"
                  text
                  v-text="btnTitle"
                ></v-btn>
              </v-card-actions>          
          </v-card>
        </v-dialog>
      </v-toolbar>
</template>
      <!--Template para la columna de acciones -->
      <template v-slot:item.action="{item}">
        <v-tooltip top>
          <template v-slot:activator="{on}">
            <v-btn
              color="success"            
              elevation="8"
              small
              fab
              dark
              :disabled="item.id<0"
              v-on="on"
              @click="showModalEditar(item)"
            >
            <v-icon>create</v-icon>
            </v-btn>
          </template>
          <span>Actualizar Datos</span>
        </v-tooltip>
        &nbsp;&nbsp;
        <v-tooltip top>
          <template v-slot:activator="{on}">
            <v-btn
              color="info"            
              elevation="8"
              small
              dark
              fab
              :disabled="item.id < 0"
              v-on="on"
              @click="deleteUsuario(item)"
            >
            <v-icon>delete</v-icon>
            </v-btn>
          </template>
          <span>Eliminar Registro</span>
        </v-tooltip>
      </template>
      <v-snackbar v-model="snackbar">
          {{ msjSnackBar}}
          <v-btn color="red" text @click="snackbar = false">Cerrar</v-btn>
      </v-snackbar>
      </v-data-table>
    </v-card>
  </div>
</div>
  
</template>

<script>
  export default {
    data () {
      return {
        arrayUsuarios:[],
        hTBUsuarios:[
          {text:"Correo", value:"nombre" , class:'blue-grey lighten-4 '},
          {text:"Estado", value:"estado" , class:'blue-grey lighten-4 '},
          {text:"Rol", value:"idtipo_usuario" , class:'blue-grey lighten-4 '},
          {text:"Acciones", value:"action",sortable:false,aling:"center",class:'blue-grey lighten-4'},
        ],
        loader:false,
        searchUsuarios:"",
        modalUsuarios:false,
        usuarios:{
          id:null,
          nombre:null,
          passwd:null,
         
          
        },
        validForm:true,
        snackbar:false,
        msjSnackBar:"",
        errorsNombre:[],
        editedUsuarios:-1,
        prueba: null,
      };
    },
    computed: {
      formTitle(){
        return this.usuarios.id == null
        ? "Agregar Usuarios"
        : "Actualizar Usuarios";
      },
      btnTitle(){
        return this.usuarios.id == null ? "Guardar" : "Actualizar";
      },
    },
    methods: {
      fetchUsuarios() {
        let me = this;
        me.loader = true;
        me.$http
        .get(`${me.$url}/usuarios`)
        .then(function(response){
            console.log(response.data)
          me.arrayUsuarios = response.data;
          me.loader = false;
        })
        .catch(function(error){
          me.loader = false;
          console.log(error);
        });
      },
      cerrarModal(){
        let me = this;
        me.modalUsuarios = false;
        setTimeout(() => {
          me.usuarios={
            id:null,
            nombre:"",
          };
          me.resetValidation();
        }, 300);
      },
      resetValidation() {
        let me = this;
        me.errorsNombre = [];
        me.$refs.formUsuarios.resetValidation();
      },
      showModalEditar(area) {
        let me = this;
        me.editedUsuarios = me.arrayUsuarios.indexOf(area);
        me.usuarios = Object.assign({},area);
        me.modalUsuarios = true;
      },
      saveUsuario() {
      let me = this;
      if (me.$refs.formUsuarios.validate()) {
        let accion = me.usuarios.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
           me.$http.post(`${me.$url}/usuarios`, me.usuarios)
            .then(function(response) {
                console.log(response.data);
            me.verificarAccionDato(response.data, response.status, accion);
            me.cerrarModal();
          })
          .catch(function(error) {
            console.log(error);
            //409 Conflicts Error (Proveedor Ya Existente En la BD)
            if (error.response.status == 409) {
              me.setMessageToSnackBar("Usuarios Ya Existe", true);
              me.errorsNombre = ["Nombre Del Usuarios Existente"];
            } else {
              me.$swal("Error", "Ocurrio Un Error Intente Nuevamente", "error");
            }
            me.loader = false;
          });
        }else{
            //para actualizar
            me.$http.put(`${me.$url}/usuarios/`+ me.usuarios.id,me.usuarios)
               .then(function(response) {
                   console.log(response.data);
                    me.verificarAccionDato(response.data, response.status, accion);
                    me.cerrarModal();
            })
          .catch(function(error) {
            console.log(error);
            me.loader = false;
          });
        }
      
      }
    },
      setMessageToSnackBar(msj, estado) {
        let me = this;
        me.snackbar = estado;
        me.msjSnackBar = msj;
      },
      deleteUsuario(usuarios) {
        let me = this;
        
        me.editedUsuarios = me.arrayUsuarios.indexOf(usuarios);
         const Toast = me.$swal.mixin({
           toast: true,
           position: "bottom-end",
           showConfirmButton: true,
           timer: 3000
         });
         me.$swal({
           title: "Eliminar Usuarios?",
           text: "Una vez realizada la accion no se podra revertir ",
           icon: "question",
           showCancelButton: true,
           confirmButtonText: "Si",
           cancelButtonText: "No",
           reverseButtons: true,
           focusConfirm: false,
           focusCancel: true,
           showCloseButton: true
         }).then(result => {
           if (result.value) {
             me.loader = true;
             console.log(usuarios);
             me.$http
              .delete(`${me.$url}/usuarios/`+ usuarios.id)
              .then(function(response){
                
                me.verificarAccionDato(response.data, response.status, "del");
                me.loader = false;
              })
              .catch(function(error) {
                if(error.response.status == 510){
                  Toast.fire({
                    icon: "error",
                    title: "No se puede eliminar este Usuarios, "
                  });
                }
                me.loader = false;
              });
           }
         });
      },
      verificarAccionDato(usuarios, statusCode, accion) {
        let me = this;
        console.log(usuarios);

        const Toast = me.$swal.mixin({
          toast: true,
          position: "bottom-end",
          showConfirmButton: true,
          timer: 3000
        });

        switch (accion) {
          case "add":
            //Agrego al array de categorias el objeto que devuelve el backend
           //me.arrayUsuarios.unshift(usuarios);
            this.fetchUsuarios();
            Toast.fire({
              icon: "success",
              title: "Usuarios Registrada con Exito"
            });
            me.loader = false;
            break;

          case "upd":
            //Actualizando al array de categorias el objeto que devuelve el Backend ya con los datos
            //Object.assign(me.arrayUsuarios[me.editedUsuarios],usuarios);
             this.fetchUsuarios();
            Toast.fire({
              icon:"success",
              title: "Usuarios Actualizada con Exito"
            });
            me.loader = false;
            break;
          case "del":
            if (statusCode == 200) {
              try{
                //se elimina del array de categorias activos si todo esta bien en el backend
                me.arrayUsuarios.splice(me.editedUsuarios, 1);
                
                //se lanza mensaje final
                me.$swal.fire("Eliminado", "Usuarios Eliminado", "success");
              }catch (error) {
                console.log(error);
              }
            }else {
              Toast.fire({
                icon: "error",
                title: "Ocurrido un Error Intente Nuevamente"
              });
            }
            break;
        }
      }
    },
    mounted() {
      let me = this;
      me.fetchUsuarios();     
    },
  };
</script>