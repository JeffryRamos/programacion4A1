var appalumnos = new Vue({
    el:'#frm-alumnos',
    data:{
        alumno:{
            id_estudiante : 0,
            accion    : 'nuevo',
            nombre    : '',
            direccion : '',
            telefono  : '',
            seccion    : '',
            nie    : '',
            grado    : '',
            email    : '',
            msg       : ''
        }
    },
    methods:{
        guardarAlumnos(){
            fetch(`private/Modulos/alumnos/procesos.php?proceso=recibirDatos&alumno=${JSON.stringify(this.alumno)}`).then( resp=>resp.json() ).then(resp=>{
                this.alumno.msg = resp.msg;
            });
        },
        limpiarAlumnos(){
            this.alumno.id_estudiante=0;
            this.alumno.accion="nuevo";
            this.alumno.nombre="";
            this.alumno.direccion="";
            this.alumno.telefono="";
            this.alumno.seccion="";
            this.alumno.nie="";
            this.alumno.grado="";
            this.alumno.email="";
            this.alumno.msg="";
        }
    }
});