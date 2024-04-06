import{m as u,o as a,c as i,b as t,d as p,v as m,e as r,f as l,F as h,r as g,g as f,t as d}from"./app-Vnrh33h6.js";import{P as v}from"./Pagination-Cwg5JI-k.js";const b={class:"row"},k={class:"col-12"},w={class:"input-group mb-3"},y={class:"form-floating"},$=t("label",{for:"search-materials"},"Поиск по материалам",-1),C=t("i",{class:"fa-solid fa-magnifying-glass"},null,-1),M=[C],j={key:0,class:"table"},I={key:0},L=t("i",{class:"fa-solid fa-caret-down"},null,-1),A=[L],P={key:1},V=t("i",{class:"fa-solid fa-caret-up"},null,-1),B=[V],O={key:0},D=t("i",{class:"fa-solid fa-caret-down"},null,-1),N=[D],T={key:1},F=t("i",{class:"fa-solid fa-caret-up"},null,-1),E=[F],G=t("th",{scope:"col",class:"text-center"},"Варианты двери",-1),S=t("th",{scope:"col",class:"text-center"},"Варианты контура вокруг",-1),U={key:0},W=t("i",{class:"fa-solid fa-caret-down"},null,-1),q=[W],z={key:1},H=t("i",{class:"fa-solid fa-caret-up"},null,-1),J=[H],K=t("th",{scope:"col",class:"text-center"},"Действие",-1),Q={scope:"row"},R=["onClick"],X={class:"text-center"},Y={class:"text-center"},Z={class:"text-center"},x={class:"text-center"},tt={class:"dropdown"},st=t("button",{class:"btn btn-link",type:"button","data-bs-toggle":"dropdown","aria-expanded":"false"},[t("i",{class:"fa-solid fa-bars"})],-1),et={class:"dropdown-menu"},ot=["onClick"],at=t("i",{class:"fa-solid fa-pen mr-2"},null,-1),it=["onClick"],nt=t("i",{class:"fa-regular fa-copy mr-2"},null,-1),lt=["onClick"],rt=t("i",{class:"fa-solid fa-trash-can mr-2"},null,-1),dt={key:1,class:"alert alert-success",role:"alert"},ct=t("h4",{class:"alert-heading"},"Материалы",-1),ht=t("p",null,"К сожалению, раздел материалов пуст. Вы еще не добавили ни одного материала, который можно отобразить на этой странице.",-1),_t=t("hr",null,null,-1),ut=t("p",{class:"mb-0"},"Воспользуйтесь формой выше и добавьте свой первый материал",-1),pt=[ct,ht,_t,ut],mt={key:2,class:"row mb-3"},gt={class:"col-12"},ft={data(){return{sort:{column:null,direction:"desc"},search:null,current_page:0,paginate_object:null,items:[{id:null,title:null,wrapper_variants:[],door_variants:[]}]}},computed:{...u(["getMaterialsPaginateObject","getMaterials"])},mounted(){this.loadMaterials()},methods:{sortAndLoad(o){this.sort.column=o,this.sort.direction=this.sort.direction==="desc"?"asc":"desc",this.loadMaterials(this.current_page)},loadMaterials(o=0){this.current_page=o,this.$store.dispatch("loadMaterials",{dataObject:{search:this.search,order:this.sort.column,direction:this.sort.direction},page:this.current_page}).then(s=>{this.items=this.getMaterials,this.paginate_object=this.getMaterialsPaginateObject}).catch(()=>{this.loading=!1})},selectItem(o){this.$emit("select",o)},duplicateItem(o){this.$store.dispatch("duplicateMaterial",{materialId:o}).then(()=>{this.sortAndLoad("id")})},removeItem(o){this.$store.dispatch("removeMaterial",{materialId:o}).then(()=>{this.sortAndLoad("id")})},showWrapperVariants(o){this.$emit("show-wrapper-variants",o.wrapper_variants)},showDoorVariants(o){this.$emit("show-door-variants",o.door_variants)}}},kt=Object.assign(ft,{__name:"MaterialTable",setup(o){return(s,n)=>(a(),i(h,null,[t("form",b,[t("div",k,[t("div",w,[t("div",y,[p(t("input",{type:"search","onUpdate:modelValue":n[0]||(n[0]=e=>s.search=e),class:"form-control",id:"search-materials"},null,512),[[m,s.search]]),$]),t("button",{type:"button",onClick:n[1]||(n[1]=e=>s.sortAndLoad("id")),class:"btn btn-outline-primary"},M)])])]),s.items.length>0?(a(),i("table",j,[t("thead",null,[t("tr",null,[t("th",{scope:"col",class:"cursor-pointer",onClick:n[2]||(n[2]=e=>s.sortAndLoad("id"))},[r("# "),s.sort.direction==="desc"&&s.sort.column==="id"?(a(),i("span",I,A)):l("",!0),s.sort.direction==="asc"&&s.sort.column==="id"?(a(),i("span",P,B)):l("",!0)]),t("th",{scope:"col",class:"text-center cursor-pointer",onClick:n[3]||(n[3]=e=>s.sortAndLoad("title"))},[r("Название "),s.sort.direction==="desc"&&s.sort.column==="title"?(a(),i("span",O,N)):l("",!0),s.sort.direction==="asc"&&s.sort.column==="title"?(a(),i("span",T,E)):l("",!0)]),G,S,t("th",{scope:"col",class:"text-center cursor-pointer",onClick:n[4]||(n[4]=e=>s.sortAndLoad("updated_at"))},[r(" Дата изменения "),s.sort.direction==="desc"&&s.sort.column==="updated_at"?(a(),i("span",U,q)):l("",!0),s.sort.direction==="asc"&&s.sort.column==="updated_at"?(a(),i("span",z,J)):l("",!0)]),K])]),t("tbody",null,[(a(!0),i(h,null,g(s.items,(e,_)=>(a(),i("tr",null,[t("th",Q,d(e.id||_),1),t("td",{class:"text-center",onClick:c=>s.selectItem(e)},d(e.title||"-"),9,R),t("td",X,d((e.door_variants||[]).length),1),t("td",Y,d((e.wrapper_variants||[]).length),1),t("td",Z,d(e.updated_at||"-"),1),t("td",x,[t("div",tt,[st,t("ul",et,[t("li",null,[t("a",{class:"dropdown-item",onClick:c=>s.selectItem(e),href:"javascript:void(0)"},[at,r("Редактировать")],8,ot)]),t("li",null,[t("a",{class:"dropdown-item",onClick:c=>s.duplicateItem(e.id),href:"javascript:void(0)"},[nt,r("Дублировать")],8,it)]),t("li",null,[t("a",{class:"dropdown-item text-danger",onClick:c=>s.removeItem(e.id),href:"javascript:void(0)"},[rt,r("Удалить")],8,lt)])])])])]))),256))])])):l("",!0),s.items.length===0?(a(),i("div",dt,pt)):l("",!0),s.items.length>0?(a(),i("div",mt,[t("div",gt,[s.paginate_object?(a(),f(v,{key:0,onPagination_page:s.loadMaterials,pagination:s.paginate_object},null,8,["onPagination_page","pagination"])):l("",!0)])])):l("",!0)],64))}});export{kt as _};
