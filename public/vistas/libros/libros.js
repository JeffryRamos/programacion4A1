var applibros = new Vue({
    el:'#frm-libros',
    data:{
        libro:{
            idLibro : 0,
            accion    : 'nuevo',
            codigo    : '',
            nombre    : '',
            edicion    : '',
            genero    : '',
            msg       : ''
        }
    },
    methods:{
        guardarLibros(){
            fetch(`private/Modulos/libros/procesos.php?proceso=recibirDatos&libro=${JSON.stringify(this.libro)}`).then( resp=>resp.json() ).then(resp=>{
                this.libro.msg = resp.msg;
            });
        },
        limpiarLibros(){
            this.libro.idLibro=0;
            this.libro.accion="nuevo";
            this.libro.codigo="";
            this.libro.nombre="";
            this.libro.edicion="";
            this.libro.genero="";
            this.libro.msg="";
        }
    }
});