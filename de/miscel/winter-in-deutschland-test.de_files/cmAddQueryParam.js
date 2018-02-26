/*
 * Copyright (c) contentmetrics GmbH, 2008
 * THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY
 * APPLICABLE LAW.  EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT
 * HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY
 * OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE.  THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM
 * IS WITH YOU.  SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
 * ALL NECESSARY SERVICING, REPAIR OR CORRECTION.
 *
 * Autor: Frank Räther 21.07.2008
 * Code: JavaScript Library zum Anhängen zusätzlicher Url Parameter onClick
 * Kunde: Stiftung Warentest, Berlin
 *
 */
 
/*
 * The function AddQueryParameter can be used to add a single name=value
 * pair to the href attribute of the link referenced by the first parameter
 * of the function call (sender).
 * A few examples:
 * 
 *<a href='http://www.google.de?name1=value1' onclick='return AddQueryParameter(this,"name2","value2")'>Klick mich</a>
 *<a href='http://www.google.de/' onclick='return AddQueryParameter(this,"name2","value2")'>Klick mich</a>
 *<a href='http://www.google.de' onclick='return AddQueryParameter(this,"name2","value2")'>Klick mich</a>
 *<a href='?name1=value1' onclick='return AddQueryParameter(this,"name2","value2")'>Klick mich</a>
 *<a href='../' onclick='return AddQueryParameter(this,"name2","value2")'>Klick mich</a>
 *<a href='AddQueryParam.html' onclick='return AddQueryParameter(this,"name2","value2")'>Klick mich</a>
 *
 */
 
 function AddQueryParameter(sender,name,value){
	var href=sender.href;
	if(href.indexOf('?')==-1){
		href+='?';
	}else{
		href+='&';
	}	
	href+=name+'='+value;
	sender.href=href;
}