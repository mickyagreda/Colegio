<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Gestion
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="año">Fecha</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarGestion(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarGestion(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Año</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="gestion in arrayGestion" :key="gestion.id">
                                        <td>
                                            <button type="button"  @click="verGestion(gestion.id)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            <template v-if="gestion.condicion">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarGestion(gestion.id)">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td v-text="gestion.año"></td>
                                        <td>
                                            <div v-if="gestion.condicion">
                                                <span class="badge badge-success">gestion en macha</span>
                                            </div>
                                            <div v-else>
                                                <span class="badge badge-danger">gestion finaliza</span>
                                            </div>
                                        
                                        </td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
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
                    </template>
                    <!--Fin Listado-->
                    <!-- Detalle-->
                
               <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row border">
                    
                            <div class="col-md-12">
                                <div v-show="errorGestion" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjGestion" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Curso <span style="color:red;" v-show="idcurso==0">(*Seleccione)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="curso" @keyup.enter="buscarCurso()" placeholder="Ingrese Curso">
                                        <button @click="abrirModal()" class="btn btn-primary">...</button>
                                        <input type="text"  class="form-control" v-model="idcurso">
                                    </div>                                    
                                </div>
                            </div>
                             <div class="col-md-2">
                                <div class="form-group">
                                    <label>dimension<span style="color:red;" v-show="dimension"></span></label>
                                    <input type="text"   class="form-control" v-model="dimension">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>paralelo<span style="color:red;" v-show="nombreParalelo"></span></label>
                                    <input type="text"  step="any" class="form-control" v-model="nombreParalelo">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Capacidad de Alumnos<span style="color:red;" v-show="capacidad==0">(*Ingrese)</span></label>
                                    <input type="number" value="0" step="any" class="form-control" v-model="capacidad">
                                </div>
                            </div>
          
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                           --DETALLES--
                            <a data-toggle="collapse" href="#avanzada"> desplegar</a>
                            <div id="avanzada" class="table-responsive col-md-12 panel-collapse collapse" >
                                
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>curso</th>
                                            <th>Capacidad</th>
                                            <th>Dimension</th>
                                            <th>Paralelo</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.curso">
                                            </td>
                                            <td>
                                                <input v-model="detalle.capacidad" type="number" value="2" class="form-control">
                                            </td>
                                            <td v-text="detalle.dimension"></td>
                                            <td v-text="detalle.paralelo"></td>
                                            
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                NO hay cursos agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                         

                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarGestion()">Registrar Compra</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- Fin Detalle-->
                    <!-- Ver ingreso -->
                    
                    <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">fecha de Gestion</label>
                                    <p v-text="año"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Curso</th>
                                            <th>Capacidad</th>
                                            <th>Dimension</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.nombre">
                                            </td>
                                            <td v-text="detalle.capacidad">
                                            </td>
                                             <td v-text="detalle.dimension">
                                            </td>
                                        </tr>
                                      <!--<tr style="background-color: #CEECF5;">//este codigo falta implementar en la base datos totalCuposHabilitados
                                            <td colspan="3" align="right"><strong>Total Cupos Habilitado:</strong></td>
                                            <td>$ {{total}}</td>
                                        </tr>-->
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="4">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                
                            </div>
                        </div>
                    </div>
                    </template>
                    
                    <!-- fin ver ingreso -->
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
                            <div class="form-group row">
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterioA">
                                        <option value="nombre">Nombre</option>
                                        <option value="dimension">dimension</option>
                                         <option value="seccion">seccion</option>
                                        </select>
                                        <input type="text" v-model="buscarA" @keyup.enter="listarCurso(1,buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarCurso(1,buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                        <button type="button" @click="/*agregarDetalleModal(curso)*/" class="btn btn-primary"><i class="icon-check">ADD ALL</i></button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Nombre</th>
                                            <th>Dimension</th>
                                            <th>Paralelo</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="curso in arrayCurso" :key="curso.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleModal(curso)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="curso.nombre"></td>
                                            <td v-text="curso.dimension"></td>
                                            <td v-text="curso.nombre_paralelo"></td>
                                            <td>
                                                <div v-if="curso.condicion">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>
                                                
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPaginaModal(pagination.current_page - 1,buscar,criterioA)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPaginaModal(page,buscar,criterioA)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterioA)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary">Actualizar</button>
                        </div>
                    </div>
                 
                    <!-- /.modal-content -->
                </div> 
                <!-- /.modal-dialog -->
            </div>

            <!--Fin del modal-->
        </main>
</template>

<script>
 export default {
        data (){
            return {
                gestion_id: 0,
                año:'',
                arrayGestion : [],
                arrayDetalle : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorGestion : 0,
                errorMostrarMsjGestion : [],
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
                criterioA:'nombre',
                buscarA: '',
                arrayCurso: [],
                idcurso: 0,
                curso: '',//nombre del curso
                dimension:'',
                nombreParalelo:'', //nombre de paralelo
                capacidad:0,
          
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
            },
            calcularTotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
                }
                return resultado;
            }
        },
        methods : {
            listarGestion(page,buscar,criterio){
                let me=this;
                var url= '/gestion?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayGestion = respuesta.gestiones.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosProveedor(val1){
                let me = this;
                me.loading = true;
                me.idproveedor = val1.id;
            },
            buscarCurso(){
                let me=this;
                var url= '/curso/buscarCursoGestion?filtro=' + me.curso;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCurso = respuesta.cursos;

                    if (me.arrayCurso.length>0){
                        me.curso=me.arrayCurso[0]['nombre'];
                        me.dimension=me.arrayCurso[0]['dimension'];
                        me.idcurso=me.arrayCurso[0]['id'];
                        me.nombreParalelo=me.arrayCurso[0]['nombre_paralelo'];
                    }
                    else{
                        me.curso='No existe curso ';
                        me.idcurso=0;
                    }
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
                me.listarGestion(page,buscar,criterio);
            },
            cambiarPaginaModal(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarCurso(page,buscar,criterio);
            },
            encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].idcurso==id){
                        sw=true;
                    }
                }
                return sw;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },
            agregarDetalle(){//se agrega registro solo a los campos de encabezado
                let me=this;
                if(me.idcurso==0 || me.capacidad==0 ){
                }
                else{
                    if(me.encuentra(me.idcurso)){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese cursos ya se encuentra agregado!',
                            })
                    }
                    else{
                       if(me.capacidad>40){
                            swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'maximo de capacidad 40 !',
                            })
                       }else{
                             me.arrayDetalle.push({
                                 idcurso:me.idcurso,
                                 curso:me.curso,
                                 capacidad:me.capacidad,
                                 dimension:me.dimension,
                                 paralelo:me.nombreParalelo
                                 
                             });
                             me.curso='';
                             me.capacidad=0;
                             me.idcurso=0;
                             me.dimension='';
                             me.nombreParalelo='';
                           

                       }
                    }
                    
                }

                

            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'])){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese curso ya se encuentra agregado!',
                            })
                    }
                    else{
                       me.arrayDetalle.push({
                            idcurso: data['id'],
                            curso: data['nombre'],
                            dimension:data['dimension'],
                            capacidad:1,
                            paralelo:data['nombre_paralelo']

                           // capacidad: 1,        
                        }); 




                    }
            },
            listarCurso (page,buscar,criterioA){
                let me=this;
                var url= '/curso/listarCursoGestion?page='+page+'&buscar='+ buscar + '&criterio='+ criterioA;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCurso = respuesta.cursos.data;
                    me.pagination= respuesta.pagination
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarGestion(){
                if (this.validarGestion()){
                    return;
                }
                
                let me = this;

                axios.post('/gestion/registrar',{
                    'data': this.arrayDetalle

                }).then(function (response) {
                    me.listado=1;
                    me.listarGestion(1,'','año');
                    me.idcurso=0;
                    me.curso='';
                    me.capacidad=0;
                    me.nombreParalelo='';
                    me.arrayDetalle=[];

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarGestion(){
                let me=this;
                me.errorGestion=0;
                me.errorMostrarMsjGestion =[];
                var art;
                me.arrayDetalle.map(function(x){
                    if(x.capacidad>40){
                        art=x.curso+'  cantidad a exedido de limite 40 alumnos por curso segun articulo 9 de ley educacion nacional';
                        me.errorMostrarMsjGestion.push(art);
                    }
                });
                if (this.arrayDetalle.length<=0) this.errorMostrarMsjGestion.push("Ingrese detalles");

                if (this.errorMostrarMsjGestion.length) this.errorGestion = 1;

                return this.errorGestion;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;
                me.idcurso=0;
                me.curso='';
                me.capacidad=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
            },
            verGestion(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos de la gestion
                var arrayGestionT=[];
                var url= '/gestion/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayGestionT = respuesta.gestiones;
                    me.año=arrayGestionT[0]['fecha_gestion'];
                    
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= '/gestion/obtenerDetalles?id=' + id;
                
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error)+'surgio algun problema';
                });               
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            }, 
            abrirModal(){               
                this.arrayCurso=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios cursos';
            },
            desactivarGestion(id){
               swal({
                title: 'Esta que desea finalizar esta gestion?',
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

                    axios.put('/gestion/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarGestion(1,'','año');
                        swal(
                        'FINALIZADO!',
                        'la gestion ha finalizado con éxito.',
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
        },
        mounted() {
            this.listarGestion(1,this.buscar,this.criterio);
            this.listarCurso(1,this.buscar,this.criterioA);
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
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
