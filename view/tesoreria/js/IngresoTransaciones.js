$(document).ready(function(){
	
	controlesStart(); // fn que inicia los controles bloqueados para generar primero el lote
	getSecuencialDocumento();
	getTipoDocumento();
	ValidarControles();
	setearFecha();
		
	$("#btnLote").popover({
	    html: true, 
	    placement:"bottom",
		content: function () {		    
		    return popOverHtml();
		}
	});
	
	
})

function controlesStart(){
	
	$("#fecha_transaccion").attr("disabled",true);
	$("#tipo_documento").attr("disabled",true);
	$("#descripcion_transaccion").attr("disabled",true);
	$("#referencia_documento").attr("disabled",true);
	$("#numero_autorizacion").attr("disabled",true);
	$("#valor_total_documento").attr("disabled",true); 
	$("#DistribucionTransaccion").attr("disabled",true);
	$("#AplicarTransaccion").attr("disabled",true); 
	$("#mdlImpuestosRelacionados").attr("disabled",true);
	$("#valor_compra_cero").attr("disabled",true);
	$("#valor_compra_iva").attr("disabled",true);
}

function controlesStartOk(){
	
	$("#tipo_documento").attr("disabled",false);
	$("#descripcion_transaccion").attr("disabled",false);
	$("#referencia_documento").attr("disabled",false);
	$("#numero_autorizacion").attr("disabled",false); 
	$("#monto_base_documento").attr("disabled",false);
	$("#valor_total_documento").attr("disabled",false); 
	$("#DistribucionTransaccion").attr("disabled",false);
	$("#AplicarTransaccion").attr("disabled",false); 
	$("#mdlImpuestosRelacionados").attr("disabled",false);
	$("#valor_compra_cero").attr("disabled",false);
	$("#valor_compra_iva").attr("disabled",false);
}

function setearFecha(){
	
	var fecha = new Date();
	var yearFecha = fecha.getFullYear();
	
	$("#fecha_transaccion").inputmask("datetime",{
		mask: "y-2-1", 
	     placeholder: "yyyy-mm-dd", 
	     leapday: "-02-29", 
	     separator: "-", 
	     clearIncomplete: true,
		 rightAlign: true,		 
		 yearrange: {
				minyear: 1950,
				maxyear: yearFecha
			},
		oncomplete:function(e){
			if( ( new Date( $(this).val() ).getTime() > new Date( fecha ).getTime())){
				$(this).notify("Fecha no puede ser Mayor",{ position:"buttom left", autoHideDelay: 2000});
				$(this).val('')
		    }
		}
	});	
	
}

function ValidarControles(){
	$("#referencia_documento").inputmask({
		mask: "999-999-999999999", 
		placeholder: "_",
		clearIncomplete: true,
		rightAlign: true
	});
}

function getSecuencialDocumento(){
	
	$.ajax({
		url:"index.php?controller=TesCuentasPagar&action=getSecuencialDocumento",
		type:"POST",
		dataType:"json",
		data:null
	}).done( function(x){
		var rsConsecutivos = x.data;
		var filaConsecutivos = rsConsecutivos[0];
		$("#id_consecutivos").val(filaConsecutivos.id_consecutivos);
		$("#secuencial_documento").val(filaConsecutivos.secuencial);
		
	})
}

function getTipoDocumento(){
	
	var $ddlTipoDocumento = $("#tipo_documento");
	$.ajax({
		url:"index.php?controller=TesCuentasPagar&action=getTipoDocumento",
		type:"POST",
		dataType:"json",
		data:null
	}).done( function(x){
		var rsTipoDocumento = x.data;
		$ddlTipoDocumento.empty();
		$ddlTipoDocumento.append("<option value=\"0\">--Seleccione--</option>");
		$.each(rsTipoDocumento,function(index,value){
			$ddlTipoDocumento.append("<option value=\""+value.id_tipo_documento+"\">"+value.nombre_tipo_documento+"</option>");
		})				
	})
}

function popOverHtml(){
	//console.log("ingresa fn devuelve string");
	var $objeto = '<form id="frm_lote" class="form-inline" role="form">'
					+'<div class="form-group">' 
					+'<input type="text" class="" id="nombre_lote"  placeholder="Nombre lote" />'
					+'<button type="button" id="btnLote" class="btn btn-primary btn-xs" onclick="popGeneraLote()">Registrar</button>'
					+'</div>'
					+'</form>';
	return $objeto;
}

function popGeneraLote(){
	//se toma el input que forma dentro popover como se dibuja se crean dos en la vista.
	var $nombre_lote = $('#frm_lote input[id=nombre_lote]');
	console.log($nombre_lote);
	if( $nombre_lote.val() == "" || $nombre_lote.val().length == 0){
		$nombre_lote.notify("Ingrese nombre lote",{position:"buttom-left", autoHideDelay: 2000});
		return false;
	}
	if( $("#id_lote").val() != "" || $("#id_lote").val().length > 0 || $("#id_lote").val() > 0 ){
		$("#btnLote").notify("Lote Generado Revisar",{className:'warn',position:"buttom-left", autoHideDelay: 2000});
		return false;
	}
	$.ajax({
		url:"index.php?controller=TesCuentasPagar&action=RegistrarLote",
		type:"POST",
		dataType:"json",
		data:{nombre_lote:$nombre_lote.val()}
	}).done(function(x){
		if(x.respuesta != undefined){
			if( x.respuesta == "OK" ){
				/** aqui habilitar todos los controles **/
				$("#btnLote").notify("Lote Generado",{className:'success',position:"buttom-left", autoHideDelay: 2000});
				$("#id_lote").val(x.id_lote);
				controlesStartOk();
				$("#txtInicio").text("");
			}else{
				$("#btnLote").notify(x.mensaje,{className:'error',position:"buttom-left", autoHideDelay: 2000});
			}
		}
		$("#btnLote").popover('hide');
	}).fail(function(xhr,status,error){
		console.log(xhr.responseText);
		swal({title:"ERROR",text:"Hemos encontrado un error con el servidor",icon:"error"})<
		$("#btnLote").popover('hide');
	})
}

function loadProveedores(pagina = 1){
	
	var $buscador = $("#mod_buscador_proveedores");
	
	$.ajax({
		url:"index.php?controller=TesCuentasPagar&action=buscaProveedores",
		dataType:"json",
		type:"POST",
		data:{page:pagina,buscador:$buscador.val()}
	}).done(function(x){
		
		var $tabla = $("#mod_tbl_proveedores");
		$tabla.find("tbody").empty();
		$tabla.find("tbody").append(x.filas);
		var $registros = $("#mod_total_proveedores");
		$registros.text(x.cantidadDatos);
		var $divPaginacion = $("#mod_paginacion_proveedores");
		$divPaginacion.html(x.paginacion);		
		
	}).fail(function(xhr,status,eror){
		console.log(xhr.responseText);
	})
	
}

function SelecionarProveedor(element){
	
	var $boton = $(element);
	var $modProveedores = $("#mod_proveedores");
	var $id_proveedor = $boton.val();
	
	$.ajax({
		url:"index.php?controller=TesCuentasPagar&action=SelecionarProveedor",
		type:"POST",
		dataType:"json",
		data:{id_proveedores:$id_proveedor}
	}).done(function(x){
		var rsProveedor = x.data;
		var arrayproveedor = rsProveedor[0];
		$("#id_proveedores").val(arrayproveedor.id_proveedores);
		$("#identificacion_proveedores").val(arrayproveedor.identificacion_proveedores);
		$("#nombre_proveedores").val(arrayproveedor.nombre_proveedores);
		$modProveedores.modal("hide");		
		//$("#id_proveedores").val( rsProveedor[0] )
	}).fail(function(xhr, status, error){
		console.log(xhr.responseText)
	})
	//console.log($buttom.val());
}

function verTablaImpuestos(){
	
	var $baseCompra = $("#monto_base_documento");
	var $modal		= $("#mod_impuestos");
	var $compra_cero	= $("#valor_compra_cero");
	var $compra_iva		= $("#valor_compra_iva");
	
	if( $compra_iva.val() == "" || $compra_iva.val() == null || $compra_iva.val() == undefined || isNaN( parseFloat($compra_iva.val() )) ){
		$modal.modal("hide");
		swal({title:"ERROR",text:"Valor no valido en base compras con iva",icon:"warning"})
		return false;
	}
	
	if( $compra_cero.val() == "" || $compra_cero.val() == null || $compra_cero.val() == undefined || isNaN( parseFloat($compra_cero.val()) ) ){
		$modal.modal("hide");
		swal({title:"ERROR",text:"Valor no valido en base compras sin iva",icon:"warning"})
		return false;
	}
	
	$("#mod_valor_base_documento").text( $baseCompra.val() );
	loadImpuestos();
	$modal.modal("show");
}

function loadImpuestos(pagina = 1){
		
	var $buscador = $("#mod_buscador_impuestos");
	
	$.ajax({
		url:"index.php?controller=TesCuentasPagar&action=buscaImpuestos",
		dataType:"json",
		type:"POST",
		data:{page:pagina,buscador:$buscador.val()}
	}).done(function(x){
		
		var $tabla = $("#mod_tbl_impuestos");
		$tabla.find("tbody").empty();
		$tabla.find("tbody").append(x.filas);
		var $registros = $("#mod_total_impuestos");
		$registros.text(x.cantidadDatos);
		var $divPaginacion = $("#mod_paginacion_impuestos");
		$divPaginacion.html(x.paginacion);		
		
	}).fail(function(xhr,status,eror){
		console.log(xhr.responseText);
	})
}

function AgregarImpuesto(objeto){
	
	var $boton			= $(objeto);
	var pid_lote		= $("#id_lote");
	var pcompra_cero	= $("#valor_compra_cero");
	var pcompra_iva		= $("#valor_compra_iva");
	var pid_impuestos	= $boton.val();
			
	var datos = {id_lote:pid_lote.val(),compra_cero:pcompra_cero.val(), compra_iva:pcompra_iva.val(),id_impuestos:pid_impuestos}
	
	$.ajax({
		url:"index.php?controller=TesCuentasPagar&action=AgregarImpuesto",
		dataType:"json",
		type:"POST",
		data:datos
	}).done(function(x){
		//console.log(x)		
		if( x.respuesta != undefined ){
			
			var resultado = x.respuesta;
			
			if( resultado == 'OK'){
				//aqui poner mensaje que se inserto un impuesto para enviar a listar todo
				$("#cantidad_impuestos_ins").text("+1");
				$("#impuestos_documento").val( x.total_impuesto );
				$("#valor_total_documento").val( x.saldo_impuesto );
			}
			
			swal({ title:"IMPUESTOS",
				text:x.texto,
				icon:x.icon
			});
			
		}
		
	}).fail(function(xhr,status,eror){
		console.log(xhr.responseText);
	})
	
	
}

function verTablaImpuestosRelacionados(){
	
	var $modal		= $("#mod_impuestos_relacionados");
	cargaImpuestos();
	$modal.modal("show");
}

function cargaImpuestos(){
	
	var pid_lote		= $("#id_lote");

	var datos = {id_lote:pid_lote.val()}
	
	$.ajax({
		url:"index.php?controller=TesCuentasPagar&action=CargaImpuestos",
		dataType:"json",
		type:"POST",
		data:datos
	}).done(function(x){
		
		var $tabla = $("#mod_tbl_impuestos_relacionados");
		$tabla.find("tbody").empty();
		$tabla.find("tbody").append(x.filas);
		var $registros = $("#mod_total_impuestos_relacionados");
		$registros.text(x.cantidadDatos);
		var $divPaginacion = $("#mod_paginacion_impuestos_relacionados");
		$divPaginacion.html(x.paginacion);		
		
	}).fail(function(xhr,status,eror){
		console.log(xhr.responseText);
	})
	
}

function RemoveImpuesto(objeto){
	
	var $boton			= $(objeto);
	var pid_lote		= $("#id_lote");
	var pcompra_cero	= $("#valor_compra_cero");
	var pcompra_iva		= $("#valor_compra_iva");
	var pid_impuestos	= $boton.val();
			
	var datos = {id_lote:pid_lote.val(),compra_cero:pcompra_cero.val(), compra_iva:pcompra_iva.val(),id_impuestos:pid_impuestos}
	
	$.ajax({
		url:"index.php?controller=TesCuentasPagar&action=QuitarImpuesto",
		dataType:"json",
		type:"POST",
		data:datos
	}).done(function(x){
		//console.log(x)		
		if( x.respuesta != undefined ){
			
			var resultado = x.respuesta;
			
			if( resultado == 'OK'){
				//aqui poner mensaje que se inserto un impuesto para enviar a listar todo	
				$("#cantidad_impuestos_ins").text("");
				$("#impuestos_documento").val( x.total_impuesto );
				$("#valor_total_documento").val( x.saldo_impuesto );
			}
			
			swal({ title:"IMPUESTOS",
				text:x.texto,
				icon:x.icon
			});
			
		}
		cargaImpuestos();
		
	}).fail(function(xhr,status,eror){
		console.log(xhr.responseText);
	})
	
}

function verDistribucion(){
	
	var pid_lote		= $("#id_lote");
	var pbase_compra	= $("#monto_base_documento");
	var $compra_cero	= $("#valor_compra_cero");
	var $compra_iva		= $("#valor_compra_iva");
	
	if( $compra_iva.val() == "" || $compra_iva.val() == null || $compra_iva.val() == undefined || isNaN( parseFloat($compra_iva.val() )) ){
		$modal.modal("hide");
		swal({title:"ERROR",text:"Valor no valido en base compras con iva",icon:"warning"})
		return false; 
	}
	
	if( $compra_cero.val() == "" || $compra_cero.val() == null || $compra_cero.val() == undefined || isNaN( parseFloat($compra_cero.val()) ) ){
		$modal.modal("hide");
		swal({title:"ERROR",text:"Valor no valido en base compras sin iva",icon:"warning"})
		return false;
	}
	
	var valor_compras = parseFloat($compra_cero.val()) + parseFloat($compra_iva.val()) ;
	$("#hd_valor_base_compra").val(valor_compras);
	var datos = {id_lote:pid_lote.val(),base_compras:valor_compras}
	
	$.ajax({
		url:"index.php?controller=TesCuentasPagar&action=DistribucionTransaccionCompras",
		dataType:"json",
		type:"POST",
		data:datos
	}).done(function(x){
		if(x.estatus != undefined ){
			if(x.estatus == 'OK'){
				cargaDistribucion();
				/**<!-- se activa el modal -->**/
				$("#mod_distribucion").modal("show");
			}
		}
	}).fail(function(xhr,status,eror){
		console.log(xhr.responseText);
	})
	
}

function cargaDistribucion(){
	
	var pid_lote		= $("#id_lote");
				
	var datos = {id_lote:pid_lote.val()}
	
	$.ajax({
		url:"index.php?controller=TesCuentasPagar&action=cargaDistribucion",
		dataType:"json",
		type:"POST",
		data:datos
	}).done(function(x){
		
		var $tabla = $("#mod_tbl_distribucion");
		$tabla.find("tbody").empty();
		$tabla.find("tbody").append(x.filas);
		var $registros = $("#mod_total_distribucion");
		$registros.text(x.cantidadDatos);
		/*var $divPaginacion = $("#mod_paginacion_distribucion");
		$divPaginacion.html(x.paginacion);	*/
				
	}).fail(function(xhr,status,eror){
		console.log(xhr.responseText);
	})
}

function AceptarDistribucion(){
	
	let divPadre = $("#mod_tbl_distribucion");	
	let filas = divPadre.find("tbody > tr ");	
	let data = [];	
	let error = true;
	
	filas.each(function(){
		
		var _id_distribucion	= $(this).attr("id").split('_')[1],
			_desc_distribucion	= $(this).find("input:text[name='mod_dis_referencia']").val(),
			_id_plan_cuentas 	= $(this).find("input:hidden[name='mod_dis_id_plan_cuentas']").val();

		item = {};
	
		if(!isNaN(_id_distribucion)){
		
	        item ["id_distribucion"] 		= _id_distribucion;
	        item ["referencia_distribucion"]= _desc_distribucion;
	        item ['id_plan_cuentas'] 		= _id_plan_cuentas;
	        
	        data.push(item);
		}else{			
			error = false; return false;
		}
		
		if(isNaN(_id_plan_cuentas) || _id_plan_cuentas.length == 0 ){
			divPadre.notify("Cuentas Faltantes",{ position:"top center"});
			error = false; return false;
		}
				
	})
	
	//para validar la referencia en la tabla
	$("input:text[name='mod_dis_referencia']").each(function(){
	    if( $(this).val() == "" ){
	    	divPadre.notify("Digite una Referencia",{ position:"top center"});
	    	error = false; return false;
	    }
	})
		
	// validar datos antes de enviar al controlador
	
	if(!error){	return false;}
	
	parametros 	= new FormData();
	arrayDatos 	= JSON.stringify(data); 
	parametros.append('lista_distribucion', arrayDatos);
 
	$.ajax({
		data: parametros,
		type: 'POST',
		url : "index.php?controller=TesCuentasPagar&action=InsertaDistribucion",
		processData: false, 
		contentType: false,
		dataType: "json"
	}).done(function(a){
		
		if(a.respuesta){
			
			 $("#mod_distribucion").modal('hide');
			//ocultar modal padre
			 swal({text: "Distribucion Realizada",
		  		  icon: "success",
		  		  button: "Aceptar",
		  		});
		}
		
	}).fail(function(xhr, status, error){
		
		var err = xhr.responseText		
		console.log(err)
		
	})
	
	
}

function IngresarTransaccion(){
	
	if( $("#id_lote").val().length == 0 && !isNaN( $("#id_lote").val() ) ){
		$("#btnLote").notify("Debe ingresar el lote",{position:"button"});
		$("html, body").animate({ scrollTop: $(nombre_lote).offset().top-120 }, 1000);
		return false;
	}
	
	/** COMIENZA VALIDACION DE FORMULARIO  campos input**/
	if( $("#tipo_documento").val() == 0 ){ $("html, body").animate({ scrollTop: $(tipo_documento).offset().top-120 }, 1000); $("#tipo_documento").notify("Seleccione Tipo Documento",{position:"button",autoHideDelay: 2000}); return false;}
	if( $("#descripcion_transaccion").val() == "" ){ $("html, body").animate({ scrollTop: $(descripcion_transaccion).offset().top-120 }, 1000); $("#descripcion_transaccion").notify("Ingrese una Descripcion",{position:"button",autoHideDelay: 2000}); return false;}
	if( $("#id_proveedores").val() == "" ){ $("html, body").animate({ scrollTop: $(identificacion_proveedores).offset().top-120 }, 1000); $("#identificacion_proveedores").notify("Seleccione un Proveedor",{position:"button",autoHideDelay: 2000}); return false;}
	if( $("#referencia_documento").val() == "" ){ $("html, body").animate({ scrollTop: $(referencia_documento).offset().top-120 }, 1000); $("#referencia_documento").notify("Digite Referencia Documento",{position:"button",autoHideDelay: 2000}); return false;}
	if( $("#numero_autorizacion").val() == "" ){ $("html, body").animate({ scrollTop: $(numero_autorizacion).offset().top-120 }, 1000); $("#numero_autorizacion").notify("Digite numero autorizacion",{position:"button",autoHideDelay: 2000}); return false;}	
	//if( $("#numero_autorizacion").val() == "" ){ $("html, body").animate({ scrollTop: $(numero_autorizacion).offset().top-120 }, 1000); $("#numero_autorizacion").notify("Digite numero autorizacion",{position:"button",autoHideDelay: 2000}); return false;}
	var $compra_cero	= $("#valor_compra_cero");
	var $compra_iva		= $("#valor_compra_iva");	
	if( $compra_iva.val() == "" || $compra_iva.val() == null || $compra_iva.val() == undefined || isNaN( parseFloat($compra_iva.val() )) ){
		$modal.modal("hide");
		swal({title:"ERROR",text:"Valor no valido en base compras con iva",icon:"warning"})
		return false; 
	}
	
	if( $compra_cero.val() == "" || $compra_cero.val() == null || $compra_cero.val() == undefined || isNaN( parseFloat($compra_cero.val()) ) ){
		$modal.modal("hide");
		swal({title:"ERROR",text:"Valor no valido en base compras sin iva",icon:"warning"})
		return false;
	}
	var monto_base_compra = parseFloat($compra_cero.val()) + parseFloat($compra_iva.val());
	/** COMIENZA VALIDACION DE FORMULARIO **/
	
	/** VALIDACION DE VALOR DE COMPRAS **/
	if( $("#hd_valor_base_compra").val() != monto_base_compra ){
		swal({text:" Distribucion No realizada ó los valores de compra han cambiado \n Verificar valores",title:"Error Valores",icon:"warning"});
		return false;
	}
	/** TERMINA VALIDACION DE VALOR DE COMPRAS **/
	
	var chkMateriales	= ( $("#compra_materiales").is(":checked") ) ? "1" : "0";
		
	var datos = {
			id_lote: $("#id_lote").val(),
			id_consecutivo: $("#id_consecutivos").val(),
			id_cuentas_pagar:0,
			id_tipo_documento: $("#tipo_documento").val(),
			id_proveedor: $("#id_proveedores").val(),
			descripcion_cuentas_pagar:$("#descripcion_transaccion").val(),
			fecha_cuentas_pagar:$("#fecha_transaccion").val(),
			numero_documento:$("#referencia_documento").val(),
			monto_cuentas_pagar:monto_base_compra,
			impuesto_cuentas_pagar:$("#impuestos_documento").val(),
			total_cuentas_pagar:$("#valor_total_documento").val(),
			compra_materiales: chkMateriales,
			monto_compra_cero: $compra_cero.val(),
			monto_compra_iva: $compra_iva.val(),
	}
	
	$.ajax({
		beforeSend:null,
		url:"index.php?controller=TesCuentasPagar&action=InsertaTransaccion",
		type:"POST",
		dataType:"json",
		data:datos
	}).done(function(x){
		
		if( x.estatus != undefined ){
			
			if( x.estatus == "OK"){
				var stext = x.mensaje;
				if(x.xml != ""){
					stext += x.xml;
				}
				//swal({title:"TRANSACCION OK",text:stext,icon:"success"}).then( isValidate => { if(isValidate){ setTimeout(function(){location.reload();},2000); } } );
				swal({title:"TRANSACCION OK",text:stext,icon:"success"}).then( isValidate => { if(isValidate){  } } );
								
			}else{
				swal({title:"ERROR TRANSACCION",text:"REVISAR DATOS ENVIADOS \n"+x.mensaje,icon:"error"});
			}
		}
		
		
	}).fail(function(xhr,status,error){
		
		let err = xhr.responseText		
		console.log(err);
		if (err.includes("Warning") || err.includes("Notice") || err.includes("Error")){			
			swal({
		  		  title: "CUENTAS PAGAR",
		  		  text: "Error al Ingresar Transaccion",
		  		  icon: "error",
		  		  button: "Aceptar",
		  		});
					
		}
	})
	
	
}


/**** FUNCIONES QUE SE EJECUTAN EN EL INTERIOR DE LA VIEW ***/

/***
 * @desc fn que permite generar autocomplete en input con determinada clase
 * @param e
 * @returns
 */
$("#mod_tbl_distribucion").on("focus","input.distribucion.distribucion_autocomplete[type=text]",function(e) {
	
	let _elemento = $(this);
	
    if ( !_elemento.data("autocomplete") ) {
    	    	
    	_elemento.autocomplete({
    		minLength: 3,    	    
    		source:function (request, response) {
    			$.ajax({
    				url:"index.php?controller=CuentasPagar&action=autompletePlanCuentas",
    				dataType:"json",
    				type:"GET",
    				data:{term:request.term},
    			}).done(function(x){
    				
    				response(x); 
    				
    			}).fail(function(xhr,status,error){
    				var err = xhr.responseText
    				console.log(err)
    			})
    		},
    		select: function (event, ui) {
     	       	// Set selection
    			let fila = _elemento.closest("tr");
    			let in_nombre_plan_cuentas = fila.find("input:text[name='mod_dis_nombre']")
    			let in_id_plan_cuentas = fila.find("input:hidden[name='mod_dis_id_plan_cuentas']")
    			let in_codigo_plan_cuentas = fila.find("input:text[name='mod_dis_codigo']")
    			
    			if(ui.item.id == ''){
    				 _elemento.closest("table").notify("Digite Cod. Cuenta Valido",{ position:"top center"});
    				 in_nombre_plan_cuentas.val('');
    	    		 in_codigo_plan_cuentas.val('');
    	    		 in_id_plan_cuentas.val('');
    				 return;
    			}
    			
    			in_nombre_plan_cuentas.val(ui.item.nombre);
    			in_codigo_plan_cuentas.val(ui.item.value);
    			in_id_plan_cuentas.val(ui.item.id);
    			     	     
     	    },
     	   appendTo: "#mod_distribucion",
     	   change: function(event,ui){
     		   
     		   if(ui.item == null){
     			   
     			 _elemento.closest("tr").find("input:hidden[name='mod_dis_id_plan_cuentas']").val("");
     			 _elemento.closest("table").notify("Digite Cod. Cuenta Valido",{ position:"top center"});
     			_elemento.val('');
     			let fila = _elemento.closest("tr");
    			fila.find("input:text[name='mod_dis_nombre']").val('');
    			fila.find("input:hidden[name='mod_dis_id_plan_cuentas']").val('')
     			 
     		   }
     	   }
    	
    	}).focusout(function() {
    		
    	})
    }
    
})

/***
 * @desc auto funcion que se genera con el evento key up hace una copia de un input y lo pone en los demas con la misma clase
 * @returns
 */
$("#mod_tbl_distribucion").on("keyup","input:text[name='mod_dis_referencia']",function(){
		
	let valorPrincipal = $(this).val();
	
	$("input:text[name='mod_dis_referencia']").each(function(index,value){		
		$(this).val(valorPrincipal);
	})
	
})

/***
 * fn para igualar el valor de totales
 */
function pasarTotal(){
	var valor_cero_compra	= ( isNaN( parseFloat( $("#valor_compra_cero").val() ) ) ) ? 0.00 : parseFloat( $("#valor_compra_cero").val() );
	var valor_iva_compra	= ( isNaN( parseFloat( $("#valor_compra_iva").val() ) ) )  ? 0.00 : parseFloat( $("#valor_compra_iva").val() ); 
	var monto_compra		= valor_cero_compra + valor_iva_compra;
	//console.log('valor en cero '+valor_cero_compra+' , valor con iva '+valor_iva_compra+' , es igual a '+monto_compra+ ' \n');
	$("#valor_total_documento").val(monto_compra);
}


