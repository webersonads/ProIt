
$('#btn-atualizar').click(function (event) {
    $("#loader").show();
    var base_url = document.getElementById('base_url').value;
    var data = new FormData();	
      data.append('logo', document.getElementById('logo').files[0]); 
      data.append('backgroundfile', document.getElementById('backgroundfile').files[0]); 
      data.append('nome', document.getElementById('nome').value); 
      data.append('telefone', document.getElementById('telefone').value); 
      data.append('email', document.getElementById('email').value); 
      data.append('menu_lateral', document.getElementById('menu_lateral').value); 
      data.append('cor_menu_superior', document.getElementById('cor_menu_superior').value); 
      data.append('cor_menus_internos', document.getElementById('cor_menus_internos').value); 
      data.append('cor_texto', document.getElementById('cor_texto').value); 
      data.append('cor_btn_primario', document.getElementById('cor_btn_primario').value); 
      data.append('cor_btn_info', document.getElementById('cor_btn_info').value); 
      data.append('cor_btn_warning', document.getElementById('cor_btn_warning').value); 
      data.append('cor_btn_danger', document.getElementById('cor_btn_danger').value); 
      
      $.ajax({ 	
          url : base_url+'configuracoes/editar', 
          type : 'POST',
          data : data,
          processData: false, 
          contentType: false, 
          success : function(data) {
            $("#loader").hide();
            $("#alertSuccess").show();

            window.setTimeout(() => {
                location.reload();
             }, 3600);
          
             }
      });
  });