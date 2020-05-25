var appbuscar_prestamose = new Vue({
    el: '#frm-buscar-prestamose',
    data:{
        mis_prestamose:[],
        valor:''
    },
    methods:{
        buscarPrestamose(){
            fetch(`private/Modulos/prestamose/procesos.php?proceso=buscarPrestamoe&prestamoe=${this.valor}`).then( resp=>resp.json() ).then(resp=>{ 
                this.mis_prestamose = resp;
            });
        },
        modificarPrestamoe(prestamoe){
            appprestamose.prestamoe = prestamoe;
            appprestamose.prestamoe.accion = 'modificar';
        },
        eliminarPrestamoe(idPrestamoe){
            fetch(`private/Modulos/prestamose/procesos.php?proceso=eliminarPrestamoe&prestamoe=${idPrestamoe}`).then( resp=>resp.json() ).then(resp=>{
                this.buscarPrestamose();
            });
        }
    },
    created(){
        this.buscarPrestamose();
    }
});