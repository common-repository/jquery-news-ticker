function _Jntp_submit()
{
	if(document.Jntp_form.Jntp_text.value=="")
	{
		alert(Jntp_adminscripts.Jntp_text)
		document.Jntp_form.Jntp_text.focus();
		return false;
	}
	else if(document.Jntp_form.Jntp_link.value=="")
	{
		alert(Jntp_adminscripts.Jntp_link)
		document.Jntp_form.Jntp_link.focus();
		return false;
	}
	else if(document.Jntp_form.Jntp_order.value=="")
	{
		alert(Jntp_adminscripts.Jntp_order)
		document.Jntp_form.Jntp_order.focus();
		return false;
	}
	else if(isNaN(document.Jntp_form.Jntp_order.value))
	{
		alert(Jntp_adminscripts.Jntp_order1)
		document.Jntp_form.Jntp_order.focus();
		return false;
	}
	else if(document.Jntp_form.Jntp_group.value=="")
	{
		alert(Jntp_adminscripts.Jntp_group)
		document.Jntp_form.Jntp_group.focus();
		return false;
	}
	else if(document.Jntp_form.Jntp_dateend.value=="")
	{
		alert(Jntp_adminscripts.Jntp_dateend)
		document.Jntp_form.Jntp_dateend.focus();
		return false;
	}
}

function _Jntp_delete(id)
{
	if(confirm(Jntp_adminscripts.Jntp_delete))
	{
		document.frm_Jntp_display.action="options-general.php?page=jquery-news-ticker&ac=del&did="+id;
		document.frm_Jntp_display.submit();
	}
}	

function _Jntp_redirect()
{
	window.location = "options-general.php?page=jquery-news-ticker";
}

function _Jntp_help()
{
	window.open("http://www.gopiplus.com/work/2013/10/03/jquery-news-ticker-wordpress-plugin/");
}