import{A as Q}from"./ApplicationLogo-DnOrubwk.js";import{B as Z,D as G,G as j,x as A,o as n,c as h,b as t,I as E,f as T,S as q,a as F,w as f,q as x,T as J,d as v,u as M,Y as V,a0 as K,m as I,k as X,v as S,e as c,F as L,r as R,t as _,p as N,g as m,j as Y,$ as H,_ as W}from"./app-IgJzOcEi.js";import{_ as U}from"./_plugin-vue_export-helper-DlAUqK2U.js";const ee={class:"relative"},te={__name:"Dropdown",props:{align:{type:String,default:"right"},width:{type:String,default:"48"},contentClasses:{type:String,default:"py-1 bg-white"}},setup(l){const s=l,e=d=>{a.value&&d.key==="Escape"&&(a.value=!1)};Z(()=>document.addEventListener("keydown",e)),G(()=>document.removeEventListener("keydown",e));const r=j(()=>({48:"w-48"})[s.width.toString()]),o=j(()=>s.align==="left"?"ltr:origin-top-left rtl:origin-top-right start-0":s.align==="right"?"ltr:origin-top-right rtl:origin-top-left end-0":"origin-top"),a=A(!1);return(d,i)=>(n(),h("div",ee,[t("div",{onClick:i[0]||(i[0]=b=>a.value=!a.value)},[E(d.$slots,"trigger")]),T(t("div",{class:"fixed inset-0 z-40",onClick:i[1]||(i[1]=b=>a.value=!1)},null,512),[[q,a.value]]),F(J,{"enter-active-class":"transition ease-out duration-200","enter-from-class":"opacity-0 scale-95","enter-to-class":"opacity-100 scale-100","leave-active-class":"transition ease-in duration-75","leave-from-class":"opacity-100 scale-100","leave-to-class":"opacity-0 scale-95"},{default:f(()=>[T(t("div",{class:x(["absolute z-50 mt-2 rounded-md shadow-lg",[r.value,o.value]]),style:{display:"none"},onClick:i[2]||(i[2]=b=>a.value=!1)},[t("div",{class:x(["rounded-md ring-1 ring-black ring-opacity-5",l.contentClasses])},[E(d.$slots,"content")],2)],2),[[q,a.value]])]),_:3})]))}},O={__name:"DropdownLink",props:{href:{type:String,required:!0}},setup(l){return(s,e)=>(n(),v(M(V),{href:l.href,class:"block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"},{default:f(()=>[E(s.$slots,"default")]),_:3},8,["href"]))}},k={__name:"NavLink",props:{href:{type:String,required:!0},active:{type:Boolean}},setup(l){const s=l,e=j(()=>s.active?"inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out":"inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out");return(r,o)=>(n(),v(M(V),{href:l.href,class:x(e.value)},{default:f(()=>[E(r.$slots,"default")]),_:3},8,["href","class"]))}},D={__name:"ResponsiveNavLink",props:{href:{type:String,required:!0},active:{type:Boolean}},setup(l){const s=l,e=j(()=>s.active?"block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out":"block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out");return(r,o)=>(n(),v(M(V),{href:l.href,class:x(e.value)},{default:f(()=>[E(r.$slots,"default")]),_:3},8,["href","class"]))}};var z={exports:{}};(function(l,s){(function(e,r){l.exports=r()})(K,function(){return function(e){function r(a){if(o[a])return o[a].exports;var d=o[a]={i:a,l:!1,exports:{}};return e[a].call(d.exports,d,d.exports,r),d.l=!0,d.exports}var o={};return r.m=e,r.c=o,r.i=function(a){return a},r.d=function(a,d,i){r.o(a,d)||Object.defineProperty(a,d,{configurable:!1,enumerable:!0,get:i})},r.n=function(a){var d=a&&a.__esModule?function(){return a.default}:function(){return a};return r.d(d,"a",d),d},r.o=function(a,d){return Object.prototype.hasOwnProperty.call(a,d)},r.p=".",r(r.s=10)}([function(e,r){e.exports={"#":{pattern:/\d/},X:{pattern:/[0-9a-zA-Z]/},S:{pattern:/[a-zA-Z]/},A:{pattern:/[a-zA-Z]/,transform:function(o){return o.toLocaleUpperCase()}},a:{pattern:/[a-zA-Z]/,transform:function(o){return o.toLocaleLowerCase()}},"!":{escape:!0}}},function(e,r,o){function a(u){var p=document.createEvent("Event");return p.initEvent(u,!0,!0),p}var d=o(2),i=o(0),b=o.n(i);r.a=function(u,p){var y=p.value;if((Array.isArray(y)||typeof y=="string")&&(y={mask:y,tokens:b.a}),u.tagName.toLocaleUpperCase()!=="INPUT"){var g=u.getElementsByTagName("input");if(g.length!==1)throw new Error("v-mask directive requires 1 input, found "+g.length);u=g[0]}u.oninput=function($){if($.isTrusted){var C=u.selectionEnd,P=u.value[C-1];for(u.value=o.i(d.a)(u.value,y.mask,!0,y.tokens);C<u.value.length&&u.value.charAt(C-1)!==P;)C++;u===document.activeElement&&(u.setSelectionRange(C,C),setTimeout(function(){u.setSelectionRange(C,C)},0)),u.dispatchEvent(a("input"))}};var w=o.i(d.a)(u.value,y.mask,!0,y.tokens);w!==u.value&&(u.value=w,u.dispatchEvent(a("input")))}},function(e,r,o){var a=o(6),d=o(5);r.a=function(i,b){var u=!(arguments.length>2&&arguments[2]!==void 0)||arguments[2],p=arguments[3];return Array.isArray(b)?o.i(d.a)(a.a,b,p)(i,b,u,p):o.i(a.a)(i,b,u,p)}},function(e,r,o){function a(g){g.component(p.a.name,p.a),g.directive("mask",b.a)}Object.defineProperty(r,"__esModule",{value:!0});var d=o(0),i=o.n(d),b=o(1),u=o(7),p=o.n(u);o.d(r,"TheMask",function(){return p.a}),o.d(r,"mask",function(){return b.a}),o.d(r,"tokens",function(){return i.a}),o.d(r,"version",function(){return y});var y="0.11.1";r.default=a,typeof window<"u"&&window.Vue&&window.Vue.use(a)},function(e,r,o){Object.defineProperty(r,"__esModule",{value:!0});var a=o(1),d=o(0),i=o.n(d),b=o(2);r.default={name:"TheMask",props:{value:[String,Number],mask:{type:[String,Array],required:!0},masked:{type:Boolean,default:!1},tokens:{type:Object,default:function(){return i.a}}},directives:{mask:a.a},data:function(){return{lastValue:null,display:this.value}},watch:{value:function(u){u!==this.lastValue&&(this.display=u)},masked:function(){this.refresh(this.display)}},computed:{config:function(){return{mask:this.mask,tokens:this.tokens,masked:this.masked}}},methods:{onInput:function(u){u.isTrusted||this.refresh(u.target.value)},refresh:function(p){this.display=p;var p=o.i(b.a)(p,this.mask,this.masked,this.tokens);p!==this.lastValue&&(this.lastValue=p,this.$emit("input",p))}}}},function(e,r,o){function a(d,i,b){return i=i.sort(function(u,p){return u.length-p.length}),function(u,p){for(var y=!(arguments.length>2&&arguments[2]!==void 0)||arguments[2],g=0;g<i.length;){var w=i[g];g++;var $=i[g];if(!($&&d(u,$,!0,b).length>w.length))return d(u,w,y,b)}return""}}r.a=a},function(e,r,o){function a(d,i){var b=!(arguments.length>2&&arguments[2]!==void 0)||arguments[2],u=arguments[3];d=d||"",i=i||"";for(var p=0,y=0,g="";p<i.length&&y<d.length;){var w=i[p],$=u[w],C=d[y];$&&!$.escape?($.pattern.test(C)&&(g+=$.transform?$.transform(C):C,p++),y++):($&&$.escape&&(p++,w=i[p]),b&&(g+=w),C===w&&y++,p++)}for(var P="";p<i.length&&b;){var w=i[p];if(u[w]){P="";break}P+=w,p++}return g+P}r.a=a},function(e,r,o){var a=o(8)(o(4),o(9),null,null);e.exports=a.exports},function(e,r){e.exports=function(o,a,d,i){var b,u=o=o||{},p=typeof o.default;p!=="object"&&p!=="function"||(b=o,u=o.default);var y=typeof u=="function"?u.options:u;if(a&&(y.render=a.render,y.staticRenderFns=a.staticRenderFns),d&&(y._scopeId=d),i){var g=y.computed||(y.computed={});Object.keys(i).forEach(function(w){var $=i[w];g[w]=function(){return $}})}return{esModule:b,exports:u,options:y}}},function(e,r){e.exports={render:function(){var o=this,a=o.$createElement;return(o._self._c||a)("input",{directives:[{name:"mask",rawName:"v-mask",value:o.config,expression:"config"}],attrs:{type:"text"},domProps:{value:o.display},on:{input:o.onInput}})},staticRenderFns:[]}},function(e,r,o){e.exports=o(3)}])})})(z);var B=z.exports;const se={directives:{mask:B.mask},computed:{...I(["getErrors","getDictionary","cartTotalCount","cartTotalPrice","cartProducts"])},data(){return{tab:0,step:0,discount:0,self_clients:[],clientForm:{client_id:null,name:null,phone:null,email:null,info:null,promo:null,work_with_nds:1,items:[]}}},mounted(){this.loadSelfClients()},methods:{hasRoles(l){return(this.$page.props.auth.roles||[]).includes(l)},back(){this.$emit("back")},preparedLawStatus(l){let e=(this.getDictionary.statuses||[]).find(r=>r.value===l)||null;return e?e.title:null},selectInfo(l){if(l==null){this.clientForm.id=null,this.clientForm.name=null,this.clientForm.email=null,this.clientForm.phone=null;return}this.clientForm.id=l.id||null,this.clientForm.name=l.title||null,this.clientForm.email=l.email||null,this.clientForm.phone=l.phone||null},clearCart(){this.$store.dispatch("clearCart").then(l=>{this.$notify({title:"DoDoors",text:"Успешно очищено",type:"success"})}).catch(l=>{this.$notify({title:"DoDoors",text:"Ошибочка...",type:"error"})})},findPromo(){this.discount=0,!((this.clientForm.promo||"").length<=5)&&this.$store.dispatch("findPromoCode",{code:this.clientForm.promo}).then(l=>{this.discount=l.discount||0})},loadSelfClients(){this.$store.dispatch("loadSelfClients").then(l=>{this.self_clients=l.data||[]}).catch(()=>{})},submit(){this.clientForm.items=this.cartProducts;let l=new FormData;Object.keys(this.clientForm).forEach(s=>{const e=this.clientForm[s]||"";typeof e=="object"?l.append(s,JSON.stringify(e)):l.append(s,e)}),l.append("total_price",this.cartTotalPrice),l.append("total_count",this.cartTotalCount),this.$store.dispatch("checkoutItems",{clientForm:l}).then(s=>{this.step=0,this.$store.dispatch("clearCart"),this.clientForm={name:null,phone:null,email:null,info:null},this.$notify({title:"DoDoors",text:"Заказ передан менеджеру!",type:"success"})}).catch(s=>{this.$notify({title:"DoDoors",text:"Ошибочка...",type:"error"})})}}},oe={class:"input-group mb-3"},ne={class:"form-floating"},ae=t("label",{for:"checkout-name"},"Ваше Ф.И.О.",-1),re={key:0,class:"btn btn-outline-secondary",type:"button","data-bs-toggle":"dropdown","aria-expanded":"false"},ie=t("i",{class:"fa-solid fa-up-right-and-down-left-from-center"},null,-1),le=[ie],ce={class:"dropdown-menu dropdown-menu-end rounded-0"},de=t("li",null,[t("hr",{class:"dropdown-divider"})],-1),ue=["onClick"],he={class:"form-floating mb-3"},me=t("label",{for:"checkout-phone"},"Ваш номер телефона",-1),fe={class:"form-floating mb-3"},pe=t("label",{for:"checkout-email"},"Ваш email",-1),ve={class:"form-floating"},_e=t("label",{for:"checkout-info"},"Дополнительная информация",-1),be={class:"row my-3"},ye={class:"col-md-6"},ge={class:"form-check"},ke=t("label",{class:"form-check-label",for:"work-with-nds"}," Для ООО ",-1),we={class:"col-md-6"},$e={class:"form-check"},Ce=t("label",{class:"form-check-label",for:"work-without-nds"}," Для ИП ",-1),De=t("hr",{class:"hr hr-blurry my-3"},null,-1),Fe={class:"font-bold"},Te={key:0},xe=t("p",{class:"mb-2"},[t("small",null,"Возможно в рассрочку!")],-1),Ee=t("p",{class:"mb-2",style:{"line-height":"80%"}},[t("small",null,"От цвета шпона или цвета покраски стекла цена не зависит, просто уточните эти детали в беседе с менеджером")],-1),Pe={class:"form-floating mb-3"},Se=t("label",{for:"checkout-promo"},"Промокод",-1),je=t("button",{class:"btn btn-dark w-100 my-2 rounded-0"},"Отправить",-1),Le={key:1,class:"card rounded-0"},Me=t("div",{class:"card-body"},[t("p",null,"Вы должны добавить в корзину хотя бы одно изделие")],-1),Ve=[Me];function Ie(l,s,e,r,o,a){const d=X("mask");return l.cartTotalCount>0?(n(),h("form",{key:0,onSubmit:s[10]||(s[10]=Y((...i)=>a.submit&&a.submit(...i),["prevent"]))},[t("div",oe,[t("div",ne,[T(t("input",{type:"text",class:"form-control","onUpdate:modelValue":s[0]||(s[0]=i=>o.clientForm.name=i),id:"checkout-name",placeholder:"name@example.com",required:""},null,512),[[S,o.clientForm.name]]),ae]),o.self_clients.length>0?(n(),h("button",re,le)):c("",!0),t("ul",ce,[t("li",null,[t("a",{class:"dropdown-item",onClick:s[1]||(s[1]=i=>a.selectInfo(null)),href:"javascript:void(0)"},"Не выбрано")]),de,t("li",null,[(n(!0),h(L,null,R(o.self_clients,i=>(n(),h("a",{class:"dropdown-item",href:"javascript:void(0)",onClick:b=>a.selectInfo(i)},_(i.title||null)+" ("+_(a.preparedLawStatus(i.status)||"Не указан")+")",9,ue))),256))])])]),t("div",he,[T(t("input",{type:"text",class:"form-control","onUpdate:modelValue":s[2]||(s[2]=i=>o.clientForm.phone=i),id:"checkout-phone",placeholder:"name@example.com",required:""},null,512),[[d,"+7(###)###-##-##"],[S,o.clientForm.phone]]),me]),t("div",fe,[T(t("input",{type:"email",class:"form-control","onUpdate:modelValue":s[3]||(s[3]=i=>o.clientForm.email=i),id:"checkout-email",placeholder:"name@example.com",required:""},null,512),[[S,o.clientForm.email]]),pe]),t("div",ve,[T(t("textarea",{class:"form-control border-secondary rounded-0","onUpdate:modelValue":s[4]||(s[4]=i=>o.clientForm.info=i),placeholder:"Оставьте свой комментарий",id:"checkout-info"},null,512),[[S,o.clientForm.info]]),_e]),t("div",be,[t("div",ye,[t("div",ge,[T(t("input",{class:"form-check-input",type:"radio",value:"1","onUpdate:modelValue":s[5]||(s[5]=i=>o.clientForm.work_with_nds=i),name:"flexRadioDefault",id:"work-with-nds"},null,512),[[N,o.clientForm.work_with_nds]]),ke])]),t("div",we,[t("div",$e,[T(t("input",{class:"form-check-input",type:"radio",value:"0",name:"flexRadioDefault","onUpdate:modelValue":s[6]||(s[6]=i=>o.clientForm.work_with_nds=i),id:"work-without-nds"},null,512),[[N,o.clientForm.work_with_nds]]),Ce])])]),De,t("h6",Fe,[m("Итого цена "+_(Math.round(l.cartTotalPrice*(1-o.discount/100)))+" ₽ ",1),o.discount>0?(n(),h("span",Te,"(скидка "+_(o.discount)+"%)",1)):c("",!0)]),xe,Ee,t("div",Pe,[T(t("input",{type:"text",class:"form-control",onKeyup:s[7]||(s[7]=(...i)=>a.findPromo&&a.findPromo(...i)),"onUpdate:modelValue":s[8]||(s[8]=i=>o.clientForm.promo=i),id:"checkout-promo",placeholder:"name@example.com"},null,544),[[S,o.clientForm.promo]]),Se]),je,t("button",{type:"button",class:"btn btn-outline-secondary w-100 rounded-0",onClick:s[9]||(s[9]=(...i)=>a.back&&a.back(...i))},"Назад")],32)):(n(),h("div",Le,Ve))}const qe=U(se,[["render",Ie]]),Ne={props:["item"],methods:{editDoorItem(){window.dispatchEvent(new CustomEvent("select-door-item",{detail:{item:this.item}}))},removeProduct(){this.$store.dispatch("removeProduct",this.item.product.id)},changeQuantityProductInCart(l="increment"){let s=l==="increment"?this.item.quantity+1:this.item.quantity-1;if(s===0){this.$store.dispatch("removeProduct",this.item.product.id);return}this.$store.dispatch("setQuantity",{id:this.item.product.id,quantity:s})}}},Oe={class:"card mb-2 rounded-0"},Ae={class:"card-body"},Re={class:"row"},Ue={class:"col-md-12"},ze={class:"text-muted font-bold"},Be={class:"text-black mb-0"},Qe={key:0},Ze={key:1,class:"ml-1"},Ge={key:2,class:"ml-1"},Je={key:3},Ke={key:4,class:"ml-1"},Xe={key:5,class:"ml-1"},Ye={key:6,class:"ml-1"},He={key:7,class:"ml-1"},We={key:8,class:"ml-1"},et={key:9,class:"ml-1"},tt={key:10,class:"ml-1"},st={key:11,class:"ml-1"},ot={key:12,class:"ml-1"},nt={key:13,class:"ml-1"},at={key:14,class:"ml-1"},rt={key:15,class:"ml-1"},it={key:16,class:"ml-1"},lt={class:"row d-flex align-items-center"},ct={class:"col-5 col-md-5 col-lg-5 col-xl-5 d-flex justify-content-center mt-2"},dt=t("i",{class:"fas fa-minus"},null,-1),ut=[dt],ht={class:"btn",style:{color:"black"}},mt=t("i",{class:"fas fa-plus"},null,-1),ft=[mt],pt={class:"col-5 col-md-5 col-lg-5 col-xl-5"},vt={class:"mb-0 text-center font-bold"},_t={class:"col-2 col-md-2 col-lg-2 col-xl-2 text-center"},bt=t("i",{class:"fas fa-times"},null,-1),yt=[bt],gt={class:"col-12"},kt=t("i",{class:"fa-regular fa-pen-to-square mr-2"},null,-1);function wt(l,s,e,r,o,a){return n(),h("div",Oe,[t("div",Ae,[t("div",Re,[t("div",Ue,[t("h6",ze,_(e.item.product.door_type.title)+" "+_(e.item.product.width)+"x"+_(e.item.product.height)+"x"+_(e.item.product.depth),1),t("h6",Be,[e.item.product.box_and_frame_color.title?(n(),h("span",Qe,"("+_(e.item.product.box_and_frame_color.title)+")",1)):c("",!0),m(" лицо "),e.item.product.front_side_finish.title?(n(),h("span",Ze,_(e.item.product.front_side_finish.title),1)):c("",!0),m("/ "),e.item.product.back_side_finish.title?(n(),h("span",Ge,_(e.item.product.back_side_finish.title)+",",1)):c("",!0),m(" петли "),e.item.product.loops.title?(n(),h("span",Je,_(e.item.product.loops.title)+",",1)):c("",!0),e.item.product.hinge_manufacturer.title?(n(),h("span",Ke,_(e.item.product.hinge_manufacturer.title)+",",1)):c("",!0),e.item.product.fittings_color.title?(n(),h("span",Xe,"("+_(e.item.product.fittings_color.title)+"),",1)):c("",!0),e.item.product.opening_type.title?(n(),h("span",Ye,_(e.item.product.opening_type.title)+",",1)):c("",!0),e.item.product.handle_holes.title?(n(),h("span",He,_(e.item.product.handle_holes.title)+",",1)):c("",!0),e.item.product.need_automatic_doorstep?(n(),h("span",We," автоматический порожек,")):c("",!0),e.item.product.need_upper_jumper?(n(),h("span",et," верхняя перемычка,")):c("",!0),e.item.product.need_handle_holes?(n(),h("span",tt," дверная ручка,")):c("",!0),e.item.product.handle_holes_type.title?(n(),h("span",st,_(e.item.product.handle_holes_type.title)+",",1)):c("",!0),e.item.product.handle_holes.title?(n(),h("span",ot,_(e.item.product.handle_holes.title)+",",1)):c("",!0),e.item.product.need_hidden_door_closer?(n(),h("span",nt," скрытый доводчик,")):c("",!0),e.item.product.need_hidden_skirting_board?(n(),h("span",at," скрытый плинтус,")):c("",!0),e.item.product.need_hidden_stopper?(n(),h("span",rt," скрытый стопор,")):c("",!0),e.item.product.need_door_install?(n(),h("span",it," установка двери")):c("",!0)])])]),t("div",lt,[t("div",ct,[t("button",{class:"btn btn-link px-2",type:"button",style:{color:"black"},onClick:s[0]||(s[0]=d=>a.changeQuantityProductInCart("decrement"))},ut),t("span",ht,_(e.item.quantity),1),t("button",{class:"btn btn-link px-2",type:"button",style:{color:"black"},onClick:s[1]||(s[1]=d=>a.changeQuantityProductInCart("increment"))},ft)]),t("div",pt,[t("h6",vt,_(e.item.quantity*(e.item.product.price||0))+" ₽",1)]),t("div",_t,[t("a",{href:"javascript:void(0)",onClick:s[2]||(s[2]=(...d)=>a.removeProduct&&a.removeProduct(...d)),class:"text-muted"},yt)]),t("div",gt,[t("button",{type:"button",style:{color:"black"},class:"btn btn-link",onClick:s[3]||(s[3]=(...d)=>a.editDoorItem&&a.editDoorItem(...d))},[kt,m("Редактировать")])])])])])}const $t=U(Ne,[["render",wt]]),Ct={class:"offcanvas offcanvas-end",tabindex:"-1",id:"cart","aria-labelledby":"cart"},Dt={class:"offcanvas-header"},Ft={class:"offcanvas-title font-bold"},Tt={key:0},xt={key:1},Et=t("button",{type:"button",class:"btn-close","data-bs-dismiss":"offcanvas","aria-label":"Close"},null,-1),Pt={key:0,class:"offcanvas-body"},St=t("div",{class:"hr my-3"},null,-1),jt={key:1,class:"card rounded-0"},Lt=t("div",{class:"card-body"},[t("p",null,"Вы должны добавить в корзину хотя бы одно изделие")],-1),Mt=[Lt],Vt={key:1,class:"offcanvas-body"},It={key:2,class:"offcanvas-footer p-3"},qt={class:"card rounded-0"},Nt={class:"card-body"},Ot={class:"font-bold"},At=t("p",{class:"mb-2"},[t("small",null,"Возможно в рассрочку!")],-1),Rt=t("p",{class:"mb-2",style:{"line-height":"80%"}},[t("small",null,"От цвета шпона или цвета покраски стекла цена не зависит, просто уточните эти детали в беседе с менеджером")],-1),Ut={key:0},zt={directives:{mask:B.mask},computed:{...I(["getErrors","getDictionary","cartTotalCount","cartTotalPrice","cartProducts"])},data(){return{tab:0,step:0,discount:0}},mounted(){},methods:{back(){this.step=0,this.tab=0},checkout(){this.step=1,this.tab=1},clearCart(){this.$store.dispatch("clearCart").then(l=>{this.$notify({title:"DoDoors",text:"Успешно очищено",type:"success"})}).catch(l=>{this.$notify({title:"DoDoors",text:"Ошибочка...",type:"error"})})},downloadCartExcel(){let l=this.cartProducts,s=new FormData;s.append("items",JSON.stringify(l)),this.$store.dispatch("downloadExcel",{cardData:s}).then(e=>{var r=window.URL.createObjectURL(new Blob([e])),o=document.createElement("a");o.href=r,o.setAttribute("download","cart.xls"),document.body.appendChild(o),o.click(),this.$notify({title:"DoDoors",text:"Excel успешно скачан!",type:"success"})}).catch(e=>{this.$notify({title:"DoDoors",text:"Ошибочка...",type:"error"})})},loadSelfClients(){this.$store.dispatch("loadSelfClients").then(l=>{this.self_clients=l.data||[]}).catch(()=>{})},submit(){this.clientForm.items=this.cartProducts;let l=new FormData;Object.keys(this.clientForm).forEach(s=>{const e=this.clientForm[s]||"";typeof e=="object"?l.append(s,JSON.stringify(e)):l.append(s,e)}),l.append("total_price",this.cartTotalPrice),l.append("total_count",this.cartTotalCount),this.$store.dispatch("checkoutItems",{clientForm:l}).then(s=>{this.step=0,this.$store.dispatch("clearCart"),this.clientForm={name:null,phone:null,email:null,info:null},this.$notify({title:"DoDoors",text:"Заказ передан менеджеру!",type:"success"})}).catch(s=>{this.$notify({title:"DoDoors",text:"Ошибочка...",type:"error"})})}}},Bt=Object.assign(zt,{__name:"CalcCartSimple",setup(l){return(s,e)=>(n(),h("div",Ct,[t("div",Dt,[t("h5",Ft,[s.tab===0?(n(),h("span",Tt,"Вы выбрали")):c("",!0),s.tab===1?(n(),h("span",xt,"Оформление заказа")):c("",!0)]),Et]),s.tab===0?(n(),h("div",Pt,[s.cartProducts.length>0?(n(),h(L,{key:0},[(n(!0),h(L,null,R(s.cartProducts,r=>(n(),v($t,{item:r},null,8,["item"]))),256)),St,t("button",{onClick:e[0]||(e[0]=(...r)=>s.downloadCartExcel&&s.downloadCartExcel(...r)),class:"btn btn-dark rounded-0 w-100 mb-2"}," Скачать в виде Excel-файла "),t("button",{onClick:e[1]||(e[1]=(...r)=>s.clearCart&&s.clearCart(...r)),class:"btn btn-outline-secondary rounded-0 w-100 mb-2"}," Очистить корзину ")],64)):(n(),h("div",jt,Mt))])):c("",!0),s.tab===1?(n(),h("div",Vt,[s.step===1?(n(),v(qe,{key:0,onBack:s.back},null,8,["onBack"])):c("",!0)])):c("",!0),s.cartProducts.length>0&&s.tab===0?(n(),h("div",It,[t("div",qt,[t("div",Nt,[t("h6",Ot,"Итого цена "+_(s.cartTotalPrice)+" ₽",1),At,Rt,s.step===0?(n(),h("div",Ut,[t("button",{class:"btn btn-dark rounded-0 w-100 mb-2",onClick:e[2]||(e[2]=(...r)=>s.checkout&&s.checkout(...r))},"Обсудить заказ с менеджером "),t("button",{class:"btn btn-outline-secondary rounded-0 w-100 mb-2",onClick:e[3]||(e[3]=(...r)=>s.checkout&&s.checkout(...r))},"Получить цену на почту "),t("button",{class:"btn btn-outline-secondary rounded-0 w-100 mb-2",onClick:e[4]||(e[4]=(...r)=>s.checkout&&s.checkout(...r))},"Получить цену в Telegram ")])):c("",!0)])])])):c("",!0)]))}}),Qt={class:"min-h-screen bg-gray-100"},Zt={class:"bg-white border-b border-gray-100"},Gt={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"},Jt={class:"flex justify-between h-16"},Kt={class:"flex"},Xt={class:"shrink-0 flex items-center"},Yt={class:"hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"},Ht={class:"badge bg-danger ml-1 rounded-full"},Wt={class:"hidden sm:flex sm:items-center sm:ms-6"},es={class:"ms-3 relative"},ts={class:"inline-flex rounded-0"},ss={type:"button",class:"inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-0 text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"},os=t("svg",{class:"ms-2 -me-0.5 h-4 w-4",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor"},[t("path",{"fill-rule":"evenodd",d:"M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z","clip-rule":"evenodd"})],-1),ns={class:"-me-2 flex items-center sm:hidden"},as={class:"h-6 w-6",stroke:"currentColor",fill:"none",viewBox:"0 0 24 24"},rs={class:"pt-2 pb-3 space-y-1"},is={class:"pt-4 pb-1 border-t border-gray-200"},ls={class:"px-4"},cs={class:"font-medium text-base text-gray-800"},ds={class:"font-medium text-sm text-gray-500"},us={class:"mt-3 space-y-1"},hs=t("hr",null,null,-1),ms={class:"mt-3 space-y-1"},fs=t("i",{class:"fa-solid fa-lock"},null,-1),ps=t("i",{class:"fa-solid fa-lock"},null,-1),vs={key:0,class:"bg-white shadow"},_s={class:"max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"},bs=W('<div class="container border-b border-gray-100"><footer class="py-3 my-4"><div class="d-flex justify-center"><img src="/images/logo.jpg" style="width:100px;" alt=""></div><p class="text-center text-muted">© 2024 DoDoors</p></footer></div>',1),ys={key:0,class:"cart-fixed-btn"},gs={class:"btn rounded-0 shadow-lg","data-bs-toggle":"offcanvas",href:"#cart",role:"button","aria-controls":"cart"},ks=t("i",{class:"fa-solid fa-basket-shopping text-primary"},null,-1),ws={class:"badge text-primary font-bold"},$s={class:"offcanvas offcanvas-start","data-bs-scroll":"true","data-bs-backdrop":"false",tabindex:"-1",id:"main-side-admin-menu","aria-labelledby":"offcanvasExampleLabel"},Cs=t("div",{class:"offcanvas-header"},[t("h5",{class:"offcanvas-title",id:"offcanvasExampleLabel"}," DoDoors "),t("button",{type:"button",class:"btn-close","data-bs-dismiss":"offcanvas","aria-label":"Close"},[t("i",{class:"fa-solid fa-xmark"})])],-1),Ds={class:"offcanvas-body"},Fs={class:"row"},Ts={class:"col-md-6"},xs=t("i",{class:"fa-solid fa-user-tie mr-2"},null,-1),Es={class:"col-md-6"},Ps=t("i",{class:"fa-solid fa-screwdriver-wrench mr-2"},null,-1),Ss={class:"py-5"},js={key:0,class:"d-flex flex-col align-items-center"},Ls={key:1,class:"d-flex flex-col align-items-center"},Ms={data(){return{menuTab:0}},computed:{...I(["getErrors","cartTotalCount","cartProducts"])},mounted(){},methods:{hasRoles(l){return(this.$page.props.auth.roles||[]).includes(l)},can(l){return(this.$page.props.auth.permissions||[]).includes(l)}}},Ns=Object.assign(Ms,{__name:"AuthenticatedLayout",setup(l){const s=A(!1);return(e,r)=>{const o=H("notifications");return n(),h(L,null,[t("div",null,[F(o,{position:"top right"}),t("div",Qt,[t("nav",Zt,[t("div",Gt,[t("div",Jt,[t("div",Kt,[t("div",Xt,[F(M(V),{href:e.route("dashboard")},{default:f(()=>[F(Q,{class:"block h-9 w-auto fill-current text-gray-800"})]),_:1},8,["href"])]),t("div",Yt,[e.can("manage-views-adminmenu")?(n(),v(k,{key:0,"data-bs-toggle":"offcanvas",href:"#main-side-admin-menu",role:"button","aria-controls":"main-side-admin-menu"},{default:f(()=>[m(" Админ.меню ")]),_:1})):c("",!0),F(k,{href:e.route("dashboard"),active:e.route().current("dashboard")},{default:f(()=>[m(" Главная ")]),_:1},8,["href","active"]),e.cartTotalCount>0?(n(),v(k,{key:1,href:e.route("basket"),active:e.route().current("basket")},{default:f(()=>[m(" Корзина "),t("span",Ht,_(e.cartTotalCount),1)]),_:1},8,["href","active"])):c("",!0)])]),t("div",Wt,[t("div",es,[F(te,{align:"right",width:"48"},{trigger:f(()=>[t("span",ts,[t("button",ss,[m(_(e.$page.props.auth.user.name)+" ",1),os])])]),content:f(()=>[F(O,{href:e.route("profile.edit")},{default:f(()=>[m(" Профиль")]),_:1},8,["href"]),F(O,{href:e.route("logout"),method:"post",as:"button"},{default:f(()=>[m(" Выход ")]),_:1},8,["href"])]),_:1})])]),t("div",ns,[t("button",{onClick:r[0]||(r[0]=a=>s.value=!s.value),class:"inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"},[(n(),h("svg",as,[t("path",{class:x({hidden:s.value,"inline-flex":!s.value}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M4 6h16M4 12h16M4 18h16"},null,2),t("path",{class:x({hidden:!s.value,"inline-flex":s.value}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M6 18L18 6M6 6l12 12"},null,2)]))])])])]),t("div",{class:x([{block:s.value,hidden:!s.value},"sm:hidden"])},[t("div",rs,[F(D,{href:e.route("dashboard"),active:e.route().current("dashboard")},{default:f(()=>[m(" Главная страница ")]),_:1},8,["href","active"])]),t("div",is,[t("div",ls,[t("div",cs,_(e.$page.props.auth.user.name),1),t("div",ds,_(e.$page.props.auth.user.email),1)]),t("div",us,[F(D,{href:e.route("profile.edit")},{default:f(()=>[m(" Профиль")]),_:1},8,["href"]),F(D,{href:e.route("logout"),method:"post",as:"button"},{default:f(()=>[m(" Выход ")]),_:1},8,["href"]),hs]),t("div",ms,[e.can("manage-users")?(n(),v(D,{key:0,class:"p-3",href:e.route("users"),active:e.route().current("users")},{default:f(()=>[m(" Пользователи ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-clients")?(n(),v(D,{key:1,class:"p-3"},{default:f(()=>[m(" Клиенты "),fs]),_:1})):c("",!0),e.can("manage-orders")?(n(),v(D,{key:2,class:"p-3"},{default:f(()=>[m(" Заказы "),ps]),_:1})):c("",!0),e.can("manage-materials")?(n(),v(D,{key:3,class:"p-3",href:e.route("materials"),active:e.route().current("materials")},{default:f(()=>[m(" Материалы ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-handles")?(n(),v(D,{key:4,class:"p-3",href:e.route("handles"),active:e.route().current("handles")},{default:f(()=>[m(" Ручки ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-hinges")?(n(),v(D,{key:5,class:"p-3",href:e.route("hinges"),active:e.route().current("hinges")},{default:f(()=>[m(" Петли ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-door-variants")?(n(),v(D,{key:6,class:"p-3",href:e.route("door-variants"),active:e.route().current("door-variants")},{default:f(()=>[m(" Типы дверей ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-colors")?(n(),v(D,{key:7,class:"p-3",href:e.route("colors"),active:e.route().current("colors")},{default:f(()=>[m(" Цвета ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-sizes")?(n(),v(D,{key:8,class:"p-3",href:e.route("sizes"),active:e.route().current("sizes")},{default:f(()=>[m(" Размеры ")]),_:1},8,["href","active"])):c("",!0)])])],2)]),e.$slots.header?(n(),h("header",vs,[t("div",_s,[E(e.$slots,"header")])])):c("",!0),t("main",null,[E(e.$slots,"default")])])]),bs,e.cartTotalCount>0?(n(),h("div",ys,[t("a",gs,[ks,t("span",ws,_(e.cartTotalCount)+" шт.",1)])])):c("",!0),F(Bt),t("div",$s,[Cs,t("div",Ds,[t("div",Fs,[t("div",Ts,[t("button",{class:x(["btn w-100 rounded-0",{"btn-dark":e.menuTab===0,"btn-outline-secondary":e.menuTab!==0}]),onClick:r[1]||(r[1]=a=>e.menuTab=0)},[xs,m("Общее ")],2)]),t("div",Es,[t("button",{class:x(["btn w-100 rounded-0",{"btn-dark":e.menuTab===1,"btn-outline-secondary":e.menuTab!==1}]),onClick:r[2]||(r[2]=a=>e.menuTab=1)},[Ps,m("Админ ")],2)])]),t("div",Ss,[e.menuTab===0?(n(),h("nav",js,[e.can("manage-calc")?(n(),v(k,{key:0,class:"p-3",href:e.route("calc"),active:e.route().current("calc")},{default:f(()=>[m(" Калькулятор ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-clients")?(n(),v(k,{key:1,class:"p-3",href:e.route("clients"),active:e.route().current("clients")},{default:f(()=>[m(" Клиенты ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-clients")?(n(),v(k,{key:2,class:"p-3",href:e.route("documents"),active:e.route().current("documents")},{default:f(()=>[m(" Договора (Документы) ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-orders")?(n(),v(k,{key:3,class:"p-3",href:e.route("orders"),active:e.route().current("orders")},{default:f(()=>[m(" Заказы ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-promo-codes")?(n(),v(k,{key:4,class:"p-3",href:e.route("promo-codes"),active:e.route().current("promo-codes")},{default:f(()=>[m(" Промокоды ")]),_:1},8,["href","active"])):c("",!0)])):c("",!0),e.menuTab===1?(n(),h("nav",Ls,[e.can("manage-users")?(n(),v(k,{key:0,class:"p-3",href:e.route("users"),active:e.route().current("users")},{default:f(()=>[m(" Пользователи ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-roles")?(n(),v(k,{key:1,class:"p-3",href:e.route("roles"),active:e.route().current("roles")},{default:f(()=>[m(" Роли пользователей ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-permissions")?(n(),v(k,{key:2,class:"p-3",href:e.route("permissions"),active:e.route().current("permissions")},{default:f(()=>[m(" Разрешения пользователей ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-materials")?(n(),v(k,{key:3,class:"p-3",href:e.route("materials"),active:e.route().current("materials")},{default:f(()=>[m(" Материалы ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-handles")?(n(),v(k,{key:4,class:"p-3",href:e.route("handles"),active:e.route().current("handles")},{default:f(()=>[m(" Ручки ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-hinges")?(n(),v(k,{key:5,class:"p-3",href:e.route("hinges"),active:e.route().current("hinges")},{default:f(()=>[m(" Петли ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-door-variants")?(n(),v(k,{key:6,class:"p-3",href:e.route("door-variants"),active:e.route().current("door-variants")},{default:f(()=>[m(" Типы дверей ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-colors")?(n(),v(k,{key:7,class:"p-3",href:e.route("colors"),active:e.route().current("colors")},{default:f(()=>[m(" Цвета ")]),_:1},8,["href","active"])):c("",!0),e.can("manage-sizes")?(n(),v(k,{key:8,class:"p-3",href:e.route("sizes"),active:e.route().current("sizes")},{default:f(()=>[m(" Размеры ")]),_:1},8,["href","active"])):c("",!0)])):c("",!0)])])])],64)}}});export{qe as C,Ns as _,B as v};
