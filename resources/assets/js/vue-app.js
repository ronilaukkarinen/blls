import Vue from 'vue';
import DatePicker from './components/DatePicker.vue';
import BarChart from './components/BarChart.vue';
import Dropdown from './components/Dropdown.vue';

Vue.component('datepicker', DatePicker);
Vue.component('barchart', BarChart);
Vue.component('dropdown', Dropdown);

const app = new Vue({
  el: '#app'
});
