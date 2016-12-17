$(function(){
	$("#btn").click(function(){
		// alert($("#username").val());
		$.post('http://www.goodjob.com/admin/Auth/dolog',{email: $("#username").val(), password: $("#password")}, function(data){
			if(data.status){
				// location.href = \
				alert(data.msg);
				console.log(data);
			}else{
				alert(2);
			}
		},'json');
	});
});
