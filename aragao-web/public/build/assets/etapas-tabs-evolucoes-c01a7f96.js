Alpine.data("etapasTabEvolucoes",()=>({infoEvolucao:null,modalInfoEvolucao:!1,modalImageSrc:null,modalImage:null,carregarImagens(){this.infoEvolucao.imagens.map(o=>axios.get("/home/imagens/arquivo/"+o.id).then(e=>(e.data&&e.data.url&&(o.url=e.data.url),o)).catch(e=>(console.error("Erro ao carregar a URL da imagem:",e),o))).forEach(o=>{o.then(e=>{const l=this.infoEvolucao.imagens.findIndex(i=>i.id===e.id);l!==-1&&(this.infoEvolucao.imagens[l]=e)})})},setInfoEvolucao(a){this.infoEvolucao=a,this.modalInfoEvolucao=!0,this.carregarImagens()},setModalImage(a){this.modalImageSrc=a,this.modalImage=!0},closeModal(a){a().inputs.id_etapa=null,a().inputs.dt_evolucao=null,a().inputs.descricao=null,a().inputsImages=[],this.infoEvolucao=null,a().editId=null,a().modal=!1},setEditModal(a,o){o().inputs.id_etapa=a.id_etapa,o().inputs.dt_evolucao=a.dt_evolucao,o().inputs.descricao=a.descricao,this.infoEvolucao=a,o().editId=a.id,o().modal=!0,this.carregarImagens()},exclurEvolucao(a,o){this.$store.dialog.show("Excluir evolução","Você realmente deseja excluir essa evolução?",{cancel:{},confirm:{text:"Sim, excluir!",action:()=>o().excluirEvolucao(a.id)}})},exclurImagem(a,o){this.$store.dialog.show("Excluir imagem","Você realmente deseja excluir essa imagem?",{cancel:{},confirm:{text:"Sim, excluir!",action:()=>o().excluirImagem(a)}})}}));
