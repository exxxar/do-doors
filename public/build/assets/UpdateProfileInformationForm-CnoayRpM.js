import{a1 as _,X as y,c as r,b as a,a as s,u as e,g as n,w as m,f as x,S as h,e as f,T as V,j as b,o as u,Y as k}from"./app-PaeVRU1m.js";import{a as p,b as g,_ as v}from"./TextInput-Cmpt8mNz.js";import{P as w}from"./PrimaryButton-CDZTRLTJ.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const B=a("header",null,[a("h2",{class:"text-lg font-medium text-gray-900"},"Информация о профиле"),a("p",{class:"mt-1 text-sm text-gray-600"}," Обновите вашу персональную информацию ")],-1),S={key:0},N={class:"text-sm mt-2 text-gray-800"},T={class:"mt-2 font-medium text-sm text-green-600"},$={class:"flex items-center gap-4"},E={key:0,class:"text-sm text-gray-600"},Y={__name:"UpdateProfileInformationForm",props:{mustVerifyEmail:{type:Boolean},status:{type:String}},setup(d){const l=_().props.auth.user,t=y({name:l.name,email:l.email});return(c,o)=>(u(),r("section",null,[B,a("form",{onSubmit:o[2]||(o[2]=b(i=>e(t).patch(c.route("profile.update")),["prevent"])),class:"mt-6 space-y-6"},[a("div",null,[s(v,{for:"name",value:"Имя"}),s(p,{id:"name",type:"text",class:"mt-1 block w-full",modelValue:e(t).name,"onUpdate:modelValue":o[0]||(o[0]=i=>e(t).name=i),required:"",autofocus:"",autocomplete:"name"},null,8,["modelValue"]),s(g,{class:"mt-2",message:e(t).errors.name},null,8,["message"])]),a("div",null,[s(v,{for:"email",value:"Почта"}),s(p,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:e(t).email,"onUpdate:modelValue":o[1]||(o[1]=i=>e(t).email=i),required:"",autocomplete:"username"},null,8,["modelValue"]),s(g,{class:"mt-2",message:e(t).errors.email},null,8,["message"])]),d.mustVerifyEmail&&e(l).email_verified_at===null?(u(),r("div",S,[a("p",N,[n(" Your email address is unverified. "),s(e(k),{href:c.route("verification.send"),method:"post",as:"button",class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:m(()=>[n(" Повторно запросить верификацию аккаунта ")]),_:1},8,["href"])]),x(a("div",T," Новая ссылка верификации была отправлена на вашу почту ",512),[[h,d.status==="verification-link-sent"]])])):f("",!0),a("div",$,[s(w,{disabled:e(t).processing},{default:m(()=>[n("Сохранить")]),_:1},8,["disabled"]),s(V,{"enter-active-class":"transition ease-in-out","enter-from-class":"opacity-0","leave-active-class":"transition ease-in-out","leave-to-class":"opacity-0"},{default:m(()=>[e(t).recentlySuccessful?(u(),r("p",E,"Сохранено")):f("",!0)]),_:1})])],32)]))}};export{Y as default};
