import{_ as p}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{o as s,c as r,b as e,z as g,F as u,r as _,t as h,f as c}from"./app-B_BzcOIB.js";const d={props:["pagination"],data(){return{currentPage:1}},computed:{hasPagination(){return!(this.pagination===null||!this.pagination||this.pagination.meta.links[0].active===!1&&this.pagination.meta.links[this.pagination.meta.links.length-1].active===!1)},filteredLinks(){return this.pagination?(parseInt(this.pagination.meta.current_page),this.pagination.meta.links):[]}},methods:{nextPage(){this.currentPage=this.pagination.meta.current_page+1,this.$emit("pagination_page",this.pagination.meta.current_page+1)},page(l){this.currentPage=l,window.scrollTo({top:500,behavior:"smooth"}),console.log("Test"),this.$emit("pagination_page",l)},prevPage(){this.currentPage!==1&&(this.currentPage=this.pagination.meta.current_page-1,this.$emit("pagination_page",this.pagination.meta.current_page-1))}}},m={key:0,class:"row d-flex justify-content-center"},f={key:0,class:"col-lg-6 dt-pagination d-flex justify-content-center align-items-center"},k={"aria-label":"Page navigation example"},P={class:"pagination"},v={class:"page-item"},b=e("span",{"aria-hidden":"true"},"«",-1),y=[b],x=["onClick"],C={key:0,class:"page-link",href:"#"},L={class:"page-item"},w=e("span",{"aria-hidden":"true"},"»",-1),B=[w];function N(l,o,a,j,z,t){return a.pagination?(s(),r("div",m,[a.pagination.links?(s(),r("div",f,[e("nav",k,[e("ul",P,[e("li",v,[e("a",{class:g(["page-link",{disabled:a.pagination.links.prev===null}]),onClick:o[0]||(o[0]=(...i)=>t.prevPage&&t.prevPage(...i)),"aria-label":"Previous"},y,2)]),(s(!0),r(u,null,_(t.filteredLinks,(i,n)=>(s(),r("li",{class:g(["page-item",{active:n===a.pagination.meta.current_page}]),key:"paginate"+n,onClick:F=>t.page(n)},[n!==0&&n!==t.filteredLinks.length-1?(s(),r("a",C,h(i.label),1)):c("",!0)],10,x))),128)),e("li",L,[e("a",{class:g(["page-link",{disabled:a.pagination.links.next===null}]),onClick:o[1]||(o[1]=(...i)=>t.nextPage&&t.nextPage(...i)),"aria-label":"Next"},B,2)])])])])):c("",!0)])):c("",!0)}const D=p(d,[["render",N]]);export{D as P};