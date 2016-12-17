jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
var zpAnalysis = new Function();
zpAnalysis.prototype = {
    on_track_event: function (callback, scope, paramCfg) {
        var monitor_url = "http://pv.zhaopin.cn/track.gif?dda_source=rd2zhaopin&dda_position=register";
        try {
            var params = {};
            $.extend(params, paramCfg);
            monitor_url = zpAnalysis.prototype.init_monitor_url(params, monitor_url);
            var i = new Image(1, 1);
            i.src = monitor_url;
        } catch (e) {
            var i = new Image(1, 1);
            i.src = monitor_url;
        } finally {
            setTimeout(callback instanceof Function ? callback : "", 100);
        }
    },
    //  初始化URL参数；
    init_monitor_url: function (params, url) {
        var _me = zpAnalysis.prototype;
        var monitor_url = url || '';
        var url_parmas = {
            //	Cookie用户ID
            dywesu: $.cookie("JsNewlogin") || '',
            //当前URL
            dda_path: _me.URIencode(location.href),
            //当前referer
            dda_dywea: _me.URIencode($.cookie("dywea")),
            //Cookie中的dwyea
            dda_referer: document.referrer ? _me.URIencode(document.referrer) : '-'
        };
        if (params) {
            $.extend(url_parmas, params);
        }
        for (var key in url_parmas) {
            monitor_url += '&' + key + '=' + url_parmas[key];
        }
        return monitor_url + '&r1=' + Math.random();
    },
    URIencode: function (d, a) {
        var c = encodeURIComponent;
        return c instanceof Function ? (a ? encodeURI(d) : c(d)) : escape(d);
    }
}
window.onbeforeunload = function(){

    var getPa = function(){
        var params = $("#com_reg").serialize().split('&');
        var validform = [];
        for(var i = 0 ,len = params.length ; i < len ; i++){
            var re = /(\S*)=(\S*)/g;
            param = params[i].split('=');
            //name属性里有temp的不加入到参数传递里
            if(param[1] != '' && param[0].indexOf("_temp") == -1){
                validform.push(param[0]);
            }
        }
        return validform.join(';');
    }
    var paData = getPa();
    zpAnalysis.prototype.on_track_event(null,null,{'validform': paData,'dda_action':'fillin'})
};
//点击提交成功跳转页面前调用此函数
var _cancelBeforeClose  = function(){
    window.onbeforeunload =  new Function();
};

