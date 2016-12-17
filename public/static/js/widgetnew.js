var code ; //ÔÚÈ«¾Ö¶¨ÒåÑéÖ¤Âë 
//²úÉúÑéÖ¤Âë 
window.onload = function createCode(){ 
code = ""; 
var codeLength = 4;//ÑéÖ¤ÂëµÄ³¤¶È 
var checkCode = document.getElementById("code"); 
var random = new Array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R', 
'S','T','U','V','W','X','Y','Z');//Ëæ»úÊý 
for(var i = 0; i < codeLength; i++) {//Ñ­»·²Ù×÷ 
var index = Math.floor(Math.random()*36);//È¡µÃËæ»úÊýµÄË÷Òý£¨0~35£© 
code += random[index];//¸ù¾ÝË÷ÒýÈ¡µÃËæ»úÊý¼Óµ½codeÉÏ 
} 
checkCode.value = code;//°ÑcodeÖµ¸³¸øÑéÖ¤Âë 
} 
//Ð£ÑéÑéÖ¤Âë 
function validate(){ 
var inputCode = document.getElementById("input").value.toUpperCase(); //È¡µÃÊäÈëµÄÑéÖ¤Âë²¢×ª»¯Îª´óÐ´ 
if(inputCode.length <= 0) { //ÈôÊäÈëµÄÑéÖ¤Âë³¤¶ÈÎª0 
alert("ÇëÊäÈëÑéÖ¤Âë£¡"); //Ôòµ¯³öÇëÊäÈëÑéÖ¤Âë 
} 
else if(inputCode != code ) { //ÈôÊäÈëµÄÑéÖ¤ÂëÓë²úÉúµÄÑéÖ¤Âë²»Ò»ÖÂÊ± 
alert("ÑéÖ¤ÂëÊäÈë´íÎó£¡@_@"); //Ôòµ¯³öÑéÖ¤ÂëÊäÈë´íÎó 
createCode();//Ë¢ÐÂÑéÖ¤Âë 
document.getElementById("input").value = "";//Çå¿ÕÎÄ±¾¿ò 
} 
else { //ÊäÈëÕýÈ·Ê± 
alert("^-^"); //µ¯³ö^-^ 
} 
}