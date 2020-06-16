/**
 * @author Kathia Mejía <usis036318@ugb.edu.sv>
 * @file chat.js logica para el chat de comunicacion entre los usuarios.
 * @license MIT libre distribucion y modificacion para fine educativos.
 * @instance objeto de instancia de vue.js
 */
var appchat = new Vue({
    /**
     * @property el element del DOM a enlazar.
     */
        el:'#frm-chat',
        data:{
            msg : '',
            msgs : []
        },
        methods:{
            /**
             * @function enviarMensaje es cuando el usuario envia un mensaje a otro usuario.
             */
            enviarMensaje(){
                socket.emit('enviarMensaje', this.msg);
                this.msg = '';
            },
            /**
             * @function limpiarChat borra el texto que escribio el usuario en la caja de texto
             */
            limpiarChat(){
                this.msg = '';
            }
        },
        created(){
            socket.emit('chatHistory');
        }
    });
    socket.on('recibirMensaje',msg=>{
        console.log(msg);
        $.notification("Biblioteca Digital",msg, 'https://image.winudf.com/v2/image1/Y29tLmZhY2Vib29rLm9yY2FfaWNvbl8xNTYxNDE0ODQ5XzAwMw/icon.png?w=100&fakeurl=1');
        appchat.msgs.push(msg);
    });
    socket.on('chatHistory',msgs=>{
        appchat.msgs = [];
        msgs.forEach(item => {
            appchat.msgs.push(item.msg);
        });
    });
