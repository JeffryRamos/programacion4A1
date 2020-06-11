var appbuscar_prestamos = new Vue({
    el: '#frm-buscar-prestamos',
    data:{
        mis_prestamos:[],
        valor:''
    },
    methods:{
        buscarPrestamos(){
            fetch(`private/Modulos/prestamos/procesos.php?proceso=buscarPrestamo&prestamo=${this.valor}`).then( resp=>resp.json() ).then(resp=>{ 
                this.mis_prestamos = resp;
            });
        },
        modificarPrestamo(prestamo){
            appprestamos.prestamo = prestamo;
            appprestamos.prestamo.accion = 'modificar';
        },
        eliminarPrestamo(idPrestamo){
            alertify.confirm("Registro De Prestamos","¿Esta seguro que desea eliminar el registro?",
                ()=>{
                    fetch(`private/Modulos/prestamos/procesos.php?proceso=eliminarPrestamo&prestamo=${idPrestamo}`).then( resp=>resp.json() ).then(resp=>{
                        this.buscarPrestamos();
                    });
                    alertify.success('Registro eliminado correctamente');
                },
                ()=>{
                    alertify.error('Eliminacion cancelada');
                });
        }
    },
    created(){
        this.buscarPrestamos();
    }
});