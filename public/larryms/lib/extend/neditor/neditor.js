layui.define("nebase",function(e){var t=layui.nebase;UE.Editor.prototype._bkGetActionUrl=UE.Editor.prototype.getActionUrl;UE.Editor.prototype.getActionUrl=function(e){if(e=="uploadimage"||e=="uploadscrawl"){return layui.cache.neUploadUrl}else if(e=="uploadvideo"){return layui.cache.neVideoUrl}else{return this._bkGetActionUrl.call(this,e)}};window.UEDITOR_CONFIG["imageUploadService"]=function(e,t){return{setUploadData:function(e){return e},setFormData:function(e,t,n){return t},setUploaderOptions:function(e){return e},getResponseSuccess:function(e){return e.code==200},imageSrcField:"url"}};window.UEDITOR_CONFIG["videoUploadService"]=function(e,t){return{setUploadData:function(e){return e},setFormData:function(e,t,n){return t},setUploaderOptions:function(e){return e},getResponseSuccess:function(e){return e.code==200},videoSrcField:"url"}};window.UEDITOR_CONFIG["scrawlUploadService"]=function(e,t){return scrawlUploadService={uploadScraw:function(e,t,n,r){}}};window.UEDITOR_CONFIG["fileUploadService"]=function(e,t){return{setUploadData:function(e){return e},setFormData:function(e,t,n){return t},setUploaderOptions:function(e){return e},getResponseSuccess:function(e){return e.code==200},fileSrcField:"url"}};e("neditor",{})});