!function(e){function t(o){if(n[o])return n[o].exports;var i=n[o]={i:o,l:!1,exports:{}};return e[o].call(i.exports,i,i.exports,t),i.l=!0,i.exports}var n={};t.m=e,t.c=n,t.i=function(e){return e},t.d=function(e,n,o){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:o})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="./",t(t.s=261)}({1:function(e,t,n){"use strict";n.d(t,"a",function(){return o}),n.d(t,"j",function(){return i}),n.d(t,"b",function(){return s}),n.d(t,"c",function(){return c}),n.d(t,"d",function(){return u}),n.d(t,"g",function(){return r}),n.d(t,"h",function(){return a}),n.d(t,"e",function(){return l}),n.d(t,"f",function(){return f}),n.d(t,"i",function(){return d});var o="SET_REQUESTING",i="SET_SHOW_PANEL",s="SET_SHOW",c="SET_SEARCH_TEXT",u="SET_SEARCH_RESULTS",r="SET_SHOW_MORE_FIELDS",a="TOGGLE_SHOW_MORE_FIELDS",l="ADD_TO_SELECTED_TOPICS",f="REMOVE_FROM_SELECTED_TOPICS",d="SET_QUESTION_DETAIL"},11:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={}},136:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var o=n(98);n(97);new Vue({el:"#app",store:o.a})},261:function(e,t,n){e.exports=n(136)},5:function(e,t,n){"use strict";var o=n(7),i=n(6),s=n(8);t.a={searchOrAskPanel:o.a,searchOrAskOverlay:i.a,topicRecommendation:s.a}},6:function(e,t,n){"use strict";function o(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var i,s=n(1);t.a={namespaced:!0,state:{requesting:!1,show:!1,searchText:null,questionDetail:null,searchResults:[],showMoreFields:!1,selectedTopics:[],postQuestionUrl:Vue.prototype.$viender.helpers.api("/questions")},mutations:(i={},o(i,s.a,function(e,t){e.requesting=t}),o(i,s.b,function(e,t){document.getElementsByTagName("body")[0].style.overflowY=t?"hidden":"auto",e.show=t}),o(i,s.c,function(e,t){e.searchText=t}),o(i,s.d,function(e,t){e.searchResults.searchResults}),o(i,s.g,function(e,t){e.showMoreFields=t}),o(i,s.h,function(e){e.showMoreFields=!e.showMoreFields}),o(i,s.e,function(e,t){e.selectedTopics.push(t)}),o(i,s.f,function(e,t){e.selectedTopics=e.selectedTopics.filter(function(e){return e.id!==t.id})}),o(i,s.i,function(e,t){e.questionDetail=t}),i),actions:{postQuestion:function(e){var t=e.state,n=e.commit;t.requesting||(n(s.a,!0),axios.post(t.postQuestionUrl,{title:t.searchText,body:t.questionDetail,topics:t.selectedTopics}).then(function(e){document.location=Vue.prototype.$viender.helpers.getUrl("self_html",e.data),n(s.a,!1)}).catch(function(e){n(s.a,!1)}))}}}},7:function(e,t,n){"use strict";function o(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var i,s=n(1);t.a={namespaced:!0,state:{requesting:!1,showPanel:!1,searchText:null,searchResults:[],showMoreFields:!1,selectedTopics:[]},mutations:(i={},o(i,s.a,function(e,t){e.requesting=t}),o(i,s.j,function(e,t){document.getElementsByTagName("body")[0].style.overflow=t?"hidden":"scroll",e.showPanel=t}),o(i,s.c,function(e,t){e.searchText=t}),o(i,s.d,function(e,t){e.searchResults.searchResults}),o(i,s.g,function(e,t){e.showMoreFields=t}),o(i,s.e,function(e,t){e.selectedTopics.push(t)}),o(i,s.f,function(e,t){e.selectedTopics=e.selectedTopics.filter(function(e){return e.id!==t.id})}),i),actions:{}}},8:function(e,t,n){"use strict";function o(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var i,s=n(1);t.a={namespaced:!0,state:{requesting:!1,show:!1,searchText:null,searchResults:[],selectedTopics:[],url:Vue.prototype.$viender.helpers.api("topics")},mutations:(i={},o(i,s.a,function(e,t){e.requesting=t}),o(i,s.b,function(e,t){e.show=t}),o(i,s.c,function(e,t){e.searchText=t}),o(i,s.d,function(e,t){e.searchResults=t}),o(i,s.e,function(e,t){e.selectedTopics.push(t)}),o(i,s.f,function(e,t){e.selectedTopics=e.selectedTopics.filter(function(e){return e.id!==t.id})}),i),actions:{showTopicRecommendations:function(e){var t=(e.state,e.commit);setTimeout(function(){t(s.b,!0)},100)},hideTopicRecommendations:function(e){var t=(e.state,e.commit);setTimeout(function(){t(s.b,!1)},200)}}}},97:function(e,t){},98:function(e,t,n){"use strict";var o=n(5);t.a=new Vuex.Store({modules:Object.assign(o.a,{}),actions:n(11)})}});