var appBuscarLibros = new Vue({
    el:'#frm-buscar-libros',
    data:{
        mislibros:[],
        valor:''
    },
    methods:{
        buscarLibro:function(){
            fetch(`private/Modulos/libros/procesos.php?proceso=buscarLibro&libro=${this.valor}`).then(resp=>resp.json()).then(resp=>{
                this.mislibros = resp;
            });
        },
        modificarLibro:function(libro){
            applibro.libro = libro;
            applibro.libro.accion = 'modificar';
        },
        eliminarLibro:function(idLibro){
            alertify.confirm("REGISTRO DE LIBROS","¿Esta seguro que desea eliminar este registro?",
                ()=>{
                    fetch(`private/Modulos/Libros/procesos.php?proceso=eliminarLibro&libro=${idLibro}`).then( resp=>resp.json() ).then(resp=>{
                        this.buscarLibros();
                    });
                    alertify.success('"Registro eliminado correctamente"');
                },
                ()=>{
                    alertify.error('"Eliminacion cancelada"');
                });
        }
    },
    created:function(){
        this.buscarLibro();
    }
});