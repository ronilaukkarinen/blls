class VanillaDatePicker{constructor(t,e={}){if(this.element=t,this.options={format:"DD.MM.YYYY",lang:document.documentElement.lang||"en",weekStart:1,...e},"undefined"==typeof moment)throw new Error("Moment.js is required for the datepicker");this.init()}init(){this.element.addEventListener("click",()=>this.show()),document.addEventListener("click",t=>{this.element.contains(t.target)||!this.picker||this.picker.contains(t.target)||this.hide()}),this.createPicker()}createPicker(){const t=moment(),e=`\n      <div class="dtp hidden">\n        <div class="dtp-content">\n          <div class="dtp-date-view">\n            <header class="dtp-header">\n              <div class="dtp-actual-day">${t.format("dddd")}</div>\n              <div class="dtp-close"><button type="button">&times;</button></div>\n            </header>\n            <div class="dtp-date">\n              <div class="dtp-actual-month">${t.format("MMM")}</div>\n              <div class="dtp-actual-num">${t.format("DD")}</div>\n              <div class="dtp-actual-year">${t.format("YYYY")}</div>\n            </div>\n            <div class="dtp-picker">\n              <div class="dtp-picker-calendar"></div>\n            </div>\n          </div>\n        </div>\n      </div>`;this.picker=document.createElement("div"),this.picker.innerHTML=e,document.body.appendChild(this.picker.firstElementChild),this.picker=document.body.lastElementChild,this.picker.querySelector(".dtp-close button").addEventListener("click",()=>this.hide()),this.setupCalendarControls()}setupCalendarControls(){const t=this.picker.querySelector(".dtp-picker-calendar");this.renderCalendar(t),this.picker.querySelector(".dtp-actual-month").addEventListener("click",()=>this.showMonthPicker()),this.picker.querySelector(".dtp-actual-year").addEventListener("click",()=>this.showYearPicker())}renderCalendar(t){const e=moment(),d=e.clone().startOf("month"),i=e.clone().endOf("month");let n='<table class="dtp-picker-days"><thead><tr>';moment.weekdaysMin().forEach(t=>{n+=`<th>${t}</th>`}),n+="</tr></thead><tbody>";let a=[],s=d.day();for(let t=0;t<s;t++)a.push("<td></td>");for(let t=1;t<=i.date();t++)a.push(`<td class="dtp-picker-day" data-date="${t}">${t}</td>`),7===a.length&&(n+="<tr>"+a.join("")+"</tr>",a=[]);if(a.length>0){for(;a.length<7;)a.push("<td></td>");n+="<tr>"+a.join("")+"</tr>"}n+="</tbody></table>",t.innerHTML=n,t.querySelectorAll(".dtp-picker-day").forEach(t=>{t.addEventListener("click",()=>this.selectDate(t.dataset.date))})}selectDate(t){const e=moment().date(t);this.element.value=e.format(this.options.format),this.hide()}show(){this.picker.classList.remove("hidden")}hide(){this.picker.classList.add("hidden")}}"undefined"!=typeof moment&&document.addEventListener("DOMContentLoaded",()=>{document.querySelectorAll(".datepicker").forEach(t=>{new VanillaDatePicker(t)})});