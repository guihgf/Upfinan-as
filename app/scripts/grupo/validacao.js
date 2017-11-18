document.title="Grupos de despesas";

//create-validacoes
$().ready(function() {
    $("#cadastro_form").validate({
        rules: {
                nome: "required"
        },
        messages: {
                nome: "Informe o nome do grupo de despesa."
        }
    });
});

function deletar_grupo(grupo){
    if (confirm('ATENÇÃO! Caso você delete este grupo, todas as despesas relacionadas à ele serão apagados.Deseja continuar?')) {
        window.location.href="deletar_grupos_despesas?codigo="+grupo;

    }
    
}
