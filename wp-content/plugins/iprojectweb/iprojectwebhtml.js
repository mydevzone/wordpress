
/*
	Copyright (C) 2007 Andrea Giammarchi - www.3site.eu
	doc: http://devpro.it/JSON/files/JSON-js.html
*/

JSON = new function(){

	this.decode = function(){
		var	filter, result, self, tmp;
		if($$("toString")) {
			switch(arguments.length){
				case	2:
					self = arguments[0];
					filter = arguments[1];
					break;
				case	1:
					if($[typeof arguments[0]](arguments[0]) === Function) {
						self = this;
						filter = arguments[0];
					}
					else
						self = arguments[0];
					break;
				default:
					self = this;
					break;
			};
			if(rc.test(self)){
				try{
					result = e("(".concat(self, ")"));
					if(filter && result !== null && (tmp = $[typeof result](result)) && (tmp === Array || tmp === Object)){
						for(self in result)
							result[self] = v(self, result) ? filter(self, result[self]) : result[self];
					}
				}
				catch(z){}
			}
			else {
				throw "Error: 'bad data':"+arguments[0];
			}
		};
		return result;
	};

	this.encode = function(){
		var	self = arguments.length ? arguments[0] : this,
			result, tmp;
		if(self === null)
			result = "null";
		else if(self !== undefined && (tmp = $[typeof self](self))) {
			switch(tmp){
				case	Array:
					result = [];
					for(var	i = 0, j = 0, k = self.length; j < k; j++) {
						if(self[j] !== undefined && (tmp = JSON.encode(self[j])))
							result[i++] = tmp;
					};
					result = "[".concat(result.join(","), "]");
					break;
				case	Boolean:
					result = String(self);
					break;
				case	Date:
					result = '"'.concat(self.getFullYear(), '-', d(self.getMonth() + 1), '-', d(self.getDate()), 'T', d(self.getHours()), ':', d(self.getMinutes()), ':', d(self.getSeconds()), '"');
					break;
				case	Function:
					break;
				case	Number:
					result = isFinite(self) ? String(self) : "null";
					break;
				case	String:
					result = '"'.concat(self.replace(rs, s).replace(ru, u), '"');
					break;
				default:
					var	i = 0, key;
					result = [];
					for(key in self) {
						if(self[key] !== undefined && (tmp = JSON.encode(self[key])))
							result[i++] = '"'.concat(key.replace(rs, s).replace(ru, u), '":', tmp);
					};
					result = "{".concat(result.join(","), "}");
					break;
			}
		};
		return result;
	};

	var	c = {"\b":"b","\t":"t","\n":"n","\f":"f","\r":"r",'"':'"',"\\":"\\","/":"/"},
		d = function(n){return n<10?"0".concat(n):n},
		e = function(c,f,e){e=eval;delete eval;if(typeof eval==="undefined")eval=e;f=eval(""+c);eval=e;return f},
		i = function(e,p,l){return 1*e.substr(p,l)},
		p = ["","000","00","0",""],
		rc = null,
		rd = /^[0-9]{4}\-[0-9]{2}\-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}$/,
		rs = /(\x5c|\x2F|\x22|[\x0c-\x0d]|[\x08-\x0a])/g,
		rt = /^([0-9]+|[0-9]+[,\.][0-9]{1,3})$/,
		ru = /([\x00-\x07]|\x0b|[\x0e-\x1f])/g,
		s = function(i,d){return "\\".concat(c[d])},
		u = function(i,d){
			var	n=d.charCodeAt(0).toString(16);
			return "\\u".concat(p[n.length],n)
		},
		v = function(k,v){return $[typeof result](result)!==Function&&(v.hasOwnProperty?v.hasOwnProperty(k):v.constructor.prototype[k]!==v[k])},
		$ = {
			"boolean":function(){return Boolean},
			"function":function(){return Function},
			"number":function(){return Number},
			"object":function(o){return o instanceof o.constructor?o.constructor:null},
			"string":function(){return String},
			"undefined":function(){return null}
		},
		$$ = function(m){
			function $(c,t){t=c[m];delete c[m];try{e(c)}catch(z){c[m]=t;return 1}};
			return $(Array)&&$(Object)
		};
	try{rc=new RegExp('^("(\\\\.|[^"\\\\\\n\\r])*?"|[,:{}\\[\\]0-9.\\-+Eaeflnr-u \\n\\r\\t])+?$')}
	catch(z){rc=/^(true|false|null|\[.*\]|\{.*\}|".*"|\d+|\d+\.\d+)$/}
};

/*
	Copyright (C) 2011 - 2012 Georgiy Vasylyev 
*/

iAjax = new function(){

	this.dParams = {};
	this.method = 'POST';

	this.request = function(requesto){
		var url = requesto.url || this.url;
		var ajx = {};      
		ajx.type = requesto.method || this.method;
		var params = AppMan.Utils.apply({}, this.dParams);
		params = AppMan.Utils.apply(params, requesto.params);

		ajx.data = params;
       ajx.data.action = 'iprojectweb-submit';
		if (requesto.dataType) ajx.dataType = requesto.dataType;
		if (requesto.success) ajx.success = requesto.success;
		ajx.error = (requesto.error) ? requesto.error : AppMan.handleError;

		var jaxhr = jQuery.ajax(url, ajx);
		if (requesto.object) jaxhr.robj = requesto.object;

	};

};

CalendarFactory = function(){

	this.instances = [];
	this.create = function(elId, config){
		elId = AppMan.Utils.idJoin(AppMan.factoryflag, elId);
		config.inputField=elId; 	
		config.button=AppMan.Utils.idJoin(elId, 'Trigger'); 	
		var calendar = Calendar.setup(config);
		this.instances.push(calendar);	
	};

	this.clear=function(){
		this.instances.length=0;
	};

};

TMCEFactory = function(){

	this.instances = {};
	this.create = function(elId, params){
		elId = AppMan.Utils.idJoin(AppMan.factoryflag, elId);
		params.mode='exact';
		params.elements=elId;
		var tmce = tinyMCE.init(params);
		this.instances[elId]=tmce;	
		jQuery('#'+elId).addClass('ufo-tinymce');
	};

	this.removeTinyMCEs=function(){
		for (var prop in this.instances){	
			var e=tinyMCE.get(prop);
			if (e!=null)
				tinyMCE.remove(e);
			delete this.instances[prop];				
		}
	};

	this.getTMCEContent=function(id, header, result){
		var e=tinyMCE.get(id);
		if (e!=null){
			var content = e.getContent();
			return content;
		}
		return false;
	};

};

AutoSuggestFactory = function(){

	this.instances = [];
	this.infos = [];

	this.create = function(elId, uparams, config){
		elId = AppMan.Utils.idJoin(AppMan.factoryflag, elId);
		params = {};
		params.minchars = 1;
		params.varname = 'query';
		params.className = 'autosuggest';
		params.timeout = 4500;
		params.delay = 500;
		params.offsety = -5;
		params.shownoresults = true;
		params.noresults = AppMan.resources.NoResults;
		params.maxheight = 250;
		params.cache = true;
		asFact = this;
		params.callback = function(data){asFact.setValues(data, elId)};
		params = AppMan.Utils.apply(params, uparams);
		if (!config.m)config.m='ajaxsuggest'; 
 
		var as = new AutoSuggest(elId, params, config);
		this.instances.push(as);	
		this.init(elId);
	};

	this.clear = function(){
		this.instances.length=0;	
		this.clearInfo();
	};

	this.clearInfo = function(){
		for (var i = 0; i < this.infos.length; i++){
			var info = this.infos[i];
			info.empty();
			info.remove();
		}
		this.infos.length=0;
	};

	this.getItem = function(elId){
		for(var i = 0; i< this.instances.length; i++){
			var as = this.instances[i];
			if (as.valueId == elId) return as;
		}
		return null;
	};

	this.getConfig = function(elId){
		var as = this.getItem(elId);
		if (as) return as.config;
		return null;
	};

	this.redirect = function(el, elId, objtype){
		elId = AppMan.Utils.siblingId(el, elId);
		objid = parseInt(jQuery('#'+elId).val());
		if (objid > 0){
			var request = {};
			request.t = objtype;
			request.m = 'show';
			request.oid = objid;
			redirect(request);
		}
	};

	this.init = function(elId){
		var value = jQuery('#'+elId).val();
		if (value && value != 0 && value != ''){
			var config = this.getConfig(elId);
			var ajx = {};
			ajx.params = AppMan.Utils.apply({}, config);
			ajx.params.oid = value;
			ajx.object = {};
			ajx.object.id = elId;
			ajx.object.asf = this;
			ajx.success = this.setAjaxValues;
			AppMan.Ajax.request(ajx); 			
		}
	};

	this.getFirstRecord = function(data){
		var response = AppMan.JSON.decode(data);
		if (response.results.length == 0) return false;
		return response.results[0];
	};	
	
	this.setAjaxValues = function(data, status, jqxhr){
		var rec = AppMan.AutoSuggest.getFirstRecord(data);
		AppMan.AutoSuggest.setValues(rec, jqxhr.robj.id);
	};	
	
	this.setValues = function(data, id){
		jQuery('#'+id).val(data.id);
		var $input = jQuery('#'+id+'input');
		$input.val(data.value);
		this.setTriggerHover(data, id);
	};		

	this.showInfo = function(config, el){
		var elid = el.id;
		if (jQuery('#'+elid+'info').length > 0) return;
		var ajx = {};
		ajx.params = AppMan.Utils.apply({}, config);
		ajx.success = function(data){
			var rec = AppMan.AutoSuggest.getFirstRecord(data);
			AppMan.AutoSuggest.setTriggerHover(rec, elid);
		};
		AppMan.Ajax.request(ajx); 			
	};

	this.setTriggerHover = function(data, id){

		var triggerid='#'+id+'-Trigger';
		$trigger = jQuery(triggerid);
		if ($trigger.length == 0)$trigger = jQuery('#'+id);
			
		var infoid=id+'info';
		var $info=jQuery('#'+infoid);
		
		if (data.info != undefined && data.info != ''){
			var width= $trigger.width(), height= $trigger.height(), infohtml;

			if ($info.length == 0){
				$info=jQuery('<div class="ufo-as-info"></div>');
				$info.attr('id', infoid);
				jQuery('body').append($info);
				this.infos.push($info);
			}

			infohtml = '<div class="ufo-as-info-inner">';
			infohtml+=data.info;
			infohtml+='</div>';

			$info.html(infohtml);
			$trigger.unbind('mouseenter mouseleave mouseover');

			$trigger.hover(
				function(){
					var pos =  jQuery(this).offset();
		 			var vpos =  pos.top + $info.height()- jQuery(window).scrollTop() < jQuery(window).height() ?  pos.top - 5: pos.top + 5 - $info.height();
		 			var hpos =  pos.left + width + $info.width() + 20 < jQuery(window).width() ? pos.left + width + 2 : pos.left - $info.width() - 22;
					$info.css({
						left:hpos+'px', 
						top:vpos+'px'})
					.fadeIn(300);
				},
				function(){
					$info.stop(true,true);
					$info.fadeOut(300);
				}
			);	
		} else {
			$info.empty();
			$trigger.unbind('mouseenter mouseleave');
		}
	};		

	this.blur = function(el, elId, md){
		var id = AppMan.Utils.siblingId(el, elId);
		var as = this.getItem(id);
		if (as) as.clearSuggestions();
		jQuery('#'+id+'info').stop(true, true);
		jQuery('#'+id+'info').animate({opacity:"hide", left:"80"},"fast");
		if (!jQuery('#'+id+'input').val()){
			var data = {id:'', value:'', info:''};
			this.setValues(data, id);
		}
		if (md != undefined){ 
			var valueEl = document.getElementById(id);
			AppMan.Filter.getListsOptions(valueEl, md);
		}		
	};		

};

AjaxUploadFactory = function(){

	this.instances = [];

	this.create = function(elId, request, oncomplete){
		elId = AppMan.Utils.idJoin(AppMan.factoryflag, elId);
		params = {};
		params.action = AppMan.Ajax.url;
		params.data = AppMan.Utils.apply({}, AppMan.Ajax.dParams);
		params.data.m = 'upload';
		params.data.action = 'iprojectweb-submit';
		params.data = AppMan.Utils.apply(params.data, request);
		params.name = request.t+'_'+request.fld+'_'+request.oid;
		params.onSubmit = this.onSubmit;
		params.onComplete = this.onComplete;
		var object = new AjaxUpload('#'+elId, params);
		object.oncomplete = oncomplete;
		this.instances.push(object);	
	};

	this.clear = function(){
		function removeNode(el){
			el.parentNode.removeChild(el);
		}
		for (var i = 0; i < this.instances.length; i++){	
			var au = this.instances[i]; 	
			if ( ! au._input ) continue;	
			removeNode(au._input.parentNode)			
		};
		this.instances.length=0;	
	};

	this.onSubmit = function(){
		jQuery('#'+this._button.id+' span a').text(AppMan.resources.Uploading);	
	};

	this.onComplete = function(){
		this.oncomplete.call();	
	};

	this.deleteFile = function(id, request, el, callback){
		request.m='delete';			
		ajx = {};			
		ajx.params = request;			
		ajx.success = this.deleteSuccess;			
		ajx.object = {};			
		ajx.object.id = id;			
		ajx.object.el = el;			
		ajx.object.callback = callback;			
		AppMan.Ajax.request(ajx);			
	};

	this.deleteSuccess = function(data, status, jqxhr){
		jQuery('#'+jqxhr.robj.id+' span button').text(AppMan.resources.Upload);	
		jQuery(jqxhr.robj.el).remove();	
		jqxhr.robj.callback.call(this);	
	};

};

var History = new function(){
	this.Actions={};
	this.Actions.clear=0;
	this.Actions.next=1;
	this.Actions.apply=2;
	this.Actions.applygui=3;
	this.Actions.refresh=5;
	this.Actions.back=6;
	this.Actions.reload=7;
	this.Actions.doNothing=8;
	this.data=[];
	this.selectors = {tab:'.ufo-tabs', tabmenu:'.ufo-tab-header li a', tableheader:'.ufo-tableheader'};
	this.tableheaders = ['.thacs', '.thdesc'];
	this.lastStep = null;
	this.getViewData=function(){
		var result = {};
		for (var prop in this.selectors){
			result[prop]={};
			jQuery(this.selectors[prop]).each(function(){
				var isActive = jQuery(this).hasClass('ufo-active') ? 'ufo-active' : 'none'; 
				result[prop][jQuery(this).attr('id')]=isActive;
			});			
		}	
		var sortarray=[];	
		for (var i = 0; i<this.tableheaders.length; i++){
			var headerclass=this.tableheaders[i];
			 
			jQuery(headerclass).each(function(){
				var th = {id: jQuery(this).attr('id'), className: headerclass.slice(1)};
				sortarray.push(th);
			});			
		}
		if (sortarray.length > 0) result.tableheaders = sortarray;		
		var activatedviews=[];	
		jQuery('.ufo-view-activated').each(function(){
			activatedviews.push(jQuery(this).attr('id')); 
		});
		if (activatedviews.length > 0) result.activatedviews=activatedviews;
		return result;
	};
	this.applyViewData=function(){
		if (!this.lastStep) return;
		var history = this.lastStep.viewdata;
		for (var prop in this.selectors){
			for (var id in history[prop]){
				jQuery('#'+id).removeClass('ufo-active');
				if (history[prop][id]=='ufo-active')
					jQuery('#'+id).addClass('ufo-active');
			}
		}
		if (history.tableheaders){
			for (var i = 0; i < history.tableheaders.length; i++){
				var th = history.tableheaders[i]; 
				jQuery('#'+th.id).addClass(th.className);
				jQuery('#'+th.id).parent().addClass('ufo-active');
			}
		}
		if (history.activatedviews){
			for (var i = 0; i < history.activatedviews.length; i++){
				jQuery('#'+history.activatedviews[i]).addClass('ufo-view-activated'); 
			}
		}
	};
	this.doAction=function(action, request){
		switch(action){
			case this.Actions.next:

					this.next(request);	
					break;	
			case this.Actions.apply: 

					this.apply(request);	
					break;	
			case this.Actions.applygui: 

					this.applygui(request);	
					break;	
			case this.Actions.back: 

					this.back();	
					break;	
			case this.Actions.refresh: 

					this.refresh();	
					break;	
			case this.Actions.reload: 

					this.reload();	
					break;	
			case this.Actions.doNothing: 

			return;
			default: this.clear(request);

		}
	};
	this.clear=function(request){
		this.data.length=0;
		this.lastStep.request=request;
	};
	this.next = function(request){
		if (this.lastStep)
			this.data.push(this.lastStep);
			
		this.lastStep = {};
		this.lastStep.request=request;
		this.doAction(this.Actions.refresh,null);
	};
	this.back = function(){
		if (this.lastStep) delete this.lastStep;
		this.lastStep=null;
		if (this.data.length==0) return;
		this.lastStep=this.data.pop();
		AppMan.request(this.Actions.apply,this.lastStep.request);
	};
	this.refresh = function(){
		this.lastStep.filterdata = AppMan.Filter.getFilterData();
		this.lastStep.viewdata = this.getViewData();
	};
	this.apply = function(request){
		this.doAction(this.Actions.applygui,null);
		if (request.viewTarget == AppMan.bodyid)
			this.lastStep.request=request;
		AppMan.Filter.refreshDetailedViews(this.lastStep.filterdata);
	};
	this.applygui = function(){
		this.applyViewData();
		AppMan.Filter.applyViewData(this.lastStep.filterdata);
	};
	this.reload = function(){
		this.doAction(this.Actions.refresh,null);
		if (this.lastStep.request.m=='new'){
			this.lastStep.request.m='show';
			var elId = AppMan.Utils.idJoin(this.lastStep.request.hash,'oid'); 
			this.lastStep.request.oid=jQuery('#'+elId).val();			
		}
		AppMan.request(this.Actions.apply,this.lastStep.request);
	};
};

function Utils(){
	this.idDelimeter='-';
			
	this.apply=function(target, source){
		if (!target) target = {};
		if (!source) return target;
		for(var prop in source)
			target[prop]=source[prop];
		return target;
	};
			
	this.applyIf=function(target, source){
		if (!target) target = {};
		if (!source) return target;
		for(var prop in source)
			if (!target[prop])
				target[prop]=source[prop];
		return target;
	};
			
	this.splitUrlString=function(url){
		var params = {};
		var pairs = url.split('&');
		for(var i = 0; i < pairs.length; i++){
			var pair = pairs[i].split('=');
			params[pair[0]]=pair[1];
		}
		return params;
	};
			
	this.getRoot =function (object, type, leaf){
		if (!object [type]) 
			object [type]={};
		if (!leaf)
			return object[type];
		if (!object [type][leaf] )
			object [type][leaf]=[];
		return object [type][leaf];
	};
			
	this.getConfig=function(config){
		var defaultConfig = {t:undefined, m:'view', viewTarget:AppMan.bodyid};
		if (typeof(config) == 'string'){ 
			defaultConfig.t=config;
			config=defaultConfig;
		} else {
			config = this.applyIf(config,defaultConfig);
		}
		if (config.viewTarget==AppMan.bodyid){
			config.hash = AppMan.hash;        	
		} else {
			config.hash = AppMan.Utils.idSplit(config.viewTarget)[0];				
		}
			
		return config;
	};
			
	this.getValue=function(el){
		var value, dbValue;
		if (el.hasClass('ufo-tinymce'))
			value = AppMan.TMCEFactory.getTMCEContent(el.attr('id'));
		else
			value = el.val();			
		dbValue = el.data('dbValue');
		if (dbValue == value) return undefined;
		return value;
	};
			
	this.getViewData=function(header, type, forms){
		var result = {}, id, names, root, form, value, ref = this;
		jQuery('.ufo-formvalue[id^="'+header+'"]').each(function(){
			value = ref.getValue(jQuery(this));
			if (value == undefined) return;
			id = jQuery(this).attr('id');
			names = AppMan.Utils.idSplit(id);
			root = AppMan.Utils.getRoot(result, names[1]);
			root[names[2]] = value;
		});
		if (!forms) forms = [];
		for (var prop in result){
			form = {};
			form.t = type;
			form.oid = prop;
			form.a = result[prop];
			forms.push(form);
		};
		return forms;
	};
			
	this.getFormData=function(header, type){
			
		var result = {}, id, value, ref = this;
			
		jQuery('.ufo-formvalue[id^="'+header+'"]').each(function(){
			value = ref.getValue(jQuery(this));
			if (value == undefined) return;
			id = jQuery(this).attr('id');
			id = id.slice(header.length);
			result[id]=value;
		});
			
		var form = {};
		form.t = type;
		form.oid = jQuery('#'+header+'oid').val();
		form.a = result;
		return form;
			
	};
			
	this.idSplit=function(id){
		return id.split(this.idDelimeter);
	};
			
	this.idJoin=function(){
		var result = '';
		for (var i=0; i < arguments.length; i++){
			var delim = i > 0 ? this.idDelimeter : '';
			result += delim + arguments[i];			
		}
		return result;
	};
			
	this.siblingId=function(el, dbid){
		var hash = this.idSplit(el.id)[0];
		return this.idJoin(hash, dbid);
	};
			
	this.getHash=function(str){
		var hash=5381, ch;
		for (i = 0; i < str.length; i++) {
			ch = str.charCodeAt(i);
			hash = ((hash<<5)+hash)+ch;
		}
		hash = Math.abs(hash);
		return hash.toString(32);
	};
			
	this.getRequestHashAttributes = function(request){
		var attribs = ['t', 'oid', 'a', 'specialfilter'];
		var result = {};
		for (var i = 0; i < attribs.length; i++){
			var attrib = attribs[i]; 
			if (request.hasOwnProperty(attrib)){
				result[attrib]=request[attrib]	
			}
		}
		return result;
	};
			
	this.getRequestHash = function(request){
		var attribs=this.getRequestHashAttributes(request);
		var str=AppMan.JSON.encode(attribs);
		return this.getHash(str);
	};
			
	this.getViewSibling = function(itemid, target){
		var view = jQuery('#'+itemid).parents('.ufo-view')[0];
		var targets = jQuery(view).data('targets');
		for (i=0; i< targets.length; i++){
			var names = AppMan.Utils.idSplit(targets[i].attr('id'));
			var exit = target ? names[1]==target : targets[i].attr('id') != itemid; 
			if (exit) return {id:targets[i].attr('id'), hash:names[0]}; 
		}
		return undefined; 
	};
			
	this.prepareElement = function(el, dbid, hash){
		var newId = AppMan.Utils.idJoin(hash, dbid);
		el.attr('id', newId);
		el.data('id', dbid);
		return el;
	};
			
	this.changeIds = function(viewTarget, hash){

		var selector = '#'+viewTarget+' ';     	

		var childSelectors = [                
					
			'#oid',		
			'.ufo-filtervalue',		
			'.ufo-filtersign',		
			'.ufo-filter',		     
			'.ufo-viewscrollervalues',		
			'.ufo-tableheader',		
			'.ufo-tab-header li a',		
			'.ufo-tabs',		
			'.ufo-asinput',		
			'.ufo-as-info',		
			'.ufo-upload',		
			'.ufo-triggerbutton',		
			'.ufo-id-link',		
			'.ufo-deletecb'		
		];
                           
		var ref = this, $el, id;

		for	(var i = 0; i < childSelectors.length; i++){
			var childSelector = childSelectors[i]; 
			jQuery(selector+childSelector).each(function(){
				id = jQuery(this).attr('id');
				ref.prepareElement(jQuery(this), id, hash);
			});
		};
		jQuery(selector+'label').each(function(){
			id = jQuery(this).attr('for');
			id = ref.idJoin(hash, id);
			jQuery(this).attr('for',id);
		});
		jQuery(selector+'.ufo-formvalue').each(function(){
			id = jQuery(this).attr('id');
			$el=ref.prepareElement(jQuery(this), id, hash);
			$el.data('dbValue', $el.val());
		});
	};    
};

function DataFilter(){
	this.getFilterValues=function(result, filteredHash){
		var hash, id, fvalue, sid, svalue, fitem, header, selector;
		header = AppMan.Utils.idJoin(filteredHash, '');
		selector = filteredHash ? '[id^="'+header+'"]' : '';
		jQuery('.ufo-filtervalue'+selector).each(function(){
			fvalue = jQuery(this).val(); 
			if (!fvalue) return; 
			id = jQuery(this).attr('id');
			var names = AppMan.Utils.idSplit(id);
			hash = names[0];
			froot = AppMan.Utils.getRoot(result, hash, 'filter');
			fitem = {};
			fitem.property = names[1];
			fitem.value = {};
			fitem.value.values=[fvalue];
			sid = AppMan.Utils.idJoin(hash, 'sgn', fitem.property);
			svalue = jQuery('#'+sid).val(); 
			if ( svalue )
				fitem.value.sign=svalue;
			froot.push(fitem);
		});			
	};
	this.getSortValues=function(result, filteredHash){
		var names, hash, id, field, sitem, sroot, header, selector;
		header = AppMan.Utils.idJoin(filteredHash, '');
		selector = filteredHash ? '[id^="'+header+'"]' : '';
		jQuery('.ufo-tableheader.ufo-active'+selector).each(function(){
			id = jQuery(this).attr('id');
			names = AppMan.Utils.idSplit(id);
			hash = names[0];
			sroot = AppMan.Utils.getRoot(result, hash, 'sort');
			sitem = {};
			sitem.property = names[2];
			sitem.direction = jQuery(this).val();
			sroot.push(sitem);
		});			
	};
	this.getPagingValues=function(result, filteredHash){
		var names, hash, id, field, proot, header, selector;
		header = AppMan.Utils.idJoin(filteredHash, '');
		selector = filteredHash ? '[id^="'+header+'"]' : '';
		jQuery('.ufo-viewscrollervalues'+selector).each(function(){
			id = jQuery(this).attr('id');
			names = AppMan.Utils.idSplit(id);
			hash = names[0];
			proot = AppMan.Utils.getRoot(result, hash);
			proot[names[1]]=jQuery(this).val();
		});			
	};
	this.getFilterData=function(filteredHash){
		var result = {};
		this.getFilterValues(result,filteredHash); 
		this.getSortValues(result,filteredHash); 
		this.getPagingValues(result,filteredHash); 
		return result;
	};
	this.applyFilterViewData=function(filters, hash){
		var hashfilter = filters[hash]['filter'];
		if (!hashfilter) return;
		var field, fieldname, el, elid; 
		for (var i = 0; i < hashfilter.length; i++){
			field = hashfilter[i];
			var fieldname = field.property;
			if (field.value.sign)           	
				jQuery('#'+AppMan.Utils.idJoin(hash, 'sgn', fieldname)).val(field.value.sign);
			elid = AppMan.Utils.idJoin(hash, fieldname);
			el = jQuery('#'+elid);
			el.val(field.value.values[0]);
			if (el.hasClass('ufo-as')){
				AppMan.AutoSuggest.init(elid);
			};
		}
	};
	this.applySortViewData=function(filters, hash){
		var hashsort = filters[hash]['sort']; 			
		if (!hashsort) return;
		var field, fieldname; 
		for (var i = 0; i < hashsort.length; i++){
			field = hashsort[i];
			jQuery('#'+AppMan.Utils.idJoin(hash, 'srt', field.property)).val(field.direction);
		}
	};
	this.applyPadingViewData=function(filters, hash){
		var hashscroll = filters[hash]; 			
		var startid='#'+AppMan.Utils.idJoin(hash, 'start');
		var limitid='#'+AppMan.Utils.idJoin(hash, 'limit');
		jQuery(startid).val(hashscroll.start);
		jQuery(limitid).val(hashscroll.limit);
	};
	this.applyViewData=function(filters){
		for (var hash  in filters){
			this.applyFilterViewData(filters, hash); 			
			this.applySortViewData(filters, hash); 			
			this.applyPadingViewData(filters, hash);
		}
	};
	this.refreshDetailedViews=function(filters){
		var targets, target, filter, request; 
		jQuery('.ufo-view-activated').each(function(){
			targets = jQuery(this).data('targets');			
			for (var i = 0; i < targets.length; i++){
				target = targets[i]; 
				request = target.data('request'); 
				filter = filters[request.hash]
				if (filter) request=AppMan.Utils.apply(request, filter);
				if (request.filter) 
					request.filter = AppMan.JSON.encode(request.filter);			
				if (request.sort) 
					request.sort = AppMan.JSON.encode(request.sort);			
				AppMan.request(AppMan.History.Actions.applygui, request); 
			}
		});
	};
	this.filter=function(request){
		var hash = request.hash; 
		var filterData = this.getFilterData(hash); 
		filterData = filterData[hash]; 
		if (filterData){ 
			filterData.filter = AppMan.JSON.encode(filterData.filter); 
			filterData.sort = AppMan.JSON.encode(filterData.sort); 
		} 
		var specialfilter = jQuery('#'+AppMan.Utils.idJoin(hash, 'specialfilter')).val(); 
		if (specialfilter) 
			filterData.specialfilter=specialfilter; 
		filterData=AppMan.Utils.apply(filterData, request); 
		AppMan.History.doAction(AppMan.History.Actions.refresh,null);
		if (request.viewTarget == AppMan.bodyid)
			AppMan.History.lastStep.request=filterData;
		AppMan.request(AppMan.History.Actions.applygui, filterData); 
	};
	this.scroll=function(config,direction){
		var hash=config.hash, start, limit, rowcount, startid, limitid, rowcountid;
		startid='#'+AppMan.Utils.idJoin(hash, 'start');
		limitid='#'+AppMan.Utils.idJoin(hash, 'limit');
		rowcountid='#'+AppMan.Utils.idJoin(hash, 'rowcount');
		start = parseInt(jQuery(startid).val());
		limit = parseInt(jQuery(limitid).val());
		rowcount = parseInt(jQuery(rowcountid).val());
		start += direction*limit;
		if (direction == -2) start = 0;                            
		if (direction == 2) start = rowcount-limit;
		start = Math.min(start,rowcount-limit);
		start = Math.max(start,0);
		jQuery(startid).val(start);
		jQuery(limitid).val(limit);
		this.filter(config);
	};
	this.sort=function(config, field){
		var hash = config.hash;
		var id = '#'+AppMan.Utils.idJoin(hash, 'srt',field);
		var selector = AppMan.Utils.idJoin(hash, 'srt','');
		var direction = jQuery(id).val();
		jQuery('.ufo-tableheader[id^="'+selector+'"]').each(function(){
			jQuery(this).val('');
			jQuery(this).removeClass('thacs');
			jQuery(this).removeClass('thdesc');
			jQuery(this).removeClass('ufo-active');
			jQuery(this).parent('th').removeClass('ufo-active');
		});
		direction = (direction=='ASC')?'DESC':'ASC';
		var className = (direction=='ASC')?'thacs':'thdesc';
		jQuery(id).val(direction);
		jQuery(id).addClass(className);
		jQuery(id).addClass('ufo-active');
		jQuery(id).parent('th').addClass('ufo-active');
		this.filter(config);
	};
	this.mdelete=function(config){
		var hash = config.hash, request = [], id, selector = AppMan.Utils.idJoin(hash, 'cb', '');
		jQuery('.ufo-deletecb[id^="'+selector+'"]').each(function(){
			if (jQuery(this).val() != 'on') return;;
			id = jQuery(this).attr('id');
			id = id.slice(selector.length);
			request.push(id);
		});
		if (request.length==0){
			alert(AppMan.resources.NoRecordsSelected);		
			return;		
		}		
		if (!confirm(AppMan.resources.ItwillDeleteRecordsAreYouSure)) return;
		config.a={};
		config.a.a=request;
		config.a.m='mdelete';
		config.a = AppMan.JSON.encode(config.a);
		AppMan.Filter.filter(config);
	};
	this.moveRow = function (config, movedirection, id){
		var hash = config.hash;
		config.a={};
		config.a.srt=jQuery('#'+AppMan.Utils.idJoin(hash, 'srt', 'ListPosition')).val();
		config.a.lpd=movedirection;
		config.a.lpi=id;
		config.a.m='moveRow';
		config.a=AppMan.JSON.encode(config.a);
		AppMan.Filter.filter(config);
	};
	this.newObject = function (config){
		config.m='new';
		config.viewTarget=AppMan.bodyid;
		AppMan.request(AppMan.History.Actions.next, config);
	};
	this.saveObjects = function (config){
		var header = AppMan.Utils.idJoin(config.hash, ''), 
			type= config.t, result =[];
		result = AppMan.Utils.getViewData(header, type);
		config.a={};
		config.a.m='save';
		config.a.a=AppMan.JSON.encode(result);
		AppMan.Filter.filter(config);
	};
	this.saveObject = function (config, historyAction){
		var header = AppMan.Utils.idJoin(config.hash, ''), 
			type = config.t, result =[], targets, request;
		var formdata = AppMan.Utils.getFormData(header, type); 	
		result.push(formdata);
		jQuery('.ufo-view[id^="'+header+'"]').each(function(){
			targets = jQuery(this).data('targets');
			for (var i = 0; i < targets.length; i++){
				request = targets[i].data('request');
				header = AppMan.Utils.idJoin(request.hash, '');
				AppMan.Utils.getViewData( header, request.t, result );
			}
		});
		config.a=AppMan.JSON.encode(result);
		AppMan.request(historyAction, config);
	};
	this.plainsave = function (config){
		if (AppMan.History.lastStep == null) AppMan.History.lastStep=config;
		config.m='apply';
		this.saveObject(config, AppMan.History.Actions.reload);
	};
	this.save = function (config){
		config.m='save';
		this.saveObject(config, AppMan.History.Actions.back);
	};
	this.apply = function (config){
		var hash = config.hash;
		config.m='apply';
		config.oid=jQuery('#'+AppMan.Utils.idJoin(hash,'oid')).val();
		this.saveObject(config, AppMan.History.Actions.reload);
	};
	this.addRow = function (config){
		config.m2='addRow';
		AppMan.Filter.filter(config);
	};
	this.link = function(addconfig, config){
		var names = AppMan.Utils.idSplit(config.viewTarget);
		config.hash = names[0];
		addconfig.m2='addRow';
		addconfig.callbackfunc = function(){
			AppMan.Filter.filter(config);
		};
		var sibling = 
			AppMan.Utils.getViewSibling(config.viewTarget, addconfig.viewTarget);
		addconfig.viewTarget = sibling.id;
		addconfig.hash = sibling.hash;
		AppMan.Filter.filter(addconfig);
	};
	this.mtmdelete = function(config){
		var sibling = 
			AppMan.Utils.getViewSibling(config.viewTarget);
		if (sibling){
			refreshconfig = jQuery('#'+sibling.id).data('request');
			config.callbackfunc = function(){
				AppMan.Filter.filter(refreshconfig);
			};
		};
		this.mdelete(config);
	};
	this.getListsOptions = function(el, configs){
		for (var i = 0; i < configs.length; i++){  
			this.getListOptions(el, configs[i]);		
		}
	};   
	this.getListOptions = function(el, config){
		var dId = AppMan.Utils.siblingId(el, config.dbId); 
		var masterValue = jQuery(el).val(); 
		config.oid=masterValue;
		config.m='list';
		ajx = {};
		ajx.params  = config;
		ajx.success = function(data){
			var loptions = AppMan.JSON.decode(data),
			$dList = jQuery('#'+dId), $option, option;
			$dList.empty();
			if (! config.noemtpy){
				$option = jQuery('<option/>');
				$option.val('');;
				$option.text('...');;
				$dList.append($option);
			}
			for (var i = 0; i< loptions.length; i++){
				option = loptions[i];
				$option = jQuery('<option/>');
				$option.val(option.id);;
				$option.text(option.Description);
				$dList.append($option);
			}
		}
		AppMan.Ajax.request(ajx);
	};   
};

AppMan = new function(){

	this.AutoSuggest = new AutoSuggestFactory(); 
	this.AjaxUpload = new AjaxUploadFactory(); 
	this.Calendar = new CalendarFactory(); 
	this.TMCEFactory = new TMCEFactory();
	this.Filter = new DataFilter(); 
	this.Utils = new Utils(); 
	this.History = History; 
	this.JSON = JSON; 
	this.Ajax = iAjax;


	this.init=function(config){
		this.resources=config.resources;
		this.bodyid=config.bodyid;
		this.Ajax.dParams={};
		this.Ajax.dParams.ac=1;
		this.Ajax.url=config.url;
		this.hash = this.Utils.getRequestHash(config.initial);
		this.preparePage(this.hash, this.bodyid);
		config.initial.hash = this.hash;
		this.History.doAction(this.History.Actions.next, config.initial);

		jQuery('#'+AppMan.bodyid).ajaxStop(function(){
			jQuery('#disabler').remove();
		});
	};

	this.request=function(action, request){
		if (typeof(request) == 'string') 
			request = AppMan.Utils.splitUrlString(request);

		var ro = {};	

		if (request.hash) 
			delete request.hash;

		ro.params = request;
		ro.success=this.updateview;			
		ro.error=this.handleError;			
		callback = {};
		callback.currentRequest=request;			
		callback.action=action;			
		callback.appman=this;			

		if (request.callbackfunc){
			callback.callbackfunc=request.callbackfunc;			
			delete request.callbackfunc;		
		}		

		ro.object=callback;

		this.Ajax.request(ro);			
		this.disableInput();

	};

	this.handleError=function(jqxhr, status, error){
		alert(status+"\n"+error);
		AppMan.enableInput();
	};


	this.updateview=function(data, status, jqxhr){
		var hash, callback = jqxhr.robj;
		var appman = callback.appman;
		var currentRequest = callback.currentRequest;
		var viewTarget = currentRequest.viewTarget || appman.bodyid;

		appman.AutoSuggest.clearInfo();			
		if (viewTarget == appman.bodyid){
			appman.AutoSuggest.clear();			
			appman.AjaxUpload.clear();			
			appman.Calendar.clear();			
			appman.TMCEFactory.removeTinyMCEs();
			hash = appman.Utils.getRequestHash(callback.currentRequest);
			appman.hash=hash;
		} else {
			var names = appman.Utils.idSplit(currentRequest.viewTarget);
			hash = names[0];
		}
		callback.currentRequest.hash=hash;

		if (callback.action != appman.History.Actions.back
				&& callback.action != appman.History.Actions.reload){
			jQuery('#'+viewTarget).html(data);
			appman.preparePage(hash, viewTarget);
		}

		appman.History.doAction(callback.action, callback.currentRequest);
		appman.enableInput();

		if (callback.callbackfunc)
			callback.callbackfunc.call(jqxhr);			
	};

	this.preparePage=function(hash, viewTarget){
		this.Utils.changeIds(viewTarget, hash);
		this.factoryflag=hash;
		jQuery('.ufo-eval').each(function(){
			eval(jQuery(this).val());
			jQuery(this).remove();
		});
		delete this.factoryflag;
	};

	this.disableInput=function(){

		var $disabler = jQuery('#disabler');		
		if ( $disabler.length > 0 ) return; 		
		var div = jQuery("<div id='disabler' style='display:none' class='disableall'></div>");		
		var body = jQuery('#'+this.bodyid);		
		var pos =  body.position();
		var width = body.width();
		var height = body.height();
		div.css({width:width+'px', height:height+'px', top:pos.top+'px', left:pos.left+'px'});
		body.append(div);
		div.show();

	};

	this.enableInput=function(){
	};

	this.switchtab = function(menuitem, className, id){

		jQuery('.'+className).removeClass('ufo-active');
		jQuery('.'+className+'-menu').removeClass('ufo-active');
		jQuery(menuitem).addClass('ufo-active');
		var names = this.Utils.idSplit(menuitem.id);
		var hash = names[0];
		id = this.Utils.idJoin(hash, id); 
		jQuery('#'+id).addClass('ufo-active');
		jQuery('#'+id).trigger('activated');

	};

	this.initRedirect = function(tabid, request, filters){
		var targets, hash, $tab; 
		tabid = AppMan.Utils.idJoin(AppMan.factoryflag, tabid);

		$tab = jQuery('#'+tabid);
		$tab.addClass('ufo-view');

		if (!(targets=$tab.data('targets'))){ 
			targets=[];
			$tab.data('targets', targets);;
		}

		hash = this.Utils.getRequestHash(request);

		$viewTarget = jQuery('#'+request.viewTarget); 
		var newId = AppMan.Utils.idJoin(hash, request.viewTarget); 

		if (filters){ 
			var filter = filters[0];
			$hidden=jQuery('<input type="hidden">');
			$hidden=this.Utils.prepareElement($hidden, 'specialfilter', hash);
			$hidden.val(AppMan.JSON.encode([filter]));
			$tab.append($hidden);
		}

		$viewTarget.addClass('ufo-embedded-view');
		$viewTarget.attr('id', newId);
		request.viewTarget = newId;
		request.hash = hash;
		$viewTarget.data('request', request);
		targets.push($viewTarget)

		$tab.live('activated', function(){

				if (jQuery(this).hasClass('ufo-view-activated')) return;
				jQuery(this).addClass('ufo-view-activated');		

				var targets=jQuery(this).data('targets');

				for (var i = 0; i < targets.length; i++){
					var target = targets[i];		
					request = target.data('request');		
					request.callbackfunc = function(){
						target.removeClass('ufo-embedded-view');
						target.addClass('ufo-view-target');
					};
					AppMan.request(AppMan.History.Actions.doNothing, request);		
				}

		});
	};
};
	
function addRow(config){
	AppMan.Filter.addRow(AppMan.Utils.getConfig(config));
} 

function apply(config){
	AppMan.Filter.apply(AppMan.Utils.getConfig(config));
}

function back(){
	AppMan.History.doAction(AppMan.History.Actions.back, null);		
} 

function doFilter(config, elem){
	var txt, rclass, aclass;
	config=AppMan.Utils.getConfig(config);
	var fid = AppMan.Utils.idJoin(config.hash, 'div'+config.t+'Filter');
	jQuery('#'+fid).slideToggle();
	var buttons = jQuery(elem).parents('.buttons')[0];
	jQuery(buttons).toggleClass('ufo-active');
	if (jQuery(buttons).hasClass('ufo-active')){
		txt =AppMan.resources.CloseFilter;
		aclass = 'icon_button_close';
		rclass = 'icon_filter';
	} else {
		txt =AppMan.resources.Search;
		rclass = 'icon_button_close';
		aclass = 'icon_filter';
	}
	jQuery(elem).attr('title', txt);
	jQuery(elem).removeClass(rclass);
	jQuery(elem).addClass(aclass);
}

function deleteFile(id, request, el, callback){
	AppMan.AjaxUpload.deleteFile(id, request, el, callback);
}

function filter(config){
	config = AppMan.Utils.getConfig(config);
	startid='#'+AppMan.Utils.idJoin(config.hash, 'start');
	jQuery(startid).val(0);
	AppMan.Filter.filter(config);
}

function getListOptions(el, configs){
	AppMan.Filter.getListsOptions(el, configs)
}


function link(addconfig, config){
	AppMan.Filter.link(addconfig, config);
}                                                                 

function mcall(rdcallmap){
	AppMan.request(AppMan.History.Actions.clear, rdcallmap);		
} 

function mdelete(config){
	AppMan.Filter.mdelete(AppMan.Utils.getConfig(config));
} 

function mtmdelete(config){
	AppMan.Filter.mtmdelete(AppMan.Utils.getConfig(config));		
} 

function moveRow(config, direction, id){
	AppMan.Filter.moveRow(AppMan.Utils.getConfig(config), direction, id);		
} 

function newObject(config){
	AppMan.History.doAction(AppMan.History.Actions.refresh, null);
	AppMan.Filter.newObject(AppMan.Utils.getConfig(config));		
} 

function plainsave(config){
	AppMan.Filter.plainsave(AppMan.Utils.getConfig(config));
}

function redirect(rdcallmap, frmName, divName){
	AppMan.History.doAction(AppMan.History.Actions.refresh, null);
	AppMan.request(AppMan.History.Actions.next, rdcallmap);		
} 

function scroll(config,direction){
	AppMan.Filter.scroll(AppMan.Utils.getConfig(config),direction);
}

function showInfo(config, el){
	return AppMan.AutoSuggest.showInfo(config, el); 
}

function sort(config, field){
	AppMan.Filter.sort(AppMan.Utils.getConfig(config), field);
}

function save(config){
	AppMan.Filter.save(AppMan.Utils.getConfig(config));
}
	
function setupCalendar(elId, config){
	AppMan.Calendar.create(elId, config);
}

jQuery(document).ready(function(){
	jQuery('.ufomenuwrapper ul li').hover(
		function() {
			jQuery(this).addClass('ufo-active');
			jQuery(this).find('ul:first').stop(true, true);
			jQuery(this).find('ul:first').delay(400).slideDown(300);
		},
		function() {
			jQuery(this).removeClass('ufo-active');
			jQuery(this).find('ul:first').stop(true, true);
			jQuery(this).find('ul:first').slideUp(150);
	});
	jQuery('.ufomenuwrapper li:has(ul)').find('a:first').addClass('ufocontainer');
	AppMan.init(appManConfig);
});


function insertContent(el, icFieldId, icValue) {
		icFieldId = AppMan.Utils.siblingId(el, icFieldId+'_EmailTemplate');
		var icField=document.getElementById(icFieldId);
		if (document.selection) {
			icField.focus();
			sel = document.selection.createRange();
			sel.text = icValue;
			icField.focus();
		}
		else if (icField.selectionStart || icField.selectionStart == '0') {
			var startPos = icField.selectionStart;
			var endPos = icField.selectionEnd;
			icField.value = icField.value.substring(0, startPos)
			+ icValue
			+ icField.value.substring(endPos, icField.value.length);
			icField.focus();
			icField.selectionStart = startPos + icValue.length;
			icField.selectionEnd = startPos + icValue.length;
		} else {
			icField.value += icValue;
			icField.focus();
		}
};
