// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "nombre": "NA",
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarID(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+id);
}

function buscarProducto(e) {
    e.preventDefault();

    var name = document.getElementById('name').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n' + client.responseText);
            
            // SE OBTIENE EL ARREGLO DE DATOS A PARTIR DEL JSON
            let productos = JSON.parse(client.responseText);
            
            if (productos.length > 0) {
                let template = '';
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                    
                    template += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });
                document.getElementById("productos").innerHTML = template;
            } else {
                // Si no hay productos, muestra un mensaje.
                document.getElementById("productos").innerHTML = '<tr><td colspan="3">No hay información</td></tr>';
            }
        }
    };
    client.send("name=" + encodeURIComponent(name));
}


// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    if (!validarFormulario()) {
        console.log("Error al Insertar");
        return false;
    }

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    //finalJSON['nombre'] = document.getElementById('name').value;
    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON,null,2);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
        }
    };
    client.send(productoJsonString);

    client.onreadystatechange = function() {
        if (client.readyState === 4 && client.status === 200) {
            const response = JSON.parse(client.responseText);
            window.alert(response.message);
            
            if (response.success) {
                // Recargar lista de productos o limpiar formulario
                document.getElementById('task-form').reset();
            }
        }
    };
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}

function validarFormulario() {
    // Obtener el JSON del textarea
    const jsonString = document.getElementById('description').value;
    let productoJSON;
    try {
        productoJSON = JSON.parse(jsonString);
    } catch (error) {
        alert("El JSON de producto no es válido.");
        return false;
    }

    // Expresión regular para validar alfanuméricos
    const alfanumerico = /^[a-zA-Z0-9]+$/;

    // Obtener valores del JSON
    const jsonNombre = productoJSON.nombre ? productoJSON.nombre.trim() : "";
    const jsonMarca = productoJSON.marca ? productoJSON.marca.trim() : "";
    const jsonModelo = productoJSON.modelo ? productoJSON.modelo.trim() : "";
    const jsonPrecio = productoJSON.precio ? productoJSON.precio : "";
    const jsonDetalles = productoJSON.detalles ? productoJSON.detalles.trim() : "";

    // Validar campos obligatorios
    if (jsonNombre === "" || jsonMarca === "" || jsonModelo === "" || jsonPrecio === "") {
        alert("Todos los campos del JSON son obligatorios.");
        return false;
    }

    // Validar longitud del nombre (<= 100 caracteres)
    if (jsonNombre.length > 100) {
        alert("El nombre en el JSON debe tener máximo 100 caracteres.");
        return false;
    }

    // Validar modelo (<=25 caracteres y alfanumérico)
    if (jsonModelo.length > 25) {
        alert("El modelo en el JSON debe tener máximo 25 caracteres.");
        return false;
    }
    if (!alfanumerico.test(jsonModelo)) {
        alert("El modelo en el JSON debe ser alfanumérico.");
        return false;
    }

    // Validar precio (número > 99.9)
    if (isNaN(jsonPrecio) || parseFloat(jsonPrecio) <= 99.9) {
        alert("El precio en el JSON debe ser un número mayor a 99.9.");
        return false;
    }

    // Validar detalles (<=250 caracteres)
    if (jsonDetalles.length > 250) {
        alert("Los detalles en el JSON no deben exceder 250 caracteres.");
        return false;
    }

    return true;
}
    
