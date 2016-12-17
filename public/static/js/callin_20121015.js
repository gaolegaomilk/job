$(function(){
    // 省份和城市选择功能  
	var provItmes = [];
	var cityQuery = {};
	// 生成省份列表
	for (var i=0; i<arrCity.length; i++){
		if (arrCity[i][1] === "489"){
			provItmes.push('<span class="sel sel_prov" sel_id="'+arrCity[i][0]+'">'+(arrProvince[arrCity[i][0]]||arrCity[i][2])+'</span>');
		}
		cityQuery[arrCity[i][0]] = arrCity[i][2];
	}
    provItmes.push('<span class="sel sel_prov" sel_id="480">国外</span>');
	$("#opts_prov").html(provItmes.join("")+'<div style="clear:both;"></div>');
	// 选择省份点击事件
	$("#prov_select").live("click", function(){
        $('#prov_select').removeClass('input-x-validate-error');
        $("#sel_city").hide();
		$("#sel_prov").css({"position":"absolute", "left":$(this).offset().left, "top":$(this).offset().top}).show();
	});
	// 选择城市点击事件
	$("#city_select").click(function(){
		if ($("#province").val() != ""){
			$("#sel_city").css({"position":"absolute", "left":$(this).offset().left, "top":$(this).offset().top}).show();
		} else {
			alert("请先选择省份");
		}
	});
	// 关闭弹层
	$(".popup .close").click(function(){
        if ($("#city_select").val() === "请选择"){
            $("#tip_city").html(msgErr.replace("{err}", "请选择公司所在地，以办公地点为准")).addClass("tip-x-validate-error");
        }
		$(".popup").hide();
	});
	// 弹层 点击省份事件
	$("#opts_prov .sel_prov").live("click",function(){
		var pid = $(this).attr("sel_id");
		var pname = $(this).text();
		changeCity(pid);
		$("#province").val(pid);
		$("#prov_select").val(pname);
		$("#city").val("");
		$("#city_select").val("请选择");
		$(".popup").hide();
		$("#tip_city").html(msgErr.replace("{err}", "请按照企业的办公地址进行选择")).removeClass("tip-x-validate-valid");
    if ($("#province").val() != ""){
			$("#sel_city").css({"position":"absolute", "left":$("#city_select").offset().left, "top":$("#city_select").offset().top}).show();
		} else {
			alert("请先选择省份");
		}
	});
	// 弹层 点击城市事件
	$("#opts_city .sel_city").live("click",function(){
		var pid = $(this).attr("sel_id");
		var pname = $(this).text();
		$("#city").val(pid);
		//@start深圳
		var existCity = $("#city_select").val();
		if(existCity != pname && (pname == '深圳' || pname == '东莞')){
			// 免责条款
			$("#policy").next("a").attr('href',"http://rd2.zhaopin.com/help/help_regist.html");	
		}else{
			// 免责条款
			$("#policy").next("a").attr('href',"http://rd2.zhaopin.com/portal/myrd/regist.asp");	
		}
		//@end
		$("#city_select").val(pname).trigger("blur");
		$(".popup").hide();
	});
	// 根据省份编号改变城市列表
	function changeCity(provId){
		var cityItmes = [];
		for (var i=0; i<arrCity.length; i++){
			if (arrCity[i][1] == provId){
				cityItmes.push('<span class="sel sel_city" sel_id="'+arrCity[i][2]+'">'+arrCity[i][2]+'</span>');
			}
		}
		if (!cityItmes.length){
			cityItmes.push('<span class="sel sel_city" sel_id="'+cityQuery[provId]+'">'+cityQuery[provId]+'</span>');
		}
		$("#opts_city").html(cityItmes.join("")+'<div style="clear:both;"></div>');
	}
	//数据转换
	/*function GetRealLength(strTemp){
		var i,sum;
		sum=0;
		for(i=0;i<strTemp.length;i++)
		{
			if ((strTemp.charCodeAt(i)>=0) && (strTemp.charCodeAt(i)<=255))
			sum=sum+1;
			else
			sum=sum+2;
		}
		return sum;
	}*/
	function GetRealLength(strTemp){
		var i,sum;
		sum=0;
		for(i=0;i<strTemp.length;i++)
		{
			if(/^[\u4E00-\u9FBF]/.test(strTemp.substring(i,i+1)))		
			sum=sum+2;
			else
			sum=sum+1;
		}
		return sum;
	}
	// 表单验证功能
	var formObj = $("#com_reg");
	var msgErr = '<table><tbody><tr><td>{err}</td></tr></tbody></table>';
	var msgVilid = '<table><tbody><tr><td></td></tr></tbody></table>';

	$("#compName").focus(function(){
			$("#tip_compName").html("请输入与公司营业执照一致的公司全称，2-64个中文");
			$(".pop_example").css("display","block");
			if($("#tip_compName").hasClass("tip-x-validate-valid")){
				$("#tip_compName").removeClass("tip-x-validate-valid")
			}
			if($("#tip_compName").hasClass("tip-x-validate-error")){
				$("#tip_compName").removeClass("tip-x-validate-error")
			}
			if($("#compName").hasClass("input-x-validate-error")){
				$("#compName").removeClass("input-x-validate-error")
			}
			
	}).blur(function(){
		var compNameValue = $("#compName").val().replace(/(^\s*)|(\s*$)/g, "");
		var flag=GetRealLength(compNameValue);
		$(".pop_example").css("display","none");
		if(flag>=4 && 128>=flag){
			$("#tip_compName").addClass("tip-x-validate-valid");
			$("#tip_compName").html("");
		}else if(flag==0){
			$("#tip_compName").addClass("tip-x-validate-error");
			$("#compName").addClass("input-x-validate-error");
			$("#tip_compName").html("请输入与公司营业执照一致的公司全称，2-64个中文");
		}else{
			$("#tip_compName").addClass("tip-x-validate-error");
			$("#compName").addClass("input-x-validate-error");
			$("#tip_compName").html("公司名称长度仅能在2-64个中文之间且需与营业执照上的名称保持一致");
			
		}
	});

	$("#contactor").validate({
		rules : [{
                text : msgErr.replace("{err}", "请输入招聘联系人，可由中文或英文组成"),
				min : 1
			},{
                text : msgErr.replace("{err}", "联系人姓名只能由中文或英文组成"),
				rule : function(a,b){
					return /^[\u4e00-\u9fa5\a-zA-Z\uFF21-\uFF3A\uFF41-\uFF5A]+$/.test(b);
				}
			}],
        defaultText : msgErr.replace("{err}", "请输入招聘联系人，可由中文或英文组成"),
		validText : msgVilid,
		tipTag : $("#tip_contactor")
	});
	$("#city_select").validate({
		rules : [{
                text : msgErr.replace("{err}", "请选择公司所在地，以办公地点为准"),
				rule : function(a,b){
					return $("#city").val() != "";
				}
			}],
        defaultText : msgErr.replace("{err}", "请选择公司所在地，以办公地点为准"),
		validText : msgVilid,
		tipTag : $("#tip_city")
	});
    var telBlur = false;
    function isPlaceholder(){ var input = document.createElement('input'); return 'placeholder' in input;}
	$("#tel1, #tel2, #tel3, #tel4").unbind().bind("change", function(){
		$("#tel").val((!$("#tel1").val()?"":$("#tel1").val()+"-")+$("#tel2").val()+$("#tel3").val());
	}).bind("focus", function(){
		$("#tel1, #tel2, #tel3").removeClass("input-x-validate-error");
	});
	var telMob = $("#tel4"),tipMob = telMob.parent('td').next('td').find('span').html('');
	telMob.validate({
		rules : [{ //请输入联系人常用电话，固定电话或手机均可
			text : msgErr.replace("{err}", "请填写手机号"),
			rule : function(a,b){
				var res = true;
				if (b == "") {
					res = false;
				}
				if(!isPlaceholder()){
					if(!res){
						$("[id*='_temp']").addClass("input-x-validate-error");
					}else{
						$("[id*='_temp']").removeClass("input-x-validate-error");
					}
				}
				return res;
			}
		},{
			text : msgErr.replace("{err}", "输入格式不正确"),
			rule : function(a,b){
				var r = /^1\d{10}$/, res = true;
				if (b !=="") {
					res = r.test(b);
				}
				return res;
			}
		}],
		defaultText : msgErr.replace("{err}", "请填写手机号"),
		validText : msgVilid,
		tipTag : tipMob
	});
	var tipTell = $("#tel2").parent('td').next('td').find('span').html('');
	$("#tel1, #tel2, #tel3").bind("focus", function(){
		$("#tel1, #tel2, #tel3").removeClass("input-x-validate-error");
	}).bind('blur', function(){
		var r1 = /^\d{0,10}$/, r2 = /^[^0]\d{6,10}$/, v1 = $("#tel1").val(), v2 = $("#tel2").val(), v3 = $("#tel3").val(), res = true;
		if((v1!=="" && !r1.test(v1)) || (v3!=="" && !r1.test(v3)) || (v2!=="" && !r2.test(v2))){
			$("#tel1, #tel2, #tel3").addClass("input-x-validate-error");
			tipTell.removeClass("input-x-validate-valid").addClass('tip-x-validate-error').html('输入格式不正确');
		}else if(v1!=="" || v2!==""){
			if(v1 == "" || !r1.test(v1) || v2 == "" || !r2.test(v2)){
				$("#tel1, #tel2").addClass("input-x-validate-error");
				tipTell.removeClass("input-x-validate-valid").addClass('tip-x-validate-error').html('输入格式不正确');
			}else{
				tipTell.removeClass('tip-x-validate-valid').removeClass('tip-x-validate-error').html('');
			}
		}else{
			$("#tel1, #tel2, #tel3").removeClass("input-x-validate-error");
			tipTell.removeClass('tip-x-validate-valid').removeClass('tip-x-validate-error').html('');
		}
	});
	
	$('#input_code').unbind().bind("change", function(){
		var val = $(this).val();
		$("#code").val(val ? val : '');
	}).bind("focus", function(){
		$(this).removeClass("input-x-validate-error");
	}).validate({
		rules : [{ //请输入联系人常用电话，固定电话或手机均可
			text : msgErr.replace("{err}", "请填写验证码"),
			rule : function(a,b){
				var res = true;
				if (b == "") {
					res = false;
				}
				if(!isPlaceholder()){
					if(!res){
						$("[id*='_temp']").addClass("input-x-validate-error");
					}else{
						$("[id*='_temp']").removeClass("input-x-validate-error");
					}
				}
				return res;
			}
		},{
			text : msgErr.replace("{err}", "输入格式不正确"),
			rule : function(a,b){
				var r = /^\d{6}$/, res = true;
				if (b !=="") {
					res = r.test(b);
				}
				return res;
			}
		},{
			text: msgErr.replace("{err}", "验证码输入错误"),
			rule: function(){
				var code = $("#code").val(), res = true;
					$.ajax({
					url:'http://jobads.zhaopin.com/ExtService/GetRegVerifyCode?mobile='+$("#tel4").val(),
					type:'get',
	                dataType:'jsonp',
	                success:function(data){                	
	                	if(code == data){
	                		res = true;
	                		$("#tip_code").addClass("tip-x-validate-valid").removeClass("tip-x-validate-error");
	                		$("#input_code").removeClass("input-x-validate-error");
	                		$("#tip_code").html("");		                	
	                	}else{
	                		res = false;
	                		$("#tip_code").removeClass("tip-x-validate-valid").addClass("tip-x-validate-error");
	                		$("#input_code").addClass("input-x-validate-error");
	                		$("#tip_code").html("验证码输入错误");	
	                	}
	                }		                
				})		
				return res;			
			}				
		}],
		defaultText : msgErr.replace("{err}", "请填写验证码"),
		validText : msgVilid,
		tipTag : $("#tip_code")
	});
	$("#username").validate({
		rules : [{
                text : msgErr.replace("{err}", "请输入英文字母、数字及-或_，且首字符必须为字母或数字，长度为6到24个字符"),
				rule : "empty"
			},{
                text : msgErr.replace("{err}", "仅能输入英文字母、数字及-或_，且首字符必须为字母或数字，长度为6到24个字符"),
				rule : function(a,b){
					return /^[a-zA-Z0-9][a-zA-Z0-9-_]{5,23}$/.test(b);
				}
			}/*,{
				text : msgErr.replace("{err}", "仅能输入英文字母、数字及-或_，且首字符必须为字母或数字，长度为6到24个字符"),
				rule : function(a,b){
					for(var i=0;i<b.length;i++){
						return /^[a-zA-Z0-9]{1}$/.test(b[0]);
					}
				}
			}*/],
        defaultText : msgErr.replace("{err}", "请输入英文字母、数字及-或_，且首字符必须为字母或数字，长度为6到24个字符"),
		validText : msgVilid,
		tipTag : $("#tip_username")
	}).focus(function(){
		window["formSubmit"] = false;
	}).blur(function(){
        var utext = $("#username").val();
		if(/^[a-zA-Z0-9][a-zA-Z0-9-_]{5,23}$/.test(utext) && (!window["usernameText"] || window["usernameText"] !== utext)){
			window["usernameText"] = utext;
			$("#tip_username").html('<img src="http://myimg.zhaopin.com/images/new_v3/ani_ajaxload.gif" width="22" height="22" />').removeClass("tip-x-validate-valid");
			$.get("http://rd2.zhaopin.com/s/usermgnt/checkuser.asp", {loginname:$(this).val(), t:+new Date()}, function(res){
				if ($.trim(res) !== ""){
					$("#tip_username").html(msgErr.replace("{err}", res)).addClass("tip-x-validate-error");
                    formFlag["usernameAjax"] = false;
				} else {
					$("#tip_username").html(msgVilid).addClass("tip-x-validate-valid");
                    formFlag["usernameAjax"] = true;
                    subForm();
				}
			});
		} else if(formFlag["usernameAjax"]){
        subForm();
    } else if(/^[a-zA-Z0-9][a-zA-Z0-9-_]{5,23}$/.test(utext) && formFlag["usernameAjax"] === false){
      $("#tip_username").html(msgErr.replace("{err}", "用户名已经存在")).addClass("tip-x-validate-error");;
    }
	});
	$("#email").validate({
		rules : [{
                text : msgErr.replace("{err}", "请输入常用的邮箱"),
				rule : "empty"
			},{
                text : msgErr.replace("{err}", "请输入有效的邮箱地址"),
				rule : "email"
			}],
        defaultText : msgErr.replace("{err}", "请输入常用的邮箱"),
		validText : msgVilid,
		tipTag : $("#tip_email")
	});
	$("#passwd").validate({
		rules : [{
                text : msgErr.replace("{err}", "8-20位非规律字母或数字组成，且不能与登录名称相同"),
				rule : "empty"
			},{	
                text : msgErr.replace("{err}", "仅能由8-20位非规律字母或数字组成，且不能与登录名称相同"),
				rule : function(a,b){
					return /^[a-zA-Z0-9]{8,20}$/.test(b) && b.toLocaleLowerCase() != $("#username").val().toLocaleLowerCase();
				}
			},{	
                text : msgErr.replace("{err}", "仅能由8-20位非规律字符或数字组成，且不能与登录名称相同"),
				rule : function(b){
					return !test_special(b.val()) && !test_repeatchar(b.val()) && !test_order(b.val()); 
				}
			}],
        defaultText : msgErr.replace("{err}", "8-20位非规律字母或数字组成，且不能与登录名称相同"),
		validText : msgVilid,
		tipTag : $("#tip_passwd")
	});
	$("#passwd2").validate({
		rules : [{
                text : msgErr.replace("{err}", "请再次输入密码"),
				rule : "empty"
			},{
				text : msgErr.replace("{err}", "两次输入的密码不一致"), 
				rule : function(a,b){
				 return $("#passwd").val() == $("#passwd2").val() ;
				}
			},{
				text : msgErr.replace("{err}", "密码由8-20位非规律字符或数字组成，且不能与登录名称相同"),
				rule : function(a,b){
					return /^[a-zA-Z0-9]{8,20}$/.test(b) && b != $("#username").val();
				}
			}],
		defaultText : msgErr.replace("{err}", "请再次输入密码"),
		validText : msgVilid,
		tipTag : $("#tip_passwd2")
	});
  formObj[0].onsubmit = function(){
    if ($("#province").val() === '') {
        $('#prov_select').addClass('input-x-validate-error');
    } else {
        $('#prov_select').removeClass('input-x-validate-error');
    }
  
    if(!$("#policy")[0].checked){
      alert('请在"我已阅读并同意智联招聘服务条款"前打勾');
      return false;
    }
    window["formSubmit"] = true;
    formFlag = formFlag || {};
    // $("#compName").validate();
    if($("#compName").val()==""){
		$("#tip_compName").addClass("tip-x-validate-error");
		$("#compName").addClass("input-x-validate-error");
		$("#tip_compName").html("请输入与公司营业执照一致的公司全称，长度不超过64个字");
	}
    $("#contactor").validate();
    $("#city_select").validate();
	$("#input_code").validate();
    $("#tel1, #tel2, #tel3, #tel4").validate();
    $("#username").validate();
    $("#email").validate();
    $("#passwd").validate();
    $("#passwd2").validate();
    //$("#validate").validate();
    return false;
  };
  function subForm(){
    if($(".submitBtn").hasClass("disable")){
	    return false;
	}
    if (window["formSubmit"] && formFlag["usernameAjax"] && !$(".tip-x-validate-default", formObj).length && !$(".tip-x-validate-error", formObj).length){
      $(".submitBtn").addClass("disable");
      if(typeof window._cancelBeforeClose == 'function'){
         window._cancelBeforeClose.call();
      }
	  formObj[0].submit();

	  window["formSubmit"] = false;
    }
  }
	// 公司名称输入提示功能
	var curWord = "";
	var suggStatus = "hide";
    var input = $("#compName");
    var pop = $("#com_name_sugg");
    var showTag = $("#opts_com_name");
    var ajaxTimer = null;
	// 提示信息列表绑定事件
	var hideTimer = null;
	$("li", showTag).live({
        "click": function(){
		    clearTimeout(hideTimer);
		    input.val($(this).text());
		    hideSugg();
        },
        "mouseenter": function(){
		    $(this).addClass("current");
	    },
        "mouseleave": function(){
		    $(this).removeClass("current");
	    }
	});
	// 输入框事件绑定
	input.keyup(function(e){
        var el = $(this);
		e.stopPropagation();
		e.preventDefault();
        var current = $("li.current:visible", showTag);
        if (e.keyCode != 38 && e.keyCode != 40 && !(current.length && e.keyCode == 13)){
            clearTimeout(ajaxTimer);
            ajaxTimer = setTimeout(function(){
                getSugg();
                curWord = input.val();
            }, 300);
        }      
        if (current.length && suggStatus=="show"){
            var prev = current.prev("li:visible");
            if (!prev.length){
                prev = $("li:visible:last", showTag);
            }
            var next = current.next("li:visible");
            if (!next.length){
                next = $("li:visible:first", showTag);
            }
            if (e.keyCode == 13){
                el.val(current.text());
                hideSugg();
                return false;
            } else if(e.keyCode == 38){
                current.removeClass("current");
                prev.addClass("current");
            } else if(e.keyCode == 40){
                current.removeClass("current");
                next.addClass("current");
            }
        } else if(suggStatus=="show"){
            if(e.keyCode == 38){
                $("li:visible:last", showTag).addClass("current");
                el.val($("li:visible:last", showTag).text());
            } else if(e.keyCode == 40){
                $("li:visible:first", showTag).addClass("current");
                el.val($("li:visible:first", showTag).text());
            }
        }     
	}).keydown(function(e){
		if ($("li.current", showTag).length && e.keyCode == 13){
			e.stopPropagation();
			e.preventDefault();
		}
	}).keypress(function(e){
		if ($("li.current", showTag).length && e.keyCode == 13){
			e.stopPropagation();
			e.preventDefault();
		}
	}).click(function(){
		ajaxTimer = setTimeout(function(){
            getSugg();
            curWord = input.val();
        }, 300); 
	}).blur(function(){
		var hideTimer = setTimeout(function(){hideSugg();},200);
	});
    // ajax获得提示内容
    function getSugg(){
        var kw = input.val();
        if (kw && kw !== curWord){    
            $.getJSON("http://search.zhaopin.com/jobs_nv/ajax_keywords_2012.asp?jsoncallback=?",
              {
                keyword: kw,
                keywordtype: "1"
              },
              function(data) {
                var str = "";
                if (data){
                    for (var key in data){
                        if (data[key]["friend_name"]){
                            str += "<li>" + data[key]["friend_name"] + "</li>";
                        }
                    }
                    if (str){
                        str = "<ul>" + str + "</ul>";
                        showTag.html(str.replace(new RegExp(kw, "gi"), function(a, b){
                            return '<span style="background:#fbc61c;">' + a + '</span>';
                        }));
                        showSugg();
                    } else {
                        showTag.html("");
                        hideSugg();
                    }
                } else {
                    showTag.html("");
                    hideSugg();
                }
            });
        } else if (!kw || !showTag.html()){
            showTag.html("");
            hideSugg();
        } else {
            showSugg();
        }
	}
	// 显示提示层
	function showSugg(){ 
        pop.css({"position":"absolute", "left":input.offset().left, "top":input.offset().top+28}).show();
        suggStatus = "show";
	}
	// 隐藏提示层
	function hideSugg(){
		pop.hide();
        suggStatus = "hide";
	}	
});