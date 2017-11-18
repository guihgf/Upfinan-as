document.title="Tipos de pagamento";
//create-validacoes
$().ready(function() {
    $("#cadastro_form").validate({
        rules: {
                nome: "required"
        },
        messages: {
                nome: "Informe o nome do tipo de pagamento.",
        }
    });
});

function deletar_tipos_pagamentos(tipo_pagamento){
    if (confirm('ATENÇÃO! Caso você delete este tipo de pagamento, todos os lançamentos relacionados à ele serão apagados.Deseja continuar?')) {
        window.location.href="deletar_tipo_pagamento?codigo="+tipo_pagamento;

    }
    
}