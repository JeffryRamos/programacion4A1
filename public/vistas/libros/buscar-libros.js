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
            fetch(`private/Modulos/libros/procesos.php?proceso=eliminarLibro&libro=${idLibro}`).then( resp=>resp.json() ).then(resp=>{
                this.buscarLibros();
            });
        }
    },
    created(){
        this.buscarLibros();
    }
});