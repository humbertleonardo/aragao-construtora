Alpine.data("obrasPage",()=>({closeModal(d){d().inputsAdd.nome=null,d().inputsAdd.dt_inicio=null,d().inputsAdd.dt_termino=null,d().inputsAdd.dt_previsao_termino=null,d().inputsAdd.endereco_rua=null,d().inputsAdd.endereco_bairro=null,d().inputsAdd.endereco_numero=null,d().inputsAdd.endereco_cidade=null,d().inputsAdd.endereco_uf=null,d().inputsAdd.endereco_cep=null,d().inputsAdd.tipo_recurso=null,d().inputsAdd.descricao_completa=null,d().obraIdEdit=null,d().modal=!1},deleteObra(d,e){this.$store.dialog.show("Excluir obra",`Você realmente deseja excluir a obra "${d.nome}"?`,{cancel:{},confirm:{text:"Sim, excluir!",action:()=>e().delObra(d.id)}})},setEditModal(d,e){e().inputsAdd.nome=d.nome,e().inputsAdd.dt_inicio=d.dt_inicio,e().inputsAdd.dt_termino=d.dt_termino,e().inputsAdd.dt_previsao_termino=d.dt_previsao_termino,e().inputsAdd.endereco_rua=d.endereco_rua,e().inputsAdd.endereco_bairro=d.endereco_bairro,e().inputsAdd.endereco_numero=d.endereco_numero,e().inputsAdd.endereco_cidade=d.endereco_cidade,e().inputsAdd.endereco_uf=d.endereco_uf,e().inputsAdd.endereco_cep=d.endereco_cep,e().inputsAdd.tipo_recurso=d.tipo_recurso,e().inputsAdd.descricao_completa=d.descricao_completa,e().obraIdEdit=d.id,e().modal=!0}}));
