document.title="Grupos de receitas";

//create-validacoes
$().ready(function() {
    $("#cadastro_form").validate({
        rules: {
                nome: "required"
        },
        messages: {
                nome: "Informe o nome do grupo de receita."
        }
    });
});

function deletar_grupo(grupo){
    if (confirm('ATENÇÃO! Caso você delete este grupo, todas as receitas relacionadas à ele serão apagados.Deseja continuar?')) {
        window.location.href="deletar_grupos_receitas?codigo="+grupo;

    }
    
}
