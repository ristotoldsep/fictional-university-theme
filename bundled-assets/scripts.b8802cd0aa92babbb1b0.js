!function(e){function t(t){for(var n,i,o=t[0],l=t[1],c=t[2],p=0,u=[];p<o.length;p++)i=o[p],Object.prototype.hasOwnProperty.call(r,i)&&r[i]&&u.push(r[i][0]),r[i]=0;for(n in l)Object.prototype.hasOwnProperty.call(l,n)&&(e[n]=l[n]);for(h&&h(t);u.length;)u.shift()();return a.push.apply(a,c||[]),s()}function s(){for(var e,t=0;t<a.length;t++){for(var s=a[t],n=!0,o=1;o<s.length;o++){var l=s[o];0!==r[l]&&(n=!1)}n&&(a.splice(t--,1),e=i(i.s=s[0]))}return e}var n={},r={0:0},a=[];function i(t){if(n[t])return n[t].exports;var s=n[t]={i:t,l:!1,exports:{}};return e[t].call(s.exports,s,s.exports,i),s.l=!0,s.exports}i.m=e,i.c=n,i.d=function(e,t,s){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:s})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var s=Object.create(null);if(i.r(s),Object.defineProperty(s,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)i.d(s,n,function(t){return e[t]}.bind(null,n));return s},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="/wp-content/themes/fictional-university-theme/bundled-assets/";var o=window.webpackJsonp=window.webpackJsonp||[],l=o.push.bind(o);o.push=t,o=o.slice();for(var c=0;c<o.length;c++)t(o[c]);var h=l;a.push([3,1]),s()}([,,function(e,t,s){},function(e,t,s){"use strict";s.r(t);s(2);var n=class{constructor(){this.menu=document.querySelector(".site-header__menu"),this.openButton=document.querySelector(".site-header__menu-trigger"),this.events()}events(){this.openButton.addEventListener("click",()=>this.openMenu())}openMenu(){this.openButton.classList.toggle("fa-bars"),this.openButton.classList.toggle("fa-window-close"),this.menu.classList.toggle("site-header__menu--active")}},r=s(1);var a=class{constructor(){if(document.querySelector(".hero-slider")){const e=document.querySelectorAll(".hero-slider__slide").length;let t="";for(let s=0;s<e;s++)t+=`<button class="slider__bullet glide__bullet" data-glide-dir="=${s}"></button>`;document.querySelector(".glide__bullets").insertAdjacentHTML("beforeend",t),new r.a(".hero-slider",{type:"carousel",perView:1,autoplay:3e3}).mount()}}};var i=class{constructor(){document.querySelectorAll(".acf-map").forEach(e=>{this.new_map(e)})}new_map(e){var t=e.querySelectorAll(".marker"),s={zoom:16,center:new google.maps.LatLng(0,0),mapTypeId:google.maps.MapTypeId.ROADMAP},n=new google.maps.Map(e,s);n.markers=[];var r=this;t.forEach((function(e){r.add_marker(e,n)})),this.center_map(n)}add_marker(e,t){var s=new google.maps.LatLng(e.getAttribute("data-lat"),e.getAttribute("data-lng")),n=new google.maps.Marker({position:s,map:t});if(t.markers.push(n),e.innerHTML){var r=new google.maps.InfoWindow({content:e.innerHTML});google.maps.event.addListener(n,"click",(function(){r.open(t,n)}))}}center_map(e){var t=new google.maps.LatLngBounds;e.markers.forEach((function(e){var s=new google.maps.LatLng(e.position.lat(),e.position.lng());t.extend(s)})),1==e.markers.length?(e.setCenter(t.getCenter()),e.setZoom(16)):e.fitBounds(t)}},o=s(0),l=s.n(o);var c=class{constructor(){this.addSearchHTML(),this.openButton=l()(".js-search-trigger"),this.closeButton=l()(".search-overlay__close"),this.searchOverlay=l()(".search-overlay"),this.searchField=l()("#search-term"),this.resultsDiv=l()("#search-overlay__results"),this.events(),this.isOverlayOpen=!1,this.typingTimer,this.isSpinnerVisible=!1,this.previousValue}events(){this.openButton.on("click",this.openOverlay.bind(this)),this.closeButton.on("click",this.closeOverlay.bind(this)),l()(document).on("keydown",this.keyPressDispatcher.bind(this)),this.searchField.on("keyup",this.typingLogic.bind(this))}typingLogic(){this.searchField.val()!=this.previousValue&&(clearTimeout(this.typingTimer),this.searchField.val()?(this.isSpinnerVisible||(this.resultsDiv.html('<div class="spinner-loader"></div>'),this.isSpinnerVisible=!0),this.typingTimer=setTimeout(this.getResults.bind(this),750)):(this.resultsDiv.html(""),this.isSpinnerVisible=!1)),this.previousValue=this.searchField.val()}getResults(){l.a.getJSON(universityData.root_url+"/wp-json/university/v1/search?term="+this.searchField.val(),e=>{this.resultsDiv.html(`\n                <div class="row">\n                    <div class="one-third">\n\n                        <h2 class="search-overlay__section-title">General Information</h2>\n\n                        ${e.generalInfo.length?'<ul class="link-list min-list">':"<p>No general info matches that search.</p>"}\n                        \n                        ${e.generalInfo.map(e=>`<li><a href="${e.permalink}">${e.title}</a> ${"post"==e.postType?"by "+e.author:""}</li>`).join("")} \n\n                        ${e.generalInfo.length?"</ul>":""}\n\n                    </div>\n                    <div class="one-third">\n\n                        <h2 class="search-overlay__section-title">Programs</h2>\n\n                        ${e.programs.length?'<ul class="link-list min-list">':`<p>No programs match that search. <a href="${universityData.root_url}/programs">View all programs</a></p>`}\n                        \n                        ${e.programs.map(e=>`<li><a href="${e.permalink}">${e.title}</a></li>`).join("")} \n\n                        ${e.programs.length?"</ul>":""}\n\n                        <h2 class="search-overlay__section-title">Professors</h2>\n\n                        ${e.professors.length?'<ul class="professor-cards">':"<p>No professors match that search.</p>"}\n                        \n                        ${e.professors.map(e=>`\n                            <li class="professor-card__list-item">\n                                <a class="professor-card" href="${e.permalink}">\n                                    <img class="professor-card__image" src="${e.image}">\n                                    <span class="professor-card__name">${e.title}</span>\n                                </a>\n                            </li>\n                        `).join("")} \n\n                        ${e.professors.length?"</ul>":""}\n\n                    </div>\n                    <div class="one-third">\n\n                        <h2 class="search-overlay__section-title">Institutions</h2>\n\n                        ${e.institutions.length?'<ul class="link-list min-list">':`<p>No institutions match that search. <a href="${universityData.root_url}/institutions">View all institutions</a></p>`}\n                        \n                        ${e.institutions.map(e=>`<li><a href="${e.permalink}">${e.title}</a></li>`).join("")} \n\n                        ${e.institutions.length?"</ul>":""}\n\n                        <h2 class="search-overlay__section-title">Events</h2>\n\n                        ${e.events.length?"":`<p>No events match that search. <a href="${universityData.root_url}/events">View all events</a></p>`}\n                        \n                        ${e.events.map(e=>`\n                            <div class="event-summary">\n                                <a class="event-summary__date t-center" href="${e.permalink}">\n                                    <span class="event-summary__month">${e.month}</span>\n                                    <span class="event-summary__day">${e.day}</span>\n                                </a>\n                                <div class="event-summary__content">\n                                    <h5 class="event-summary__title headline headline--tiny"><a href="${e.permalink}">${e.title}</a></h5>\n                                    <p>${e.description}<a href="${e.permalink}" class="nu gray">Learn more</a></p>\n                                </div> \n                            </div>\n                        `).join("")} \n\n                    </div>\n                </div>\n            `),this.isSpinnerVisible=!1})}keyPressDispatcher(e){83!=e.keyCode||this.isOverlayOpen||l()("input, textarea").is(":focus")||(this.openOverlay(),console.log("OpenMethod")),27==e.keyCode&&this.isOverlayOpen&&(this.closeOverlay(),console.log("CloseMethod"))}openOverlay(){return this.searchOverlay.addClass("search-overlay--active"),l()("body").addClass("body-no-scroll"),this.searchField.val(""),setTimeout(()=>{this.searchField.focus()},301),this.isOverlayOpen=!0,!1}closeOverlay(){this.searchOverlay.removeClass("search-overlay--active"),l()("body").removeClass("body-no-scroll"),this.isOverlayOpen=!1}addSearchHTML(){l()("body").append(' \n             \x3c!-- SEARCH OVERLAY --\x3e\n            <div class="search-overlay"> \x3c!-- ACTIVE class makes the search window appear (JS) --\x3e\n                <div class="search-overlay__top">\n                <div class="container">\n                <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>\n                    <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">\n                    <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>\n                </div>\n                </div>\n\n                <div class="container">\n                <div id="search-overlay__results">\n                    <h2></h2>\n                </div>\n                </div>\n            </div>\n        ')}};new n,new a,new i,new c}]);