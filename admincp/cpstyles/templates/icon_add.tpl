<br />

<div class="address_bar">{$lang['Control_Panel']} &raquo;
<a href="index.php?page=icon&amp;control=1&amp;main=1">{$lang['icons']}</a> &raquo;
 {$lang['add_new_icon']}</div>

<br />

<form action="index.php?page=icon&amp;add=1&amp;start=1" method="post">
	<table width="60%" class="t_style_b" border="0" cellspacing="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['add_new_icon']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['Image_Path']}
			</td>
			<td class="row1">
				<input type="text" name="path" id="input_path" value="look/images/icons/" />
			</td>
		</tr>
	</table>

	<br />

	<div align="center">
		<input class="submit" type="submit" value="{$lang['acceptable']}" name="submit" />
	</div>
</form>
