var applibros = new Vue({
    el:'#frm-libros',
    data:{
        libro:{
            idLibro : 0,
            accion    : 'nuevo',
            codigo    : '',
            titulo    : '',
            edicion : '',
            genero  : '',
            msg       : ''
        }
    },
    methods:{
        guardarLibros(){
            fetch(`private/Modulos/libros/procesos.php?proceso=recibirDatos&libro=${JSON.stringify(this.libro)}`).then( resp=>resp.json() ).then(resp=>{
                if( resp.msg.indexOf("Correctamente")>=0 ){
                    alertify.success(resp.msg);
                } else if(resp.msg.indexOf("Error")>=0){
                    alertify.error(resp.msg);
                } else{
                    alertify.warning(resp.msg);
                }
            });
        },
        limpiarLibros(){
            this.libro.idLibro=0;
            this.libro.accion="nuevo";
            this.libro.codigo="";
            this.libro.titulo="";
            this.libro.edicion="";
            this.libro.genero="";
            this.libro.msg="";
        }
    }
});