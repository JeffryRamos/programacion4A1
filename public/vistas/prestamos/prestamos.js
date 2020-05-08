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
            prestamo  : '',
            devolucion : '',
            valor: '',
            msg       : ''
        },
        estudiantes : {},
        libros  : {}
    },
    methods:{
        guardarPrestamos(){
             fetch(`private/modulos/prestamos/procesos.php?proceso=recibirDatos&prestamo=${JSON.stringify(this.prestamo)}`).then( resp=>resp.json() ).then(resp=>{
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
         fetch(`private/modulos/prestamos/procesos.php?proceso=traer_estudiante_libro&prestamo=''`).then( resp=>resp.json() ).then(resp=>{
           this.estudiantes = resp.estudiantes;
            this.libros = resp.libros; 
        });
    }
});