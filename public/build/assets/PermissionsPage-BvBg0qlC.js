import{_}from"./AuthenticatedLayout-VxhPxQC7.js";import{_ as g}from"./PermissionTable-DQb0W263.js";import{o as l,c as n,b as e,f as m,v as d,F as f,r as b,e as r,g as a,j as k,t as y,a as u,u as v,w as c,Z as $,d as h}from"./app-IgJzOcEi.js";import"./RalColorSelector-B6AoE9De.js";import"./ApplicationLogo-DnOrubwk.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./Pagination-BIryTHWu.js";const F={class:"form-floating mb-3"},P=e("label",{for:"permission-code"},"Название разрешения",-1),w={class:"form-floating mb-3"},C=e("label",{for:"permission-code"},"Программный идентификатор разрешения",-1),D={class:"row"},V={class:"col-12"},x={class:"alert alert-danger alert-dismissible fade show",role:"alert"},T=e("strong",null,"Внимание!",-1),j=["onClick"],B={class:"row mt-5"},M={class:"col-12 d-flex justify-content-center"},N=["disabled"],S={key:0,class:"fa-regular fa-floppy-disk mr-1"},q={key:1,class:"spinner-border spinner-border-sm text-success"},O=e("i",{class:"fa-solid fa-xmark mr-1"},null,-1),U={props:["item"],data(){return{messages:[],loading:!1,form:{id:null,name:null,slug:null}}},computed:{needClearForm(){return this.form.id||this.form.name||this.form.slug}},mounted(){this.item&&this.$nextTick(()=>{this.form={id:this.item.id||null,slug:this.item.slug||null,name:this.item.name||null}})},methods:{alert(t){this.messages.push(t)},resetForm(){this.form.id=null,this.form.name=null,this.form.slug=0,this.$emit("callback")},removeMessage(t){this.messages.splice(t,1)},submit(){this.$store.dispatch("storePermission",{permissionForm:this.form}).then(t=>{this.$notify({title:"DoDoors",text:"Роль успешно добавлена",type:"success"}),this.$emit("callback"),this.resetForm()}).catch(t=>{this.$notify({title:"DoDoors",text:"Ошибка добавления роли",type:"error"})})}}},E=Object.assign(U,{__name:"PermissionForm",setup(t){return(s,o)=>(l(),n("form",{action:"",onSubmit:o[3]||(o[3]=k((...i)=>s.submit&&s.submit(...i),["prevent"]))},[e("div",F,[m(e("input",{type:"text","onUpdate:modelValue":o[0]||(o[0]=i=>s.form.name=i),class:"form-control",id:"permission-name",required:""},null,512),[[d,s.form.name]]),P]),e("div",w,[m(e("input",{type:"text","onUpdate:modelValue":o[1]||(o[1]=i=>s.form.slug=i),class:"form-control",id:"permission-slug",required:""},null,512),[[d,s.form.slug]]),C]),e("div",D,[e("div",V,[s.messages.length>0?(l(!0),n(f,{key:0},b(s.messages,(i,p)=>(l(),n("div",x,[T,a(" "+y(i||"Ошибка")+" ",1),e("button",{type:"button",class:"btn-close",onClick:J=>s.removeMessage(p)},null,8,j)]))),256)):r("",!0)])]),e("div",B,[e("div",M,[e("button",{disabled:!s.needClearForm,class:"btn btn-dark rounded-0"},[s.loading?(l(),n("span",q)):(l(),n("i",S)),a(" Сохранить разрешения ")],8,N),s.needClearForm&&!s.loading?(l(),n("button",{key:0,type:"button",onClick:o[2]||(o[2]=(...i)=>s.resetForm&&s.resetForm(...i)),class:"btn btn-outline-secondary rounded-0 ml-2"},[O,a(" Очистить форму ")])):r("",!0)])])],32))}}),L=e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Разрешения",-1),Z={class:"py-12"},z={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},A={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},G={class:"p-6 text-gray-900"},H=e("hr",{class:"hr my-5"},null,-1),I={data(){return{loading:!1,selectedPermission:null}},methods:{selectPermission(t){this.selectedPermission=t,this.loading=!0,this.$nextTick(()=>{this.loading=!1})},callbackPermissionForm(){this.loading=!0,this.selectedPermission=null,this.$nextTick(()=>{this.loading=!1})}}},es=Object.assign(I,{__name:"PermissionsPage",setup(t){return(s,o)=>(l(),n(f,null,[u(v($),{title:"Разрешения"}),u(_,null,{header:c(()=>[L]),default:c(()=>[e("div",Z,[e("div",z,[e("div",A,[e("div",G,[s.loading?r("",!0):(l(),h(E,{key:0,item:s.selectedPermission,onCallback:s.callbackPermissionForm},null,8,["item","onCallback"])),H,s.loading?r("",!0):(l(),h(g,{key:1,onSelect:s.selectPermission},null,8,["onSelect"]))])])])])]),_:1})],64))}});export{es as default};
