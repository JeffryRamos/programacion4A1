var appestudiantes = new Vue({
    el:'#frm-estudiantes',
    data:{
        estudiante:{
            idEstudiante : 0,
            accion    : 'nuevo',
            nie    : '',
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
        guardarEstudiantes(){
            fetch(`private/Modulos/estudiantes/procesos.php?proceso=recibirDatos&estudiante=${JSON.stringify(this.estudiante)}`).then( resp=>resp.json() ).then(resp=>{
                if( resp.msg.indexOf("Correctamente")>=0 ){
                    alertify.success(resp.msg);
                } else if(resp.msg.indexOf("Error")>=0){
                    alertify.error(resp.msg);
                } else{
                    alertify.warning(resp.msg);
                }
            });
        },
        limpiarEstudiantes(){
            this.estudiante.idEstudiante=0;
            this.estudiante.accion="nuevo";
            this.estudiante.nie="";
            this.estudiante.nombre="";
            this.estudiante.direccion="";
            this.estudiante.telefono="";
            this.estudiante.grado="";
            this.estudiante.seccion="";
            this.estudiante.email="";
            this.estudiante.msg="";
        }
    }
});