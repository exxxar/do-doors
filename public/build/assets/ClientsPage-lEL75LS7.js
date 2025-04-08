import{_ as c}from"./AuthenticatedLayout-CVSut16L.js";import{_ as h,a as _}from"./ClientTable-DV8KEkGd.js";import{c as o,a,u as p,w as n,F as u,o as s,Z as f,b as e,d as y,e as r,f as d}from"./app-Bt_CszfV.js";import"./ApplicationLogo-Cpp7e418.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./vue-the-mask-DlB0C2QX.js";import"./Pagination-nG-LyF60.js";import"./UserTable-BEQnJ6rI.js";import"./RoleTable-Bwal4CzD.js";import"./RalColorSelector-DArAR-70.js";import"./main-BH2I5IYy.js";import"./PermissionTable-B7RAFUsN.js";const g=e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Клиенты",-1),k={class:"py-12"},C={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},b={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},x={class:"p-6 text-gray-900"},$={key:0,class:"fa-solid fa-file-import"},F={key:1,class:"spinner-border spinner-border-sm text-primary",role:"status"},v=e("span",{class:"visually-hidden"},"Loading...",-1),w=[v],D=e("hr",{class:"hr my-5"},null,-1),S={data(){return{loading:!1,moysklad_loading:!1,selectedClient:null}},methods:{importClientsFromMoySklad(){this.$notify({title:"DoDoors",text:"Началась загрузка данных"}),this.moysklad_loading=!0,this.$store.dispatch("importClientsFromMoySklad").then(()=>{this.$notify({title:"DoDoors",text:"Данные успешно загружены",type:"success"}),this.loading=!0,this.$nextTick(()=>{this.loading=!1,this.moysklad_loading=!1})}).catch(()=>{this.$notify({title:"DoDoors",text:"Ошибка загрузки данных",type:"error"}),this.moysklad_loading=!1})},selectClient(i){this.selectedClient=i,this.loading=!0,this.$nextTick(()=>{this.loading=!1})},callbackClientForm(){this.loading=!0,this.selectedClient=null,this.$nextTick(()=>{this.loading=!1})}}},z=Object.assign(S,{__name:"ClientsPage",setup(i){return(t,l)=>(s(),o(u,null,[a(p(f),{title:"Клиенты"}),a(c,null,{header:n(()=>[g]),default:n(()=>[e("div",k,[e("div",C,[e("div",b,[e("div",x,[e("button",{class:"my-3 p-3 border-gray-100 border btn rounded-0",type:"button",onClick:l[0]||(l[0]=(...m)=>t.importClientsFromMoySklad&&t.importClientsFromMoySklad(...m))},[t.moysklad_loading?(s(),o("div",F,w)):(s(),o("i",$)),y(" Загрузить данные из Мой Склад ")]),t.loading?d("",!0):(s(),r(h,{key:0,item:t.selectedClient,onCallback:t.callbackClientForm},null,8,["item","onCallback"])),D,t.loading?d("",!0):(s(),r(_,{key:1,onSelect:t.selectClient},null,8,["onSelect"]))])])])])]),_:1})],64))}});export{z as default};
