var appbuscar_docentes = new Vue({
    el: '#frm-buscar-docentes',
    data:{
        mis_docentes:[],
        valor:''
    },
    methods:{
        buscarDocentes(){
            fetch(`private/Modulos/docentes/procesos.php?proceso=buscarDocente&docente=${this.valor}`).then( resp=>resp.json() ).then(resp=>{ 
                this.mis_docentes = resp;
            });
        },
        modificarDocente(docente){
            appdocentes.docente = docente;
            appdocentes.docente.accion = 'modificar';
        },
        eliminarDocente(idDocente){
            alertify.confirm("Registro De Docentes","¿Esta seguro que desea eliminar el registro?",
                ()=>{
                    fetch(`private/Modulos/docentes/procesos.php?proceso=eliminarDocente&docente=${idDocente}`).then( resp=>resp.json() ).then(resp=>{
                        this.buscarDocentes();
                    });
                    alertify.success('Registro eliminado correctamente');
                },
                ()=>{
                    alertify.error('Eliminacion cancelada');
                });
        }
    },
    created(){
        this.buscarDocentes();
    }
});