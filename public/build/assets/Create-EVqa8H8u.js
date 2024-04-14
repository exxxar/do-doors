import{_ as a}from"./AuthenticatedLayout-BkqzL3y2.js";import"./CalcForm-BsdXOZsE.js";import{c as o,a as s,u as r,w as t,F as l,o as i,Z as n,b as e,e as m}from"./app-B_BzcOIB.js";import"./ApplicationLogo-BXgHuuHF.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./RalColorSelector-CUJfaE28.js";const d=e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Калькулятор",-1),c=e("div",{class:"py-12"},[e("div",{class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},[e("div",{class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},[e("div",{class:"p-6 text-gray-900"},[e("div",{class:"bg-light p-4 rounded"},[e("h2",null,"Add new permission"),e("div",{class:"lead"}," Add new permission. "),e("div",{class:"container mt-4"},[e("form",{method:"POST",action:"{{ route('permissions.store') }}"},[m(" @csrf "),e("div",{class:"mb-3"},[e("label",{for:"name",class:"form-label"},"Name"),e("input",{value:"{{ old('name') }}",type:"text",class:"form-control",name:"name",placeholder:"Name",required:""})]),e("button",{type:"submit",class:"btn btn-primary"},"Save permission"),e("a",{href:"{{ route('permissions.index') }}",class:"btn btn-default"},"Back")])])])])])])],-1),w={__name:"Create",setup(p){return(u,f)=>(i(),o(l,null,[s(r(n),{title:"Разрешения"}),s(a,null,{header:t(()=>[d]),default:t(()=>[c]),_:1})],64))}};export{w as default};