Alpine.data("tablesUsers",()=>({closeModal(e){e().userName=null,e().userEmail=null,e().userPhoneNumber=null,e().userPassword=null,e().userEngineerLocation=!1,e().userEngineerAdmin=!1,e().set("userIdEdit",null),e().modalAdd=!1},deleteUser(e,n,l,s){this.$store.dialog.show(`Excluir ${n}`,`Você realmente deseja excluir o ${n} "${l}"?`,{cancel:{},confirm:{text:"Sim, excluir!",action:()=>s().delUser(e)}})},setFormEdit(e,n){n().userName=e.name,n().userEmail=e.email,n().userPhoneNumber=e.phone_number,n().userEngineerLocation=e.engineer_location,n().userEngineerAdmin=e.engineer_admin,n().set("userIdEdit",e.id),n().modalAdd=!0}}));
