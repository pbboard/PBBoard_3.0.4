<br />

<div class="address_bar">{$lang['Control_Panel']} &raquo;
<a href="index.php?page=groups&amp;control=1&amp;main=1">{$lang['groups']}</a> &raquo;
 {$lang['Delet']} :
  {$Inf['title']}</div>

<br />

<table width="50%" class="t_style_b" border="0" cellspacing="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		{$lang['Confirm_the_deletion']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" colspan="2">
		{$lang['Are_you_sure_you_want_Delete']}
<br />
{$lang['All_members_of_this_group_will_return_to_the_group_members']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1">
			<a href="index.php?page=groups&amp;del=1&amp;start=1&amp;id={$Inf['id']}">
			{$lang['yes']}</a>
		</td>
		<td class="row1">
			<a href="index.php?page=groups&amp;control=1&amp;main=1">
			{$lang['no']}</a>
		</td>
	</tr>
</table>
