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
            fetch(`private/Modulos/estudiantes/procesos.php?proceso=eliminarEstudiante&estudiante=${idEstudiante}`).then(resp=>resp.json()).then(resp=>{
                this.buscarEstudiante();
            });
        }
    },
    created:function(){
        this.buscarEstudiante();
    }
});