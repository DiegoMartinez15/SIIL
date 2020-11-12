<template>

<div class="content">
  
  
  <div class="md-layout-item md-medium-size-100 md-xsmall-sixe-100 md-size-100">
    
    <v-overlay :value="loader" :z-index="'99999999'">
        <v-progress-circular indeterminate size="80" color="grey darken-4"></v-progress-circular>
    </v-overlay>
    <v-card>
      <v-card-title>
        Listado de Areas de empresas
       <div class="flex-grow-1"></div>
        <v-text-field
          v-model="searchAreas"
          append-icon="search"
          label="Buscar"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        
        :headers="hTBAreas"
        :items="arrayAreas"
        :footer-props="{
          'items-per-page-options' :[5,10,15,20,30],
          'items-per-page-text' :'Registros por Página'
        }"
        :items-per-page="5"
        :search="searchAreas"
        multi-sort
        class="elevation-3 text--center ml-80 pl-10 pr-10"
      >
      <!-- Templeate para form modal para agregar o actualizar categorias-->
    <template v-slot:top>
      <v-toolbar flat color="white">
        
        <div class="flex-grow-1"></div>
        <v-dialog v-model="modalAreas" persistent max-width="700px">
          
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
                <v-form ref="formAreas" v-model="validForm" :lazy-validation="true">
                <v-text-field
                  append-icon="mdi-folder-outline"
                  v-model="areas.nombre"
                  @keyup="errorsNombre = []"
                  :rules="[v => !!v || 'Nombre Es Requerido']"
                  label="Nombre"
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
                  @click="saveAreas()"
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
              @click="deleteAreas(item)"
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
        arrayAreas:[],
        hTBAreas:[
          {text:"Nombre", value:"nombre" , class:'blue-grey lighten-4 '},
          {text:"Acciones", value:"action",sortable:false,aling:"center",class:'blue-grey lighten-4'},
        ],
        loader:false,
        searchAreas:"",
        modalAreas:false,
        areas:{
          id:null,
          nombre:null,
        },
        validForm:true,
        snackbar:false,
        msjSnackBar:"",
        errorsNombre:[],
        editedAreas:-1,
        prueba: null,
      };
    },
    computed: {
      formTitle(){
        return this.areas.id == null
        ? "Agregar Areas"
        : "Actualizar Areas";
      },
      btnTitle(){
        return this.areas.id == null ? "Guardar" : "Actualizar";
      },
    },
    
    methods: {
      fetchAreas() {        
        let me = this;          
        me.loader = true;
        me.$http.get(`${me.$url}/areas`)
        .then(function(response){
            console.log(response.data)
          me.arrayAreas = response.data;
          me.loader = false;
        })
        .catch(function(error){
          me.loader = false;
          console.log(error);
        });
      },
      cerrarModal(){
        let me = this;
        me.modalAreas = false;
        setTimeout(() => {
          me.areas={
            id:null,
            nombre:"",
          };
          me.resetValidation();
        }, 300);
      },
      resetValidation() {
        let me = this;
        me.errorsNombre = [];
        me.$refs.formAreas.resetValidation();
      },
      showModalEditar(area) {
        let me = this;
        me.editedAreas = me.arrayAreas.indexOf(area);
        me.areas = Object.assign({},area);
        me.modalAreas = true;
      },
      /*saveAreas() {
        let me = this;
       
        if(me.$refs.formAreas.validate()) {
          let accion = me.areas.id == null ? "add" : "upd";
          me.loader = true;
          me.$http
            .post(`${me.$url}/areas`, me.areas)
            .then(function(response) {
              me.verificarAccionDato(response.data, response.status, accion);
              me.cerrarModal();
            })
            .catch(function(error) {
              console.log(error);
              //409 conflicts Error (Proveedor ya existe en la base de datos)
              if(error.response.status == 409) {
                me.setMessageToSnackBar("Areas Ya Existente", true);
                me.errorsNombre = ["Nombre de la Areas ya Existente"];
              }else {
                me.$swal("Error", "Ocurrido Un Error Intente de Nuevovamente", "error");
              }
              me.loader = false;
            });
            }else{
            //para actualizar
            me.$http.put('/areas/'+me.area.id, me.area)
               .then(function(response) {
                   console.log(response.data);
                    me.verificarAccionDato(response.data, response.status, "upd");
                    me.cerrarModal();
            })
          .catch(function(error) {
            console.log(error);
            me.loader = false;
          });
        }
      },*/
      saveAreas() {
      let me = this;
      if (me.$refs.formAreas.validate()) {
        let accion = me.areas.id == null ? "add" : "upd";
        me.loader = true;
        if(accion=="add"){
           me.$http.post(`${me.$url}/areas`, me.areas)
            .then(function(response) {
            me.verificarAccionDato(response.data, response.status, accion);
            me.cerrarModal();
          })
          .catch(function(error) {
            console.log(error);
            //409 Conflicts Error (Proveedor Ya Existente En la BD)
            if (error.response.status == 409) {
              me.setMessageToSnackBar("Area Ya Existe", true);
              me.errorsNombre = ["Nombre De Area Existente"];
            } else {
              me.$swal("Error", "Ocurrio Un Error Intente Nuevamente", "error");
            }
            me.loader = false;
          });
        }else{
            //para actualizar
            me.$http.put(`${me.$url}/areas/`+ me.areas.id,me.areas)
            .then(function(response) {
              console.log(response.data);
              console.log(response.status);
              me.verificarAccionDato(response.data, response.status, "upd");
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
      deleteAreas(areas) {
        let me = this;
        
        me.editedAreas = me.arrayAreas.indexOf(areas);
         const Toast = me.$swal.mixin({
           toast: true,
           position: "bottom-end",
           showConfirmButton: true,
           timer: 3000
         });
         me.$swal({
           title: "Eliminar Area?",
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
             console.log(areas);
             me.$http
              .delete(`${me.$url}/areas/`+ areas.id)
              .then(function(response){
                
                me.verificarAccionDato(response.data, response.status, "del");
                me.loader = false;
              })
              .catch(function(error) {
                if(error.response.status == 510){
                  Toast.fire({
                    icon: "error",
                    title: "No se puede eliminar esta Areas, tiene registrados"
                  });
                }
                me.loader = false;
              });
           }
         });
      },
      verificarAccionDato(areas, statusCode, accion) {
        let me = this;

        const Toast = me.$swal.mixin({
          toast: true,
          position: "bottom-end",
          showConfirmButton: true,
          timer: 3000
        });

        switch (accion) {
          case "add":
            //Agrego al array de categorias el objeto que devuelve el backend
            me.arrayAreas.unshift(areas);
            Toast.fire({
              icon: "success",
              title: "Areas Registrada con Exito"
            });
            me.loader = false;
            break;

          case "upd":
            //Actualizando al array de categorias el objeto que devuelve el Backend ya con los datos
            //Object.assign(me.arrayAreas[me.editedAreas], areas);
            this.fetchAreas(); 
            Toast.fire({
              icon:"success",
              title: "Areas Actualizada con Exito"
            });
            me.loader = false;
            break;
          case "del":
            if (statusCode == 200) {
              try{
                //se elimina del array de categorias activos si todo esta bien en el backend
                me.arrayAreas.splice(me.editedAreas, 1);
                //se lanza mensaje final
                me.$swal.fire("Eliminado", "Area Eliminada", "success");
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
      },
     
    },
    mounted() {
      let x =localStorage.getItem('token')
      if(x != null){
        this.fetchAreas(); 
      }else{
         
         this.$router.push('/login')
      }
       
    },
  };
</script>