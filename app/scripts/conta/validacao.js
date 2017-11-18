document.title="Contas";
//create-validacoes
$().ready(function() {
	$( "#data_inicio" ).datepicker();
	$( "#data_fim" ).datepicker();
    $("#cadastro_form").validate({
        rules: {
                nome: "required"
        },
        messages: {
                nome: "Informe o nome da conta."
        }
    });

});
function deletar_conta(conta){
    if (confirm('ATENÇÃO! Caso você delete esta conta, todos os lançamentos e transferências relacionados à ela serão apagados.Deseja continuar?')) {
        window.location.href="deletar_conta?codigo="+conta;

    }
    
}
