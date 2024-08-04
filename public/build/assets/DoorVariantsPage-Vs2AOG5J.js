import{_ as v}from"./AuthenticatedLayout-hakV431P.js";import{m as $,o as s,c as o,b as e,f as p,v as u,g as a,e as c,F as m,r as k,d as f,t as h,h as w,j as V,a as b,u as D,w as g,Z as C}from"./app-DQBQKKhA.js";import{P as j}from"./Pagination-_PVCuvTQ.js";import{_ as F}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./ApplicationLogo-BHcr6PlQ.js";import"./vue-the-mask-DS_Oh2nZ.js";const L={class:"row"},A={class:"col-12"},I={class:"input-group mb-3"},O={class:"form-floating"},P=e("label",{for:"search-door-variants"},"Поиск по производителям петель",-1),U=e("i",{class:"fa-solid fa-magnifying-glass"},null,-1),T=[U],q={style:{"overflow-y":"auto"}},M={key:0,class:"table"},N={key:0},S=e("i",{class:"fa-solid fa-caret-down"},null,-1),B=[S],E={key:1},G=e("i",{class:"fa-solid fa-caret-up"},null,-1),J=[G],Z={key:0},z=e("i",{class:"fa-solid fa-caret-down"},null,-1),H=[z],K={key:1},Q=e("i",{class:"fa-solid fa-caret-up"},null,-1),R=[Q],W={key:0},X=e("i",{class:"fa-solid fa-caret-down"},null,-1),Y=[X],x={key:1},ee=e("i",{class:"fa-solid fa-caret-up"},null,-1),te=[ee],se={key:0},oe=e("i",{class:"fa-solid fa-caret-down"},null,-1),ie=[oe],ne={key:1},re=e("i",{class:"fa-solid fa-caret-up"},null,-1),le=[re],ae=e("th",{scope:"col",class:"text-center"},"Действие",-1),ce={scope:"row"},de=["onClick"],_e={class:"text-center",style:{width:"50px"}},he={class:"text-center"},pe={class:"w-100"},ue={key:0},me={key:1},fe={key:0},be={key:1},ge={key:0},ke={key:1},ye={key:0},ve={key:1},$e={style:{"min-width":"100px","text-align":"center"}},we={style:{"min-width":"100px","text-align":"center"}},Ve={style:{"min-width":"100px","text-align":"center"}},De={style:{"min-width":"100px","text-align":"center"}},Ce={class:"text-center"},je={class:"dropdown"},Fe=e("button",{class:"btn btn-link",type:"button","data-bs-toggle":"dropdown","aria-expanded":"false"},[e("i",{class:"fa-solid fa-bars"})],-1),Le={class:"dropdown-menu"},Ae=["onClick"],Ie=e("i",{class:"fa-solid fa-pen mr-2"},null,-1),Oe=["onClick"],Pe=e("i",{class:"fa-solid fa-trash-can mr-2"},null,-1),Ue={key:0,class:"alert alert-success",role:"alert"},Te=e("h4",{class:"alert-heading"},"Варианты дверей",-1),qe=e("p",null,"К сожалению, раздел Варианты дверей пуст. Вы еще не добавили ни одного варианта дверей, которые можно отобразить на этой странице.",-1),Me=e("hr",null,null,-1),Ne=e("p",{class:"mb-0"},"Воспользуйтесь формой выше и добавьте свой первый вариант дверей",-1),Se=[Te,qe,Me,Ne],Be={key:1,class:"row mb-3"},Ee={class:"col-12"},Ge={data(){return{sort:{column:null,direction:"desc"},search:null,current_page:0,paginate_object:null,items:[{id:null,title:null,price:0}]}},computed:{...$(["getDoorVariants","getDoorVariantsPaginateObject"])},mounted(){this.loadDoorVariants()},methods:{sortAndLoad(n){this.sort.column=n,this.sort.direction=this.sort.direction==="desc"?"asc":"desc",this.loadDoorVariants(this.current_page)},loadDoorVariants(n=0){this.current_page=n,this.$store.dispatch("loadDoorVariants",{dataObject:{search:this.search,order:this.sort.column,direction:this.sort.direction},page:this.current_page}).then(t=>{this.items=this.getDoorVariants,this.paginate_object=this.getDoorVariantsPaginateObject}).catch(()=>{this.loading=!1})},selectItem(n){this.$emit("select",n)},duplicateItem(n){this.$store.dispatch("duplicateDoorVariant",{doorVariantId:n}).then(()=>{this.sortAndLoad("id")})},removeItem(n){this.$store.dispatch("removeDoorVariant",{doorVariantId:n}).then(()=>{this.sortAndLoad("id")})}}},Je=Object.assign(Ge,{__name:"DoorVariantTable",setup(n){return(t,r)=>(s(),o(m,null,[e("form",L,[e("div",A,[e("div",I,[e("div",O,[p(e("input",{type:"search","onUpdate:modelValue":r[0]||(r[0]=d=>t.search=d),class:"form-control",id:"search-door-variants"},null,512),[[u,t.search]]),P]),e("button",{type:"button",onClick:r[1]||(r[1]=d=>t.sortAndLoad("id")),class:"btn btn-outline-secondary rounded-0"},T)])])]),e("div",q,[t.items.length>0?(s(),o("table",M,[e("thead",null,[e("tr",null,[e("th",{scope:"col",class:"cursor-pointer",onClick:r[2]||(r[2]=d=>t.sortAndLoad("id"))},[a("# "),t.sort.direction==="desc"&&t.sort.column==="id"?(s(),o("span",N,B)):c("",!0),t.sort.direction==="asc"&&t.sort.column==="id"?(s(),o("span",E,J)):c("",!0)]),e("th",{scope:"col",class:"text-center cursor-pointer",onClick:r[3]||(r[3]=d=>t.sortAndLoad("title"))},[a("Название "),t.sort.direction==="desc"&&t.sort.column==="title"?(s(),o("span",Z,H)):c("",!0),t.sort.direction==="asc"&&t.sort.column==="title"?(s(),o("span",K,R)):c("",!0)]),e("th",{scope:"col",class:"text-center cursor-pointer",onClick:r[4]||(r[4]=d=>t.sortAndLoad("need_percent_price"))},[a("% "),t.sort.direction==="desc"&&t.sort.column==="need_percent_price"?(s(),o("span",W,Y)):c("",!0),t.sort.direction==="asc"&&t.sort.column==="need_percent_price"?(s(),o("span",x,te)):c("",!0)]),e("th",{scope:"col",class:"text-center cursor-pointer",onClick:r[5]||(r[5]=d=>t.sortAndLoad("price"))},[a("Цена "),t.sort.direction==="desc"&&t.sort.column==="price"?(s(),o("span",se,ie)):c("",!0),t.sort.direction==="asc"&&t.sort.column==="price"?(s(),o("span",ne,le)):c("",!0)]),ae])]),e("tbody",null,[(s(!0),o(m,null,k(t.items,(d,i)=>(s(),o("tr",null,[e("th",ce,h(d.id||i),1),e("td",{class:"text-center",onClick:_=>t.selectItem(d)},h(d.title||"-"),9,de),e("td",_e,h(d.need_percent_price?"да":"нет"),1),e("td",he,[e("table",pe,[e("thead",null,[e("th",null,[a("опт"),t.items[i].need_percent_price?(s(),o("span",ue,", %")):(s(),o("span",me,", ₽"))]),e("th",null,[a("дилер"),t.items[i].need_percent_price?(s(),o("span",fe,", %")):(s(),o("span",be,", ₽"))]),e("th",null,[a("розница"),t.items[i].need_percent_price?(s(),o("span",ge,", %")):(s(),o("span",ke,", ₽"))]),e("th",null,[a("себестоимость"),t.items[i].need_percent_price?(s(),o("span",ye,", %")):(s(),o("span",ve,", ₽"))])]),e("tbody",null,[e("tr",null,[e("td",$e,h(t.items[i].price.wholesale||0),1),e("td",we,h(t.items[i].price.dealer||0),1),e("td",Ve,h(t.items[i].price.retail||0),1),e("td",De,h(t.items[i].price.cost||0),1)])])])]),e("td",Ce,[e("div",je,[Fe,e("ul",Le,[e("li",null,[e("a",{class:"dropdown-item",onClick:_=>t.selectItem(d),href:"javascript:void(0)"},[Ie,a("Редактировать")],8,Ae)]),e("li",null,[e("a",{class:"dropdown-item text-danger",onClick:_=>t.removeItem(d.id),href:"javascript:void(0)"},[Pe,a("Удалить")],8,Oe)])])])])]))),256))])])):c("",!0)]),t.items.length===0?(s(),o("div",Ue,Se)):c("",!0),t.items.length>0?(s(),o("div",Be,[e("div",Ee,[t.paginate_object?(s(),f(j,{key:0,onPagination_page:t.loadDoorVariants,pagination:t.paginate_object},null,8,["onPagination_page","pagination"])):c("",!0)])])):c("",!0)],64))}}),Ze={props:["item"],data(){return{messages:[],loading:!1,form:{id:null,title:null,need_percent_price:!1,price:{wholesale:0,dealer:0,retail:0,cost:0}}}},computed:{needClearForm(){return this.form.id||this.form.title||this.form.price}},mounted(){this.item&&this.$nextTick(()=>{this.form={id:this.item.id||null,title:this.item.title||null,need_percent_price:this.item.need_percent_price||!1,price:this.item.price||{wholesale:0,dealer:0,retail:0,cost:0}}})},methods:{alert(n){this.messages.push(n)},resetForm(){this.form.id=null,this.form.title=null,this.form.need_percent_price=!1,this.form.price={wholesale:0,dealer:0,retail:0,cost:0},this.$emit("callback")},removeMessage(n){this.messages.splice(n,1)},submit(){let n=new FormData;Object.keys(this.form).forEach(t=>{const r=this.form[t]||"";typeof r=="object"?n.append(t,JSON.stringify(r)):n.append(t,r)}),this.$store.dispatch("storeDoorVariant",{doorVariantForm:n}).then(t=>{this.$emit("callback"),this.resetForm()}).catch(t=>{})}}},ze={class:"form-floating mb-3"},He=e("label",{for:"door-variant-title"},"Наименование варианта двери",-1),Ke={class:"form-check form-switch mb-3"},Qe=e("label",{class:"form-check-label",for:"is-base"}," Использовать процент от базовой цены ",-1),Re={class:"card rounded-0 mb-3 border-black"},We=e("div",{class:"card-header bg-dark text-white rounded-0"},[e("h6",null,"Настройка цены")],-1),Xe={class:"card-body"},Ye={class:"row"},xe={class:"col-6"},et={class:"form-floating mb-3"},tt={for:"price-wholesale"},st={key:0},ot={key:1},it={class:"col-6"},nt={class:"form-floating mb-3"},rt={for:"price-retail"},lt={key:0},at={key:1},ct={class:"col-6"},dt={class:"form-floating"},_t={for:"price-dealer"},ht={key:0},pt={key:1},ut={class:"col-6"},mt={class:"form-floating"},ft={for:"price-cost"},bt={key:0},gt={key:1},kt={class:"row"},yt={class:"col-12"},vt={class:"alert alert-danger alert-dismissible fade show",role:"alert"},$t=e("strong",null,"Внимание!",-1),wt=["onClick"],Vt={class:"row mt-5"},Dt={class:"col-12 d-flex justify-content-center"},Ct=["disabled"],jt={key:0,class:"fa-regular fa-floppy-disk mr-1"},Ft={key:1,class:"spinner-border spinner-border-sm text-success",role:"status"},Lt=e("i",{class:"fa-solid fa-xmark mr-1"},null,-1);function At(n,t,r,d,i,_){return s(),o("form",{action:"",onSubmit:t[7]||(t[7]=V((...l)=>_.submit&&_.submit(...l),["prevent"]))},[e("div",ze,[p(e("input",{type:"text","onUpdate:modelValue":t[0]||(t[0]=l=>i.form.title=l),class:"form-control",id:"door-variant-title",required:""},null,512),[[u,i.form.title]]),He]),e("div",Ke,[p(e("input",{class:"form-check-input","onUpdate:modelValue":t[1]||(t[1]=l=>i.form.need_percent_price=l),type:"checkbox",role:"switch",id:"is-base"},null,512),[[w,i.form.need_percent_price]]),Qe]),e("div",Re,[We,e("div",Xe,[e("div",Ye,[e("div",xe,[e("div",et,[p(e("input",{type:"number","onUpdate:modelValue":t[2]||(t[2]=l=>i.form.price.wholesale=l),class:"form-control",id:"price-wholesale",required:""},null,512),[[u,i.form.price.wholesale]]),e("label",tt,[a("Опт"),i.form.need_percent_price?(s(),o("span",st,", %")):(s(),o("span",ot,", руб"))])])]),e("div",it,[e("div",nt,[p(e("input",{type:"number","onUpdate:modelValue":t[3]||(t[3]=l=>i.form.price.retail=l),class:"form-control",id:"price-retail",required:""},null,512),[[u,i.form.price.retail]]),e("label",rt,[a("Розница"),i.form.need_percent_price?(s(),o("span",lt,", %")):(s(),o("span",at,", руб"))])])]),e("div",ct,[e("div",dt,[p(e("input",{type:"number","onUpdate:modelValue":t[4]||(t[4]=l=>i.form.price.dealer=l),class:"form-control",id:"price-dealer",required:""},null,512),[[u,i.form.price.dealer]]),e("label",_t,[a("Дилер"),i.form.need_percent_price?(s(),o("span",ht,", %")):(s(),o("span",pt,", руб"))])])]),e("div",ut,[e("div",mt,[p(e("input",{type:"number","onUpdate:modelValue":t[5]||(t[5]=l=>i.form.price.cost=l),class:"form-control",id:"price-cost",required:""},null,512),[[u,i.form.price.cost]]),e("label",ft,[a("Себестоимость"),i.form.need_percent_price?(s(),o("span",bt,", %")):(s(),o("span",gt,", руб"))])])])])])]),e("div",kt,[e("div",yt,[i.messages.length>0?(s(!0),o(m,{key:0},k(i.messages,(l,y)=>(s(),o("div",vt,[$t,a(" "+h(l||"Ошибка")+" ",1),e("button",{type:"button",class:"btn-close",onClick:St=>_.removeMessage(y)},null,8,wt)]))),256)):c("",!0)])]),e("div",Vt,[e("div",Dt,[e("button",{disabled:!_.needClearForm,class:"btn btn-dark rounded-0"},[i.loading?(s(),o("span",Ft)):(s(),o("i",jt)),a(" Сохранить вариант двери ")],8,Ct),_.needClearForm&&!i.loading?(s(),o("button",{key:0,type:"button",onClick:t[6]||(t[6]=(...l)=>_.resetForm&&_.resetForm(...l)),class:"btn btn-outline-secondary rounded-0 ml-2"},[Lt,a(" Очистить форму ")])):c("",!0)])])],32)}const It=F(Ze,[["render",At]]),Ot=e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Варианты дверей",-1),Pt={class:"py-12"},Ut={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},Tt={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},qt={class:"p-6 text-gray-900"},Mt=e("hr",{class:"hr my-5"},null,-1),Nt={data(){return{loading:!1,selectedDoorVariant:null}},methods:{selectDoorVariant(n){this.selectedDoorVariant=n,this.loading=!0,this.$nextTick(()=>{this.loading=!1})},callbackDoorVariantForm(){this.loading=!0,this.selectedDoorVariant=null,this.$nextTick(()=>{this.loading=!1})}}},Ht=Object.assign(Nt,{__name:"DoorVariantsPage",setup(n){return(t,r)=>(s(),o(m,null,[b(D(C),{title:"Варианты дверей"}),b(v,null,{header:g(()=>[Ot]),default:g(()=>[e("div",Pt,[e("div",Ut,[e("div",Tt,[e("div",qt,[t.loading?c("",!0):(s(),f(It,{key:0,item:t.selectedDoorVariant,onCallback:t.callbackDoorVariantForm},null,8,["item","onCallback"])),Mt,t.loading?c("",!0):(s(),f(Je,{key:1,onSelect:t.selectDoorVariant},null,8,["onSelect"]))])])])])]),_:1})],64))}});export{Ht as default};