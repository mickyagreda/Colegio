    @extends('principal')
    @section('contenido')
        <template v-if="menu==0"> 
            <MARQUEE BEHAVIOR=ALTERNATE><h1>Bienvenido Al Control Del Colegio</h1></MARQUEE>
        </template>

        <template v-if="menu==1">
            <profesor></profesor>
        </template>

        <template v-if="menu==2">
            <alumno></alumno>
        </template>

        <template v-if="menu==3">
           <curso></curso>
        </template>

        <template v-if="menu==4">
            <gestion></gestion>
        </template>

        <template v-if="menu==5">
            <calificasion></calificasion>
        </template>

        <template v-if="menu==7">
            <alumno></alumno>
        </template>

        <template v-if="menu==8">
            <materia></materia>
        </template>

        <template v-if="menu==9">
           <bimestre></bimestre>
        </template>

        <template v-if="menu==10">
            <inscripcion></inscripcion>
        </template>

        <template v-if="menu==11">
            <materia></materia>
        </template>

        <template v-if="menu==12">
            <registrarmateria></registrarmateria>
        </template>
        <template v-if="menu==13">
            <paralelo></paralelo>
        </template>
        
    @endsection