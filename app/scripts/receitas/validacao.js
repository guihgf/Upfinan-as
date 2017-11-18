document.title="Receitas";
//index-botoes

$('#busca_contas').val(0);

$.validator.setDefaults({ ignore: ":hidden:not(select)" })


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

	$("#data_credito" ).datepicker();
    $("#cadastro_form").validate({
        rules: {
                nome: "required",
                data_credito:"required",
                valor:"required",
                tipo_pagamento:"required",
                busca_grupos:"required",
         
        },
        messages: {
                nome: "Informe o nome do lançamento",
                data_credito:"Informe uma data", 
                valor:"Informe o valor do lançamento",
				tipo_pagamento:"Informe um tipo de pagamento",
				busca_grupos:"Informe um grupo de receita"
        }
    });
});





