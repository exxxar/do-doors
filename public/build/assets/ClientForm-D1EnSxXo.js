import{m as b,o as e,c as n,b as s,f as u,v as h,g as c,e as d,F as f,r as p,d as k,t as _,k as $,i as g,j as v,a as y,h as q}from"./app-PaeVRU1m.js";import{P as w}from"./Pagination-dbUYlKos.js";import{_ as C}from"./UserTable-BCwBaGhS.js";import{v as U}from"./AuthenticatedLayout-B6rLL-Zc.js";const V={class:"row"},L={class:"col-12"},D={class:"input-group mb-3"},M={class:"form-floating"},j=s("label",{for:"search-clients"},"Поиск по клиентам",-1),A=s("i",{class:"fa-solid fa-magnifying-glass"},null,-1),B=[A],I={class:"d-flex scrollable-area py-5 mb-3"},S={key:0,class:"table table-responsive"},F={key:0},O=s("i",{class:"fa-solid fa-caret-down"},null,-1),R=[O],T={key:1},P=s("i",{class:"fa-solid fa-caret-up"},null,-1),E=[P],N={key:0},G=s("i",{class:"fa-solid fa-caret-down"},null,-1),J=[G],z={key:1},H=s("i",{class:"fa-solid fa-caret-up"},null,-1),K=[H],Q={key:0},W=s("i",{class:"fa-solid fa-caret-down"},null,-1),X=[W],Y={key:1},Z=s("i",{class:"fa-solid fa-caret-up"},null,-1),x=[Z],ss={key:0},ts=s("i",{class:"fa-solid fa-caret-down"},null,-1),os=[ts],es={key:1},ns=s("i",{class:"fa-solid fa-caret-up"},null,-1),ls=[ns],is={key:0},rs=s("i",{class:"fa-solid fa-caret-down"},null,-1),as=[rs],ds={key:1},cs=s("i",{class:"fa-solid fa-caret-up"},null,-1),us=[cs],ms={key:0},hs=s("i",{class:"fa-solid fa-caret-down"},null,-1),_s=[hs],fs={key:1},ps=s("i",{class:"fa-solid fa-caret-up"},null,-1),bs=[ps],ks={key:0},$s=s("i",{class:"fa-solid fa-caret-down"},null,-1),gs=[$s],vs={key:1},ys=s("i",{class:"fa-solid fa-caret-up"},null,-1),qs=[ys],ws={key:0},Cs=s("i",{class:"fa-solid fa-caret-down"},null,-1),Us=[Cs],Vs={key:1},Ls=s("i",{class:"fa-solid fa-caret-up"},null,-1),Ds=[Ls],Ms={key:0},js=s("i",{class:"fa-solid fa-caret-down"},null,-1),As=[js],Bs={key:1},Is=s("i",{class:"fa-solid fa-caret-up"},null,-1),Ss=[Is],Fs={key:0},Os=s("i",{class:"fa-solid fa-caret-down"},null,-1),Rs=[Os],Ts={key:1},Ps=s("i",{class:"fa-solid fa-caret-up"},null,-1),Es=[Ps],Ns={key:0},Gs=s("i",{class:"fa-solid fa-caret-down"},null,-1),Js=[Gs],zs={key:1},Hs=s("i",{class:"fa-solid fa-caret-up"},null,-1),Ks=[Hs],Qs={key:0},Ws=s("i",{class:"fa-solid fa-caret-down"},null,-1),Xs=[Ws],Ys={key:1},Zs=s("i",{class:"fa-solid fa-caret-up"},null,-1),xs=[Zs],st=s("th",{scope:"col",class:"text-center"},"Действие",-1),tt={scope:"row"},ot=["onClick"],et={class:"text-center"},nt={class:"text-center"},lt={class:"text-center"},it={class:"text-center"},rt={class:"text-center"},at={class:"text-center"},dt={class:"text-center"},ct={class:"text-center"},ut={class:"text-center"},mt={class:"text-center"},ht={class:"text-center"},_t={class:"dropdown"},ft=s("button",{class:"btn btn-link",type:"button","data-bs-toggle":"dropdown","aria-expanded":"false"},[s("i",{class:"fa-solid fa-bars"})],-1),pt={class:"dropdown-menu"},bt=["onClick"],kt=s("i",{class:"fa-solid fa-pen mr-2"},null,-1),$t=["onClick"],gt=s("i",{class:"fa-solid fa-trash-can mr-2"},null,-1),vt={key:0,class:"alert alert-success",role:"alert"},yt=s("h4",{class:"alert-heading"},"Клиенты",-1),qt=s("p",null,"К сожалению, раздел клиентов пуст. Вы еще не добавили ни одного клиента, которых можно отобразить на этой странице.",-1),wt=s("hr",null,null,-1),Ct=s("p",{class:"mb-0"},"Воспользуйтесь формой выше и добавьте своего первого клиента",-1),Ut=[yt,qt,wt,Ct],Vt={key:1,class:"row mb-3"},Lt={class:"col-12"},Dt={data(){return{sort:{column:null,direction:"desc"},search:null,current_page:0,paginate_object:null,statuses:[],items:[{id:null,status:null,phone:null,email:null,fact_address:null,comment:null,user_id:null,title:null,law_address:null,inn:null,kpp:null,ogrn:null,okpo:null,requisites:[]}]}},computed:{...b(["getClients","getClientsPaginateObject","getDictionary"])},mounted(){this.loadClients(),this.statuses=this.getDictionary.statuses||[]},methods:{preparedLawStatus(l){let t=this.statuses.find(o=>o.value===l)||null;return t?t.title:null},sortAndLoad(l){this.sort.column=l,this.sort.direction=this.sort.direction==="desc"?"asc":"desc",this.loadClients(this.current_page)},loadClients(l=0){this.current_page=l,this.$store.dispatch("loadClients",{dataObject:{search:this.search,order:this.sort.column,direction:this.sort.direction},page:this.current_page}).then(t=>{this.items=this.getClients,this.paginate_object=this.getClientsPaginateObject}).catch(()=>{this.loading=!1})},selectItem(l){this.$emit("select",l)},duplicateItem(l){this.$store.dispatch("duplicateClient",{materialId:l}).then(()=>{this.sortAndLoad("id")})},removeItem(l){this.$store.dispatch("removeClient",{materialId:l}).then(()=>{this.sortAndLoad("id")})}}},je=Object.assign(Dt,{__name:"ClientTable",setup(l){return(t,o)=>(e(),n(f,null,[s("form",V,[s("div",L,[s("div",D,[s("div",M,[u(s("input",{type:"search","onUpdate:modelValue":o[0]||(o[0]=a=>t.search=a),class:"form-control",id:"search-clients"},null,512),[[h,t.search]]),j]),s("button",{type:"button",onClick:o[1]||(o[1]=a=>t.sortAndLoad("id")),class:"btn btn-outline-secondary rounded-0"},B)])])]),s("div",I,[t.items.length>0?(e(),n("table",S,[s("thead",null,[s("tr",null,[s("th",{scope:"col",class:"cursor-pointer",onClick:o[2]||(o[2]=a=>t.sortAndLoad("id"))},[c("# "),t.sort.direction==="desc"&&t.sort.column==="id"?(e(),n("span",F,R)):d("",!0),t.sort.direction==="asc"&&t.sort.column==="id"?(e(),n("span",T,E)):d("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[3]||(o[3]=a=>t.sortAndLoad("title"))},[c("Название \\ ФИО "),t.sort.direction==="desc"&&t.sort.column==="title"?(e(),n("span",N,J)):d("",!0),t.sort.direction==="asc"&&t.sort.column==="title"?(e(),n("span",z,K)):d("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[4]||(o[4]=a=>t.sortAndLoad("phone"))},[c("Телефон "),t.sort.direction==="desc"&&t.sort.column==="phone"?(e(),n("span",Q,X)):d("",!0),t.sort.direction==="asc"&&t.sort.column==="phone"?(e(),n("span",Y,x)):d("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[5]||(o[5]=a=>t.sortAndLoad("status"))},[c("Статус клиента "),t.sort.direction==="desc"&&t.sort.column==="status"?(e(),n("span",ss,os)):d("",!0),t.sort.direction==="asc"&&t.sort.column==="status"?(e(),n("span",es,ls)):d("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[6]||(o[6]=a=>t.sortAndLoad("fact_address"))},[c("Фактический адрес "),t.sort.direction==="desc"&&t.sort.column==="fact_address"?(e(),n("span",is,as)):d("",!0),t.sort.direction==="asc"&&t.sort.column==="fact_address"?(e(),n("span",ds,us)):d("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[7]||(o[7]=a=>t.sortAndLoad("law_address"))},[c("Юридический адрес "),t.sort.direction==="desc"&&t.sort.column==="law_address"?(e(),n("span",ms,_s)):d("",!0),t.sort.direction==="asc"&&t.sort.column==="law_address"?(e(),n("span",fs,bs)):d("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[8]||(o[8]=a=>t.sortAndLoad("inn"))},[c("ИНН "),t.sort.direction==="desc"&&t.sort.column==="inn"?(e(),n("span",ks,gs)):d("",!0),t.sort.direction==="asc"&&t.sort.column==="inn"?(e(),n("span",vs,qs)):d("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[9]||(o[9]=a=>t.sortAndLoad("kpp"))},[c("КПП "),t.sort.direction==="desc"&&t.sort.column==="kpp"?(e(),n("span",ws,Us)):d("",!0),t.sort.direction==="asc"&&t.sort.column==="kpp"?(e(),n("span",Vs,Ds)):d("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[10]||(o[10]=a=>t.sortAndLoad("ogrn"))},[c("ОГРН "),t.sort.direction==="desc"&&t.sort.column==="ogrn"?(e(),n("span",Ms,As)):d("",!0),t.sort.direction==="asc"&&t.sort.column==="ogrn"?(e(),n("span",Bs,Ss)):d("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[11]||(o[11]=a=>t.sortAndLoad("okpo"))},[c("ОКПО "),t.sort.direction==="desc"&&t.sort.column==="okpo"?(e(),n("span",Fs,Rs)):d("",!0),t.sort.direction==="asc"&&t.sort.column==="okpo"?(e(),n("span",Ts,Es)):d("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[12]||(o[12]=a=>t.sortAndLoad("comment"))},[c("Комментарий "),t.sort.direction==="desc"&&t.sort.column==="comment"?(e(),n("span",Ns,Js)):d("",!0),t.sort.direction==="asc"&&t.sort.column==="comment"?(e(),n("span",zs,Ks)):d("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:o[13]||(o[13]=a=>t.sortAndLoad("updated_at"))},[c(" Дата изменения "),t.sort.direction==="desc"&&t.sort.column==="updated_at"?(e(),n("span",Qs,Xs)):d("",!0),t.sort.direction==="asc"&&t.sort.column==="updated_at"?(e(),n("span",Ys,xs)):d("",!0)]),st])]),s("tbody",null,[(e(!0),n(f,null,p(t.items,(a,i)=>(e(),n("tr",null,[s("th",tt,_(a.id||i),1),s("td",{class:"text-center",onClick:r=>t.selectItem(a)},_(a.title||"-"),9,ot),s("td",et,_(a.phone||"-"),1),s("td",nt,_(t.preparedLawStatus(a.status)||"-"),1),s("td",lt,_(a.fact_address||"-"),1),s("td",it,_(a.law_address||"-"),1),s("td",rt,_(a.inn||"-"),1),s("td",at,_(a.kpp||"-"),1),s("td",dt,_(a.ogrn||"-"),1),s("td",ct,_(a.okpo||"-"),1),s("td",ut,_(a.comment||"-"),1),s("td",mt,_(a.updated_at||"-"),1),s("td",ht,[s("div",_t,[ft,s("ul",pt,[s("li",null,[s("a",{class:"dropdown-item",onClick:r=>t.selectItem(a),href:"javascript:void(0)"},[kt,c("Редактировать")],8,bt)]),s("li",null,[s("a",{class:"dropdown-item text-danger",onClick:r=>t.removeItem(a.id),href:"javascript:void(0)"},[gt,c("Удалить")],8,$t)])])])])]))),256))])])):d("",!0)]),t.items.length===0?(e(),n("div",vt,Ut)):d("",!0),t.items.length>0?(e(),n("div",Vt,[s("div",Lt,[t.paginate_object?(e(),k(w,{key:0,onPagination_page:t.loadClients,pagination:t.paginate_object},null,8,["onPagination_page","pagination"])):d("",!0)])])):d("",!0)],64))}}),Mt={class:"row mb-3"},jt={class:"col-md-6 col-12"},At={class:"row"},Bt={class:"col-md-6 col-12"},It={class:"form-floating"},St=s("option",{value:null},"Не выбрано",-1),Ft=["value"],Ot=s("label",{for:"status"},"Тип контрагента",-1),Rt={class:"col-md-6 col-12"},Tt={class:"form-floating mb-3"},Pt=s("label",{for:"client-title"},"Наименование компании \\ Ф.И.О.",-1),Et={class:"col-12"},Nt={class:"form-floating mb-3"},Gt={class:"form-floating"},Jt=s("label",{for:"law_address"},"Юридический адрес",-1),zt={class:"col-md-6 col-12"},Ht={class:"form-floating mb-3"},Kt=s("label",{for:"client-email"},"Электронная почта",-1),Qt={class:"col-md-6 col-12"},Wt={class:"form-floating mb-3"},Xt=s("label",{for:"client-phone"},"Телефон",-1),Yt={class:"col-md-12 col-12"},Zt={class:"form-floating mb-3"},xt={class:"form-floating"},so=s("label",{for:"comment"},"Комментарий",-1),to={class:"col-md-6 col-12 mb-3"},oo={class:"input-group"},eo={class:"form-floating"},no=s("label",{for:"client-inn"},"ИНН",-1),lo=["disabled"],io=s("i",{class:"fa-solid fa-magnifying-glass"},null,-1),ro=[io],ao=["href"],co={class:"col-md-6 col-12"},uo={class:"form-floating mb-3"},mo=s("label",{for:"client-kpp"},"КПП",-1),ho={class:"col-md-6 col-12"},_o={class:"form-floating mb-3"},fo=s("label",{for:"client-ogrn"},"ОГРН",-1),po={class:"col-md-6 col-12"},bo={class:"form-floating mb-3"},ko=s("label",{for:"client-okpo"},"ОКПО",-1),$o={class:"col-md-6 col-12 mb-3"},go={class:"input-group"},vo={key:0,class:"form-control rounded-0 border-secondary"},yo={key:1,class:"form-control rounded-0 border-secondary"},qo=s("label",{for:"client-user_id"},"Пользователь",-1),wo=s("i",{class:"fa-solid fa-ban"},null,-1),Co=[wo],Uo={class:"row"},Vo={class:"col-12 my-2"},Lo=s("i",{class:"fa-solid fa-plus mr-1"},null,-1),Do={class:"col-md-6 col-12 mb-3"},Mo={class:"card rounded-0 border-secondary"},jo={class:"card-header d-flex justify-between align-items-center border-secondary"},Ao={class:"form-check form-switch"},Bo=["onChange","onUpdate:modelValue","id"],Io=["for"],So=["onClick"],Fo=s("i",{class:"fa-solid fa-xmark mr-2"},null,-1),Oo={class:"card-body"},Ro={class:"row"},To={class:"col-md-6 col-12"},Po={class:"input-group mb-3"},Eo={class:"form-floating"},No=["onUpdate:modelValue","id"],Go=["for"],Jo=["disabled","onClick"],zo=s("i",{class:"fa-solid fa-magnifying-glass"},null,-1),Ho=[zo],Ko={class:"col-md-6 col-12"},Qo={class:"form-floating mb-3"},Wo=["onUpdate:modelValue","id"],Xo=["for"],Yo={class:"col-md-12 col-12"},Zo={class:"form-floating mb-3"},xo=["onUpdate:modelValue","id"],se=["for"],te={class:"col-md-6 col-12"},oe={class:"form-floating mb-3"},ee=["onUpdate:modelValue","id"],ne=["for"],le={class:"col-md-6 col-12"},ie={class:"form-floating"},re=["onUpdate:modelValue","id"],ae=["for"],de={class:"row"},ce={class:"col-12"},ue={class:"alert alert-danger alert-dismissible fade show",role:"alert"},me=s("strong",null,"Внимание!",-1),he=["onClick"],_e={class:"row mt-5"},fe={class:"col-12 d-flex justify-content-center"},pe={class:"btn btn-dark rounded-0"},be={key:0,class:"fa-regular fa-floppy-disk mr-1"},ke={key:1,class:"spinner-border spinner-border-sm text-success",role:"status"},$e=s("i",{class:"fa-solid fa-xmark mr-1"},null,-1),ge={class:"modal fade",id:"search-users",tabindex:"-1","aria-labelledby":"exampleModalLabel","aria-hidden":"true"},ve={class:"modal-dialog modal-lg"},ye={class:"modal-content rounded-0 border-secondary"},qe=s("div",{class:"modal-header"},[s("h1",{class:"modal-title fs-5",id:"exampleModalLabel"},"Поиск пользователя"),s("button",{type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close"})],-1),we={class:"modal-body 0"},Ce=s("div",{class:"modal-footer"},[s("button",{type:"button",class:"btn btn-outline-secondary rounded-0 border-secondary","data-bs-dismiss":"modal"},"Закрыть ")],-1),Ue={components:{},directives:{mask:U.mask},props:["item"],data(){return{messages:[],userSearchModal:null,loading:!1,link_for_document:null,statuses:[],form:{id:null,status:null,phone:null,email:null,fact_address:null,comment:null,user:null,user_id:null,title:null,law_address:null,inn:null,kpp:null,ogrn:null,okpo:null,requisites:[]}}},computed:{...b(["getDictionary"])},mounted(){this.statuses=this.getDictionary.statuses||[],this.userSearchModal=new bootstrap.Modal(document.getElementById("search-users"),{}),this.item&&this.$nextTick(()=>{this.form={id:this.item.id||null,status:this.item.status||null,phone:this.item.phone||null,email:this.item.email||null,fact_address:this.item.fact_address||null,comment:this.item.comment||null,user_id:this.item.user_id||null,user:this.item.user||null,title:this.item.title||null,law_address:this.item.law_address||null,inn:this.item.inn||null,kpp:this.item.kpp||null,ogrn:this.item.ogrn||null,okpo:this.item.okpo||null,requisites:this.item.requisites||[]}})},methods:{openUserSearchModal(){this.userSearchModal.show()},requestByBik(l){this.$notify({title:"DoDoors",text:"Ищем по БИК..."}),this.$store.dispatch("requestByBik",{bik:this.form.requisites[l].bik}).then(t=>{this.form.requisites[l].bank=(t.name||"").replaceAll("&quot;","'"),this.form.requisites[l].address=t.address?(t.index||"")+", "+(t.city||"")+", "+(t.address||""):null,this.form.requisites[l].correspondent_account=t.ks||null,this.$notify({title:"DoDoors",text:"Отлично! Данные найдены",type:"success"})}).catch(t=>{this.$notify({title:"DoDoors",text:"Данные не найдено",type:"error"})})},requestByInn(){this.link_for_document=null,this.$notify({title:"DoDoors",text:"Ищем по ИНН..."}),this.$store.dispatch("requestByInn",{inn:this.form.inn}).then(l=>{this.form.title=l[0].c||null,this.form.kpp=l[0].p||null,this.form.ogrn=l[0].o||null;let t=new Date;this.link_for_document=(l[0].t||null)+`?r=${t.getTime()}&_=${t.getTime()}`,this.$notify({title:"DoDoors",text:"Отлично! Данные найдены",type:"success"})}).catch(l=>{this.$notify({title:"DoDoors",text:"Данные не найдено",type:"error"})})},changeRequisitesMain(l){this.form.requisites.forEach(t=>t.is_main=!1),this.form.requisites[l].is_main=!0},alert(l){this.messages.push(l)},removeRequisite(l){this.form.requisites.splice(l,1)},addRequisites(){this.form.requisites.push({bik:null,bank:null,address:null,correspondent_account:null,checking_account:null,is_main:!1})},selectUserId(l){this.form.user_id=l.id,this.form.user=l,this.userSearchModal.hide()},resetForm(){const l={id:null,status:null,phone:null,email:null,fact_address:null,comment:null,user_id:null,title:null,law_address:null,inn:null,kpp:null,ogrn:null,okpo:null,requisites:[]};this.form=l,this.$emit("callback")},removeMessage(l){this.messages.splice(l,1)},submit(){let l=new FormData;Object.keys(this.form).forEach(t=>{const o=this.form[t]||"";typeof o=="object"?l.append(t,JSON.stringify(o)):l.append(t,o)}),this.$store.dispatch("storeClient",{clientForm:l}).then(t=>{this.$emit("callback"),this.resetForm()}).catch(t=>{})}}},Ae=Object.assign(Ue,{__name:"ClientForm",setup(l){return(t,o)=>{const a=$("mask");return e(),n(f,null,[s("div",Mt,[s("div",jt,[s("button",{type:"button",class:"btn btn-dark rounded-0",onClick:o[0]||(o[0]=(...i)=>t.resetForm&&t.resetForm(...i))},"Очистить форму ")])]),s("form",{action:"",onSubmit:o[16]||(o[16]=v((...i)=>t.submit&&t.submit(...i),["prevent"]))},[s("div",At,[s("div",Bt,[s("div",It,[u(s("select",{class:"form-select","onUpdate:modelValue":o[1]||(o[1]=i=>t.form.status=i),id:"status","aria-label":"Floating label select example"},[St,(e(!0),n(f,null,p(t.statuses,i=>(e(),n("option",{value:i.value},_(i.title||"Не указано"),9,Ft))),256))],512),[[g,t.form.status]]),Ot])]),s("div",Rt,[s("div",Tt,[u(s("input",{type:"text","onUpdate:modelValue":o[2]||(o[2]=i=>t.form.title=i),class:"form-control",id:"client-title",required:""},null,512),[[h,t.form.title]]),Pt])]),s("div",Et,[s("div",Nt,[s("div",Gt,[u(s("textarea",{class:"form-control rounded-0 border-secondary","onUpdate:modelValue":o[3]||(o[3]=i=>t.form.law_address=i),placeholder:"Leave a comment here",id:"law_address"},null,512),[[h,t.form.law_address]]),Jt])])]),s("div",zt,[s("div",Ht,[u(s("input",{type:"email","onUpdate:modelValue":o[4]||(o[4]=i=>t.form.email=i),class:"form-control",id:"client-email"},null,512),[[h,t.form.email]]),Kt])]),s("div",Qt,[s("div",Wt,[u(s("input",{type:"text","onUpdate:modelValue":o[5]||(o[5]=i=>t.form.phone=i),class:"form-control",id:"client-phone"},null,512),[[h,t.form.phone],[a,"+7(###)###-##-##"]]),Xt])]),s("div",Yt,[s("div",Zt,[s("div",xt,[u(s("textarea",{class:"form-control rounded-0 border-secondary","onUpdate:modelValue":o[6]||(o[6]=i=>t.form.comment=i),placeholder:"Leave a comment here",id:"comment"},null,512),[[h,t.form.comment]]),so])])]),s("div",to,[s("div",oo,[s("div",eo,[u(s("input",{type:"text","onUpdate:modelValue":o[7]||(o[7]=i=>t.form.inn=i),maxlength:"12",class:"form-control",id:"client-inn",required:""},null,512),[[h,t.form.inn]]),no]),s("button",{type:"button",disabled:!t.form.inn,onClick:o[8]||(o[8]=(...i)=>t.requestByInn&&t.requestByInn(...i)),class:"btn btn-outline-secondary rounded-0"},ro,8,lo)]),t.link_for_document?(e(),n("a",{key:0,href:"https://egrul.nalog.ru/vyp-download/"+t.link_for_document,target:"_blank",class:"btn btn-link my-0 py-0 px-0",style:{color:"red"}},"Скачать выписку",8,ao)):d("",!0)]),s("div",co,[s("div",uo,[u(s("input",{type:"text",maxlength:"9","onUpdate:modelValue":o[9]||(o[9]=i=>t.form.kpp=i),class:"form-control",id:"client-kpp"},null,512),[[h,t.form.kpp]]),mo])]),s("div",ho,[s("div",_o,[u(s("input",{type:"text",maxlength:"15","onUpdate:modelValue":o[10]||(o[10]=i=>t.form.ogrn=i),class:"form-control",id:"client-ogrn"},null,512),[[h,t.form.ogrn]]),fo])]),s("div",po,[s("div",bo,[u(s("input",{type:"text","onUpdate:modelValue":o[11]||(o[11]=i=>t.form.okpo=i),maxlength:"10",class:"form-control",id:"client-okpo"},null,512),[[h,t.form.okpo]]),ko])]),s("div",$o,[s("div",go,[s("div",{class:"form-floating",onClick:o[12]||(o[12]=(...i)=>t.openUserSearchModal&&t.openUserSearchModal(...i))},[t.form.user?(e(),n("p",vo,_(t.form.user.email),1)):(e(),n("p",yo,"Не выбран")),qo]),t.form.user?(e(),n("button",{key:0,type:"button",class:"btn btn-outline-secondary rounded-0",onClick:o[13]||(o[13]=i=>t.form.user=null)},Co)):d("",!0)])])]),s("div",Uo,[s("div",Vo,[s("button",{type:"button",onClick:o[14]||(o[14]=(...i)=>t.addRequisites&&t.addRequisites(...i)),class:"btn btn-dark rounded-0"},[Lo,c("Добавить расчётный счёт ")])]),(e(!0),n(f,null,p(t.form.requisites,(i,r)=>(e(),n("div",Do,[s("div",Mo,[s("div",jo,[s("div",Ao,[u(s("input",{class:"form-check-input",onChange:m=>t.changeRequisitesMain(r),"onUpdate:modelValue":m=>t.form.requisites[r].is_main=m,type:"checkbox",role:"switch",id:"form-requisites-checking_account"+r,checked:""},null,40,Bo),[[q,t.form.requisites[r].is_main]]),s("label",{class:"form-check-label",for:"form-requisites-checking_account"+r}," Основной расчетный счёт ",8,Io)]),s("a",{href:"javascript:void(0)",class:"btn btn-outline-secondary rounded-0",onClick:m=>t.removeRequisite(r)},[Fo,c(" Удалить")],8,So)]),s("div",Oo,[s("div",Ro,[s("div",To,[s("div",Po,[s("div",Eo,[u(s("input",{type:"text",maxlength:"11","onUpdate:modelValue":m=>t.form.requisites[r].bik=m,class:"form-control",id:"form-requisites-bik"+r,required:""},null,8,No),[[h,t.form.requisites[r].bik]]),s("label",{for:"form-requisites-bik"+r},"БИК",8,Go)]),s("button",{type:"button",disabled:!t.form.requisites[r].bik,onClick:m=>t.requestByBik(r),class:"btn btn-outline-secondary rounded-0"},Ho,8,Jo)])]),s("div",Ko,[s("div",Qo,[u(s("input",{type:"text","onUpdate:modelValue":m=>t.form.requisites[r].bank=m,class:"form-control",id:"form-requisites-bank"+r},null,8,Wo),[[h,t.form.requisites[r].bank]]),s("label",{for:"form-requisites-bank"+r},"Банк",8,Xo)])]),s("div",Yo,[s("div",Zo,[u(s("input",{type:"text","onUpdate:modelValue":m=>t.form.requisites[r].address=m,class:"form-control",id:"form-requisites-address"+r},null,8,xo),[[h,t.form.requisites[r].address]]),s("label",{for:"form-requisites-address"+r},"Адрес",8,se)])]),s("div",te,[s("div",oe,[u(s("input",{type:"text",maxlength:"20","onUpdate:modelValue":m=>t.form.requisites[r].correspondent_account=m,class:"form-control",id:"form-requisites-correspondent_account"+r},null,8,ee),[[h,t.form.requisites[r].correspondent_account]]),s("label",{for:"form-requisites-correspondent_account"+r},"Кор.счёт",8,ne)])]),s("div",le,[s("div",ie,[u(s("input",{type:"text","onUpdate:modelValue":m=>t.form.requisites[r].checking_account=m,maxlength:"20",class:"form-control",id:"form-requisites-checking_account"+r,required:""},null,8,re),[[h,t.form.requisites[r].checking_account]]),s("label",{for:"form-requisites-checking_account"+r},"Расчетный счет",8,ae)])])])])])]))),256))]),s("div",de,[s("div",ce,[t.messages.length>0?(e(!0),n(f,{key:0},p(t.messages,(i,r)=>(e(),n("div",ue,[me,c(" "+_(i||"Ошибка")+" ",1),s("button",{type:"button",class:"btn-close",onClick:m=>t.removeMessage(r)},null,8,he)]))),256)):d("",!0)])]),s("div",_e,[s("div",fe,[s("button",pe,[t.loading?(e(),n("span",ke)):(e(),n("i",be)),c(" Сохранить клиента ")]),t.loading?d("",!0):(e(),n("button",{key:0,type:"button",onClick:o[15]||(o[15]=(...i)=>t.resetForm&&t.resetForm(...i)),class:"btn btn-outline-secondary rounded-0 ml-2"},[$e,c(" Очистить клиента ")]))])])],32),s("div",ge,[s("div",ve,[s("div",ye,[qe,s("div",we,[y(C,{"for-select":!0,onSelect:t.selectUserId},null,8,["onSelect"])]),Ce])])])],64)}}});export{Ae as _,je as a};