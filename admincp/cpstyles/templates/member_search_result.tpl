<br />

<div class="address_bar">{$lang['Control_Panel']} &raquo;
<a href="index.php?page=member&amp;control=1&amp;main=1">{$lang['members']}</a> &raquo;
<a href="index.php?page=member&amp;search=1&amp;main=1">{$lang['Member_Search']}</a> &raquo;
 {$lang['Search_Results']}</div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="0" cellspacing="1" align="center">

<tr valign="top" align="center">
	<td class="main1">{$lang['username']}</td>
	<td class="main1">{$lang['edit']}</td>
	<td class="main1">{$lang['Delet']}</td>
</tr>
{Des::while}{MembersList}
<tr valign="top" align="center">
	<td class="row1"><a href="../index.php?page=profile&amp;show=1&amp;id={$MembersList['id']}" target="_blank">{$MembersList['username']}</a></td>
	<td class="row1"><a href="index.php?page=member&amp;edit=1&amp;main=1&amp;id={$MembersList['id']}">{$lang['edit']}</a></td>
	<td class="row1"><a href="index.php?page=member&amp;del=1&amp;main=1&amp;id={$MembersList['id']}">{$lang['Delet']}</a></td>
</tr>
{/Des::while}
</table>
