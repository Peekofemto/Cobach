    @extends('principal')
    @section('contenido')
    
    <template v-if="menu==0">
            <h1>Contenido del menú 0</h1>
    </template>

    <template v-if="menu==1">
            <Alumno></Alumno>
    </template>
    
    <template v-if="menu==2">
            <Maestro></Maestro>
    </template>

    <template v-if="menu==3">  
        <div class="container">
                <form method="post" action="{{url('/alumno/import')}}" enctype="multipart/form-data" class="form-horizontal">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">Importar Excel <i class="fa fa-file-excel-o"></i></label>
                        <div class="col-md-9">
                            <input type="file" name="excel">
                            
                            <input type="submit" value="Enviar" style="padding: 10px 20px;">
                        </div>         
                    </div>
                </form>
        </div>      
    </template>

    <template v-if="menu==4">
            <h1>Contenido del menú 4</h1>
    </template>

    <template v-if="menu==5">
            <h1>Contenido del menú 5</h1>
    </template>

    <template v-if="menu==6">
            <h1>Contenido del menú 6</h1>
    </template>

    <template v-if="menu==7">
            <h1>Contenido del menú 7</h1>
    </template>
    
    <template v-if="menu==8">
            <h1>Contenido del menú 8</h1>
    </template>

    <template v-if="menu==9">
            <h1>Contenido del menú 9</h1>
    </template>

    <template v-if="menu==10">
            <h1>Contenido del menú 10</h1>
    </template>

    <template v-if="menu==11">
            <h1>Contenido del menú 11</h1>
    </template>

    <template v-if="menu==12">
            <h1>Contenido del menú 12</h1>
    </template>
    @endsection