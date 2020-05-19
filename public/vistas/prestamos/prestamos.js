Vue.component('v-select', VueSelect.VueSelect);

var appprestamos = new Vue({
    el:'#frm-prestamos',
    data:{
        prestamo:{
            idPrestamo : 0,
            accion    : 'nuevo',
            estudiante   : {
                idEstudiante : 0,
                estudiante   : ''
            },
            libro    : {
                idLibro : 0,
                libro   : ''
            },
            fechaPrestamo     : '',
            fechaDevolucion     : '',
            msg       : ''
        },
        estudiantes : {},
        libros  : {}
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
        fetch(`private/Modulos/prestamos/procesos.php?proceso=traer_estudiantes_libros&prestamo=''`).then( resp=>resp.json() ).then(resp=>{
            this.estudiantes = resp.estudiantes;
            this.libros = resp.libros;
        });
    }
});