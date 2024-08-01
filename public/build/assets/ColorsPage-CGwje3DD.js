import{_ as y}from"./AuthenticatedLayout-DNZ-kFLE.js";import{m as $,o as l,c as i,b as s,f as c,v as u,g as d,e as r,F as _,r as p,d as f,t as a,h as k,i as v,j as w,a as b,u as C,w as g,Z as j}from"./app-CTwLR2lZ.js";import{P as F}from"./Pagination-BfJRwfEy.js";import{R as L}from"./RalColorSelector-LDokoh6-.js";import"./ApplicationLogo-BlmgUDcj.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./vue-the-mask-CnJHS1_e.js";const z={class:"row"},M={class:"col-12"},S={class:"input-group mb-3"},V={class:"form-floating"},A=s("label",{for:"search-colors"},"Поиск по цвету",-1),I=s("i",{class:"fa-solid fa-magnifying-glass"},null,-1),U=[I],O={style:{"overflow-y":"auto"}},P={key:0,class:"table"},q={key:0},T=s("i",{class:"fa-solid fa-caret-down"},null,-1),B=[T],N={key:1},D=s("i",{class:"fa-solid fa-caret-up"},null,-1),E=[D],R={key:0},G=s("i",{class:"fa-solid fa-caret-down"},null,-1),J=[G],Z={key:1},H=s("i",{class:"fa-solid fa-caret-up"},null,-1),K=[H],Q={key:0},W=s("i",{class:"fa-solid fa-caret-down"},null,-1),X=[W],Y={key:1},x=s("i",{class:"fa-solid fa-caret-up"},null,-1),ss=[x],ts={key:0},os=s("i",{class:"fa-solid fa-caret-down"},null,-1),es=[os],ls={key:1},is=s("i",{class:"fa-solid fa-caret-up"},null,-1),ns=[is],rs={key:0},as=s("i",{class:"fa-solid fa-caret-down"},null,-1),ds=[as],cs={key:1},hs=s("i",{class:"fa-solid fa-caret-up"},null,-1),us=[hs],_s={key:0},ms=s("i",{class:"fa-solid fa-caret-down"},null,-1),ps=[ms],fs={key:1},bs=s("i",{class:"fa-solid fa-caret-up"},null,-1),gs=[bs],ys={key:0},$s=s("i",{class:"fa-solid fa-caret-down"},null,-1),ks=[$s],vs={key:1},ws=s("i",{class:"fa-solid fa-caret-up"},null,-1),Cs=[ws],js=s("th",{scope:"col",class:"text-center"},"Действие",-1),Fs={scope:"row"},Ls=["onClick"],zs={class:"text-center"},Ms={key:0,class:"w-100"},Ss=s("thead",null,[s("th",null,"опт"),s("th",null,"дилер"),s("th",null,"розница"),s("th",null,"себестоимость")],-1),Vs={style:{"min-width":"100px","text-align":"center"}},As={style:{"min-width":"100px","text-align":"center"}},Is={style:{"min-width":"100px","text-align":"center"}},Us={style:{"min-width":"100px","text-align":"center"}},Os={key:1},Ps={class:"text-center"},qs={class:"text-center"},Ts={class:"text-center"},Bs={class:"text-center"},Ns={class:"text-center"},Ds={class:"dropdown"},Es=s("button",{class:"btn btn-link",type:"button","data-bs-toggle":"dropdown","aria-expanded":"false"},[s("i",{class:"fa-solid fa-bars"})],-1),Rs={class:"dropdown-menu"},Gs=["onClick"],Js=s("i",{class:"fa-solid fa-pen mr-2"},null,-1),Zs=["onClick"],Hs=s("i",{class:"fa-solid fa-trash-can mr-2"},null,-1),Ks={key:0,class:"alert alert-success",role:"alert"},Qs=s("h4",{class:"alert-heading"},"Цвета",-1),Ws=s("p",null,"К сожалению, раздел петель пуст. Вы еще не добавили ни одного цвета, которые можно отобразить на этой странице.",-1),Xs=s("hr",null,null,-1),Ys=s("p",{class:"mb-0"},"Воспользуйтесь формой выше и добавьте первый цвет",-1),xs=[Qs,Ws,Xs,Ys],st={key:1,class:"row mb-3"},tt={class:"col-12"},ot={data(){return{sort:{column:null,direction:"desc"},search:null,current_page:0,paginate_object:null,items:[{id:null,title:null,price:0}]}},computed:{...$(["getColors","getColorsPaginateObject"])},mounted(){this.loadColors()},methods:{sortAndLoad(n){this.sort.column=n,this.sort.direction=this.sort.direction==="desc"?"asc":"desc",this.loadColors(this.current_page)},loadColors(n=0){this.current_page=n,this.$store.dispatch("loadColors",{dataObject:{search:this.search,order:this.sort.column,direction:this.sort.direction},page:this.current_page}).then(t=>{this.items=this.getColors,this.paginate_object=this.getColorsPaginateObject}).catch(()=>{this.loading=!1})},selectItem(n){this.$emit("select",n)},duplicateItem(n){this.$store.dispatch("duplicateColor",{colorId:n}).then(()=>{this.sortAndLoad("id")})},removeItem(n){this.$store.dispatch("removeColor",{colorId:n}).then(()=>{this.sortAndLoad("id")})}}},et=Object.assign(ot,{__name:"ColorTable",setup(n){return(t,o)=>(l(),i(_,null,[s("form",z,[s("div",M,[s("div",S,[s("div",V,[c(s("input",{type:"search","onUpdate:modelValue":o[0]||(o[0]=e=>t.search=e),class:"form-control",id:"search-colors"},null,512),[[u,t.search]]),A]),s("button",{type:"button",onClick:o[1]||(o[1]=e=>t.sortAndLoad("id")),class:"btn btn-outline-secondary rounded-0"},U)])])]),s("div",O,[t.items.length>0?(l(),i("table",P,[s("thead",null,[s("tr",null,[s("th",{scope:"col",class:"cursor-pointer",onClick:o[2]||(o[2]=e=>t.sortAndLoad("id"))},[d("# "),t.sort.direction==="desc"&&t.sort.column==="id"?(l(),i("span",q,B)):r("",!0),t.sort.direction==="asc"&&t.sort.column==="id"?(l(),i("span",N,E)):r("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[3]||(o[3]=e=>t.sortAndLoad("title"))},[d("Название "),t.sort.direction==="desc"&&t.sort.column==="title"?(l(),i("span",R,J)):r("",!0),t.sort.direction==="asc"&&t.sort.column==="title"?(l(),i("span",Z,K)):r("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[4]||(o[4]=e=>t.sortAndLoad("price"))},[d("Цена "),t.sort.direction==="desc"&&t.sort.column==="price"?(l(),i("span",Q,X)):r("",!0),t.sort.direction==="asc"&&t.sort.column==="price"?(l(),i("span",Y,ss)):r("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[5]||(o[5]=e=>t.sortAndLoad("code"))},[d("Код цвета "),t.sort.direction==="desc"&&t.sort.column==="code"?(l(),i("span",ts,es)):r("",!0),t.sort.direction==="asc"&&t.sort.column==="code"?(l(),i("span",ls,ns)):r("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[6]||(o[6]=e=>t.sortAndLoad("assign_with_size"))},[d("Привязан к размеру "),t.sort.direction==="desc"&&t.sort.column==="assign_with_size"?(l(),i("span",rs,ds)):r("",!0),t.sort.direction==="asc"&&t.sort.column==="assign_with_size"?(l(),i("span",cs,us)):r("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[7]||(o[7]=e=>t.sortAndLoad("type"))},[d("Тип "),t.sort.direction==="desc"&&t.sort.column==="type"?(l(),i("span",_s,ps)):r("",!0),t.sort.direction==="asc"&&t.sort.column==="type"?(l(),i("span",fs,gs)):r("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[8]||(o[8]=e=>t.sortAndLoad("updated_at"))},[d(" Дата изменения "),t.sort.direction==="desc"&&t.sort.column==="updated_at"?(l(),i("span",ys,ks)):r("",!0),t.sort.direction==="asc"&&t.sort.column==="updated_at"?(l(),i("span",vs,Cs)):r("",!0)]),js])]),s("tbody",null,[(l(!0),i(_,null,p(t.items,(e,h)=>(l(),i("tr",null,[s("th",Fs,a(e.id||h),1),s("td",{class:"text-center",onClick:m=>t.selectItem(e)},a(e.title||"-"),9,Ls),s("td",zs,[e.assign_with_size?(l(),i("p",Os," Цены к цвету указаны в таблице размеров ")):(l(),i("table",Ms,[Ss,s("tbody",null,[s("tr",null,[s("td",Vs,a(t.items[h].price.wholesale||0),1),s("td",As,a(t.items[h].price.dealer||0),1),s("td",Is,a(t.items[h].price.retail||0),1),s("td",Us,a(t.items[h].price.cost||0),1)])])]))]),s("td",Ps,a(e.code||"Не задан"),1),s("td",qs,a(e.assign_with_size?"Да":"Нет"),1),s("td",Ts,a(e.type||"Не задан"),1),s("td",Bs,a(e.updated_at||"-"),1),s("td",Ns,[s("div",Ds,[Es,s("ul",Rs,[s("li",null,[s("a",{class:"dropdown-item",onClick:m=>t.selectItem(e),href:"javascript:void(0)"},[Js,d("Редактировать")],8,Gs)]),s("li",null,[s("a",{class:"dropdown-item text-danger",onClick:m=>t.removeItem(e.id),href:"javascript:void(0)"},[Hs,d("Удалить")],8,Zs)])])])])]))),256))])])):r("",!0)]),t.items.length===0?(l(),i("div",Ks,xs)):r("",!0),t.items.length>0?(l(),i("div",st,[s("div",tt,[t.paginate_object?(l(),f(F,{key:0,onPagination_page:t.loadColors,pagination:t.paginate_object},null,8,["onPagination_page","pagination"])):r("",!0)])])):r("",!0)],64))}}),lt={class:"form-floating mb-3"},it=s("label",{for:"color-title"},"Наименование цвета",-1),nt={class:"form-check form-switch mb-3"},rt=s("label",{class:"form-check-label",for:"color-assign_with_size"}," Цена связана с таблицей размеров (по названию цвета) ",-1),at={key:0,class:"card rounded-0 mb-3 border-black"},dt=s("div",{class:"card-header bg-dark text-white rounded-0"},[s("h6",null,"Настройка цены")],-1),ct={class:"card-body"},ht={class:"row"},ut={class:"col-6"},_t={class:"form-floating mb-3"},mt=s("label",{for:"price-wholesale"},"Опт",-1),pt={class:"col-6"},ft={class:"form-floating mb-3"},bt=s("label",{for:"price-retail"},"Розница",-1),gt={class:"col-6"},yt={class:"form-floating"},$t=s("label",{for:"price-dealer"},"Дилер",-1),kt={class:"col-6"},vt={class:"form-floating"},wt=s("label",{for:"price-cost"},"Себестоимость",-1),Ct={class:"input-group mb-3"},jt={class:"form-floating"},Ft=s("label",{for:"color-title"},"Код цвета",-1),Lt=s("i",{class:"fa-solid fa-palette"},null,-1),zt=[Lt],Mt={class:"form-floating mb-3"},St=s("option",{value:null},"Выберите один из вариантов",-1),Vt=["value"],At=s("label",{for:"floatingSelect"},"Вариант применения",-1),It={class:"row"},Ut={class:"col-12"},Ot={class:"alert alert-danger alert-dismissible fade show",role:"alert"},Pt=s("strong",null,"Внимание!",-1),qt=["onClick"],Tt={class:"row mt-5"},Bt={class:"col-12 d-flex justify-content-center"},Nt=["disabled"],Dt={key:0,class:"fa-regular fa-floppy-disk mr-1"},Et={key:1,class:"spinner-border spinner-border-sm text-success",role:"status"},Rt=s("i",{class:"fa-solid fa-xmark mr-1"},null,-1),Gt={class:"modal fade",id:"choose-color",tabindex:"-1","aria-labelledby":"exampleModalLabel","aria-hidden":"true"},Jt={class:"modal-dialog"},Zt={class:"modal-content"},Ht=s("div",{class:"modal-header"},[s("h1",{class:"modal-title fs-5",id:"exampleModalLabel"},"Выбор цвета RAL"),s("button",{type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close"})],-1),Kt={class:"modal-body"},Qt={props:["item"],data(){return{messages:[],loading:!1,colorModal:null,types:[{title:"Для всех",key:"all"},{title:"Отделка сторон",key:"side_finish"},{title:"Короб и каркас",key:"box_and_frame"},{title:"Фурнитура",key:"fittings"},{title:"Уплотнитель",key:"seal"}],form:{id:null,title:null,price:{wholesale:0,dealer:0,retail:0,cost:0},code:null,type:null,assign_with_size:!1}}},computed:{needClearForm(){return this.form.id||this.form.title||this.form.price||this.form.code||this.form.type}},mounted(){this.item&&this.$nextTick(()=>{this.form={id:this.item.id||null,title:this.item.title||null,price:this.item.price||{wholesale:0,dealer:0,retail:0,cost:0},code:this.item.code||null,type:this.item.type||null,assign_with_size:this.item.assign_with_size||!1}})},methods:{callbackSelectColor(n){this.form.title=n.names.en||n.color.code,this.form.code=n.color.code||n.color.hex||null,this.colorModal.hide()},selectColor(){this.colorModal=new bootstrap.Modal(document.getElementById("choose-color"),{}),this.colorModal.show()},alert(n){this.messages.push(n)},resetForm(){this.form.id=null,this.form.title=null,this.form.price={wholesale:0,dealer:0,retail:0,cost:0},this.form.code=null,this.form.type=null,this.$emit("callback")},removeMessage(n){this.messages.splice(n,1)},submit(){let n=new FormData;Object.keys(this.form).forEach(t=>{const o=this.form[t]||"";typeof o=="object"?n.append(t,JSON.stringify(o)):n.append(t,o)}),this.$store.dispatch("storeColor",{colorForm:n}).then(t=>{this.$emit("callback"),this.resetForm()}).catch(t=>{})}}},Wt=Object.assign(Qt,{__name:"ColorForm",setup(n){return(t,o)=>(l(),i(_,null,[s("form",{action:"",onSubmit:o[11]||(o[11]=w((...e)=>t.submit&&t.submit(...e),["prevent"]))},[s("div",lt,[c(s("input",{type:"text","onUpdate:modelValue":o[0]||(o[0]=e=>t.form.title=e),class:"form-control",id:"color-title",required:""},null,512),[[u,t.form.title]]),it]),s("div",nt,[c(s("input",{class:"form-check-input","onUpdate:modelValue":o[1]||(o[1]=e=>t.form.assign_with_size=e),type:"checkbox",role:"switch",id:"color-assign_with_size",checked:""},null,512),[[k,t.form.assign_with_size]]),rt]),t.form.assign_with_size?r("",!0):(l(),i("div",at,[dt,s("div",ct,[s("div",ht,[s("div",ut,[s("div",_t,[c(s("input",{type:"number","onUpdate:modelValue":o[2]||(o[2]=e=>t.form.price.wholesale=e),class:"form-control",id:"price-wholesale",required:""},null,512),[[u,t.form.price.wholesale]]),mt])]),s("div",pt,[s("div",ft,[c(s("input",{type:"number","onUpdate:modelValue":o[3]||(o[3]=e=>t.form.price.retail=e),class:"form-control",id:"price-retail",required:""},null,512),[[u,t.form.price.retail]]),bt])]),s("div",gt,[s("div",yt,[c(s("input",{type:"number","onUpdate:modelValue":o[4]||(o[4]=e=>t.form.price.dealer=e),class:"form-control",id:"price-dealer",required:""},null,512),[[u,t.form.price.dealer]]),$t])]),s("div",kt,[s("div",vt,[c(s("input",{type:"number","onUpdate:modelValue":o[5]||(o[5]=e=>t.form.price.cost=e),class:"form-control",id:"price-cost",required:""},null,512),[[u,t.form.price.cost]]),wt])])])])])),s("div",Ct,[s("div",jt,[c(s("input",{type:"text","onUpdate:modelValue":o[6]||(o[6]=e=>t.form.code=e),class:"form-control",id:"color-code"},null,512),[[u,t.form.code]]),Ft]),s("button",{type:"button",onClick:o[7]||(o[7]=(...e)=>t.selectColor&&t.selectColor(...e)),class:"btn btn-outline-secondary rounded-0",id:"basic-addon1"},zt)]),s("div",Mt,[c(s("select",{class:"form-select",onInvalid:o[8]||(o[8]=e=>t.alert("Вы не выбрали вариант использования!")),"onUpdate:modelValue":o[9]||(o[9]=e=>t.form.type=e),id:"floatingSelect","aria-label":"Floating label select example",required:""},[St,(l(!0),i(_,null,p(t.types,e=>(l(),i("option",{value:e.key},a(e.title),9,Vt))),256))],544),[[v,t.form.type]]),At]),s("div",It,[s("div",Ut,[t.messages.length>0?(l(!0),i(_,{key:0},p(t.messages,(e,h)=>(l(),i("div",Ot,[Pt,d(" "+a(e||"Ошибка")+" ",1),s("button",{type:"button",class:"btn-close",onClick:m=>t.removeMessage(h)},null,8,qt)]))),256)):r("",!0)])]),s("div",Tt,[s("div",Bt,[s("button",{disabled:!t.needClearForm,class:"btn btn-dark rounded-0"},[t.loading?(l(),i("span",Et)):(l(),i("i",Dt)),d(" Сохранить цвет ")],8,Nt),t.needClearForm&&!t.loading?(l(),i("button",{key:0,type:"button",onClick:o[10]||(o[10]=(...e)=>t.resetForm&&t.resetForm(...e)),class:"btn btn-outline-secondary rounded-0 ml-2"},[Rt,d(" Очистить форму ")])):r("",!0)])])],32),s("div",Gt,[s("div",Jt,[s("div",Zt,[Ht,s("div",Kt,[b(L,{onSelect:t.callbackSelectColor},null,8,["onSelect"])])])])])],64))}}),Xt=s("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Цвета",-1),Yt={class:"py-12"},xt={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},so={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},to={class:"p-6 text-gray-900"},oo=s("hr",{class:"hr my-5"},null,-1),eo={data(){return{loading:!1,selectedColor:null}},methods:{selectColor(n){this.selectedColor=n,this.loading=!0,this.$nextTick(()=>{this.loading=!1})},callbackColorForm(){this.loading=!0,this.selectedColor=null,this.$nextTick(()=>{this.loading=!1})}}},uo=Object.assign(eo,{__name:"ColorsPage",setup(n){return(t,o)=>(l(),i(_,null,[b(C(j),{title:"Цвета"}),b(y,null,{header:g(()=>[Xt]),default:g(()=>[s("div",Yt,[s("div",xt,[s("div",so,[s("div",to,[t.loading?r("",!0):(l(),f(Wt,{key:0,item:t.selectedColor,onCallback:t.callbackColorForm},null,8,["item","onCallback"])),oo,t.loading?r("",!0):(l(),f(et,{key:1,onSelect:t.selectColor},null,8,["onSelect"]))])])])])]),_:1})],64))}});export{uo as default};
