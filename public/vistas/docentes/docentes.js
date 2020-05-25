var appdocentes = new Vue({
    el:'#frm-docentes',
    data:{
        docente:{
            idDocente : 0,
            accion    : 'nuevo',
            codigo    : '',
            nombre    : '',
            direccion : '',
            telefono  : '',
            dui  : '',
            nit  : '',
            email  : '',
            msg       : ''
        }
    },
    methods:{
        guardarDocentes(){
            fetch(`private/Modulos/docentes/procesos.php?proceso=recibirDatos&docente=${JSON.stringify(this.docente)}`).then( resp=>resp.json() ).then(resp=>{
                if( resp.msg.indexOf("Correctamente")>=0 ){
                    alertify.success(resp.msg);
                } else if(resp.msg.indexOf("Error")>=0){
                    alertify.error(resp.msg);
                } else{
                    alertify.warning(resp.msg);
                }
            });
        },
        limpiarDocentes(){
            this.docente.idDocente=0;
            this.docente.accion="nuevo";
            this.docente.codigo="";
            this.docente.nombre="";
            this.docente.direccion="";
            this.docente.telefono="";
            this.docente.dui="";
            this.docente.nit="";
            this.docente.email="";
            this.docente.msg="";
        }
    }
});