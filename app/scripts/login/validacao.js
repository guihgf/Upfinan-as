var res;
document.title="Up Finanças - O seu novo controle financeiro!";

$.validator.addMethod('captcha',
    function(value) {
        $result = ( parseInt($('#num1').val()) + parseInt($('#num2').val()) == parseInt($('#captcha').val()) ) ;
        $('#spambot').fadeOut('fast');
         return $result;
    },
    'Valor incorreto, tente novamente.'
);

$.validator.addMethod('verificar_email',
    function(value) {
        $.ajax({
            url: 'verificar_email?email=' + value,
            type: 'get',
            dataType: 'html',
            async: false,
            success: function(data) {
                res = data;
            } 
        });
        
        if(res=='ok'){
            return true;
        }
        else
        {
            return false;
        }
        
    },
    'E-mail já cadastrado.'
);

$().ready(function() {
    $("#recuperar_senha").on('click',function(){
        if ($("#email").val()==""){
          alert("Informe o seu e-mail");
          $("#email").focus();
        }
        else
        {
          window.location.assign("recuperar_senha?email="+$("#email").val());

        }
    });
    $("#login_form").validate({
       rules:{
           email:{
               required:true,
               email:true
           },
           senha:"required"
       },
       messages:{
           email:{
               required:"Digite o e-mail.",
               email:"Digite um e-mail válido."
           },
           senha: "Digite a senha."
       }
    }),	
    $("#cadastro_form").validate({
            rules: {
                    nome: "required",
                    sobre_nome: "required",
                    email: {
                        required: true,
                        email: true,
                        verificar_email:true
                    },
                    confirmar_email:{
                        required:true,
                        email:true,
                        equalTo:"#email"
                    },
                    senha: {
                            required: true,
                            minlength: 5
                    },
                    confirmar_senha:{
                        required:true,
                        equalTo:"#senha"
                    },
                    captcha: {
                    required: true,
                    captcha: true
                    }
            },
            messages: {
                    nome: "Informe o seu nome.",
                    sobre_nome: "Informe o seu sobrenome.",
                    senha: {
                            required: "Informe a senha.",
                            minlength: "Sua senha precisa ter ao menos 5 caracteres."
                    },
                    confirmar_senha: {
                            required: "Confirme a senha.",
                            minlength: "Sua senha precisa ter ao menos 5 caracteres.",
                            equalTo: "Senhas não são iguais."
                    },
                    email:{
                        required:"Informe o e-mail",
                        email:"Por favor informe um e-mail válido."
                    },
                    confirmar_email:{
                        email:"Por favor informe um e-mail válido.",
                        required:"Confirme o e-mail.",
                        equalTo: "E-mails não são iguais."
                    },
                    captcha:{
                        required: "Informe a soma."
                    }
            }
    });
});