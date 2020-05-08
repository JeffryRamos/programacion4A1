var appbuscar_prestamos = new Vue({
    el: '#frm-buscar-prestamos',
    data:{
        mis_prestamos:[],
        valor:''
    },
    methods:{
        buscarPrestamo(){
            fetch(`private/modulos/prestamos/procesos.php?proceso=buscarPrestamo&prestamo=${this.valor}`).then( resp=>resp.json() ).then(resp=>{ 
                this.mis_prestamos = resp;
            });
        },
        modificarPrestamo(prestamo){
            appprestamos.prestamo = prestamo;
            appprestamos.prestamo.accion = 'modificar';
        },
        eliminarPrestamo(idPrestamo){
            var confirmacion = confirm("¿Esta seguro que desea el registro?");
            if (confirmacion){
                alert("El registro se elimino corretamente");
                fetch(`private/modulos/prestamos/procesos.php?proceso=eliminarPrestamo&prestamo=${idPrestamo}`).then(resp=>resp.json()).then(resp=>{
                  this.buscarPrestamo();
              });
              }

        }
    },
    created(){
        this.buscarPrestamo();
    }
});