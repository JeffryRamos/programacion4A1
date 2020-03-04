document.addEventListener("DOMContentLoaded", e=>{
    const form = document.querySelector("#frmConversoresMonedas");
    form.addEventListener("submit", event=>{
        event.preventDefault();

        let de = document.querySelector("#cboDe").value,
            a = document.querySelector("#cboA").value,
            cantidad = document.querySelector("#txtCantidadConversor").value;
        console.log(de, a, cantidad);
        let monedas = {
            "dolar":1,
            "euro":0.93,
            "quetzal":7.63,
            "lempira":24.9,
            "cordoba":34.19
        };
        let $res = document.querySelector("#lblRespuesta");
        $res.innerHTML = `Respuesta: ${ (monedas[a]/monedas[de]*cantidad).toFixed(2) }`;
    });
    const form = document.querySelector("#frmConversoresLongitud");
    form.addEventListener("submit", event=>{
        event.preventDefault();

        let de = document.querySelector("#cboDe").value,
            a = document.querySelector("#cboA").value,
            cantidad = document.querySelector("#txtCantidadConversor").value;
        console.log(de, a, cantidad);
        let monedas = {
            "dolar":1,
            "centimetro":100,
            "quilometro":0.001,
            "milla":0.000621371,
            "pies":3.2808388799999997
        };
        let $res = document.querySelector("#lblRespuesta");
        $res.innerHTML = `Respuesta: ${ (monedas[a]/monedas[de]*cantidad).toFixed(2) }`;
    });
    
});