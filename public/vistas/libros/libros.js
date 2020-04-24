var applibro = new Vue({
    el:'#frm-libros',
    data:{
        libro:{ 
            idLibro  : 0,
            accion    : 'nuevo',
            codigo    : '',
            titulo : '',
            edicion  : '',
            genero  : '',
            msg       : ''
        }
    },
    methods:{
        guardarLibro:function(){
            fetch(`private/Modulos/libros/procesos.php?proceso=recibirDatos&libro=${JSON.stringify(this.libro)}`).then( resp=>resp.json() ).then(resp=>{
                this.libro.msg = resp.msg;
                this.libro.idLibro = 0;
                this.libro.codigo = '';
                this.libro.titulo = '';
                this.libro.edicion = '';
                this.libro.genero = '';
                this.libro.accion = 'nuevo';
                appBuscarLibros.buscarLibro();
            });
        }
    }
});