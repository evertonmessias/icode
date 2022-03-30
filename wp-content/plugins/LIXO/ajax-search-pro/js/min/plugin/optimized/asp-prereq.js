/*
 swiped-events.js - v@version@
 Pure JavaScript swipe events
 https://github.com/john-doherty/swiped-events
 @inspiration https://stackoverflow.com/questions/16348031/disable-scrolling-when-touch-moving-certain-element
 @author John Doherty <www.johndoherty.info>
 @license MIT
*/
(function(){window.WPD="undefined"!==typeof window.WPD?window.WPD:{};if("undefined"!=typeof WPD.dom&&1<WPD.dom.version)return!1;WPD.dom=function(){if("undefined"==typeof WPD.dom.fn||"undefined"==typeof WPD.dom.fn.a)WPD.dom.fn={a:[],is_wpd_dom:!0,length:0,get:function(a){return"undefined"==typeof a?this.a.slice():"undefined"!=typeof this.a[a]?this.a[a]:null},_:function(a){return"<"===a.charAt(0)?WPD.dom._fn.createElementsFromHTML(a):Array.prototype.slice.call(document.querySelectorAll(a))},$:function(a,
b){let c=this.copy(this,!0);c.a="undefined"!=typeof b?b.find(a).get():"string"==typeof a?c._(a):[a];c.length=c.a.length;return c},extend:function(){for(let a=1;a<arguments.length;a++)for(let b in arguments[a])arguments[a].hasOwnProperty(b)&&(arguments[0][b]=arguments[a][b]);return arguments[0]},copy:function(a,b){let c,d,e;if("object"!=typeof a||null===a)return a;c=new a.constructor;for(d in a)a.hasOwnProperty(d)&&(e=typeof a[d],c[d]=b&&"object"===e&&null!==a[d]?this.copy(a[d]):a[d]);return c},parent:function(a){let b=
this.get(0),c=this.copy(this,!0);c.a=[];null!=b&&(b=b.parentElement,"undefined"!=typeof a?b.matches(a)&&(c.a=[b]):c.a=null==b?[]:[b]);return c},first:function(){let a=this.copy(this,!0);a.a="undefined"!=typeof a.a[0]?[a.a[0]]:[];a.length=a.a.length;return a},last:function(){let a=this.copy(this,!0);a.a=0<a.a.length?[a.a[a.a.length-1]]:[];a.length=a.a.length;return a},prev:function(a){let b=this.copy(this,!0);if("undefined"==typeof a)b.a="undefined"!=typeof b.a[0]&&null!=b.a[0].previousElementSibling?
[b.a[0].previousElementSibling]:[];else if("undefined"!=typeof b.a[0]){let c=b.a[0].previousElementSibling;for(b.a=[];null!=c;){if(c.matches(a)){b.a=[c];break}c=c.previousElementSibling}}b.length=b.a.length;return b},next:function(a){let b=this.copy(this,!0);if("undefined"==typeof a)b.a="undefined"!=typeof b.a[0]&&null!=b.a[0].nextElementSibling?[b.a[0].nextElementSibling]:[];else if("undefined"!=typeof b.a[0]){let c=b.a[0].nextElementSibling;for(b.a=[];null!=c;){if(c.matches(a)){b.a=[c];break}c=
c.nextElementSibling}}b.length=b.a.length;return b},closest:function(a){let b=this.get(0),c=this.copy(this,!0);c.a=[];if("string"===typeof a){if(null!==b&&"undefined"!=typeof b.matches&&""!==a){if(!b.matches(a))for(;(b=b.parentElement)&&!b.matches(a););c.a=null==b?[]:[b]}}else if(null!==b&&"undefined"!=typeof b.matches&&"undefined"!=typeof a.matches){if(b!==a)for(;(b=b.parentElement)&&b!==a;);c.a=null==b?[]:[b]}c.length=c.a.length;return c},add:function(a){if("undefined"!==typeof a.nodeType)-1==this.a.indexOf(a)&&
this.a.push(a);else if("undefined"!==typeof a.n){let b=this;a.n.forEach(function(c){-1==b.a.indexOf(c)&&b.a.push(c)})}return this},find:function(a){let b=this.copy(this,!0);b.a=[];this.forEach(function(c){null!==c&&"undefined"!=typeof c.querySelectorAll&&(b.a=b.a.concat(Array.prototype.slice.call(c.querySelectorAll(a))))});b.length=b.a.length;return b},forEach:function(a){this.a.forEach(function(b,c,d){a.apply(b,[b,c,d])});return this},each:function(a){return this.forEach(a)},hasClass:function(a){let b=
this.get(0);return null!=b?b.classList.contains(a):!1},addClass:function(a){let b=arguments;1==b.length&&(b=a.split(" "));this.forEach(function(c){c.classList.add.apply(c.classList,b)});return this},removeClass:function(a){let b=arguments;1==b.length&&(b=a.split(" "));this.forEach(function(c){c.classList.remove.apply(c.classList,b)});return this},is:function(a){let b=this.get(0);return null!=b?b.matches(a):!1},val:function(a){let b=this.get(0);if(null!=b)if(1==arguments.length)if("select-multiple"==
b.type){a="string"===typeof a?a.split(","):a;for(let c=0,d=b.options.length,e;c<d;c++)e=b.options[c],-1!=a.indexOf(e.value)?e.selected=!0:e.selected=!1}else b.value=a;else return"select-multiple"==b.type?Array.prototype.map.call(b.selectedOptions,function(c){return c.value}):b.value;return this},attr:function(a,b){let c,d=arguments,e=this;this.forEach(function(f){2==d.length?(f.setAttribute(a,b),c=e):"object"===typeof a?Object.keys(a).forEach(function(g){f.setAttribute(g,a[g])}):c=f.getAttribute(a)});
return c},removeAttr:function(a){this.forEach(function(b){b.removeAttribute(a)});return this},prop:function(a,b){let c,d=arguments;this.forEach(function(e){2==d.length?e[a]=b:c="undefined"!=typeof e[a]?e[a]:null});return 2==d.length?this:c},data:function(a,b){let c=this.get(0),d=a.replace(/-([a-z])/g,function(e){return e[1].toUpperCase()});return null!=c?2==arguments.length?(c.dataset[d]=b,this):"undefined"==typeof c.dataset[d]?"":c.dataset[d]:""},html:function(a){let b=this.get(0);return null!=b?
1==arguments.length?(b.innerHTML=a,this):b.innerHTML:""},text:function(a){let b=this.get(0);return null!=b?1==arguments.length?(b.textContent=a,this):b.textContent:""},css:function(a,b){let c=this.get(),d;for(let e=0;e<c.length;e++)if(d=c[e],1==arguments.length)if("object"==typeof a)Object.keys(a).forEach(function(f){d.style[f]=a[f]});else return window.getComputedStyle(d)[a];else d.style[a]=b;return this},position:function(){let a=this.get(0);return null!=a?{top:a.offsetTop,left:a.offsetLeft}:{top:0,
left:0}},offset:function(){let a=this.get(0);return null!=a?WPD.dom._fn.hasFixedParent(a)?a.getBoundingClientRect():WPD.dom._fn.absolutePosition(a):{top:0,left:0}},outerWidth:function(a){a=a||!1;let b=this.get(0);if(null!=b)return a?parseInt(b.offsetWidth)+parseInt(this.css("marginLeft"))+parseInt(this.css("marginRight")):parseInt(b.offsetWidth)},outerHeight:function(a){return a?parseInt(this.css("height"))+parseInt(this.css("marginTop"))+parseInt(this.css("marginBottom")):parseInt(this.css("height"))},
width:function(){return this.outerWidth()},height:function(){return this.outerHeight()},on:function(){let a=arguments,b=function(e,f){let g;if("mouseenter"==f.type||"mouseleave"==f.type||"hover"==f.type){var h=document.elementFromPoint(f.clientX,f.clientY);if(!h.matches(e[1]))for(;(h=h.parentElement)&&!h.matches(e[1]););null!=h&&(g=WPD.dom(h))}else g=WPD.dom(f.target).closest(e[1]);if(null!=g&&0<g.closest(this).length){h=[];h.push(f);if("undefined"!=typeof e[4])for(f=4;f<e.length;f++)h.push(e[f]);
e[2].apply(g.get(0),h)}},c=function(e,f){let g=[];g.push(f);if("undefined"!=typeof e[3])for(f=3;f<e.length;f++)g.push(e[f]);e[1].apply(this,g)},d=a[0].split(" ");for(let e=0;e<d.length;e++){let f=d[e];"string"==typeof a[1]?this.forEach(function(g){if(!WPD.dom._fn.hasEventListener(g,f,a[2])){let h=b.bind(g,a);g.addEventListener(f,h,a[3]);g._wpd_el="undefined"==typeof g._wpd_el?[]:g._wpd_el;g._wpd_el.push({type:f,selector:a[1],func:h,trigger:a[2],args:a[3]})}}):this.forEach(function(g){if(!WPD.dom._fn.hasEventListener(g,
f,a[1])){let h=c.bind(g,a);g.addEventListener(f,h,a[2]);g._wpd_el="undefined"==typeof g._wpd_el?[]:g._wpd_el;g._wpd_el.push({type:f,func:h,trigger:a[1],args:a[2]})}})}return this},off:function(a,b){this.forEach(function(c){if("undefined"!=typeof c._wpd_el&&0<c._wpd_el.length)if("undefined"===typeof a){let d;for(;d=c._wpd_el.pop();)c.removeEventListener(d.type,d.func,d.args);c._wpd_el=[]}else a.split(" ").forEach(function(d){if("undefined"==typeof b){let e;for(;e=c._wpd_el.pop();)c.removeEventListener(d,
e.func,e.args);c._wpd_el=[]}else{let e=[];c._wpd_el.forEach(function(f,g){f.type==d&&f.trigger==b?c.removeEventListener(d,f.func,f.args):e.push(f)});c._wpd_el=e}})});return this},offForced:function(){let a=this;this.forEach(function(b,c){let d=b.cloneNode(!0);b.parentNode.replaceChild(d,b);a.a[c]=d});return this},trigger:function(a,b,c,d){c=c||!1;d=d||!1;this.forEach(function(e){if(d&&"undefined"!=typeof jQuery)jQuery(e).trigger(a,b);else if(c){let f=new Event(a);f.detail=b;e.dispatchEvent(f)}if("undefined"!=
typeof e._wpd_el)e._wpd_el.forEach(function(f){if(f.type==a){let g=new Event(a);f.trigger.apply(e,[g].concat(b))}});else{let f=!1,g=e;for(;;){g=g.parentElement;if(null==g)break;"undefined"!=typeof g._wpd_el&&g._wpd_el.forEach(function(h){if("undefined"!==typeof h.selector){var l=WPD.dom(g).find(h.selector);0<l.length&&0<=l.get().indexOf(e)&&h.type==a&&(l=new Event(a),h.trigger.apply(e,[l].concat(b)),f=!0)}});if(f)break}}});return this},clone:function(){let a=this.get(0);null!=a?(this.a=[a.cloneNode(!0)],
this.length=this.a.length):this.a=[];this.length=this.a.length;return this},remove:function(a){if("undefined"!=typeof a)return a.parentElement.removeChild(a);this.forEach(function(b){if(null!=b.parentElement)return b.parentElement.removeChild(b)});this.a=[];this.length=this.a.length;return null},detach:function(){let a=this,b=[];this.forEach(function(c){c=a.remove(c);null!=c&&b.push(c)});this.a=b;this.length=this.a.length;return this},prepend:function(a){"string"==typeof a&&(a=WPD.dom._fn.createElementsFromHTML(a));
a=Array.isArray(a)?a:[a];this.forEach(function(b){a.forEach(function(c){"undefined"!=typeof c.is_wpd_dom?c.forEach(function(d){b.insertBefore(d,b.children[0])}):b.insertBefore(c,b.children[0])})});return this},append:function(a){"string"==typeof a&&(a=WPD.dom._fn.createElementsFromHTML(a));a=Array.isArray(a)?a:[a];this.forEach(function(b){a.forEach(function(c){null!=c&&("undefined"!=typeof c.is_wpd_dom?c.forEach(function(d){b.appendChild(d)}):b.appendChild(c))})});return this},uuidv4:function(){return"xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g,
function(a){let b=16*Math.random()|0;return("x"==a?b:b&3|8).toString(16)})}},WPD.dom._fn={hasFixedParent:function(a){do if("fixed"==window.getComputedStyle(a).position)return!0;while(a=a.parentElement);return!1},hasEventListener:function(a,b,c){if("undefined"==typeof a._wpd_el)return!1;for(let d=0;d<a._wpd_el.length;d++)if(a._wpd_el[d].trigger==c&&a._wpd_el[d].type==b)return!0;return!1},allDescendants:function(a){let b=[],c=this;Array.isArray(a)||(a=[a]);a.forEach(function(d){for(let e=0;e<d.childNodes.length;e++){let f=
d.childNodes[e];b.push(f);b=b.concat(c.allDescendants(f))}});return b},createElementsFromHTML:function(a){let b=document.createElement("template");b.innerHTML=a;return Array.prototype.slice.call(b.content.childNodes)},absolutePosition:function(a){let b=document.body.getBoundingClientRect();a=a.getBoundingClientRect();let c=window.getComputedStyle(document.body).position,d=document.documentElement.offsetTop,e=document.documentElement.offsetLeft;if("relative"==c||"absolute"==c)e=d=0;return{top:a.top-
b.top+d,left:a.left-b.left+e}},plugin:function(a,b){WPD.dom.fn[a]=function(c){return"undefined"!=typeof c&&b[c]?b[c].apply(this,Array.prototype.slice.call(arguments,1)):this.each(function(d){d["wpd_dom_"+a]=Object.create(b).init(c,d)})}}},WPD.dom.version=1;return 1<=arguments.length?WPD.dom.fn.$.apply(WPD.dom.fn,arguments):WPD.dom.fn};WPD.dom();document.dispatchEvent(new Event("wpd-dom-core-loaded"))})();
(function(){WPD.dom.fn._animate={easing:{linear:function(a){return a},easeInOutQuad:function(a){return.5>a?2*a*a:1-Math.pow(-2*a+2,2)/2},easeOutQuad:function(a){return 1-(1-a)*(1-a)}}};WPD.dom.fn.animate=function(a,b,c){let d=this;b=b||200;c=c||"linear";this.forEach(function(e){let f,g=0,h,l={},k={},m,p,q;m=d.prop("_wpd_dom_animations");m=null==m?[]:m;!1===a?m.forEach(function(n){clearInterval(n)}):(q="undefined"!=typeof d._animate.easing[c]?d._animate.easing[c]:d._animate.easing.easeInOutQuad,Object.keys(a).forEach(function(n){-1<
n.indexOf("scroll")?l[n]=e[n]:l[n]=parseInt(window.getComputedStyle(e)[n]);k[n]=a[n]-l[n]}),f=b/1E3*60,p=setInterval(function(){g++;g>f?clearInterval(p):(h=q(g/f),Object.keys(k).forEach(function(n){-1<n.indexOf("scroll")?e[n]=l[n]+k[n]*h:e.style[n]=l[n]+k[n]*h+"px"}))},1E3/60),m.push(p),d.prop("_wpd_dom_animations",m))});return this};document.dispatchEvent(new Event("wpd-dom-animate-loaded"))})();
(function(){let a=WPD.dom;WPD.dom.fn.unhighlight=function(b){let c={className:"highlight",element:"span"};a.extend(c,b);return this.find(c.element+"."+c.className).each(function(){let d=this.parentNode;d.replaceChild(this.firstChild,this);d.normalize()})};WPD.dom.fn.highlight=function(b,c){function d(g,h,l,k,m){m=""==m?".exhghttt":m;if(3===g.nodeType){if(h=g.data.normalize("NFD").replace(/[\u0300-\u036f]/g,"").match(h))return l=document.createElement(l||"span"),l.className=k||"highlight",k=/\.|,|\s/.test(h[0].charAt(0))?
h.index+1:h.index,g=g.splitText(k),g.splitText(h[1].length),k=g.cloneNode(!0),l.appendChild(k),g.parentNode.replaceChild(l,g),1}else if(1===g.nodeType&&g.childNodes&&!/(script|style)/i.test(g.tagName)&&0< !a(g).closest(m).length&&(g.tagName!==l.toUpperCase()||g.className!==k))for(let p=0;p<g.childNodes.length;p++)p+=d(g.childNodes[p],h,l,k,m);return 0}let e={className:"highlight",element:"span",caseSensitive:!1,wordsOnly:!1,excludeParents:""};a.fn.extend(e,c);b.constructor===String&&(b=[b]);b=b.filter(function(g){return""!=
g});b.forEach(function(g,h,l){l[h].replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&").normalize("NFD").replace(/[\u0300-\u036f]/g,"")});if(0==b.length)return this;c=e.caseSensitive?"":"i";b="("+b.join("|")+")";e.wordsOnly&&(b="(?:,|^|\\s)"+b+"(?:,|$|\\s)");let f=new RegExp(b,c);return this.each(function(g){d(g,f,e.element,e.className,e.excludeParents)})}})();
(function(){WPD.dom.fn.serialize=function(){let a=this.get(0);if(a&&"FORM"===a.nodeName){var b,c,d=[];for(b=a.elements.length-1;0<=b;--b)if(""!==a.elements[b].name)switch(a.elements[b].nodeName){case "INPUT":switch(a.elements[b].type){case "text":case "hidden":case "password":case "button":case "reset":case "submit":d.push(a.elements[b].name+"="+encodeURIComponent(a.elements[b].value));break;case "checkbox":case "radio":a.elements[b].checked&&d.push(a.elements[b].name+"="+encodeURIComponent(a.elements[b].value))}break;
case "TEXTAREA":d.push(a.elements[b].name+"="+encodeURIComponent(a.elements[b].value));break;case "SELECT":switch(a.elements[b].type){case "select-one":d.push(a.elements[b].name+"="+encodeURIComponent(a.elements[b].value));break;case "select-multiple":for(c=a.elements[b].options.length-1;0<=c;--c)a.elements[b].options[c].selected&&d.push(a.elements[b].name+"="+encodeURIComponent(a.elements[b].options[c].value))}break;case "BUTTON":switch(a.elements[b].type){case "reset":case "submit":case "button":d.push(a.elements[b].name+
"="+encodeURIComponent(a.elements[b].value))}}return d.join("&")}};WPD.dom.fn.serializeForAjax=function(a,b){let c=[],d;for(d in a)if(a.hasOwnProperty(d)){let e=b?b+"["+d+"]":d,f=a[d];c.push(null!==f&&"object"===typeof f?WPD.dom.fn.serializeForAjax(f,e):encodeURIComponent(e)+"="+encodeURIComponent(f))}return c.join("&")};document.dispatchEvent(new Event("wpd-dom-serialize-loaded"))})();
(function(){WPD.dom.fn.inViewPort=function(a,b){var c=this.get(0);let d;if(null==c)return!1;a="undefined"==typeof a?0:a;b="undefined"==typeof b?window:"string"==typeof b?document.querySelector(b):b;var e=c.getBoundingClientRect();c=e.top;let f=e.bottom,g=e.left,h=e.right;null==b&&(b=window);b===window?(e=window.innerWidth||0,d=window.innerHeight||0):(e=b.clientWidth,d=b.clientHeight,b=b.getBoundingClientRect(),c-=b.top,f-=b.top,g-=b.left,h-=b.left);a=~~Math.round(parseFloat(a));return 0>=h||g>=e?
!1:0<a?c>=a&&f<d-a:(0<f&&c<=d-a)|(0>=c&&f>a)};document.dispatchEvent(new Event("wpd-dom-viewport-loaded"))})();
(function(){WPD.dom.fn.ajax=function(a){a=this.extend({url:"",method:"GET",cors:"cors",data:{},success:null,fail:null,accept:"text/html",contentType:"application/x-www-form-urlencoded; charset=UTF-8"},a);if("cors"!=a.cors){var b="ajax_cb_"+this.uuidv4().replaceAll("-","");WPD.dom.fn[b]=function(){a.success.apply(this,arguments);delete WPD.dom.fn[a.data.fn]};a.data.callback="WPD.dom.fn."+b;a.data.fn=b;b=document.createElement("script");b.type="text/javascript";b.src=a.url+"?"+this.serializeForAjax(a.data);
b.onload=function(){this.remove()};document.body.appendChild(b)}else return b=new XMLHttpRequest,b.onreadystatechange=function(){null!=a.success&&4==this.readyState&&200==this.status&&a.success(this.responseText);null!=a.fail&&4==this.readyState&&400<=this.status&&a.fail(this)},b.open(a.method.toUpperCase(),a.url,!0),b.setRequestHeader("Content-type",a.contentType),b.setRequestHeader("Accept",a.accept),b.send(this.serializeForAjax(a.data)),b};document.dispatchEvent(new Event("wpd-dom-xhttp-loaded"))})();
window.WPD=window.WPD||{};
window.WPD.Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(a){let b="";let c,d,e,f,g,h=0;for(a=this._utf8_encode(a);h<a.length;){var l=a.charCodeAt(h++);c=a.charCodeAt(h++);d=a.charCodeAt(h++);e=l>>2;l=(l&3)<<4|c>>4;f=(c&15)<<2|d>>6;g=d&63;isNaN(c)?f=g=64:isNaN(d)&&(g=64);b=b+this._keyStr.charAt(e)+this._keyStr.charAt(l)+this._keyStr.charAt(f)+this._keyStr.charAt(g)}return b},decode:function(a){let b="";let c,d,e,f=0;for(a=a.replace(/[^A-Za-z0-9\+\/=]/g,
"");f<a.length;){var g=this._keyStr.indexOf(a.charAt(f++));var h=this._keyStr.indexOf(a.charAt(f++));d=this._keyStr.indexOf(a.charAt(f++));e=this._keyStr.indexOf(a.charAt(f++));g=g<<2|h>>4;h=(h&15)<<4|d>>2;c=(d&3)<<6|e;b+=String.fromCharCode(g);64!=d&&(b+=String.fromCharCode(h));64!=e&&(b+=String.fromCharCode(c))}return b=this._utf8_decode(b)},_utf8_encode:function(a){a=a.replace(/\r\n/g,"\n");let b="";for(let c=0;c<a.length;c++){let d=a.charCodeAt(c);128>d?b+=String.fromCharCode(d):(127<d&&2048>
d?b+=String.fromCharCode(d>>6|192):(b+=String.fromCharCode(d>>12|224),b+=String.fromCharCode(d>>6&63|128)),b+=String.fromCharCode(d&63|128))}return b},_utf8_decode:function(a){let b="",c=0,d,e,f;for(;c<a.length;)d=a.charCodeAt(c),128>d?(b+=String.fromCharCode(d),c++):191<d&&224>d?(e=a.charCodeAt(c+1),b+=String.fromCharCode((d&31)<<6|e&63),c+=2):(e=a.charCodeAt(c+1),f=a.charCodeAt(c+2),b+=String.fromCharCode((d&15)<<12|(e&63)<<6|f&63),c+=3);return b}};
(function(){window.WPD=window.WPD||{};WPD.Hooks=WPD.Hooks||{};let a=WPD.Hooks;a.filters=a.filters||{};a.addFilter=function(b,c,d,e){a.filters[b]=a.filters[b]||[];a.filters[b].push({priority:"undefined"===typeof d?10:d,scope:"undefined"===typeof e?null:e,callback:c})};a.removeFilter=function(b,c){"undefined"!=typeof a.filters[b]&&("undefined"==typeof c?a.filters[b]=[]:a.filters[b].forEach(function(d,e){d.callback===c&&a.filters[b].splice(e,1)}))};a.applyFilters=function(b){let c=[],d=Array.prototype.slice.call(arguments),
e=arguments[1];"undefined"!==typeof a.filters[b]&&0<a.filters[b].length&&(a.filters[b].forEach(function(f){c[f.priority]=c[f.priority]||[];c[f.priority].push({scope:f.scope,callback:f.callback})}),d.splice(0,2),c.forEach(function(f){f.forEach(function(g){e=g.callback.apply(g.scope,[e].concat(d))})}));return e}})();window.WPD=window.WPD||{};
window.WPD.intervalUntilExecute=function(a,b,c,d){let e,f=0,g="function"===typeof b?b():b;c="undefined"==typeof c?100:c;d="undefined"==typeof d?50:d;if(!1===g)e=setInterval(function(){g="function"===typeof b?b():b;f++;if(f>d)return clearInterval(e),!1;if(!1!==g)return clearInterval(e),a(g)},c);else return a(g)};
(function(a,b){function c(k,m,p){for(;k&&k!==b.documentElement;){var q=k.getAttribute(m);if(q)return q;k=k.parentNode}return p}"function"!==typeof a.CustomEvent&&(a.CustomEvent=function(k,m){m=m||{bubbles:!1,cancelable:!1,detail:void 0};var p=b.createEvent("CustomEvent");p.initCustomEvent(k,m.bubbles,m.cancelable,m.detail);return p},a.CustomEvent.prototype=a.Event.prototype);b.addEventListener("touchstart",function(k){"true"!==k.target.getAttribute("data-swipe-ignore")&&(l=k.target,h=Date.now(),d=
k.touches[0].clientX,e=k.touches[0].clientY,g=f=0)},!1);b.addEventListener("touchmove",function(k){if(d&&e){var m=k.touches[0].clientY;f=d-k.touches[0].clientX;g=e-m}},!1);b.addEventListener("touchend",function(k){if(l===k.target){var m=parseInt(c(l,"data-swipe-threshold","20"),10),p=parseInt(c(l,"data-swipe-timeout","500"),10),q=Date.now()-h,n="";k=k.changedTouches||k.touches||[];Math.abs(f)>Math.abs(g)?Math.abs(f)>m&&q<p&&(n=0<f?"swiped-left":"swiped-right"):Math.abs(g)>m&&q<p&&(n=0<g?"swiped-up":
"swiped-down");""!==n&&(m={dir:n.replace(/swiped-/,""),xStart:parseInt(d,10),xEnd:parseInt((k[0]||{}).clientX||-1,10),yStart:parseInt(e,10),yEnd:parseInt((k[0]||{}).clientY||-1,10)},l.dispatchEvent(new CustomEvent("swiped",{bubbles:!0,cancelable:!0,detail:m})),l.dispatchEvent(new CustomEvent(n,{bubbles:!0,cancelable:!0,detail:m})));h=e=d=null}},!1);var d=null,e=null,f=null,g=null,h=null,l=null})(window,document);