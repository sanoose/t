<script setup>
     
     

    
        const props = defineProps ( ["data"] ) ; 
     
        // console.log(2222);
</script>


<template>
             <div class="float-right  text-dark links_container">
                <ul class="link_container pagination">
 
                                     <li class="page-item" >
                                        <Link
                                            class="page-link text-dark"
                                            :href="data.first_page_url != null ? `${data.first_page_url}` : `` "
                                            :class="{'d-none'  : data.current_page ==  1 }"
                                            >الأولى
                                        </Link>
                                    </li>

                                    <li class="page-item"
                                    :class="{'d-none'  : data.prev_page_url ==  null  }"
                                    >
                                        <Link
                                            class="page-link text-dark"
                                            :href="data.prev_page_url != null ? data.prev_page_url  : '' "
                                        >
                                            السابقة
                                        </Link>
                                    </li>

                                     <li   class="page-item" v-for = "link , i in data.links"  :key="i"  >
                                            
                                            <Link   class="page-link"
                                            :href="link.url != null ? link.url : '' " 
                                            :class="{ 'text-danger   page-bg-active bg-black'  :  link.active  }"
                                            v-html="link.label"
                                            v-if="  i  != ( data.links.length - 1 )  &&  i != 0   "
                                            >
                                            </Link>
                                     </li>   

                                     <li class="page-item"
                                        :class="{'d-none'  : data.next_page_url ==  null  }"
                                        >
                                            <Link
                                                class="page-link text-dark "
                                                :href="data.next_page_url != null ? data.next_page_url : '' "
                                                :class="{'d-none'  : data.next_page_url ==  null  }"
                                                >التالية</Link
                                            >
                                        </li>

                                     
                                        <li class="page-item"
                                        :class="{'d-none'  : data.current_page ==   data.last_page }"
                                        >
                                            <Link
                                                class="page-link text-dark "
                                                :href="data.last_page_url != null ? data.last_page_url : ''"
                                                >الأخيرة</Link>
                                        </li>  
                                        
                                    </ul>           
                                     
                                     
                             </div>
                                
</template>

<style scoped>

.link_container {
    /* display: block;
    display: flex;
    justify-content: center;
    gap: 4px; */
}

.link_container  div {
    text-align: center;
    /* background: #1023ff; */
    cursor: pointer;
    margin-bottom: 10px;
    border-radius: 8px;
}

/* .link_container  div  a  {
    color: white;
    padding: 2px 9px;
} */
.link_container  div:first-child ,
.link_container  div:last-child  
 {
    display: none ;
 }

.links_container {
    padding: 20px;
    /* background: #e4e5fa ; */
    border-radius: 10px;
}

.links_container  ul {
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0px;
    margin: 0px;
    height: fit-content;
    flex-direction: row;

}

.links_container  ul li  a { 
    color: #0080bd  !important;
    border-radius: 0px !important;
}

.page-bg-active {
    /* background-color: #00ffd5  !important; */
    z-index:   0 ;
}

.links_container {
    position: static;
    z-index: -1 ;
}
</style>