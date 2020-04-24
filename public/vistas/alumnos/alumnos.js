var appalumno = new Vue({
    el:'#frm-alumnos',
    data:{
        alumno:{
            idAlumno  : 0,
            accion    : 'nuevo',
            nombre    : '',
            direccion : '',
            telefono  : '',
            seccion  : '',
            nie  : '',
            grado  : '',
            email  : '',
            msg       : ''
        }
    },
    methods:{
        guardarAlumno:function(){
            fetch(`private/Modulos/alumnos/procesos.php?proceso=recibirDatos&alumno=${JSON.stringify(this.alumno)}`).then( resp=>resp.json() ).then(resp=>{
                this.alumno.msg = resp.msg;
                this.alumno.idAlumno = 0;
                this.alumno.nombre = '';
                this.alumno.direccion = '';
                this.alumno.telefono = '';
                this.alumno.seccion = '';
                this.alumno.nie = '';
                this.alumno.grado = '';
                this.alumno.email = '';
                this.alumno.accion = 'nuevo';
                appBuscarAlumnos.buscarAlumno();
            });
        }
    }
});