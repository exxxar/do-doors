import{X as u,f as d,k as r,o as i,g as a,u as s,Z as c,c as f,t as p,e as _,a as t,d as w,q as g,w as y}from"./app-18_fjooi.js";import{_ as b}from"./GuestLayout-BKrK9gJv.js";import{_ as k,a as x,b as V}from"./TextInput-bQulG0qO.js";import{P as h}from"./PrimaryButton-CTpNu7eD.js";import"./ApplicationLogo-4aOqyZwU.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const v=t("div",{class:"mb-4 text-sm text-gray-600"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ",-1),B={key:0,class:"mb-4 font-medium text-sm text-green-600"},N={class:"flex items-center justify-end mt-4"},T={__name:"ForgotPassword",props:{status:{type:String}},setup(o){const e=u({email:""}),m=()=>{e.post(route("password.email"))};return(P,l)=>(i(),d(b,null,{default:r(()=>[a(s(c),{title:"Forgot Password"}),v,o.status?(i(),f("div",B,p(o.status),1)):_("",!0),t("form",{onSubmit:y(m,["prevent"])},[t("div",null,[a(k,{for:"email",value:"Email"}),a(x,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":l[0]||(l[0]=n=>s(e).email=n),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(V,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),t("div",N,[a(h,{class:g({"opacity-25":s(e).processing}),disabled:s(e).processing},{default:r(()=>[w(" Email Password Reset Link ")]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{T as default};
