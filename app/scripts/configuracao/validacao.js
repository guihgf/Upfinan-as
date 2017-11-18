$().ready(function() {
	document.title="Configurações";
    $("#senha_form").validate({
            rules: {
                    senha: {
                            required: true,
                            minlength: 5
                    },
                    confirmar_senha: {

                            required: true,
                            minlength: 5,
                            equalTo: "#senha"
                    }
            },
            messages: {
                    senha: {
                            required: "Informe a senha.",
                            minlength: "Sua senha precisa ter ao menos 5 caracteres."
                    },
                    confirmar_senha: {
                            required: "Confirme a senha.",
                            minlength: "Sua senha precisa ter ao menos 5 caracteres.",
                            equalTo: "Senhas não são iguais."
                    }
            }
    }),
	$("#cancelar_form").validate({
            rules: {
                    motivo: {
                            required: true,
                            minlength: 5
                    }
            },
            messages: {
                    motivo: {
                            required: "Informe o motivo do cancelamento.",
                            minlength: "O motivo deve ter no minimo 5 caracteres."
                    }
            }
    });
});