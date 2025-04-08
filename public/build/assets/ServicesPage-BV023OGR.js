import{_ as $}from"./AuthenticatedLayout-CVSut16L.js";import{o as s,c as i,b as e,g as _,v as m,h as w,i as S,F as u,r as v,d as c,f as a,j as C,t as p,m as F,e as f,l as V,a as b,u as j,w as y,Z as M}from"./app-Bt_CszfV.js";import{P as x}from"./Pagination-nG-LyF60.js";import{_ as D}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./ApplicationLogo-Cpp7e418.js";import"./vue-the-mask-DlB0C2QX.js";const I={props:["item"],data(){return{messages:[],loading:!1,types:[{title:"Работа с ручками",value:"service_handle"},{title:"Работа со стопором",value:"service_stopper"},{title:"Работа с порогом",value:"service_doorstep"},{title:"Работа с доводчиком",value:"service_door_closer"},{title:"Работа с плинтусом",value:"service_baseboard"},{title:"Установка двери",value:"service_door_install"},{title:"Упаковка двери",value:"service_door_wrapper"},{title:"Покраска элементов",value:"service_painting"}],form:{id:null,title:null,description:null,type:null,order_position:0,is_active:!0,price:{wholesale:0,dealer:0,retail:0,cost:0}}}},computed:{needClearForm(){return this.form.id||this.form.title||this.form.description||this.form.order_position||this.form.type}},mounted(){this.item&&this.$nextTick(()=>{this.form={id:this.item.id||null,title:this.item.title||null,description:this.item.description||null,is_active:this.item.is_active||!0,type:this.item.type||null,order_position:this.item.order_position||0,price:this.item.price||{wholesale:0,dealer:0,retail:0,cost:0}}})},methods:{alert(r){this.messages.push(r)},resetForm(){this.form.id=null,this.form.title=null,this.form.description=null,this.form.type=null,this.form.order_position=0,this.form.is_active=!1,this.form.price={wholesale:0,dealer:0,retail:0,cost:0},this.$emit("callback")},removeMessage(r){this.messages.splice(r,1)},submit(){let r=new FormData;Object.keys(this.form).forEach(t=>{const n=this.form[t]||"";typeof n=="object"?r.append(t,JSON.stringify(n)):r.append(t,n)}),this.$store.dispatch("storeService",{serviceForm:r}).then(t=>{this.$emit("callback"),this.resetForm()}).catch(t=>{})}}},L={class:"form-floating mb-3"},U=e("label",{for:"service-title"},"Наименование варианта двери",-1),T={class:"form-floating mb-3"},A=e("label",{for:"service-description"},"Пояснение к параметру",-1),O={class:"form-check form-switch mb-3"},P=e("label",{class:"form-check-label",for:"service-is_active"}," Отображается в калькуляторе ",-1),N={class:"form-floating mb-3"},q=["value"],B=e("label",{for:"service-type"},"Тип сервиса",-1),E={class:"form-floating mb-3"},G=e("label",{for:"service-order_position"},"Позиция в выдаче",-1),J={class:"card rounded-0 mb-3 border-black"},Z=e("div",{class:"card-header bg-dark text-white rounded-0"},[e("h6",null,"Настройка цены")],-1),z={class:"card-body"},H={class:"row"},K={class:"col-md-6 col-12"},Q={class:"form-floating mb-3"},R={for:"price-wholesale"},W={key:0},X={key:1},Y={class:"col-md-6 col-12"},ee={class:"form-floating mb-3"},te={for:"price-retail"},se={key:0},oe={key:1},ie={class:"col-md-6 col-12 mb-3"},le={class:"form-floating"},re={for:"price-dealer"},ne={key:0},de={key:1},ae={class:"col-md-6 col-12"},ce={class:"form-floating"},he={for:"price-cost"},_e={key:0},me={key:1},pe={class:"row"},ue={class:"col-12"},fe={class:"alert alert-danger alert-dismissible fade show",role:"alert"},ve=e("strong",null,"Внимание!",-1),be=["onClick"],ye={class:"row mt-5"},ge={class:"col-12 d-flex justify-content-center"},ke=["disabled"],$e={key:0,class:"fa-regular fa-floppy-disk mr-1"},we={key:1,class:"spinner-border spinner-border-sm text-success",role:"status"},Se=e("i",{class:"fa-solid fa-xmark mr-1"},null,-1);function Ce(r,t,n,d,o,h){return s(),i("form",{action:"",onSubmit:t[10]||(t[10]=C((...l)=>h.submit&&h.submit(...l),["prevent"]))},[e("div",L,[_(e("input",{type:"text","onUpdate:modelValue":t[0]||(t[0]=l=>o.form.title=l),class:"form-control",id:"service-title",required:""},null,512),[[m,o.form.title]]),U]),e("div",T,[_(e("input",{type:"text","onUpdate:modelValue":t[1]||(t[1]=l=>o.form.description=l),class:"form-control",id:"service-description"},null,512),[[m,o.form.description]]),A]),e("div",O,[_(e("input",{class:"form-check-input","onUpdate:modelValue":t[2]||(t[2]=l=>o.form.is_active=l),type:"checkbox",role:"switch",id:"service-is_active"},null,512),[[w,o.form.is_active]]),P]),e("div",N,[_(e("select",{class:"form-select","onUpdate:modelValue":t[3]||(t[3]=l=>o.form.type=l),id:"service-type","aria-label":"Floating label select example"},[(s(!0),i(u,null,v(o.types,l=>(s(),i("option",{value:l.value},p(l.title||"-"),9,q))),256))],512),[[S,o.form.type]]),B]),e("div",E,[_(e("input",{type:"text","onUpdate:modelValue":t[4]||(t[4]=l=>o.form.order_position=l),class:"form-control",id:"service-order_position"},null,512),[[m,o.form.order_position]]),G]),e("div",J,[Z,e("div",z,[e("div",H,[e("div",K,[e("div",Q,[_(e("input",{type:"number","onUpdate:modelValue":t[5]||(t[5]=l=>o.form.price.wholesale=l),class:"form-control",id:"price-wholesale",required:""},null,512),[[m,o.form.price.wholesale]]),e("label",R,[c("Опт"),o.form.need_percent_price?(s(),i("span",W,", %")):(s(),i("span",X,", руб"))])])]),e("div",Y,[e("div",ee,[_(e("input",{type:"number","onUpdate:modelValue":t[6]||(t[6]=l=>o.form.price.retail=l),class:"form-control",id:"price-retail",required:""},null,512),[[m,o.form.price.retail]]),e("label",te,[c("Розница"),o.form.need_percent_price?(s(),i("span",se,", %")):(s(),i("span",oe,", руб"))])])]),e("div",ie,[e("div",le,[_(e("input",{type:"number","onUpdate:modelValue":t[7]||(t[7]=l=>o.form.price.dealer=l),class:"form-control",id:"price-dealer",required:""},null,512),[[m,o.form.price.dealer]]),e("label",re,[c("Дилер"),o.form.need_percent_price?(s(),i("span",ne,", %")):(s(),i("span",de,", руб"))])])]),e("div",ae,[e("div",ce,[_(e("input",{type:"number","onUpdate:modelValue":t[8]||(t[8]=l=>o.form.price.cost=l),class:"form-control",id:"price-cost",required:""},null,512),[[m,o.form.price.cost]]),e("label",he,[c("Себестоимость"),o.form.need_percent_price?(s(),i("span",_e,", %")):(s(),i("span",me,", руб"))])])])])])]),e("div",pe,[e("div",ue,[o.messages.length>0?(s(!0),i(u,{key:0},v(o.messages,(l,k)=>(s(),i("div",fe,[ve,c(" "+p(l||"Ошибка")+" ",1),e("button",{type:"button",class:"btn-close",onClick:Et=>h.removeMessage(k)},null,8,be)]))),256)):a("",!0)])]),e("div",ye,[e("div",ge,[e("button",{disabled:!h.needClearForm,class:"btn btn-dark rounded-0"},[o.loading?(s(),i("span",we)):(s(),i("i",$e)),c(" Сохранить сервис ")],8,ke),h.needClearForm&&!o.loading?(s(),i("button",{key:0,type:"button",onClick:t[9]||(t[9]=(...l)=>h.resetForm&&h.resetForm(...l)),class:"btn btn-outline-secondary rounded-0 ml-2"},[Se,c(" Очистить форму ")])):a("",!0)])])],32)}const g=D(I,[["render",Ce]]),Fe={class:"row"},Ve={class:"col-12"},je={class:"input-group mb-3"},Me={class:"form-floating"},xe=e("label",{for:"search-services"},"Поиск по доступным сервисам",-1),De=e("i",{class:"fa-solid fa-magnifying-glass"},null,-1),Ie=[De],Le={style:{"overflow-y":"auto"}},Ue={key:0,class:"table"},Te={key:0},Ae=e("i",{class:"fa-solid fa-caret-down"},null,-1),Oe=[Ae],Pe={key:1},Ne=e("i",{class:"fa-solid fa-caret-up"},null,-1),qe=[Ne],Be=e("th",{scope:"col",class:"text-center"},"Действие",-1),Ee={key:0},Ge=e("i",{class:"fa-solid fa-caret-down"},null,-1),Je=[Ge],Ze={key:1},ze=e("i",{class:"fa-solid fa-caret-up"},null,-1),He=[ze],Ke={key:0},Qe=e("i",{class:"fa-solid fa-caret-down"},null,-1),Re=[Qe],We={key:1},Xe=e("i",{class:"fa-solid fa-caret-up"},null,-1),Ye=[Xe],et=V('<table class="w-100"><thead><th style="width:100px;">опт</th><th style="width:100px;">дилер</th><th style="width:100px;">розница</th><th style="width:100px;">себестоимость</th></thead><tbody></tbody></table>',1),tt={scope:"row"},st={class:"text-center"},ot={class:"dropdown"},it=e("button",{class:"btn btn-link",type:"button","data-bs-toggle":"dropdown","aria-expanded":"false"},[e("i",{class:"fa-solid fa-bars"})],-1),lt={class:"dropdown-menu"},rt=["onClick"],nt=e("i",{class:"fa-solid fa-pen mr-2"},null,-1),dt=["onClick"],at=e("i",{class:"fa-solid fa-trash-can mr-2"},null,-1),ct=["onClick"],ht={class:"text-center"},_t={class:"w-100"},mt={style:{width:"100px","text-align":"center"}},pt={style:{width:"100px","text-align":"center"}},ut={style:{width:"100px","text-align":"center"}},ft={style:{width:"100px","text-align":"center"}},vt={key:0,class:"alert alert-success",role:"alert"},bt=e("h4",{class:"alert-heading"},"Варианты дверей",-1),yt=e("p",null,"К сожалению, раздел Варианты дверей пуст. Вы еще не добавили ни одного варианта дверей, которые можно отобразить на этой странице.",-1),gt=e("hr",null,null,-1),kt=e("p",{class:"mb-0"},"Воспользуйтесь формой выше и добавьте свой первый вариант дверей",-1),$t=[bt,yt,gt,kt],wt={key:1,class:"row mb-3"},St={class:"col-12"},Ct={class:"modal fade",id:"service-editor-modal",tabindex:"-1","aria-labelledby":"exampleModalLabel","aria-hidden":"true"},Ft={class:"modal-dialog modal-lg"},Vt={class:"modal-content rounded-0"},jt={class:"modal-body"},Mt={data(){return{editor_modal:null,selected_item:null,sort:{column:null,direction:"desc"},search:null,current_page:0,paginate_object:null,items:[{id:null,title:null,price:{wholesale:0,dealer:0,retail:0,cost:0},type:null,description:null,is_active:!0,order_position:0}]}},computed:{...F(["getServices","getServicesPaginateObject"])},mounted(){this.loadServices(),this.editor_modal=new bootstrap.Modal(document.getElementById("service-editor-modal"),{})},methods:{sortAndLoad(r){this.sort.column=r,this.sort.direction=this.sort.direction==="desc"?"asc":"desc",this.loadServices(this.current_page)},loadServices(r=0){this.current_page=r,this.$store.dispatch("loadServices",{dataObject:{search:this.search,order:this.sort.column,direction:this.sort.direction},page:this.current_page}).then(t=>{this.items=this.getServices,this.paginate_object=this.getServicesPaginateObject}).catch(()=>{this.loading=!1})},selectItem(r){if(r==null){this.selected_item=null,this.editor_modal.hide();return}this.selected_item=null,this.$nextTick(()=>{this.selected_item=r,this.editor_modal.show()})},duplicateItem(r){this.$store.dispatch("duplicateDoorVariant",{doorVariantId:r}).then(()=>{this.sortAndLoad("id")})},removeItem(r){this.$store.dispatch("removeDoorVariant",{doorVariantId:r}).then(()=>{this.sortAndLoad("id")})}}},xt=Object.assign(Mt,{__name:"ServiceTable",setup(r){return(t,n)=>(s(),i(u,null,[e("form",Fe,[e("div",Ve,[e("div",je,[e("div",Me,[_(e("input",{type:"search","onUpdate:modelValue":n[0]||(n[0]=d=>t.search=d),class:"form-control",id:"search-services"},null,512),[[m,t.search]]),xe]),e("button",{type:"button",onClick:n[1]||(n[1]=d=>t.sortAndLoad("id")),class:"btn btn-outline-secondary rounded-0"},Ie)])])]),e("div",Le,[t.items.length>0?(s(),i("table",Ue,[e("thead",null,[e("tr",null,[e("th",{scope:"col",class:"cursor-pointer",onClick:n[2]||(n[2]=d=>t.sortAndLoad("id"))},[c("# "),t.sort.direction==="desc"&&t.sort.column==="id"?(s(),i("span",Te,Oe)):a("",!0),t.sort.direction==="asc"&&t.sort.column==="id"?(s(),i("span",Pe,qe)):a("",!0)]),Be,e("th",{scope:"col",class:"text-center cursor-pointer",onClick:n[3]||(n[3]=d=>t.sortAndLoad("title"))},[c("Название "),t.sort.direction==="desc"&&t.sort.column==="title"?(s(),i("span",Ee,Je)):a("",!0),t.sort.direction==="asc"&&t.sort.column==="title"?(s(),i("span",Ze,He)):a("",!0)]),e("th",{scope:"col",class:"text-center cursor-pointer",onClick:n[4]||(n[4]=d=>t.sortAndLoad("price"))},[c("Цена, ₽ "),t.sort.direction==="desc"&&t.sort.column==="price"?(s(),i("span",Ke,Re)):a("",!0),t.sort.direction==="asc"&&t.sort.column==="price"?(s(),i("span",We,Ye)):a("",!0),et])])]),e("tbody",null,[(s(!0),i(u,null,v(t.items,(d,o)=>(s(),i("tr",null,[e("th",tt,p(d.id||o),1),e("td",st,[e("div",ot,[it,e("ul",lt,[e("li",null,[e("a",{class:"dropdown-item",onClick:h=>t.selectItem(d),href:"javascript:void(0)"},[nt,c("Редактировать")],8,rt)]),e("li",null,[e("a",{class:"dropdown-item text-danger",onClick:h=>t.removeItem(d.id),href:"javascript:void(0)"},[at,c("Удалить")],8,dt)])])])]),e("td",{class:"text-center",onClick:h=>t.selectItem(d)},p(d.title||"-"),9,ct),e("td",ht,[e("table",_t,[e("tbody",null,[e("tr",null,[e("td",mt,p(t.items[o].price.wholesale||0),1),e("td",pt,p(t.items[o].price.dealer||0),1),e("td",ut,p(t.items[o].price.retail||0),1),e("td",ft,p(t.items[o].price.cost||0),1)])])])])]))),256))])])):a("",!0)]),t.items.length===0?(s(),i("div",vt,$t)):a("",!0),t.items.length>0?(s(),i("div",wt,[e("div",St,[t.paginate_object?(s(),f(x,{key:0,onPagination_page:t.loadServices,pagination:t.paginate_object},null,8,["onPagination_page","pagination"])):a("",!0)])])):a("",!0),e("div",Ct,[e("div",Ft,[e("div",Vt,[e("div",jt,[t.selected_item?(s(),f(g,{key:0,item:t.selected_item,onCallback:n[5]||(n[5]=d=>t.selectItem(null))},null,8,["item"])):a("",!0)])])])])],64))}}),Dt=e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Сервисы",-1),It={class:"py-12"},Lt={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},Ut={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},Tt={class:"p-6 text-gray-900"},At={key:0,class:"fa-solid fa-file-import"},Ot={key:1,class:"spinner-border spinner-border-sm text-primary",role:"status"},Pt=e("span",{class:"visually-hidden"},"Loading...",-1),Nt=[Pt],qt=e("hr",{class:"hr my-5"},null,-1),Bt={data(){return{loading:!1,moysklad_loading:!1,selectedService:null}},methods:{selectService(r){this.selectedService=r,this.loading=!0,this.$nextTick(()=>{this.loading=!1})},callbackServiceForm(){this.loading=!0,this.selectedService=null,this.$nextTick(()=>{this.loading=!1})},importServicesFromMoySklad(){this.$notify({title:"DoDoors",text:"Началась загрузка данных"}),this.moysklad_loading=!0,this.$store.dispatch("importServicesFromMoySklad").then(()=>{this.$notify({title:"DoDoors",text:"Данные успешно загружены",type:"success"}),this.loading=!0,this.$nextTick(()=>{this.loading=!1,this.moysklad_loading=!1})}).catch(()=>{this.$notify({title:"DoDoors",text:"Ошибка загрузки данных",type:"error"}),this.moysklad_loading=!1})}}},Qt=Object.assign(Bt,{__name:"ServicesPage",setup(r){return(t,n)=>(s(),i(u,null,[b(j(M),{title:"Сервисы"}),b($,null,{header:y(()=>[Dt]),default:y(()=>[e("div",It,[e("div",Lt,[e("div",Ut,[e("div",Tt,[e("button",{class:"my-3 p-3 border-gray-100 border btn rounded-0",type:"button",onClick:n[0]||(n[0]=(...d)=>t.importServicesFromMoySklad&&t.importServicesFromMoySklad(...d))},[t.moysklad_loading?(s(),i("div",Ot,Nt)):(s(),i("i",At)),c(" Загрузить данные из Мой Склад ")]),t.loading?a("",!0):(s(),f(g,{key:0,item:t.selectedService,onCallback:t.callbackServiceForm},null,8,["item","onCallback"])),qt,t.loading?a("",!0):(s(),f(xt,{key:1,onSelect:t.selectService},null,8,["onSelect"]))])])])])]),_:1})],64))}});export{Qt as default};
