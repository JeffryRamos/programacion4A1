Vue.component('v-select', VueSelect.VueSelect);

var appprestamose = new Vue({
    el:'#frm-prestamose',
    data:{
        prestamoe:{
            idPrestamoe : 0,
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
        guardarPrestamose(){
            fetch(`private/Modulos/prestamose/procesos.php?proceso=recibirDatos&prestamoe=${JSON.stringify(this.prestamoe)}`).then( resp=>resp.json() ).then(resp=>{
                this.prestamoe.msg = resp.msg;
            });
        },
        limpiarPrestamose(){
            this.prestamoe.idPrestamoe=0;
            this.prestamoe.accion="nuevo";
            this.prestamoe.msg="";
        }
    },
    created(){
        fetch(`private/Modulos/prestamose/procesos.php?proceso=traer_estudiante_libro&prestamoe=''`).then( resp=>resp.json() ).then(resp=>{
            this.estudiantes = resp.estudiantes;
            this.libros = resp.libros;
        });
    }
});