<template>
<main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li></ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Maestros
                    <button type="button" @click="abrirModal('maestro','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                <option value="numero_control">Número de control</option>
                                <option value="nombre">Nombre</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarMaestro(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarMaestro(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Número de control</th>
                                <th>Correo Electrónico</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="maestro in arrayMaestro" :key="maestro.id">
                                <td>
                                    <button type="button" @click="abrirModal('maestro','actualizar',maestro)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                        <template v-if="maestro.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarMaestro(maestro.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarMaestro(maestro.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                </td>
                                <td v-text="maestro.nombre"></td>
                                <td v-text="maestro.numero_control"></td>
                                <td v-text="maestro.email"></td>
                                <td>
                                    <div v-if="maestro.condicion" >
                                    <span class="badge badge-success">Activo</span>
                                    </div>

                                    <div v-else >
                                    <span class="badge badge-danger">Inactivo</span>
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page -1, buscar, criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active': '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
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
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Número de control*</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="numero_control" class="form-control" placeholder="Número de control">
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del maestro">
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email">email*</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="email" class="form-control" placeholder="Ingrese email">
                                </div>
                            </div>
                            <div v-show="errorMaestro" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjMaestro" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarMaestro()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarMaestro()">Actualizar</button>
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
            return{
                maestro_id: 0,
                nombre : '',
                numero_control : '',
                email : '',
                arrayMaestro : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorMaestro : 0,
                errorMostrarMsjMaestro : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },


            
            //Calcula los elementos de la paginacion
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

            
            listarMaestro (page, buscar, criterio){
                //'maestro' es la route que nos regresa los maestros
                let me = this;
                var url = '/maestro?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayMaestro = respuesta.maestros.data;
                    me.pagination = respuesta.pagination;
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },



            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar la data de esa pagina
                me.listarMaestro(page, buscar, criterio);
            },


            registrarMaestro(){

                if(this.validarMaestro()){
                    return;
                }

                let me = this;
                //esta ruta hace referencia a la funcion store del MaestroController
                axios.post('/maestro/registrar',{
                    'numero_control' : this.numero_control,
                    'nombre' : this.nombre,
                    'email' : this.email
                }).then(function(response) {
                    me.cerrarModal();
                    me.listarMaestro(1, '', 'nombre');
                }).catch(function(error){
                    console.log(error);
                });           
            },



            actualizarMaestro(){

               if (this.validarMaestro()){
                    return;
                }
                
                let me = this;

                axios.put('/maestro/actualizar',{
                    'numero_control': this.numero_control,
                    'nombre': this.nombre,
                    'email' :this.email,
                    'id': this.maestro_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarMaestro(1, '', 'nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },



            cerrarModal(){
                this.modal=0;
                this.tituloModal = '';
                this.numero_control = '';
                this.nombre = '';
                this.email = '';
            },
        


            desactivarMaestro(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false,
                    })

                    swalWithBootstrapButtons.fire({
                        title: 'Estás seguro que quieres desactivar este registro?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;

                        axios.put('/maestro/desactivar',{
                            'id': id
                        }).then(function (response) {
                            me.listarMaestro(1, '', 'nombre');
                            swalWithBootstrapButtons.fire(
                                'Desactivado!',
                                'El registro ha sido desactivado con éxito.',
                                'success'
                        )
                        }).catch(function (error) {
                            console.log(error);
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {

                    }
                    })
            },



            activarMaestro(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false,
                    })

                    swalWithBootstrapButtons.fire({
                        title: 'Estás seguro que quieres activar este registro?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;

                        axios.put('/maestro/activar',{
                            'id': id
                        }).then(function (response) {
                            me.listarMaestro(1, '', 'nombre');
                            swalWithBootstrapButtons.fire(
                                'Activado!',
                                'El registro ha sido activado con éxito.',
                                'success'
                        )
                        }).catch(function (error) {
                            console.log(error);
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {

                    }
                 })
            },



            validarMaestro(){
                this.errorMaestro = 0;
                this.errorMostrarMsjMaestro = [];

                //Si el nombre esta vacio pushamos el mensaje de error
                if(!this.nombre)this.errorMostrarMsjMaestro.push("El nombre de la categoría no puedo estar vacio.");

                if(this.errorMostrarMsjMaestro.length) this.errorMaestro = 1;

                return this.errorMaestro;
            },



            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "maestro":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Maestro';
                                this.numero_control = '';
                                this.nombre = '';
                                this.email = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);

                                this.modal = 1;
                                this.tituloModal = 'Actualizar categoría';
                                this.tipoAccion = 2;
                                this.maestro_id = data['id'];
                                this.numero_control = data['numero_control'];
                                this.nombre = data['nombre'];
                                this.email = data['email'];
                                break;
                            }
                        }
                    }
                }
            }
        },



        mounted() {
            this.listarMaestro(1, this.buscar, this.criterio);
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
        color:red !important;
        font-weight: bold;
    }
</style>
