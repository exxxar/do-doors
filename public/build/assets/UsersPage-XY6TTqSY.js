import{_ as n}from"./AuthenticatedLayout-DXXPBfXP.js";import{a as c,_ as d}from"./UserTable-CIKEi8pC.js";import{c as m,a as l,u as _,w as o,F as h,o as t,Z as u,b as e,d as i,e as r}from"./app-DbH5cOv5.js";import"./ApplicationLogo-CjObZmt_.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./vue-the-mask-DwrNzmFO.js";import"./Pagination-BBSxhLes.js";import"./RoleTable-DehkcMz2.js";import"./RalColorSelector-BwrpR_i-.js";import"./main-C4eX5Ge2.js";import"./PermissionTable-C7W5K1B7.js";const p=e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Пользователи",-1),f={class:"py-12"},g={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},k={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},x={class:"p-6 text-gray-900"},U=e("hr",{class:"hr my-5"},null,-1),b={data(){return{loading:!1,selectedUser:null}},methods:{selectUser(a){this.selectedUser=a,this.loading=!0,this.$nextTick(()=>{this.loading=!1})},callbackUserForm(){this.loading=!0,this.selectedUser=null,this.$nextTick(()=>{this.loading=!1})}}},E=Object.assign(b,{__name:"UsersPage",setup(a){return(s,w)=>(t(),m(h,null,[l(_(u),{title:"Пользователи"}),l(n,null,{header:o(()=>[p]),default:o(()=>[e("div",f,[e("div",g,[e("div",k,[e("div",x,[s.loading?r("",!0):(t(),i(c,{key:0,id:"user-form-1",item:s.selectedUser,onCallback:s.callbackUserForm},null,8,["item","onCallback"])),U,s.loading?r("",!0):(t(),i(d,{key:1,onSelect:s.selectUser},null,8,["onSelect"]))])])])])]),_:1})],64))}});export{E as default};
