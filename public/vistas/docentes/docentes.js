var appdocente = new Vue({
    el:'#frm-docentes',
    data:{
        docente:{
            idDocente  : 0,
            accion    : 'nuevo',
            nombre    : '',
            direccion : '',
            telefono  : '',
            seccion    : '',
            codigo    : '',
            dui    : '',
            nit  : '',
            msg       : ''
        }
    },
    methods:{
        guardarDocente:function(){
            fetch(`private/Modulos/docentes/procesos.php?proceso=recibirDatos&docente=${JSON.stringify(this.docente)}`).then( resp=>resp.json() ).then(resp=>{
                this.docente.msg = resp.msg;
                this.docente.idDocente = 0;
                this.docente.nombre = '';
                this.docente.direccion = '';
                this.docente.telefono = '';
                this.docente.seccion = '';
                this.docente.codigo = '';
                this.docente.dui = '';
                this.docente.nit = '';
                this.docente.accion = 'nuevo';
                appBuscarDocentes.buscarDocente();
            });
        }
    }
});