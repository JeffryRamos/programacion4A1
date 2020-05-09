var appBuscarDocentes = new Vue({
    el:'#frm-buscar-docentes',
    data:{
        misdocentes:[],
        valor:''
    },
    methods:{
        buscarDocente:function(){
            fetch(`private/Modulos/docentes/procesos.php?proceso=buscarDocente&docente=${this.valor}`).then(resp=>resp.json()).then(resp=>{
                this.misdocentes = resp;
            });
        },
        modificarDocente:function(docente){
            appdocente.docente = docente;
            appdocente.docente.accion = 'modificar';
        },
        eliminarDocente:function(idDocente){
            alertify.confirm("REGISTRO DE DOCENTES","¿Esta seguro que desea eliminar este registro?",
                ()=>{
                    fetch(`private/Modulos/Docentes/procesos.php?proceso=eliminarDocente&docente=${idDocente}`).then( resp=>resp.json() ).then(resp=>{
                        this.buscarDocentes();
                    });
                    alertify.success('"Registro eliminado correctamente"');
                },
                ()=>{
                    alertify.error('"Eliminacion cancelada"');
                });
        }
    },
    created:function(){
        this.buscarDocente();
    }
});