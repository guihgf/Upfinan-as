document.title="Participantes";

//create-validacoes
$().ready(function() {
    $("#cadastro_form").validate({
        rules: {
                nome: "required",
                email: {
                    email: true
                },
				telefone:{
					number:true
				},
				celular:{
					number:true
				}
        },
        messages: {
                nome: "Informe o nome do participante.",
                email:{
                    email:"Por favor informe um e-mail válido."
                },
				telefone:{
					number:"Informe apena números"},
				celular:{
					number:"Informe apenas números"}
				
        }
    });
});

function deletar_participante(participante){
    if (confirm('ATENÇÃO! Caso você delete este participante, todos os lançamentos relacionados à ele serão apagados.Deseja continuar?')) {
        window.location.href="deletar_participante?codigo="+participante;

    }
    
}
