var appBuscarEstudiantes = new Vue({
    el:'#frm-buscar-estudiantes',
    data:{
        misestudiantes:[],
        valor:''
    },
    methods:{
        buscarEstudiante:function(){
            fetch(`private/Modulos/estudiantes/procesos.php?proceso=buscarEstudiante&estudiante=${this.valor}`).then(resp=>resp.json()).then(resp=>{
                this.misestudiantes = resp;
            });
        },
        modificarEstudiante:function(estudiante){
            appestudiante.estudiante = estudiante;
            appestudiante.estudiante.accion = 'modificar';
        },
        eliminarEstudiante:function(idEstudiante){
            alertify.confirm("REGISTRO DE ESTUDIANTES","¿Esta seguro que desea eliminar este registro?",
                ()=>{
                    fetch(`private/Modulos/Estudiantes/procesos.php?proceso=eliminarEstudiante&estudiante=${idEstudiante}`).then( resp=>resp.json() ).then(resp=>{
                        this.buscarEstudiantes();
                    });
                    alertify.success('"Registro eliminado correctamente"');
                },
                ()=>{
                    alertify.error('"Eliminacion cancelada"');
                });
        }
    },
    created:function(){
        this.buscarEstudiante();
    }
});