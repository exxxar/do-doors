import{_ as r}from"./AuthenticatedLayout-DXXPBfXP.js";import{_ as c,a as d}from"./ClientTable-CS4IP1EN.js";import{c as m,a,u as _,w as i,F as h,o as s,Z as u,b as e,d as o,e as n}from"./app-DbH5cOv5.js";import"./ApplicationLogo-CjObZmt_.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./vue-the-mask-DwrNzmFO.js";import"./Pagination-BBSxhLes.js";import"./UserTable-CIKEi8pC.js";import"./RoleTable-DehkcMz2.js";import"./RalColorSelector-BwrpR_i-.js";import"./main-C4eX5Ge2.js";import"./PermissionTable-C7W5K1B7.js";const p=e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Клиенты",-1),g={class:"py-12"},f={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},C={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},k={class:"p-6 text-gray-900"},x=e("hr",{class:"hr my-5"},null,-1),b={data(){return{loading:!1,selectedClient:null}},methods:{selectClient(l){this.selectedClient=l,this.loading=!0,this.$nextTick(()=>{this.loading=!1})},callbackClientForm(){this.loading=!0,this.selectedClient=null,this.$nextTick(()=>{this.loading=!1})}}},P=Object.assign(b,{__name:"ClientsPage",setup(l){return(t,w)=>(s(),m(h,null,[a(_(u),{title:"Клиенты"}),a(r,null,{header:i(()=>[p]),default:i(()=>[e("div",g,[e("div",f,[e("div",C,[e("div",k,[t.loading?n("",!0):(s(),o(c,{key:0,item:t.selectedClient,onCallback:t.callbackClientForm},null,8,["item","onCallback"])),x,t.loading?n("",!0):(s(),o(d,{key:1,onSelect:t.selectClient},null,8,["onSelect"]))])])])])]),_:1})],64))}});export{P as default};
