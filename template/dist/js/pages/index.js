function dadosValidos() {  
    var retorno = true;
    if ($('#name').val() == '') {
      $('#name').addClass('invalido');
      retorno = false;
    }else {
      $('#name').removeClass('name');
    }

    if ($('#itilcategories_id').val() == '') {
      $('#itilcategories_id').addClass('invalido');
      retorno = false;
    }else {
      $('#itilcategories_id').removeClass('itilcategories_id');
    }

    if ($('#content').val() == '') {
      $('#content').addClass('invalido');
      retorno = false;
    }else {
      $('#content').removeClass('content');
    }

    return retorno;
  }

  $('#criarOs').submit(function(e){
    e.preventDefault();    

      if(dadosValidos()){
        $('#spinner').show();
        let status = document.getElementById('status').value;
        let requesttypes_id = document.getElementById('requesttypes_id').value;
        let urgency = document.getElementById('urgency').value;
        let impact = document.getElementById('impact').value;
        let priority = document.getElementById('priority').value;
        let type = document.getElementById('type').value;
        let global_validation = document.getElementById('global_validation').value;
        let users_id_recipient = document.getElementById('users_id_recipient').value;
        let name = document.getElementById('name').value;
        let itilcategories_id = document.getElementById('itilcategories_id').value;
        let content = document.getElementById('content').value;
        let base_url = document.getElementById('base_url').value;

        var url = base_url+'tickets/criarTicket';
        $.ajax({
            url : url,
            type:"post",
            data:new FormData(this),
            processData:false,
            contentType:false,
            cache:false,
            async:false,
            success : function(retorno){
              $('#spinner').hide();
              var ret = JSON.parse(retorno);

              if(ret.retorno == "ok"){
                        swal({
                            title: "Sucesso",
                            text: "Ticket criado com sucesso!",
                            type: "success",
                            onClose: () => {
                                document.location.reload(true);
                            }
                        });
              }else{
                swal({
                      title: "Error",
                      text: "Nenhum processo realizado. Tente novamente !",
                      type: "error",
                      onClose: () => {
                          $.fancybox.close();
                          document.location.reload(true);
                      }
                  });
              }
                  
            },
            error : function(retorno){
              $('#spinner').hide();
            }
          });

      }else{
        $('#spinner').hide();
        swal({
                title: "Erro",
                text: "Verifique os campos e tente novamente!",
                type: "error",
                onClose: () => {
                    $.fancybox.close();
                    document.location.reload(true);
                }
            });
      } 
      
   });


   $('#pesquisar').click(function (event) {

      // $("#loader").show();
      $("#chamados").hide();
      $("#msgChamados").hide();
      var base_url = document.getElementById('base_url').value;
      var data = new FormData();	
      data.append('statusCad', document.getElementById('statusCad').value); 

   })