function AjaxUtil (){};
AjaxUtil.prototype = new Object();
AjaxUtil.READYSTATE_UNINITIALIZED		= 0;   //객체만 생성되고 아직 초기화 되지 않은 상태(open 메서드가 호출되지 않음)
AjaxUtil.READYSTATE_LOADING				= 1;   //open 메서드가 호출되고 아직 send 메서드가 불리지 않은상태
AjaxUtil.READYSTATE_LOADED				= 3 ;   //send 메서드가 불렸지만 status와 헤더는 도착하지 않은상태
AjaxUtil.READYSTATE_INTERACTIVE			= 4;   //데이터의 일부를 받은상태
AjaxUtil.READYSTATE_COMPLETED			= 5;   //데이터를 전부 받은 상태 완전한 데이터의 이용가능
AjaxUtil.STATE_OK						= 200  ;   //요청성공
AjaxUtil.STATE_FORBIDDEN				= 403  ;   //접근거브
AjaxUtil.STATE_NOTFOUND					= 404  ;   //페이지없어
AjaxUtil.STATE_INTERNALSERVERERROR		= 500  ;   //서버 오류 발생

AjaxUtil.getAjaxObj = function(window_o){
	if(!window_o){
		window_o=window;
	}
  if(window_o.ActiveXObject) {
      try{
    	  return new ActiveXObject("Msxml2.XMLHTTP"); //윈도우 익스플로러일경우
      } catch(e){
             try {
                   return new ActiveXObject("Microsoft.XMLHTTP"); //윈도우 익스플로러 옛날 버전경우
             } catch(e1) {
                   return null;
             }
      }
   } else if (window_o.XMLHttpRequest) {
          return new XMLHttpRequest(); //윈도우 익스플로러 외 다른         익스플로러 일경우!!

   } else {
          return null;
   }
};

AjaxUtil.getAjaxClass = function(window_o){
	if(!window_o){
		window_o=window;
	}
  if(window_o.ActiveXObject) {
      try{
    	  return ActiveXObject; //윈도우 익스플로러일경우
      } catch(e){
             try {
                   return ActiveXObject; //윈도우 익스플로러 옛날 버전경우
             } catch(e1) {
                   return null;
             }
      }
   } else if (window_o.XMLHttpRequest) {
          return XMLHttpRequest; //윈도우 익스플로러 외 다른         익스플로러 일경우!!

   } else {
          return null;
   }
};




//creatClass
AjaxK.prototype = new Object();
//AjaxK.prototype	= AjaxUtil.getAjaxObj();
//AjaxK.prototype.constructor	=AjaxK;

AjaxK.READYSTATE_UNINITIALIZED 			= 0; //객체만 생성되고 아직 초기화 되지 않은 상태(open 메서드가 호출되지 않음)
AjaxK.READYSTATE_LOADING 				= 1; //open 메서드가 호출되고 아직 send 메서드가 불리지 않은상태
AjaxK.READYSTATE_LOADED 					= 3; //send 메서드가 불렸지만 status와 헤더는 도착하지 않은상태
AjaxK.READYSTATE_INTERACTIVE 			= 4; //데이터의 일부를 받은상태
AjaxK.READYSTATE_COMPLETED				= 5; //데이터를 전부 받은 상태 완전한 데이터의 이용가능
AjaxK.STATE_OK									= 200; //요청성공
AjaxK.STATE_FORBIDDEN						= 403; //접근거브
AjaxK.STATE_NOTFOUND						= 404; //페이지없어
AjaxK.STATE_INTERNALSERVERERROR		= 500; //서버 오류 발생



AjaxK.prototype.context					= null;
AjaxK.prototype.name					= null;
AjaxK.prototype.requestObj				= null;

//param-----start
AjaxK.prototype.url						= "";
AjaxK.prototype.type					= "POST";
AjaxK.prototype.data					= null,
AjaxK.prototype.dataType				= "TEXT";
AjaxK.prototype.async					= true;
AjaxK.prototype.autoStart				= true;
AjaxK.prototype.loop					= false;
AjaxK.prototype.onBeforeProcess			= function(){};
AjaxK.prototype.onSuccess				= function(data,readyState,status){};
AjaxK.prototype.onError					= function(data,readyState,status){};
AjaxK.prototype.onComplete				= function(){};
AjaxK.prototype.onMonitor				= function(readyState,status,data){};
AjaxK.prototype.outparam				= {
		url : '',
		type :'POST',
		data : null,
		dataType:"TEXT",
		async:true,
		autoStart:true,
		loop:false,
		onBeforeProcess:function(){},
		onSuccess:function(data,readyState,status){},
		onError:function(data,readyState,status){},
		onComplete:function(){},
		onMonitor:function(data,readyState,status){}
};
//param------end

AjaxK.prototype.successCnt 	= 0;
AjaxK.prototype.errorCnt 	= 0;
AjaxK.prototype.responsed 	= false;

/* 익스경우 이렇게 상속자체를 못한다 -_-8에서 아오ㅉ댜ㅓㅁ자ㅣㅇㅁㅇ
AjaxRequest.prototype=AjaxUtil.getAjaxObj();
AjaxRequest.prototype.constructor = AjaxRequest;
AjaxRequest.prototype.ajaxk=null;
AjaxRequest.prototype.onreadystatechange=function(){
	alert(1);
};

function AjaxRequest(ajaxk_o){
	this.ajaxk=ajaxk_o;
};
*/
AjaxK.prototype.onreadystatechange = function(){};
function AjaxK(param_o,name_s){

	if(param_o){
		this.setParam(param_o);
	}else{
		throw "no input param obj";
		return;
	}
	if(name_s){
		this.setName(name_s);
	}

	this.context = this;
	this.outparam.ajaxk = this;//리터널을위해
	this.requestObj = AjaxUtil.getAjaxObj();//new AjaxRequest(this);
	this.requestObj.onreadystatechange = this.onreadystatechange = function(){
		param_o.ajaxk.onReceive.call(param_o.ajaxk);//여기서 this를알수가없으니.ㅠㅠ
	};

	if(this.autoStart){
		this.start();
	}


}
AjaxK.prototype.onReceive = function(){
	if(this.responsed){//한번했는데 두번 들어올수있으니.
		return;
	}

	if (this.requestObj.readyState == AjaxK.READYSTATE_INTERACTIVE || this.requestObj.readyState == AjaxK.READYSTATE_COMPLETED) {
        if (this.requestObj.status == AjaxK.STATE_OK) {
        	var indata = null;
        	if(StringUtil.upper(this.dataType) == "TEXT"){
        		indata = this.requestObj.responseText;
        	}else if(StringUtil.upper(this.dataType) == "JSON"){
        		indata = eval("(" + this.requestObj.responseText + ")");
        	}else if(StringUtil.upper(this.dataType) == "XML"){
        		//indata = XMLUtil.getXMLObj(this.request.responseText);
        		indata = this.requestObj.responseXML;
        	}
        	this.successCnt++;
        	this.onSuccess(indata,this.requestObj.readyState,this.requestObj.status);
        }else{
        	this.errorCnt++;
        	this.onError(this.requestObj.responseText,this.requestObj.readyState,this.requestObj.status);
        }
        this.onComplete();
        this.responsed = true;
        if(this.loop){
        	this.start();
        }
	}


	//loop!~~
	if(this.requestObj.readyState > 3){
		this.onMonitor(this.requestObj.readyState,this.requestObj.status,this.requestObj.responseText);
	}else{
		this.onMonitor(this.requestObj.readyState,null,null);
	}
};

AjaxK.prototype.start = function(){
	this.responsed = false;
	this.onBeforeProcess();
	var concatenateData = null;
	var applyURL = this.url;
	if(StringUtil.upper(this.type)=="GET" && this.data){
		applyURL += "?"+ConvertingUtil.concatenateToParameter( JavaScriptUtil.isFunction(this.data)?this.data(): this.data );
	}else if(StringUtil.upper(this.type)=="POST" && this.data){
		concatenateData=ConvertingUtil.concatenateToParameter( JavaScriptUtil.isFunction(this.data)?this.data(): this.data );
	};


	//익스경우 다시 생성해줘야된다 그지같다  크롬같은경우 재사용가능한데-_-
	if(JavaScriptUtil.isInternetExplorer() && this.requestObj.readyState > AjaxK.READYSTATE_UNINITIALIZED  ){
		this.requestObj = AjaxUtil.getAjaxObj();
		this.requestObj.onreadystatechange = this.onreadystatechange;
	}


	this.requestObj.open(this.type, applyURL, this.async);
	this.requestObj.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=UTF-8");
	this.requestObj.setRequestHeader("Cache-Control", "no-cache, must-revalidate");
	this.requestObj.setRequestHeader("Pragma", "no-cache");
	this.requestObj.send(concatenateData);
};
AjaxK.prototype.send = function(param_o){
	if(param_o){
		this.setParam(param_o);
	}
	this.start();
};


AjaxK.prototype.stop = function(){
	this.responsed = true;
};
AjaxK.prototype.setName = function(name_s){
	this.name = name_s;
};
AjaxK.prototype.setParam = function(param_o){
    for (var property in param_o) {
    	this[property] = param_o[property];
    };
    this.outparam = JavaScriptUtil.extend(this.outparam,param_o);
};
AjaxK.prototype.setData = function(data_o){
	this.data = data_o;
};


/*cache = false로 해주니까 잘 돌아갑니다 ~*/의견 1
