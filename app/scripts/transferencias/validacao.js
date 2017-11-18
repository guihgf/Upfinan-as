document.title="Transferências";
//index-botoes

$.validator.setDefaults({ ignore: ":hidden:not(select)" })

$.validator.addMethod('transferencias',
    function(value) {
        if($("#contade option:selected" ).val()==$("#contapara option:selected").val())
        {
        	return false;	
        }
        else
        {
        	return true;
        }
    },
    'Você não pode informar a mesma conta.'
);

function desmascararValor(){
    $('#valor').priceFormat({
        prefix: '',
        thousandsSeparator: ''
    });
}

 $('#valor').priceFormat({
    prefix: 'R$ ',
    centsSeparator: ',',
    thousandsSeparator: '.'
});

$().ready(function() {
	  

	$( "#data_transferencia" ).datepicker();
    $("#cadastro_form").validate({
        rules: {
                data_transferencia:"required",
                valor:"required",
                contapara:{
                	transferencias:true
                }
         
        },
        messages: {
                valor:"Informe o valor da transferência",
				data_transferencia:"Informe a data de transferência"
        }
    });
});





