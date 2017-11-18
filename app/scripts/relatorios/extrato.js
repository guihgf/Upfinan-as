document.title="Extrato geral por conta";

$( "#data_ini" ).datepicker();
$( "#data_fim" ).datepicker();

$('#periodo').on('change', function() {
  var data = new Date();
  data.setDate(data.getDate()-$('#periodo').val()); 
  $("#data_ini").datepicker('setDate', data);
});

$('#processar_relatorio').on('click',function(){
    window.open("extrato_pdf?conta="+$("#busca_contas").val()+'&data_ini='+$("#data_ini").val()+'&data_fim='+$("#data_fim").val()+'&conta_desc='+$("#busca_contas").find(":selected").text());
});


