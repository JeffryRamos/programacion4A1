var appbuscar_libros = new Vue({
    el: '#frm-buscar-libros',
    data:{
        mis_libros:[],
        valor:''
    },
    methods:{
        buscarLibros(){
            fetch(`private/Modulos/libros/procesos.php?proceso=buscarLibro&libro=${this.valor}`).then( resp=>resp.json() ).then(resp=>{ 
                this.mis_libros = resp;
            });
        },
        modificarLibro(libro){
            applibros.libro = libro;
            applibros.libro.accion = 'modificar';
        },
        eliminarLibro(idLibro){
            alertify.confirm("Registro De Libros","¿Esta seguro que desea eliminar el registro?",
                ()=>{
                    fetch(`private/Modulos/libros/procesos.php?proceso=eliminarLibro&libro=${idLibro}`).then( resp=>resp.json() ).then(resp=>{
                        this.buscarLibros();
                    });
                    alertify.success('Registro eliminado correctamente');
                },
                ()=>{
                    alertify.error('Eliminacion cancelada');
                });
        }
    },
    created(){
        this.buscarLibros();
    }
});