import{_ as a}from"./AuthenticatedLayout-DNZ-kFLE.js";import"./CalcForm-40fJg8Uu.js";import{c as i,a as t,u as o,w as s,F as r,o as l,Z as n,b as e,g as m}from"./app-CTwLR2lZ.js";import"./ApplicationLogo-BlmgUDcj.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./vue-the-mask-CnJHS1_e.js";import"./RalColorSelector-LDokoh6-.js";const d=e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Калькулятор",-1),c=e("div",{class:"py-12"},[e("div",{class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},[e("div",{class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},[e("div",{class:"p-6 text-gray-900"},[e("div",{class:"bg-light p-4 rounded"},[e("h2",null,"Edit permission"),e("div",{class:"lead"}," Editing permission. "),e("div",{class:"container mt-4"},[e("form",{method:"POST",action:"{{ route('permissions.update', $permission->id) }}"},[m(" @method('patch') @csrf "),e("div",{class:"mb-3"},[e("label",{for:"name",class:"form-label"},"Name"),e("input",{value:"",type:"text",class:"form-control",name:"name",placeholder:"Name",required:""})]),e("button",{type:"submit",class:"btn btn-primary"},"Save permission"),e("a",{href:"{{ route('permissions.index') }}",class:"btn btn-default"},"Back")])])])])])])],-1),y={__name:"Edit",setup(p){return(u,h)=>(l(),i(r,null,[t(o(n),{title:"Разрешения"}),t(a,null,{header:s(()=>[d]),default:s(()=>[c]),_:1})],64))}};export{y as default};
