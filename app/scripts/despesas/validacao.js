document.title="Despesas";
//index-botoes

$('#busca_contas').val(0);

$.validator.setDefaults({ ignore: ":hidden:not(select)" })

$.validator.addMethod('data_pagamento',
    function(value) {
        if($("#pago").val()=="S"){
        	if($("#data_pagamento").val()!="" ){
				return true;
			}
			else
			{
				return false;
			}
        	
        }
        else
        {
        	return true;
        }
    },
    'Informe a data de pagamento.'
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
	$('#pago').on('change', function() {
       if ($('#pago').val()=="N"){
            $("#data_pagamento").val("");
       }
       else{
           var data=$("#data_vencimento").val();
           $("#data_pagamento").val(data);
       }

    });


   

	$( "#data_vencimento" ).datepicker();
	$( "#data_pagamento" ).datepicker();
    $("#cadastro_form").validate({
        rules: {
                nome: "required",
				parcelas: "required",
                data_vencimento:"required",
                valor:"required",
                tipo_pagamento:"required",
                busca_grupos:"required",
                data_pagamento:{
                	data_pagamento:true
                }
         
        },
        messages: {
                nome: "Informe o nome do lançamento",
                data_vencimento:"Informe uma data", 
                valor:"Informe o valor do lançamento",
				parcelas:"Informe número",
				tipo_pagamento:"Informe um tipo de pagamento",
				busca_grupos:"Informe um grupo de despesa"
        }
    });
});





