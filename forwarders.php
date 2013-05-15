<!DOCTYPE html>
<html>
<head>
  <meta charset=utf-8 />
  <title></title>
</head>
<body onload="listForwarders()">
<a href="index.html">Tornar</a></br>
<form name="frmEmail" method="post">
<table width="400" border="0">
<tr>
<td>Forwarder:</td>
<td><input id="emailalias" name="emailalias" size="20" type="text" value="" />@domain.com</td>
</tr>
<tr>
<td>Forward to </td>
<td><input id="destemail" name="destemail" size="20" type="text" value="default@domain.com" /></td>
</tr>

<tr>
<td colspan="2" align="center"><hr /><!-- <input name="submit" type="submit" value="Create Forward" /> --><button onclick="addForwarder()" type="button" >Add</button></td></tr>
</table>
</form>

<div id="myDiv"></div>

<script>

function addForwarder()
{
	xmlhttp=new XMLHttpRequest();
	xmlhttp.open("POST","parser.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	var address=document.getElementById("emailalias").value + "@domain.com";
	var forwardto=document.getElementById("destemail").value;

	var args = encodeURIComponent("&domain=domain.com&email="+address+"&fwdopt=fwd&fwdemail="+forwardto);
	xmlhttp.send("cpanel_xmlapi_module=Email&cpanel_xmlapi_func=addforward&args=" + args);
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("emailalias").value="";
			listForwarders();
		}
	}
}



function delForwarder(args)
{
	xmlhttp=new XMLHttpRequest();
	xmlhttp.open("POST","parser_api1.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("cpanel_xmlapi_module=Email&cpanel_xmlapi_func=delforward&args=" + args);
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			listForwarders();
		}
	}
	
}

function listForwarders()
{
  var domain = "";
	xmlhttp=new XMLHttpRequest();
	xmlhttp.open("POST","parser.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	var args = encodeURIComponent("&domain="+domain);
	xmlhttp.send("cpanel_xmlapi_module=Email&cpanel_xmlapi_func=listforwards&args=" + args);

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			xmlDoc=xmlhttp.responseXML;
		      txt="<table><tr><th>Address</th><th>Forward to</th><th></th></tr>";
		      x=xmlDoc.getElementsByTagName("data");
		      for (i=0;i<x.length;i++)
		      {
		        alias = x[i].getElementsByTagName("html_dest");
		        mailto = x[i].getElementsByTagName("html_forward");
		        txt=txt + '<tr><td>' + alias[0].textContent + '</td><td>' + mailto[0].textContent + '</td><td><button name="' + x[i].getElementsByTagName("uri_dest")[0].textContent + '%3D' + x[i].getElementsByTagName("uri_forward")[0].textContent +'" onclick="delForwarder(this.name)" type="button" >Del</button></td></tr>';
		      }
		      txt=txt + "</table>";
		      document.getElementById("myDiv").innerHTML=txt;
	        }
	} 
}


</script>
</body>
</html>
