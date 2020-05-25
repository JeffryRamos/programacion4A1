var appbuscar_prestamosd = new Vue({
    el: '#frm-buscar-prestamosd',
    data:{
        mis_prestamosd:[],
        valor:''
    },
    methods:{
        buscarPrestamosd(){
            fetch(`private/Modulos/prestamosd/procesos.php?proceso=buscarPrestamod&prestamod=${this.valor}`).then( resp=>resp.json() ).then(resp=>{ 
                this.mis_prestamosd = resp;
            });
        },
        modificarPrestamod(prestamod){
            appprestamosd.prestamod = prestamod;
            appprestamosd.prestamod.accion = 'modificar';
        },
        eliminarPrestamod(idPrestamod){
            fetch(`private/Modulos/prestamosd/procesos.php?proceso=eliminarPrestamod&prestamod=${idPrestamod}`).then( resp=>resp.json() ).then(resp=>{
                this.buscarPrestamosd();
            });
        }
    },
    created(){
        this.buscarPrestamosd();
    }
});