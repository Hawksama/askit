!function(t){var e={};function n(r){if(e[r])return e[r].exports;var o=e[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:r})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)n.d(r,o,function(e){return t[e]}.bind(null,o));return r},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=0)}([function(t,e,n){"use strict";n.r(e);n(1),n(3);var r=wp.i18n.__,o=wp.editPost.PluginPostStatusInfo,u=wp.plugins.registerPlugin,i=wp.data,l=i.subscribe,s=i.dispatch,a=i.select,c=i.withSelect,d=i.withDispatch,f=wp.compose.compose,p=wp.components.SelectControl,v=window.EditFlowCustomStatuses.map((function(t){return{label:t.name,value:t.slug}})),m=null;function w(t){!t||t.innerText!==r("Save Draft")&&t.innerText!==r("Save as Pending")||(t.innerText=r("Save"))}l((function(){a("core/editor").getCurrentPostId()&&(a("core/editor").isCleanNewPost()&&s("core/editor").editPost({status:ef_default_custom_status}),w(document.querySelector(".editor-post-save-draft")),null===m&&window.MutationObserver&&a("core/editor").isSavingPost()&&(m=function(t){if(!t)return null;var e=new MutationObserver((function(t){var e=!0,n=!1,r=void 0;try{for(var o,u=t[Symbol.iterator]();!(e=(o=u.next()).done);e=!0){var i=o.value,l=!0,s=!1,a=void 0;try{for(var c,d=i.addedNodes[Symbol.iterator]();!(l=(c=d.next()).done);l=!0){w(c.value)}}catch(t){s=!0,a=t}finally{try{l||null==d.return||d.return()}finally{if(s)throw a}}}}catch(t){n=!0,r=t}finally{try{e||null==u.return||u.return()}finally{if(n)throw r}}}));return e.observe(t,{childList:!0}),e}(document.querySelector(".edit-post-header__settings"))))}));u("edit-flow-custom-status",{icon:"edit-flow",render:f(c((function(t){return{status:t("core/editor").getEditedPostAttribute("status")}})),d((function(t){return{onUpdate:function(e){t("core/editor").editPost({status:e})}}})))((function(t){var e=t.onUpdate,n=t.status;return wp.element.createElement(o,{className:"edit-flow-extended-post-status edit-flow-extended-post-status-".concat(n)},wp.element.createElement("h4",null,r("publish"!==n?"Extended Post Status":"Extended Post Status Disabled.","edit-flow")),"publish"!==n?wp.element.createElement(p,{label:"",value:n,options:v,onChange:e}):null,wp.element.createElement("small",{className:"edit-flow-extended-post-status-note"},r("publish"!==n?"Note: this will override all status settings above.":"To select a custom status, please unpublish the content first.","edit-flow")))}))})},function(t,e){},,function(t,e){}]);
//# sourceMappingURL=custom-status.build.js.map