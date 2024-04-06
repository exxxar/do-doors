import{_ as m}from"./AuthenticatedLayout-DMaCE6Fv.js";import{m as f,o as e,c as o,b as s,d as g,v,e as r,f as i,F as _,r as b,g as k,t as d,a as c,u as y,w as u,Z as $}from"./app-Vnrh33h6.js";import{P as w}from"./Pagination-Cwg5JI-k.js";import"./ApplicationLogo-D-GyZ-4m.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const U={class:"row"},C={class:"col-12"},j={class:"input-group mb-3"},L={class:"form-floating"},A=s("label",{for:"search-users"},"Поиск пользователя",-1),I=s("i",{class:"fa-solid fa-magnifying-glass"},null,-1),P=[I],O={key:0,class:"table"},V={key:0},B=s("i",{class:"fa-solid fa-caret-down"},null,-1),N=[B],T={key:1},D=s("i",{class:"fa-solid fa-caret-up"},null,-1),F=[D],E={key:0},G=s("i",{class:"fa-solid fa-caret-down"},null,-1),M=[G],S={key:1},Z=s("i",{class:"fa-solid fa-caret-up"},null,-1),q=[Z],z={key:0},H=s("i",{class:"fa-solid fa-caret-down"},null,-1),J=[H],K={key:1},Q=s("i",{class:"fa-solid fa-caret-up"},null,-1),R=[Q],W={key:0},X=s("i",{class:"fa-solid fa-caret-down"},null,-1),Y=[X],x={key:1},ss=s("i",{class:"fa-solid fa-caret-up"},null,-1),ts=[ss],es=s("th",{scope:"col",class:"text-center"},"Действие",-1),os={scope:"row"},ns=["onClick"],as={class:"text-center"},is={class:"text-center"},ls={class:"text-center"},rs={class:"dropdown"},ds=s("button",{class:"btn btn-link",type:"button","data-bs-toggle":"dropdown","aria-expanded":"false"},[s("i",{class:"fa-solid fa-bars"})],-1),cs={class:"dropdown-menu"},_s=["onClick"],hs=s("i",{class:"fa-solid fa-pen mr-2"},null,-1),us=["onClick"],ps=s("i",{class:"fa-solid fa-trash-can mr-2"},null,-1),ms={key:1,class:"alert alert-success",role:"alert"},fs=s("h4",{class:"alert-heading"},"Ручки",-1),gs=s("p",null,"К сожалению, раздел ручек пуст. Вы еще не добавили ни одной ручки, которые можно отобразить на этой странице.",-1),vs=s("hr",null,null,-1),bs=s("p",{class:"mb-0"},"Воспользуйтесь формой выше и добавьте свою первую ручку",-1),ks=[fs,gs,vs,bs],ys={key:2,class:"row mb-3"},$s={class:"col-12"},ws={data(){return{sort:{column:null,direction:"desc"},search:null,current_page:0,paginate_object:null,items:[{id:null,title:null,price:0,variants:[]}]}},computed:{...f(["getUsers","getUsersPaginateObject"])},mounted(){this.loadUsers()},methods:{sortAndLoad(l){this.sort.column=l,this.sort.direction=this.sort.direction==="desc"?"asc":"desc",this.loadUsers(this.current_page)},loadUsers(l=0){this.current_page=l,this.$store.dispatch("loadUsers",{dataObject:{search:this.search,order:this.sort.column,direction:this.sort.direction},page:this.current_page}).then(t=>{this.items=this.getUsers,this.paginate_object=this.getUsersPaginateObject}).catch(()=>{this.loading=!1})},selectItem(l){this.$emit("select",l)},duplicateItem(l){this.$store.dispatch("duplicateUser",{materialId:l}).then(()=>{this.sortAndLoad("id")})},removeItem(l){this.$store.dispatch("removeUser",{materialId:l}).then(()=>{this.sortAndLoad("id")})}}},Us=Object.assign(ws,{__name:"UserTable",setup(l){return(t,a)=>(e(),o(_,null,[s("form",U,[s("div",C,[s("div",j,[s("div",L,[g(s("input",{type:"search","onUpdate:modelValue":a[0]||(a[0]=n=>t.search=n),class:"form-control",id:"search-users"},null,512),[[v,t.search]]),A]),s("button",{type:"button",onClick:a[1]||(a[1]=n=>t.sortAndLoad("id")),class:"btn btn-outline-primary"},P)])])]),t.items.length>0?(e(),o("table",O,[s("thead",null,[s("tr",null,[s("th",{scope:"col",class:"cursor-pointer",onClick:a[2]||(a[2]=n=>t.sortAndLoad("id"))},[r("# "),t.sort.direction==="desc"&&t.sort.column==="id"?(e(),o("span",V,N)):i("",!0),t.sort.direction==="asc"&&t.sort.column==="id"?(e(),o("span",T,F)):i("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:a[3]||(a[3]=n=>t.sortAndLoad("email"))},[r("Почта "),t.sort.direction==="desc"&&t.sort.column==="email"?(e(),o("span",E,M)):i("",!0),t.sort.direction==="asc"&&t.sort.column==="email"?(e(),o("span",S,q)):i("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:a[4]||(a[4]=n=>t.sortAndLoad("name"))},[r("Имя "),t.sort.direction==="desc"&&t.sort.column==="name"?(e(),o("span",z,J)):i("",!0),t.sort.direction==="asc"&&t.sort.column==="name"?(e(),o("span",K,R)):i("",!0)]),s("th",{scope:"col",class:"text-center cursor-pointer",onClick:a[5]||(a[5]=n=>t.sortAndLoad("updated_at"))},[r(" Дата изменения "),t.sort.direction==="desc"&&t.sort.column==="updated_at"?(e(),o("span",W,Y)):i("",!0),t.sort.direction==="asc"&&t.sort.column==="updated_at"?(e(),o("span",x,ts)):i("",!0)]),es])]),s("tbody",null,[(e(!0),o(_,null,b(t.items,(n,p)=>(e(),o("tr",null,[s("th",os,d(n.id||p),1),s("td",{class:"text-center",onClick:h=>t.selectItem(n)},d(n.email||"-"),9,ns),s("td",as,d(n.name||0),1),s("td",is,d(n.updated_at||"-"),1),s("td",ls,[s("div",rs,[ds,s("ul",cs,[s("li",null,[s("a",{class:"dropdown-item",onClick:h=>t.selectItem(n),href:"javascript:void(0)"},[hs,r("Редактировать")],8,_s)]),s("li",null,[s("a",{class:"dropdown-item text-danger",onClick:h=>t.removeItem(n.id),href:"javascript:void(0)"},[ps,r("Удалить")],8,us)])])])])]))),256))])])):i("",!0),t.items.length===0?(e(),o("div",ms,ks)):i("",!0),t.items.length>0?(e(),o("div",ys,[s("div",$s,[t.paginate_object?(e(),k(w,{key:0,onPagination_page:t.loadUsers,pagination:t.paginate_object},null,8,["onPagination_page","pagination"])):i("",!0)])])):i("",!0)],64))}}),Cs=s("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Пользователи",-1),js={class:"py-12"},Ls={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},As={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},Is={class:"p-6 text-gray-900"},Ps={data(){return{loading:!1}},methods:{}},Ds=Object.assign(Ps,{__name:"UsersPage",setup(l){return(t,a)=>(e(),o(_,null,[c(y($),{title:"Пользователи"}),c(m,null,{header:u(()=>[Cs]),default:u(()=>[s("div",js,[s("div",Ls,[s("div",As,[s("div",Is,[c(Us)])])])])]),_:1})],64))}});export{Ds as default};