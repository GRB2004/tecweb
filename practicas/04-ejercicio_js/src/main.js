
function getDatos()
{
    var nombre = prompt("Nombre: ", "");

    var edad = prompt("Edad: ", 0);

    var div1 = document.getElementById('nombre');
    div1.innerHTML = '<h3> Nombre: '+nombre+'</h3>';

    var div2 = document.getElementById('edad');
    div2.innerHTML = '<h3> Edad: '+edad+'</h3>';
}

// JS01 EJEMPLO PAG. 8
function holaMundo()
{
    document.getElementById("mensaje").innerHTML = "<h2>Hola Mundo</h2>";
}

//JS02 EJEMPLO PAG.6
function variables() {
    var nombre = 'Juan';
    var edad = 10;
    var altura = 1.92;
    var casado = false;

    document.getElementById("resultado").innerHTML = `
        <h2>Nombre: ${nombre}</h2>
        <h2>Edad: ${edad}</h2>
        <h2>Altura: ${altura} m</h2>
        <h2>Casado: ${casado ? "Sí" : "No"}</h2>
    `;
}

//JS02 EJEMPLO PAG 12.
function obtenerDatos(){
    var nombre;
    var edad;
    nombre = prompt('Ingresa tu nombre:', '');
    edad = prompt('Ingresa tu edad:', '');

    document.getElementById("datos").innerHTML = `
    <h2>Hola ${nombre}</h2>
    <h2>Asi que tienes</h2>
    <h2>${edad} años</h2>
`;
}

//JS03 EJEMPLO PAG 3
function sumaProducto() {
    var valor1;
    var valor2;
    valor1 = prompt('Introducir primer número:', '');
    valor2 = prompt('Introducir segundo número:', '');
    var suma = parseInt(valor1) +parseInt(valor2);
    var producto = parseInt(valor1)*parseInt(valor2);
    document.getElementById("suma").innerHTML = `
    <h2>La suma es </h2>
    <h2>${suma}</h2>
    <br>
    <h2>El producto es </h2>
    <h2>${producto}</h2>
    `
}

//JS03 EJEMPLO PAG 8
function nota() {
    var nombre;
    var nota;
    nombre = prompt('Ingresa tu nombre:', '');
    nota = prompt('Ingresa tu nota:', '');
    if (nota>=4) {
        document.write(nombre+' esta aprobado con un '+nota);
    }
}

//JS03 EJEMPLO PAG 11
function numeroMayor() {
    var num1,num2;
    num1 = prompt('Ingresa el primer número:', '');
    num2 = prompt('Ingresa el segundo número:', '');
    num1 = parseInt(num1);
    num2 = parseInt(num2);
    if (num1>num2) {
        document.write('el mayor es '+num1);
    }
    else {
        document.write('el mayor es '+num2);
    }
}

function convertirEntero() {
    var nota1 = prompt('Ingresa 1ra. nota:', '');
    var nota2 = prompt('Ingresa 2da. nota:', '');
    var nota3 = prompt('Ingresa 3ra. nota:', '');

    // Convertimos los valores a enteros
    nota1 = parseInt(nota1);
    nota2 = parseInt(nota2);
    nota3 = parseInt(nota3);

    // Calculamos el promedio
    var pro = (nota1 + nota2 + nota3) / 3;

    // Evaluamos el resultado
    if (pro >= 7) {
        document.write('Aprobado');
    } else if (pro >= 4) {
        document.write('Regular');
    } else {
        document.write('Reprobado');
    }
}


//JS03 EJEMPLO PAG 18
function rango() {
    var valor = prompt('Ingresar un valor comprendido entre 1 y 5:', '');
    valor = parseInt(valor); // Convertir a número
    
    var mensaje = ""; // Variable para guardar el mensaje
    
    switch (valor) {
        case 1: mensaje = "<h2>Uno</h2>"; break;
        case 2: mensaje = "<h2>Dos</h2>"; break;
        case 3: mensaje = "<h2>Tres</h2>"; break;
        case 4: mensaje = "<h2>Cuatro</h2>"; break;
        case 5: mensaje = "<h2>Cinco</h2>"; break;
        default: mensaje = "<h2>Debe ingresar un valor entre 1 y 5</h2>";
    }

    document.getElementById("18").innerHTML = mensaje;
}


//JS03 EJEMPLO 21
function pintarVentana(){
    var col;
    col = prompt('Ingresa el color con que quiera pintar el fondo de la ventana (rojo, verde, azul)', '');
    switch (col) {
        case 'rojo': document.bgColor='#ff0000';
                break;
        case 'verde': document.bgColor='#00ff00';
                break;
        case 'azul': document.bgColor='#000ff';
                break;
    }
}

//JS04 EJEMPLO PAG s5
function imprimirCien() {
    var x;
    x=1;
    while (x<=100) {
        document.write(x);
        document.write('<br>');
        x=x+1;
    }
}

// JS04 EJEMPLO PAG 6
function sumarIngresados() {
    var x=1;
    var suma=0;
    while (x<=5) {
        valor = prompt('Ingresa el valor:', '');
        valor = parseInt(valor);
        suma = suma + valor;
        x = x + 1;
    }

    document.getElementById("r-p6").innerHTML = `<h2>La suma de los valores es ${suma}</h2>`;
}


// JS04 EJEMPLO PAG 12
function numDigitos() {
    var valor;
    do {
        valor = prompt('Ingresa un valor entre 0 y 999:', '');
        valor = parseInt(valor);
        document.write('El valor '+valor+' tiene ');
        if (valor<10) {
            document.write('Tiene 1 digitos');
        }
        else {
            if (valor<100) {
                document.write('Tiene 2 digitos');
            }
            else {
                document.write('Tiene 3 digitos');
            }
        }
        document.write('<br>');
    } while (valor!=0);
}

// JS04 EJEMPLO PAG 16
function rango10() {
    var f;
    for (f=1; f<=10; f++)
    {
        document.getElementById("r-p16").innerHTML += `${f} `;
    }
}

// JS05 EJEMPLO PAG 6
function sinFuncion() {
    document.getElementById("f-6").innerHTML = `
        Cuidado<br>
        Ingresa tu documento correctamente<br>
        Cuidado<br>
        Ingresa tu documento correctamente<br>
        Cuidado<br>
        Ingresa tu documento correctamente<br>
    `
}

//JS05 EJEMPLO PAG 7
function conFuncion() {
    var mensaje = document.createElement("div");
    mensaje.innerHTML = `
        Cuidado<br>
        Ingresa tu documento correctamente<br>
    `;
    document.getElementById("f-7").appendChild(mensaje);
}

//JS04 EJEMPLO PAG 10
function mostrarRango(x1,x2) {
    var inicio;
    for(inicio=x1; inicio<=x2; inicio++) {
        document.getElementById("f-10").innerHTML += `${inicio} `;
    }
}

//JS05 EJEMPLO PAG 13
function convertirCastellano(x) {
    var resultado;
    if (x == 1) {
        resultado =  "uno";
        document.getElementById("f-13").innerHTML = `${resultado} `;
    }
    else if (x == 2) {
        resultado = "dos";
        document.getElementById("f-13").innerHTML = `${resultado} `;
    }
    else if (x == 3) {
        resultado = "tres";
        document.getElementById("f-13").innerHTML = `${resultado} `;
    }
    else if (x == 4) {
        resultado = "cuatro";
        document.getElementById("f-13").innerHTML = `${resultado} `;
    }
    else if (x == 5) {
        resultado = "cinco";
        document.getElementById("f-13").innerHTML = `${resultado} `;
    }
    else {
        resultado = "valor incorrecto";
        document.getElementById("f-13").innerHTML = `${resultado} `;
    }
}

//JS05 PAG 15
function convertirCastellanoDos(x) {
    // Convertimos el valor a número
    let numero = parseInt(x, 10);

    // Evaluamos con switch
    let resultado;
    switch (numero) {
        case 1: resultado = "uno"; break;
        case 2: resultado = "dos"; break;
        case 3: resultado = "tres"; break;
        case 4: resultado = "cuatro"; break;
        case 5: resultado = "cinco"; break;
        default: resultado = "valor incorrecto";
    }

    // Mostramos el resultado en el HTML
    document.getElementById("f-14").innerHTML = resultado;
}





