Vue.component('v-select', VueSelect.VueSelect);

var appprestamosd = new Vue({
    el:'#frm-prestamosd',
    data:{
        prestamod:{
            idPrestamod : 0,
            accion    : 'nuevo',
            docente   : {
                idDocente : 0,
                docente   : ''
            },
            libro    : {
                idLibro : 0,
                libro   : ''
            },
            fechaPrestamo     : '',
            fechaDevolucion     : '',
            msg       : ''
        },
        docentes : {},
        libros  : {}
    },
    methods:{
        guardarPrestamosd(){
            fetch(`private/Modulos/prestamosd/procesos.php?proceso=recibirDatos&prestamod=${JSON.stringify(this.prestamod)}`).then( resp=>resp.json() ).then(resp=>{
                this.prestamod.msg = resp.msg;
            });
        },
        limpiarPrestamosd(){
            this.prestamod.idPrestamod=0;
            this.prestamod.accion="nuevo";
            this.prestamod.msg="";
        }
    },
    created(){
        fetch(`private/Modulos/prestamosd/procesos.php?proceso=traer_docente_libro&prestamod=''`).then( resp=>resp.json() ).then(resp=>{
            this.docentes = resp.docentes;
            this.libros = resp.libros;
        });
    }
});