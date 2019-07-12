<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Profesor</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Profesores
                        <button type="button" @click="abrirModal('profesor','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="apellido">apellido</option>
                                      <option value="fechaNacimiento">fechaNacimiento</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarProfesor(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarProfesor(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>FechaNacimiento</th>
                                    <th>Direccion</th>
                                    <th>DNI</th>
                                    <th>Telefono</th>
                                    <th>Profesion</th>
                                    <th>Estado</th>
                                    <th>Foto Perfil</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="profesor in arrayProfesor" :key="profesor.id">
                                    <td>
                                        <button type="button" @click="abrirModal('profesor','actualizar',profesor)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>
                                         <template v-if="profesor.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarProfesor(profesor.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarProfesor(profesor.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td> 
                                    <td v-text="profesor.nombre"></td>
                                    <td v-text="profesor.apellido"></td>
                                    <td v-text="profesor.fechaNacimiento"></td>
                                    <td v-text="profesor.direccion"></td>
                                    <td v-text="profesor.DNI"></td>
                                    <td v-text="profesor.telefono"></td>
                                    <td v-text="profesor.profesion"></td>
                                       <td>
                                        <div v-if="profesor.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>

                                    <td>
                                        <img v-bind:src="`img/imagenes/profesor/${profesor.imagen}`" width="70px" height="70px">
                                    </td>

                                     
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>

             <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form group row text-center" >
                                     <label class="col-md-12 form-control-label text-center" for="text-input">FOTO DE PERFIL</label>
                                     <div class="col-md-12 text-center">
                                      
                                          <img  v-bind:src="`img/imagenes/profesor/${copia}`" width="160px" height="120px">

                                     </div>
                                    
                                </div>
                                 <hr>
                                 <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">                                   
                                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                                <div class="col-md-9">
                                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de profesor">
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3 form-control-label" for="text-input">Apellido</label>
                                                <div class="col-md-9">
                                                    <input type="text" v-model="apellido" class="form-control" placeholder="Ingrese apellidos">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3 form-control-label" for="text-input">fecha de Nacimiento</label>
                                                <div class="col-md-9">
                                                    <input type="date" v-model="fechaNacimiento" class="form-control" placeholder="Ingrese fechaNacimiento">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                               <label class="col-md-3 form-control-label" for="text-input">Sube una imagen</label>
                                               <div class="col-md-9">
                                                    <input type="file" class="form-control" @change="imageChanged"/>
                                               </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 form-control-label" for="text-input">direccion </label>
                                                <div class="col-md-9">
                                                    <input type="text" v-model="direccion" class="form-control" placeholder="Ingrese direccion de domicilio">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3 form-control-label" for="text-input">DNI </label>
                                                <div class="col-md-9">
                                                    <input type="text" v-model="DNI" class="form-control" placeholder="Ingrese Carnet Identidad">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3 form-control-label" for="text-input">Profesion </label>
                                                <div class="col-md-9">
                                                    <input type="text" v-model="profesion" class="form-control" placeholder="Ingrese Profesion">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3 form-control-label" for="text-input">telefono </label>
                                                <div class="col-md-9">
                                                    <input type="text" v-model="telefono" class="form-control" placeholder="Ingrese Telefono">
                                                </div>
                                            </div>
                                        </div>
                                 </div>
  
                            </form>
                                <div v-show="errorProfesor" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjProfesor" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarProfesor()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarProfesor()">Actualizar</button>
                        </div>
                    </div>
                  
  
                </div>
            
            </div> 
          <!-- Fin del modal-->
             
        </main>

</template>

<script>  
 
    export default {
        data (){
            return {
                profesor_id: 0,
                nombre : '',
                apellido : '',
                fechaNacimiento : '',
                direccion :'',
                DNI : '',
                telefono : '',
                profesion : '',
                imagen : '',
                copia : '',
                arrayProfesor : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorProfesor : 0,
                errorMostrarMsjProfesor : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
            }  
    },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarProfesor (page,buscar,criterio){
                let me=this;
                var url= '/profesor?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProfesor = respuesta.profesor.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarProfesor(page,buscar,criterio);
            },
            imageChanged(e){
               console.log(e.target.files[0]);
                 var fileReader =new FileReader();
                 fileReader.readAsDataURL(e.target.files[0]);
                 fileReader.onload =(e)=>{
                 this.imagen=e.target.result;   
                 }
                 console.log(this.imagen);   
            },
            registrarProfesor(){
                if (this.validarProfesor()){
                    return;
                }
                let me = this;
                axios.post('/profesor/registrar',{
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'fechaNacimiento': this.fechaNacimiento,
                    'direccion': this.direccion,
                    'DNI': this.DNI,
                    'telefono':this.telefono,
                    'profesion':this.profesion,
                    'imagen':this.imagen
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarProfesor(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                    
                });
            },
             actualizarProfesor(){
                if (this.validarProfesor()){
                    return;
                }
                let me = this;
                axios.put('/profesor/actualizar',{
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'fechaNacimiento': this.fechaNacimiento,
                    'imagen':this.imagen,
                    'copia':this.copia,//copia representa nombre de la imagen que se utiliza para eliminar
                    'id':this.profesor_id,
                    'direccion': this.direccion,
                    'DNI': this.DNI,
                    'telefono':this.telefono,
                    'profesion':this.profesion
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarProfesor(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
             desactivarProfesor(id){
               swal({
                title: 'Esta seguro de desactivar este Profesor?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/profesor/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarProfesor(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarProfesor(id){
               swal({
                title: 'Esta seguro de activar este Profesor?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/profesor/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarProfesor(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarProfesor(){
                this.errorProfesor=0;
                this.errorMostrarMsjProfesor =[];

                if (!this.nombre) this.errorMostrarMsjProfesor.push("Seleccione una nombre.");
                if (!this.apellido) this.errorMostrarMsjProfesor.push("selecione un apellido .");
                if(!this.fechaNacimiento)this.errorMostrarMsjProfesor.push("Fecha Nacimiento obligatoria");
                
                if(!this.direccion)this.errorMostrarMsjProfesor.push("Direccion donde vive es obligatorio");
                if(!this.DNI)this.errorMostrarMsjProfesor.push("El carnet identidad es obligatorio");
                if(!this.profesion)this.errorMostrarMsjProfesor.push("Profesion o especialidad es obligatorio");
                
               // if(this.imagen.t != "image/jpeg") this.errorMostrarMsjProfesor.push("Solo se permite imagenes");
                if(this.errorMostrarMsjProfesor.length) this.errorProfesor = 1;

                return this.errorProfesor;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre= '';
                this.apellido = '';
                this.fechaNacimiento='';
                this.imagen = '';
                this.copia='';
                this.direccion='';
                this.DNI='';
                this.telefono='';
                this.profesion='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "profesor":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar profesor';
                                this.nombre= '';
                                this.fechaNacimiento = '';
                                this.imagen = '';
                                this.apellido = '';
                                this.direccion='';
                                this.DNI='';
                                this.telefono='';
                                this.profesion='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {    
                                this.modal=1;
                                this.tituloModal='Actualizar profesor';
                                this.tipoAccion=2;
                                this.profesor_id=data['id'];
                                this.nombre = data['nombre'];
                                this.apellido =data['apellido'];
                                this.fechaNacimiento =data['fechaNacimiento'];
                                this.copia =data['imagen'];
                                this.direccion=data['direccion'];
                                this.DNI=data['DNI'];
                                this.telefono=data['telefono'];
                                this.profesion=data['profesion'];
                                break;
                            }
                        }
                    }
                }
               
            }
        },
        mounted() {
            this.listarProfesor(1,this.buscar,this.criterio);
        }
    }
</script>


<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
