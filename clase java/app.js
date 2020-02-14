document.addEventListener("DOMContentLoaded",( event) =>{
    const formAlumnos = document.querySelector("#frmAlumno");
    formAlumnos.addEventListener("submit", (e)=>{
        e.preventDefault();

        const $ = document.querySelector;
        let codigo = $("#txtCodigoAlumno").value;
        nombre = document.querySelector("#txtCodigoAlumno").value,
        Direccion = document.querySelector("#txtDireccionAlumno").value,
        Telefono = document.querySelector("#txtTelefonoAlumno").value;
        
        if('localStorage' in window){
            window.localStorage.setItem("codigo", codigo);
            window.localStorage.setItem("nombre", nombre);
            window.localStorage.setItem("direccion", Direccion);
            window.localStorage.setItem("telefono", Telefono);
        }else{
            alert("almacenamiento local no soportado!!! ")
        }
    });
    document.querySelector("#btnRecuperarAlumno").addEventListener("click", (e)=> {
        if('localstorage' in window){
            document.querySelector("#txtCodigoAlumno").value = window.localStorage.getItem("codigo");
            document.querySelector("#txtNombreAlumno").value = window.localStorage.getItem("nombre");
            document.querySelector("#txtDireccionAlumno").value = window.localStorage.getItem("direccion");
            document.querySelector("#txtTelefonoAlumno").value = window.localStorage.getItem("telefono");
        }else{
            alert("alacenamiento en local no soportado!!");
        }
    })
});


/*function init(evrnt){
    alert("hola la pagina a cargado");
}*/