import{_ as p}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{o as s,c as r,b as e,q as l,F as u,r as d,t as _,e as c}from"./app-PaeVRU1m.js";const h={props:["pagination"],data(){return{currentPage:1}},computed:{hasPagination(){return!(this.pagination===null||!this.pagination||this.pagination.meta.links[0].active===!1&&this.pagination.meta.links[this.pagination.meta.links.length-1].active===!1)},filteredLinks(){return this.pagination?(parseInt(this.pagination.meta.current_page),this.pagination.meta.links):[]}},methods:{nextPage(){this.currentPage=this.pagination.meta.current_page+1,this.$emit("pagination_page",this.pagination.meta.current_page+1)},page(g){this.currentPage=g,window.scrollTo({top:500,behavior:"smooth"}),console.log("Test"),this.$emit("pagination_page",g)},prevPage(){this.currentPage!==1&&(this.currentPage=this.pagination.meta.current_page-1,this.$emit("pagination_page",this.pagination.meta.current_page-1))}}},m={key:0,class:"row d-flex justify-content-center"},k={key:0,class:"col-lg-6 dt-pagination d-flex justify-content-center align-items-center"},f={"aria-label":"Page navigation example"},P={class:"pagination"},v={class:"page-item"},y=e("span",{"aria-hidden":"true"},"«",-1),b=[y],x=["onClick"],C={class:"page-item"},L=e("span",{"aria-hidden":"true"},"»",-1),w=[L];function B(g,o,a,N,j,t){return a.pagination?(s(),r("div",m,[a.pagination.links?(s(),r("div",k,[e("nav",f,[e("ul",P,[e("li",v,[e("a",{class:l(["page-link rounded-0",{disabled:a.pagination.links.prev===null}]),onClick:o[0]||(o[0]=(...i)=>t.prevPage&&t.prevPage(...i)),"aria-label":"Previous"},b,2)]),(s(!0),r(u,null,d(t.filteredLinks,(i,n)=>(s(),r("li",{class:l(["page-item",{"active-dark":n===a.pagination.meta.current_page}]),key:"paginate"+n,onClick:F=>t.page(n)},[n!==0&&n!==t.filteredLinks.length-1?(s(),r("a",{key:0,class:l(["page-link rounded-0",{"text-secondary":n!==a.pagination.meta.current_page}]),href:"#"},_(i.label),3)):c("",!0)],10,x))),128)),e("li",C,[e("a",{class:l(["page-link rounded-0 text-secondary",{disabled:a.pagination.links.next===null}]),onClick:o[1]||(o[1]=(...i)=>t.nextPage&&t.nextPage(...i)),"aria-label":"Next "},w,2)])])])])):c("",!0)])):c("",!0)}const q=p(h,[["render",B]]);export{q as P};
