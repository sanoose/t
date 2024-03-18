
// import './bootstrap';
// import '../css/app.css';

//  handle tree chart  with jquery and adding some important functions
import "./bootstrap";

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap/dist/js/bootstrap.min.js' ;

import 'vue3-toastify/dist/index.css';


import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from "@fortawesome/free-solid-svg-icons";
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';



import { createApp, h } from 'vue';
import { createInertiaApp , Link   } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import VueApexCharts from "vue3-apexcharts";

// import $ from 'jquery';

import  "@/style/Common.css" ;
// window.$ = window.jQuery = $;
library.add(fas) ;

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';


if ( localStorage.getItem("isChecked") == "true" ) {
    document.documentElement.style.setProperty("--main_background", "#010420");
    document.documentElement.style.setProperty("--body_background", "black");
    document.documentElement.style.setProperty("--main_color", "white");
} else {
 
    document.documentElement.style.setProperty("--main_background", "whitesmoke");
    document.documentElement.style.setProperty("--body_background", "white");
    document.documentElement.style.setProperty("--main_color", "black");
}



createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(ElementPlus)
     
          
            .component('VueApexCharts' , VueApexCharts)
            .component('fa' , FontAwesomeIcon)
            .component ("Link" , Link) 
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
