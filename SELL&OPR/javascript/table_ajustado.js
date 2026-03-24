/**
 * 
 */



function taju(){


    const div = $("#table-ajustado1")[0];
const div_cu = $("#table-ajustado")[0];
const tabla = div.querySelectorAll("table")[0];
const tabla_cu = div_cu.querySelectorAll("table")[0];
const thead = tabla.querySelectorAll("thead tr")[0];
const thead_cu = tabla_cu.querySelectorAll("thead tr")[0];
const tbody = tabla.querySelectorAll("tbody tr");
const tbody_cu = tabla_cu.querySelectorAll("tbody tr");
tbody.forEach(function (fila) {
const td = fila.querySelectorAll("td");
if (td[0].innerText === 'Venta') {

fila.setAttribute("id", td[0].innerText + "_on")
//$(td[0]).addClass("fa fa-eye");
$(td[0]).empty();
$(td[0]).append('Venta<i class="fa fa-eye"></i>   ');
fila.style.cursor = 'pointer';
}
if (td[0].innerText === 'Inv.Inicial') {

fila.setAttribute("id", "Inv_on")
//$(td[0]).addClass("fa fa-eye");
$(td[0]).empty();
$(td[0]).append('Inv.Inicial<i class="fa fa-eye"></i>   ');
fila.style.cursor = 'pointer';
}
if (td[0].innerText === 'Inv.Final') {

fila.setAttribute("id", "Invf_on")
//$(td[0]).addClass("fa fa-eye");
$(td[0]).empty();
$(td[0]).append('Inv. Final<i class="fa fa-eye"></i>   ');
fila.style.cursor = 'pointer';
}
if (td[0].innerText === 'Pedidos Navision') {

fila.setAttribute("id", "Ped_on")
//$(td[0]).addClass("fa fa-eye");
// $(td[0]).append('<i class="fa fa-eye"></i>   ');
}
if (td[0].innerText === 'Compra Presupuesto') {

fila.setAttribute("id", "Comp_on")
//$(td[0]).addClass("fa fa-eye");
$(td[0]).empty();
$(td[0]).append('Compra Presupuesto<i class="fa fa-eye"></i>   ');
fila.style.cursor = 'pointer';
}
if (td[0].innerText === 'Recepción Alm.') {

fila.setAttribute("id", "Comp_on");
$(td[0]).empty();
$(td[0]).append('Recepción Alm.<i class="fa fa-eye"></i>   ');
fila.style.cursor = 'pointer';

//$(td[0]).addClass("fa fa-eye");
/* $(td[0]).empty();
$(td[0]).append('Compra PPTO<i class="fa fa-eye"></i>   ');*/
//fila.style.cursor = 'pointer';
}
if (td[0].innerText === 'Cubrimiento') {
fila.setAttribute("id", "Cu_on");
//$(td[0]).empty();
//$(td[0]).append('Cubrimiento<i class="fa fa-eye"></i>   ');
// fila.style.cursor = 'pointer';

//$(td[0]).addClass("fa fa-eye");
/* $(td[0]).empty();
$(td[0]).append('Compra PPTO<i class="fa fa-eye"></i>   ');*/
//fila.style.cursor = 'pointer';
}
switch (td[0].innerText) {
case "$ Venta" :
case  "$ Costo Venta" :
case"Precio Promedio":
case"$ Venta 19":
case"$ Utilidad" :
for (let i = 0; i < td.length; i++) {
$(td[i]).addClass("venta_on");
}
break;

case "$ Inv.Inicial Costo" :
case  "Inv.Inicial 2019" :
for (let i = 0; i < td.length; i++) {
$(td[i]).addClass("inv_on");
}
break;
case "$ Compra" :
case  "Compra 2019" :
for (let i = 0; i < td.length; i++) {
$(td[i]).addClass("comp_on");
}
break;
case  "Compra Real-Ppto" :
for (let i = 0; i < td.length; i++) {
$(td[i]).addClass("comp_rp");
}
break;

case "$ Inv.Final Costo":
for (let i = 0; i < td.length; i++) {
$(td[i]).addClass("invf_on");
}
break;


}
});
tbody_cu.forEach(function (fila) {
const td = fila.querySelectorAll("td");


if (td[0].innerText === 'Venta') {

fila.setAttribute("id", td[0].innerText + "_or")
//$(td[0]).addClass("fa fa-eye");
$(td[0]).empty();
$(td[0]).append('Venta');
//$(td[0]).append('Venta<i class="fa fa-eye"></i>   ');
fila.style.cursor = 'pointer';
}
if (td[0].innerText === 'Inv.Inicial') {

fila.setAttribute("id", "Inv_or")
//$(td[0]).addClass("fa fa-eye");
$(td[0]).empty();
$(td[0]).append('Inv.Inicial');
//$(td[0]).append('Inv.Inicial<i class="fa fa-eye"></i>   ');
fila.style.cursor = 'pointer';
}
if (td[0].innerText === 'Inv.Final') {

fila.setAttribute("id", "Invf_or")
//$(td[0]).addClass("fa fa-eye");
$(td[0]).empty();
$(td[0]).append('Inv. Final');
//$(td[0]).append('Inv. Final<i class="fa fa-eye"></i>   ');
fila.style.cursor = 'pointer';
}
if (td[0].innerText === 'Pedidos Navision') {

fila.setAttribute("id", "Ped_or")
//$(td[0]).addClass("fa fa-eye");
// $(td[0]).append('<i class="fa fa-eye"></i>   ');
}
if (td[0].innerText === 'Compra Presupuesto') {

fila.setAttribute("id", "Comp_or")
//$(td[0]).addClass("fa fa-eye");
$(td[0]).empty();
$(td[0]).append('Compra Presupuesto');
//$(td[0]).append('Compra Presupuesto<i class="fa fa-eye"></i>   ');
fila.style.cursor = 'pointer';
}
if (td[0].innerText === 'Recibido') {

fila.setAttribute("id", "Comp_or");
$(td[0]).empty();
$(td[0]).append('Recibido');
// $(td[0]).append('Recibido<i class="fa fa-eye"></i>   ');
fila.style.cursor = 'pointer';

//$(td[0]).addClass("fa fa-eye");
/* $(td[0]).empty();
$(td[0]).append('Compra PPTO<i class="fa fa-eye"></i>   ');*/
//fila.style.cursor = 'pointer';
}
if (td[0].innerText === 'Cubrimiento') {

fila.setAttribute("id", "Cu_or");
//$(td[0]).addClass("fa fa-eye");
/* $(td[0]).empty();
$(td[0]).append('Compra PPTO<i class="fa fa-eye"></i>   ');*/
//fila.style.cursor = 'pointer';
}


switch (td[0].innerText) {
case "$ Venta" :
case  "$ Costo Venta" :
case"Precio Promedio":
case"$ Venta 19":
case"$ Utilidad" :
for (let i = 0; i < td.length; i++) {
$(td[i]).addClass("venta_or");
}
break;

case "$ Inv.Inicial Costo" :
case  "Inv.Inicial 2019" :
for (let i = 0; i < td.length; i++) {
$(td[i]).addClass("inv_or");
}
break;
case "$ Compra" :
case  "Compra 2019" :
for (let i = 0; i < td.length; i++) {
$(td[i]).addClass("comp_or");
}
break;
case  "Compra Real-Ppto" :
for (let i = 0; i < td.length; i++) {
$(td[i]).addClass("comp_rp");
}
break;

case "$ Inv.Final Costo":
for (let i = 0; i < td.length; i++) {
$(td[i]).addClass("invf_or");
}
break;


}
});
/*tbody_cu.forEach(function (fila) {
const td_cu = fila.querySelectorAll("td");


if (td_cu[0].innerText === 'Cubrimiento') {

fila.setAttribute("id", td_cu[0].innerText + "_or")
//$(td_cu[0]).addClass("fa fa-eye");
$(td_cu[0]).empty();
$(td_cu[0]).append('Cubrimiento<i class="fa fa-eye"></i>   ');
fila.style.cursor = 'pointer';
}


switch (td_cu[0].innerText) {

case  "Meses Inv" :
for (let i = 0; i < td_cu.length; i++) {
$(td_cu[i]).addClass("cubrimiento_or");
}
break;
case  "Cubrimiento2":
for (let i = 0; i < td_cu.length; i++) {
$(td_cu[i]).addClass("cubrimiento_or");
}
break;

}
});*/
$('#Venta_on').on('click', function () {
const venta_row = this.querySelectorAll("td")[0];
var etiqueta = venta_row.querySelectorAll("i")[0];

if (etiqueta.className === "fa fa-eye") {
$(etiqueta).removeClass("fa fa-eye");
$(etiqueta).addClass("fa fa-eye-slash");
$('.venta_on').hide();


} else if (etiqueta.className === "fa fa-eye-slash") {

$(etiqueta).removeClass("fa fa-eye-slash");
$(etiqueta).addClass("fa fa-eye");
$('.venta_on').show();
}


});
$('#Inv_on').on('click', function () {
const venta_row = this.querySelectorAll("td")[0];
var etiqueta = venta_row.querySelectorAll("i")[0];


if (etiqueta.className === "fa fa-eye") {
$(etiqueta).removeClass("fa fa-eye");
$(etiqueta).addClass("fa fa-eye-slash");
$('.inv_on').hide();
} else if (etiqueta.className === "fa fa-eye-slash") {
$(etiqueta).removeClass("fa fa-eye-slash");
$(etiqueta).addClass("fa fa-eye");
$('.inv_on').show();
}


});
$('#Comp_on').on('click', function () {
const venta_row = this.querySelectorAll("td")[0];
var etiqueta = venta_row.querySelectorAll("i")[0];


if (etiqueta.className === "fa fa-eye") {
$(etiqueta).removeClass("fa fa-eye");
$(etiqueta).addClass("fa fa-eye-slash");
$('.comp_on').hide();
$('.comp_rp').hide();
} else if (etiqueta.className === "fa fa-eye-slash") {
$(etiqueta).removeClass("fa fa-eye-slash");
$(etiqueta).addClass("fa fa-eye");
$('.comp_on').show();
$('.comp_rp').show();
}


});
$('#Invf_on').on('click', function () {
const venta_row = this.querySelectorAll("td")[0];
var etiqueta = venta_row.querySelectorAll("i")[0];


if (etiqueta.className === "fa fa-eye") {
$(etiqueta).removeClass("fa fa-eye");
$(etiqueta).addClass("fa fa-eye-slash");
$('.invf_on').hide();
} else if (etiqueta.className === "fa fa-eye-slash") {
$(etiqueta).removeClass("fa fa-eye-slash");
$(etiqueta).addClass("fa fa-eye");
$('.invf_on').show();
}


});
/* $('#Venta_or').on('click', function () {
const venta_row = this.querySelectorAll("td")[0];
var etiqueta = venta_row.querySelectorAll("i")[0];

if (etiqueta.className === "fa fa-eye") {
$(etiqueta).removeClass("fa fa-eye");
$(etiqueta).addClass("fa fa-eye-slash");
$('.venta_or').hide();


} else if (etiqueta.className === "fa fa-eye-slash") {

$(etiqueta).removeClass("fa fa-eye-slash");
$(etiqueta).addClass("fa fa-eye");
$('.venta_or').show();
}


});
$('#Inv_or').on('click', function () {
const venta_row = this.querySelectorAll("td")[0];
var etiqueta = venta_row.querySelectorAll("i")[0];


if (etiqueta.className === "fa fa-eye") {
$(etiqueta).removeClass("fa fa-eye");
$(etiqueta).addClass("fa fa-eye-slash");
$('.inv_or').hide();
} else if (etiqueta.className === "fa fa-eye-slash") {
$(etiqueta).removeClass("fa fa-eye-slash");
$(etiqueta).addClass("fa fa-eye");
$('.inv_or').show();
}


});
$('#Comp_or').on('click', function () {
const venta_row = this.querySelectorAll("td")[0];
var etiqueta = venta_row.querySelectorAll("i")[0];


if (etiqueta.className === "fa fa-eye") {
$(etiqueta).removeClass("fa fa-eye");
$(etiqueta).addClass("fa fa-eye-slash");
$('.comp_or').hide();
$('.comp_rp').hide();
} else if (etiqueta.className === "fa fa-eye-slash") {
$(etiqueta).removeClass("fa fa-eye-slash");
$(etiqueta).addClass("fa fa-eye");
$('.comp_or').show();
$('.comp_rp').show();
}


});
$('#Invf_or').on('click', function () {
const venta_row = this.querySelectorAll("td")[0];
var etiqueta = venta_row.querySelectorAll("i")[0];


if (etiqueta.className === "fa fa-eye") {
$(etiqueta).removeClass("fa fa-eye");
$(etiqueta).addClass("fa fa-eye-slash");
$('.invf_or').hide();
} else if (etiqueta.className === "fa fa-eye-slash") {
$(etiqueta).removeClass("fa fa-eye-slash");
$(etiqueta).addClass("fa fa-eye");
$('.invf_or').show();
}


});*/



}



export {taju};