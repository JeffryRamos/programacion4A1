Vue.component('v-select', VueSelect.VueSelect);

var appprestamos = new Vue({
    el:'#frm-prestamos',
    data:{
        prestamo:{
            idPrestamo : 0,
            accion    : 'nuevo',
            prestamo     : '',
            msg       : ''
            },
            devolucion     : '',
            msg       : ''
    },
    methods:{
        guardarPrestamos(){
            fetch(`private/Modulos/prestamos/procesos.php?proceso=recibirDatos&prestamo=${JSON.stringify(this.prestamo)}`).then( resp=>resp.json() ).then(resp=>{
                this.prestamo.msg = resp.msg;
            });
        },
        limpiarPrestamos(){
            this.prestamo.idPrestamo=0;
            this.prestamo.accion="nuevo";
            this.prestamo.msg="";
        }
    },
    created(){
        fetch(`private/Modulos/prestamos/procesos.php?proceso=traer_periodos_alumnos&prestamo=''`).then( resp=>resp.json() ).then(resp=>{
            this.periodos = resp.periodos;
            this.alumnos = resp.alumnos;
        });
    }
});