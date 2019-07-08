    @extends('principal')
    @section('contenido')
        <template v-if="menu==0">
        <h1>Contenido del menú 0</h1>
        </template>

        <template v-if="menu==1">
            <categoria></categoria>
        </template>

        <template v-if="menu==2">
            <articulo></articulo>
        </template>

        <template v-if="menu==3">
            <profesor></profesor>
        </template>

        <template v-if="menu==4">
            <gestion></gestion>
        </template>

        <template v-if="menu==5">
           <curso></curso>           
        </template>
        <template v-if="menu==6">
           <alumno><alumno/>
        </template>

        <template v-if="menu==7">
            <bimestre></bimestre>
        </template>

        <template v-if="menu==8">
            <paralelo></paralelo>
        </template>

        <template v-if="menu==9">
           <inscripcion></inscripcion>
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
        <template v-if="menu==13">
            <h1>Contenido del menú 13</h1>
        </template>
        
    @endsection