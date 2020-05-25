var appbuscar_estudiantes = new Vue({
    el: '#frm-buscar-estudiantes',
    data:{
        mis_estudiantes:[],
        valor:''
    },
    methods:{
        buscarEstudiantes(){
            fetch(`private/Modulos/estudiantes/procesos.php?proceso=buscarEstudiante&estudiante=${this.valor}`).then( resp=>resp.json() ).then(resp=>{ 
                this.mis_estudiantes = resp;
            });
        },
        modificarEstudiante(estudiante){
            appestudiantes.estudiante = estudiante;
            appestudiantes.estudiante.accion = 'modificar';
        },
        eliminarEstudiante(idEstudiante){
            alertify.confirm("Registro De Estudiantes","¿Esta seguro que desea eliminar el registro?",
                ()=>{
                    fetch(`private/Modulos/estudiantes/procesos.php?proceso=eliminarEstudiante&estudiante=${idEstudiante}`).then( resp=>resp.json() ).then(resp=>{
                        this.buscarEstudiantes();
                    });
                    alertify.success('Registro eliminado correctamente');
                },
                ()=>{
                    alertify.error('Eliminacion cancelada');
                });
        }
    },
    created(){
        this.buscarEstudiantes();
    }
});