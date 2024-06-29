import{_ as g}from"./AuthenticatedLayout-BSqVuLaM.js";import{_ as v}from"./UserTable-CCSOguPg.js";import{o as i,c as r,b as s,f as h,v as u,t as p,e as a,g as d,F as m,r as f,j as k,a as c,u as w,w as b,Z as $,d as _}from"./app-BsPAEwDl.js";import{_ as M}from"./RoleTable-CZeJGn56.js";import{_ as S}from"./PermissionTable-C3QD9aOS.js";import"./ApplicationLogo-DinvSiH0.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./Pagination-DSNaiyZe.js";const C={class:"form-floating mb-3"},F=s("label",{for:"user-title"},"Имя пользователя",-1),U={class:"form-floating mb-3"},P=s("label",{for:"user-email"},"Почта пользователя",-1),D={class:"form-floating mb-3"},V=s("label",{for:"user-password"},"Пароль",-1),j={class:"row"},B={class:"col-12"},L={class:"input-group"},N={key:0,class:"form-control rounded-0 border-secondary"},R={key:1,class:"form-control rounded-0 border-secondary"},T=s("label",{for:"client-user_id"},"Роль",-1),E=s("i",{class:"fa-solid fa-ban"},null,-1),O=[E],I={class:"row mt-3"},q={class:"col-12 mb-3"},J=s("i",{class:"fa-solid fa-plus mr-1"},null,-1),Z={class:"col-md-4 col-12 mb-3"},z={class:"input-group"},A={class:"form-floating"},G={key:0,class:"form-control rounded-0 border-secondary"},H={key:1,class:"form-control rounded-0 border-secondary"},K=s("label",{for:"client-user_id"},"Разрешение",-1),Q=["onClick"],W=s("i",{class:"fa-solid fa-ban"},null,-1),X=[W],Y={class:"row"},x={class:"col-12"},ss={class:"alert alert-danger alert-dismissible fade show",role:"alert"},es=s("strong",null,"Внимание!",-1),os=["onClick"],ts={class:"row mt-5"},ls={class:"col-12 d-flex justify-content-center"},is=["disabled"],rs={key:0,class:"fa-regular fa-floppy-disk mr-1"},ns={key:1,class:"spinner-border spinner-border-sm text-success",role:"status"},as=s("i",{class:"fa-solid fa-xmark mr-1"},null,-1),ds={class:"modal fade",id:"search-roles",tabindex:"-1","aria-labelledby":"exampleModalLabel","aria-hidden":"true"},ms={class:"modal-dialog modal-lg"},cs={class:"modal-content rounded-0 border-secondary"},hs=s("div",{class:"modal-header"},[s("h1",{class:"modal-title fs-5",id:"exampleModalLabel"},"Поиск роли"),s("button",{type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close"})],-1),us={class:"modal-body 0"},ps=s("div",{class:"modal-footer"},[s("button",{type:"button",class:"btn btn-outline-secondary rounded-0 border-secondary","data-bs-dismiss":"modal"},"Закрыть ")],-1),fs={class:"modal fade",id:"search-permissions",tabindex:"-1","aria-labelledby":"exampleModalLabel","aria-hidden":"true"},bs={class:"modal-dialog modal-lg"},_s={class:"modal-content rounded-0 border-secondary"},ys=s("div",{class:"modal-header"},[s("h1",{class:"modal-title fs-5",id:"exampleModalLabel"},"Поиск разрешения"),s("button",{type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close"})],-1),gs={class:"modal-body 0"},vs=s("div",{class:"modal-footer"},[s("button",{type:"button",class:"btn btn-outline-secondary rounded-0 border-secondary","data-bs-dismiss":"modal"},"Закрыть ")],-1),ks={props:["item"],data(){return{roleSearchModal:null,permissionSearchModal:null,messages:[],loading:!1,form:{id:null,email:null,name:null,password:null,roles:[],permissions:[]}}},computed:{preparedPermissions(){return this.form.permissions.map(t=>t.id)},needClearForm(){return this.form.id||this.form.email||this.form.name||this.form.password||this.form.roles.length>0||this.form.permissions.length>0}},mounted(){this.roleSearchModal=new bootstrap.Modal(document.getElementById("search-roles"),{}),this.permissionSearchModal=new bootstrap.Modal(document.getElementById("search-permissions"),{}),this.item&&this.$nextTick(()=>{this.form={id:this.item.id||null,email:this.item.email||null,name:this.item.name||null,roles:this.item.roles||[],permissions:this.item.permissions||[]}})},methods:{openRoleSearchModal(){this.roleSearchModal.show()},openPermissionsSearchModal(){this.permissionSearchModal.show()},alert(t){this.messages.push(t)},selectRole(t){this.form.roles=[],this.form.roles.push(t),this.roleSearchModal.hide()},removePermission(t){this.form.permissions.splice(t,1),this.$notify({title:"DoDoors",text:"Разрешение успешно удалено",type:"success"})},selectPermissions(t){let e=this.form.permissions.findIndex(o=>o.id===t.id);e===-1?(this.form.permissions.push(t),this.$notify({title:"DoDoors",text:"Разрешение успешно добавлено",type:"success"})):(this.form.permissions.splice(e,1),this.$notify({title:"DoDoors",text:"Разрешение успешно удалено",type:"success"}))},resetForm(){this.form.id=null,this.form.name=null,this.form.email=null,this.form.password=null,this.form.roles=[],this.form.permissions=[],this.$emit("callback")},removeMessage(t){this.messages.splice(t,1)},submit(){let t=new FormData;Object.keys(this.form).forEach(e=>{const o=this.form[e]||"";typeof o=="object"?t.append(e,JSON.stringify(o)):t.append(e,o)}),this.$store.dispatch("storeUser",{userForm:t}).then(e=>{this.$emit("callback"),this.resetForm()}).catch(e=>{})}}},ws=Object.assign(ks,{__name:"UserForm",setup(t){return(e,o)=>(i(),r(m,null,[s("form",{action:"",onSubmit:o[7]||(o[7]=k((...l)=>e.submit&&e.submit(...l),["prevent"]))},[s("div",C,[h(s("input",{type:"text","onUpdate:modelValue":o[0]||(o[0]=l=>e.form.name=l),class:"form-control",id:"user-name",required:""},null,512),[[u,e.form.name]]),F]),s("div",U,[h(s("input",{type:"email","onUpdate:modelValue":o[1]||(o[1]=l=>e.form.email=l),class:"form-control",id:"user-email",required:""},null,512),[[u,e.form.email]]),P]),s("div",D,[h(s("input",{type:"password","onUpdate:modelValue":o[2]||(o[2]=l=>e.form.password=l),class:"form-control",id:"user-password"},null,512),[[u,e.form.password]]),V]),s("div",j,[s("div",B,[s("div",L,[s("div",{class:"form-floating",onClick:o[3]||(o[3]=(...l)=>e.openRoleSearchModal&&e.openRoleSearchModal(...l))},[e.form.roles.length>0?(i(),r("p",N,p(e.form.roles[0].name),1)):(i(),r("p",R,"Не выбрана")),T]),e.form.roles.length>0?(i(),r("button",{key:0,type:"button",class:"btn btn-outline-secondary rounded-0",onClick:o[4]||(o[4]=l=>e.form.roles=[])},O)):a("",!0)])])]),s("div",I,[s("div",q,[s("button",{type:"button",onClick:o[5]||(o[5]=(...l)=>e.openPermissionsSearchModal&&e.openPermissionsSearchModal(...l)),class:"btn btn-dark rounded-0"},[J,d(" Добавить разрешение ")])]),(i(!0),r(m,null,f(e.form.permissions,(l,n)=>(i(),r("div",Z,[s("div",z,[s("div",A,[e.form.permissions[n]?(i(),r("p",G,p(e.form.permissions[n].name),1)):(i(),r("p",H,"Не выбрана")),K]),e.form.permissions[n]?(i(),r("button",{key:0,type:"button",class:"btn btn-outline-secondary rounded-0",onClick:y=>e.removePermission(n)},X,8,Q)):a("",!0)])]))),256))]),s("div",Y,[s("div",x,[e.messages.length>0?(i(!0),r(m,{key:0},f(e.messages,(l,n)=>(i(),r("div",ss,[es,d(" "+p(l||"Ошибка")+" ",1),s("button",{type:"button",class:"btn-close",onClick:y=>e.removeMessage(n)},null,8,os)]))),256)):a("",!0)])]),s("div",ts,[s("div",ls,[s("button",{disabled:!e.needClearForm,class:"btn btn-dark rounded-0"},[e.loading?(i(),r("span",ns)):(i(),r("i",rs)),d(" Сохранить пользователя ")],8,is),e.needClearForm&&!e.loading?(i(),r("button",{key:0,type:"button",onClick:o[6]||(o[6]=(...l)=>e.resetForm&&e.resetForm(...l)),class:"btn btn-outline-secondary rounded-0 ml-2"},[as,d(" Очистить форму ")])):a("",!0)])])],32),s("div",ds,[s("div",ms,[s("div",cs,[hs,s("div",us,[c(M,{"for-select":!0,onSelect:e.selectRole},null,8,["onSelect"])]),ps])])]),s("div",fs,[s("div",bs,[s("div",_s,[ys,s("div",gs,[c(S,{"for-select":!0,selected:e.preparedPermissions,onSelect:e.selectPermissions},null,8,["selected","onSelect"])]),vs])])])],64))}}),$s=s("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Пользователи",-1),Ms={class:"py-12"},Ss={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},Cs={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},Fs={class:"p-6 text-gray-900"},Us=s("hr",{class:"hr my-5"},null,-1),Ps={data(){return{loading:!1,selectedUser:null}},methods:{selectUser(t){this.selectedUser=t,this.loading=!0,this.$nextTick(()=>{this.loading=!1})},callbackUserForm(){this.loading=!0,this.selectedUser=null,this.$nextTick(()=>{this.loading=!1})}}},Es=Object.assign(Ps,{__name:"UsersPage",setup(t){return(e,o)=>(i(),r(m,null,[c(w($),{title:"Пользователи"}),c(g,null,{header:b(()=>[$s]),default:b(()=>[s("div",Ms,[s("div",Ss,[s("div",Cs,[s("div",Fs,[e.loading?a("",!0):(i(),_(ws,{key:0,item:e.selectedUser,onCallback:e.callbackUserForm},null,8,["item","onCallback"])),Us,e.loading?a("",!0):(i(),_(v,{key:1,onSelect:e.selectUser},null,8,["onSelect"]))])])])])]),_:1})],64))}});export{Es as default};