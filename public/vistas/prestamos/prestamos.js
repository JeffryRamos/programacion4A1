Vue.component('v-select', VueSelect.VueSelect);

var appprestamos = new Vue({
    el:'#frm-prestamos',
    data:{
        prestamo:{
            idPrestamo : 0,
            accion    : 'nuevo',
            registro   : {
                idRegistro : 0,
                registro   : ''
            },
            libro    : {
                idLibro : 0,
                libro   : ''
            },
            fechaPrestamo     : '',
            fechaDevolucion     : '',
            msg       : ''
        },
        registros : {},
        libros  : {}
    },
    methods:{
        guardarPrestamos(){
            fetch(`private/Modulos/prestamos/procesos.php?proceso=recibirDatos&prestamo=${JSON.stringify(this.prestamo)}`).then( resp=>resp.json() ).then(resp=>{
                if( resp.msg.indexOf("Correctamente")>=0 ){
                    alertify.success(resp.msg);
                } else if(resp.msg.indexOf("Error")>=0){
                    alertify.error(resp.msg);
                } else{
                    alertify.warning(resp.msg);
                }
            });
        },
        limpiarPrestamos(){
            this.prestamo.idPrestamo=0;
            this.prestamo.accion="nuevo";
            this.prestamo.msg="";
        }
    },
    created(){
        fetch(`private/Modulos/prestamos/procesos.php?proceso=traer_registro_libro&prestamo=''`).then( resp=>resp.json() ).then(resp=>{
            this.registros = resp.registros;
            this.libros = resp.libros;
        });
    }
});