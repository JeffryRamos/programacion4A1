var appestudiante = new Vue({
    el:'#frm-estudiantes',
    data:{
        estudiante:{
            idEstudiante  : 0,
            accion    : 'nuevo',
            nie  : '',
            nombre    : '',
            direccion : '',
            telefono  : '',
            grado  : '',
            seccion  : '',
            email  : '',
            msg       : ''
        }
    },
    methods:{
        guardarEstudiante:function(){
            fetch(`private/Modulos/estudiantes/procesos.php?proceso=recibirDatos&estudiante=${JSON.stringify(this.estudiante)}`).then( resp=>resp.json() ).then(resp=>{
                this.estudiante.msg = resp.msg;
                this.estudiante.idEstudiante = 0;
                this.estudiante.nie = '';
                this.estudiante.nombre = '';
                this.estudiante.direccion = '';
                this.estudiante.telefono = '';
                this.estudiante.grado = '';
                this.estudiante.seccion = '';
                this.estudiante.email = '';
                this.estudiante.accion = 'nuevo';
                appBuscarEstudiantes.buscarEstudiante();
            });
        }
    }
});