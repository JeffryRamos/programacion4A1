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
            fetch(`private/Modulos/libros/procesos.php?proceso=eliminarLibro&libro=${idLibro}`).then(resp=>resp.json()).then(resp=>{
                this.buscarLibro();
            });
        }
    },
    created:function(){
        this.buscarLibro();
    }
});