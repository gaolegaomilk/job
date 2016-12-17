// Check password
	function checkPassword(strPassword){
		result = 'weak';
		ctlName = document.getElementById("loginname").value;
		var ctlCompanyID;
		ctlCompanyID = document.getElementById("companyid").value;
		//guojun  20150331  passport 
        if(test_otherspecial(strPassword)){
			result = 'weak'; //Poor
		} else
		if(!test_lettnumstr(strPassword)){
			result = 'weak'; //Poor
		} else if (test_repeatchar(strPassword)){
			result = 'weak'; //Poor
		} else if(ctlName.length > 0 && strPassword.toLocaleLowerCase().indexOf(ctlName.toLocaleLowerCase()) != -1){
			result = 'weak'; //Poor
		} else if(strPassword.indexOf(ctlCompanyID) != -1){
			result = 'weak'; //Poor
		} else if (test_order(strPassword)){
			//contains ordered chars (1234, abcd)
			result = 'weak'; //Poor
		} else if (!test_len(strPassword) && !test_letters(strPassword) && !test_numbers(strPassword) && !test_special(strPassword)) {
			result = 'weak'; //Poor
		} 
		/*else if (test_len(strPassword) && !test_letters(strPassword) && !test_numbers(strPassword) && !test_special(strPassword)) {
			result = 'mediocre'; //Fair
		} else if (test_len(strPassword) && !test_letters(strPassword) && test_numbers(strPassword) && !test_special(strPassword)) {
			result = 'strong'; //Good
		} else if (test_len(strPassword) && !test_letters(strPassword) && !test_numbers(strPassword) && test_special(strPassword)) {
			result = 'strong'; //Good
		} else if (test_len(strPassword) && test_letters(strPassword) && !test_numbers(strPassword) && !test_special(strPassword)) {
			result = 'strong'; //Good
		} else if (test_len(strPassword) && !test_letters(strPassword) && test_numbers(strPassword) && test_special(strPassword)) {
			result = 'strongest'; //Strong
		} else if (test_len(strPassword) && test_letters(strPassword) && !test_numbers(strPassword) && test_special(strPassword)) {
			result = 'strongest'; //Strong
		} else if (test_len(strPassword) && test_letters(strPassword) && test_numbers(strPassword) && !test_special(strPassword)) {
			result = 'strongest'; //Strong
		} else if (test_len(strPassword) && test_letters(strPassword) && test_numbers(strPassword) && test_special(strPassword)) {
			result = 'strongest'; //Strong
		}*/
		else if (test_lettnumstr(strPassword) && !test_special(strPassword)){
			result = 'strong'; //Good
		} else if(test_lettnumstr(strPassword) && test_special(strPassword)){
			result = 'strongest'; //Strong
		} else {
			result = 'weak';
		}
		
		return result;
	}

	function checkPassword_multi(strPassword,strFieldName){
		result = 'weak';
		ctlName = document.getElementById(strFieldName).value;
		var ctlCompanyID;
		ctlCompanyID = document.getElementById("companyid").value;

		if(!test_lettnumstr(strPassword)){
			result = 'weak'; //Poor
		} else if (test_repeatchar(strPassword)){
			result = 'weak'; //Poor
		} else if(ctlName.length > 0 && strPassword.indexOf(ctlName) != -1){
			result = 'weak'; //Poor
		} else if(strPassword.indexOf(ctlCompanyID) != -1){
			result = 'weak'; //Poor
		} else if (test_order(strPassword)){
			//contains ordered chars (1234, abcd)
			result = 'weak'; //Poor
		} else if (!test_len(strPassword) && !test_letters(strPassword) && !test_numbers(strPassword) && !test_special(strPassword)) {
			result = 'weak'; //Poor
		} 
		/*else if (test_len(strPassword) && !test_letters(strPassword) && !test_numbers(strPassword) && !test_special(strPassword)) {
			result = 'mediocre'; //Fair
		} else if (test_len(strPassword) && !test_letters(strPassword) && test_numbers(strPassword) && !test_special(strPassword)) {
			result = 'strong'; //Good
		} else if (test_len(strPassword) && !test_letters(strPassword) && !test_numbers(strPassword) && test_special(strPassword)) {
			result = 'strong'; //Good
		} else if (test_len(strPassword) && test_letters(strPassword) && !test_numbers(strPassword) && !test_special(strPassword)) {
			result = 'strong'; //Good
		} else if (test_len(strPassword) && !test_letters(strPassword) && test_numbers(strPassword) && test_special(strPassword)) {
			result = 'strongest'; //Strong
		} else if (test_len(strPassword) && test_letters(strPassword) && !test_numbers(strPassword) && test_special(strPassword)) {
			result = 'strongest'; //Strong
		} else if (test_len(strPassword) && test_letters(strPassword) && test_numbers(strPassword) && !test_special(strPassword)) {
			result = 'strongest'; //Strong
		} else if (test_len(strPassword) && test_letters(strPassword) && test_numbers(strPassword) && test_special(strPassword)) {
			result = 'strongest'; //Strong
		}*/
		else if (test_lettnumstr(strPassword) && !test_special(strPassword)){
			result = 'strong'; //Good
		} else if(test_lettnumstr(strPassword) && test_special(strPassword)){
			result = 'strongest'; //Strong
		} else {
			result = 'weak';
		}
		
		return result;
	}
	
	// BEGIN TEST FUNCTIONS
	function test_len(str) {
		if ((str.length > 7) && (str.length < 21)) {
			return true;
		}
		return false;
	}
	function test_letters(str) {
		//test if there are Uppercase & lowercase letters
		if (str.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
			return true;
		}
		return false;
	}
	//判断字符串是否是8位以上的字母数字组合
	function test_lettnumstr(str)
	{
		if(str.length > 7)
		{
			var ret = false;
			var num = false;
			var let = false;
			if (str.match(/\d+/g)) {
				num = true;
			}
			if (str.match(/[a-zA-Z]+/ig)) {
				let = true;
			}
			if (num && let) {
				ret = true;
			}
			return ret;
		}
		else
			return false;
	}
	function test_numbers(str) {
		//test if there is a number and a letter in the string
		var ret = false;
		var num = false;
		var let = false;
		if (str.match(/\d+/)) {
			num = true;
		}
		if (str.match(/[a-z].*/i)) {
			let = true;
		}
		if (num && let) {
			ret = true;
		}
		return ret;
	}
	//guojun  20150331  passport  
	function test_special(str) {
		//Checking for special characters
		if (str.match(/[!,@,#,\$,%,^,&,\*,(,)]/)) {
			return true;
		}
		return false;
	}
	function test_otherspecial(str) {
		var regExp = /[^a-zA-Z0-9!,@,#,\$,%,^,&,\*,(,)]/g;
		//Checking for special characters
		if (regExp.test(str)) {
			return true;
		}
		return false;
	}

	function test_repeatchar(str) {
		//test for repeated chars (aaaa, bbbb, 1111, 2222)
		str_chars = 'abcdefghijklmnopqrstuvwxyz012345678909876543210zyxwvutsrqponmlkjihgfedcba';
		for (i=0; i<str_chars.length;i++) {
			cmd = '/[' + str_chars.substr(i, 1) + ']+/i';
			cmd = eval(cmd);
			if (str.match(cmd)) {
				newstr = new String(str.match(cmd));
				if (newstr.length > 7) {
					//test to see if the repeats are greater than 7
					return true;
				}
			}
		}
		return false;
	}
	function test_order(str) {
		//test for ordered chars in the string (1234, abcd, lmno, 5678)
		str_chars = 'abcdefghijklmnopqrstuvwxyzyxwvutsrqponmlkjihgfedcba';
		for (i=0; i<str_chars.length;i++) {
			nc = str_chars.substr(i + 1, 7);
			if (nc.length == 7) {
				cmd = '/' + str_chars.substr(i, 1) + '(?=' + nc + ')/i';
				cmd = eval(cmd);
				if (str.match(cmd)) {
					return true;
				}
			}
		}
		str_chars = '012345678909876543210';
		for (i=0; i<str_chars.length;i++) {
			nc = str_chars.substr(i + 1, 7);
			if (nc.length == 7) {
				cmd = '/' + str_chars.substr(i, 1) + '(?=' + nc + ')/i';
				cmd = eval(cmd);
				if (str.match(cmd)) {
					return true;
				}
			}
		}
		return false;
	}