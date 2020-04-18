var appbuscar_prestamos = new Vue({
    el: '#frm-buscar-prestamos',
    data:{
        mis_prestamos:[],
        valor:''
    },
    methods:{
        buscarPrestamos: function(){
            fetch(`private/Modulos/prestamos/procesos.php?proceso=buscarPrestamo&prestamo=${this.valor}`).then( resp=>resp.json() ).then(resp=>{ 
                this.mis_prestamos = resp;
            });
        },
        modificarPrestamo:function(prestamo){
            appprestamos.prestamo = prestamo;
            appprestamos.prestamo.accion = 'modificar';
        },
        eliminarPrestamo:function(idPrestamo){
            fetch(`private/Modulos/prestamos/procesos.php?proceso=eliminarPrestamo&prestamo=${idPrestamo}`).then( resp=>resp.json() ).then(resp=>{
                this.buscarPrestamos();
            });
        }
    },
    created:function(){
        this.buscarPrestamos();
    }
});