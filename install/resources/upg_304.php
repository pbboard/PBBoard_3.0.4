<?php/** * PBBoard 304 * Copyright 2022 PBBoard Group, All Rights Reserved * Website: http://www.PBBoard.info *//** * Upgrade Script: 3.0.3 */define('NO_TEMPLATE',true);include('../common.php');	$PowerBB->html->page_header('معالج ترقية برنامج منتديات PBBoard 3.0.4');	$logo = $PowerBB->html->create_image(array('align'=>'left','alt'=>'PowerBB','src'=>'../images/logo.png', 'border'=>'0', 'cellspacing'=>'0','return'=>true));	$PowerBB->html->page_body('<div class="pbboard_body">');	$PowerBB->html->open_table('100%',true);	$PowerBB->html->cells($logo,'header_logo_side');class PowerBBTHETA extends PowerBBInstall {	var $_TempArr 	= 	array();	var $_Masseges	=	array();	function _CreateMention()	{		global $PowerBB;		$this->_TempArr['CreateArr']				= 	array();		$this->_TempArr['CreateArr']['table_name'] 	= 	$PowerBB->prefix."mention";		$this->_TempArr['CreateArr']['fields'] 		= 	array();		$this->_TempArr['CreateArr']['fields'][] 	= 	"id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY";		$this->_TempArr['CreateArr']['fields'][] 	= 	"user_mention_about_you varchar(255) NOT NULL default ''";		$this->_TempArr['CreateArr']['fields'][] 	= 	"you varchar(255) NOT NULL default ''";		$this->_TempArr['CreateArr']['fields'][] 	= 	"topic_id int(10) UNSIGNED NOT NULL DEFAULT '0'";		$this->_TempArr['CreateArr']['fields'][] 	= 	"reply_id int(10) UNSIGNED NOT NULL DEFAULT '0'";		$this->_TempArr['CreateArr']['fields'][] 	= 	"profile_id int(10) UNSIGNED NOT NULL DEFAULT '0'";		$this->_TempArr['CreateArr']['fields'][] 	= 	"date varchar(200) NULL default ''";		$this->_TempArr['CreateArr']['fields'][] 	= 	"user_read int(1) NOT NULL DEFAULT '0'";        $create = $this->create_table($this->_TempArr['CreateArr']);        return ($create) ? true : false;	}	function UpdateNoActiveAddons()	{		global $PowerBB;		$update = $PowerBB->DB->sql_query("UPDATE " . $PowerBB->table['addons'] . " SET active='0'");		return ($update) ? true : false;	}	function DisableAllOldStyles()	{		global $PowerBB;		$update = $PowerBB->DB->sql_query("UPDATE " . $PowerBB->table['style'] . " SET style_on ='0'");		return ($update) ? true : false;	}	function DisableAllOldLangs ()	{		global $PowerBB;		$update = $PowerBB->DB->sql_query("UPDATE " . $PowerBB->table['lang'] . " SET lang_on ='0'");		return ($update) ? true : false;	}	function profile_view_ADD_KEY()	{		global $PowerBB;        $update1 = $PowerBB->DB->sql_query('ALTER TABLE ' . $PowerBB->table['profile_view'] . " ADD KEY(profile_user_id)");        if ($update1)        {        $update = $PowerBB->DB->sql_query('ALTER TABLE ' . $PowerBB->table['profile_view'] . " ADD KEY(viewer_user_id)");        }		return ($update1) ? true : false;	}	function update_mobile_style_id()	{	global $PowerBB;	$def_style = $PowerBB->_CONF['info_row']['def_style'];	$update = $PowerBB->DB->sql_query("UPDATE " . $PowerBB->table['info'] . " SET value='$def_style' WHERE var_name='mobile_style_id'");	return ($update) ? true : false;	}	function _InsertStyle($u)	{		global $PowerBB;        $xml_code = @file_get_contents("../resources/PBBoard-Style.xml");		if (strstr($xml_code,'decode="0"'))		{			$xml_code = str_replace('decode="0"','decode="1"',$xml_code);			preg_match_all('/<!\[CDATA\[(.*?)\]\]>/is', $xml_code, $match);			foreach($match[0] as $val)			{			$xml_code = str_replace($val,base64_encode($val),$xml_code);			}		}		$import = $this->xml_array($xml_code);		$title = $import['styles_attr']['name'];        $limt = 5;		if($u == 0)		{		$image_path = $import['styles_attr']['image_path'];		$style_path = $import['styles_attr']['style_path'];		$StlArr 					= 	array();		$StlArr['field']			=	array();		$StlArr['field']['style_title'] 	= 	'default-style-304';		$StlArr['field']['style_path'] 		= 	$style_path;		$StlArr['field']['style_order'] 	= 	'1';		$StlArr['field']['style_on'] 		= 	'1';		$StlArr['field']['image_path'] 		= 	$image_path;		$insert_Style = $PowerBB->style->InsertStyle($StlArr);		$styleid = $PowerBB->DB->sql_insert_id();		if($insert_Style)		{		$update_def_style = $PowerBB->DB->sql_query("UPDATE " . $PowerBB->table['info'] . " SET value='$styleid' WHERE var_name='def_style'");        }        $x = 0;        $y = $limt;        $yx = $limt;		}       else		{	    $info_query = $PowerBB->DB->sql_query("SELECT id FROM " . $PowerBB->table['style'] . " WHERE style_title='default-style-304'");	    $info_row   = $PowerBB->DB->sql_fetch_array($info_query);		$styleid = $info_row['id'];        $x = $u;        $y = $u+$limt;        $yx = $u+$limt;		}      		$showmsgs = "<b>تم إنشاء القالب: </b>";		$pbbversion = $import['styles_attr']['pbbversion'];		$Templates = $import['styles']['templategroup'];		//$Templates_number = sizeof($import['styles']['templategroup']['template'])/2;		$Templates_number = 210;        $PowerBB->html->cells('عمليات إنشاء قوالب الاستايل الافتراضي','main1');        $PowerBB->html->close_table();			while ($x < $Templates_number)			{				$templatetitle = $Templates['template'][$x.'_attr']['name'];				$version = $Templates['template'][$x.'_attr']['version'];				$template = base64_decode($Templates['template'][$x]);				$templatetype = $Templates['template'][$x.'_attr']['templatetype'];				$dateline = $Templates['template'][$x.'_attr']['date'];				$product = $Templates['template'][$x.'_attr']['product'];				$version = $Templates['template'][$x.'_attr']['version'];				$username = $Templates['template'][$x.'_attr']['username'];				$template = str_replace("'", "&#39;", $template);				$template = str_replace("//<![CDATA[", "", $template);				$template = str_replace("//]]>", "", $template);				$template = str_replace("<![CDATA[","", $template);				$template = str_replace("]]>","", $template);				$InsertTemplatesArr	=	array();				$InsertTemplatesArr['field']	=	array();				$InsertTemplatesArr['field']['styleid']	=	$styleid;				$InsertTemplatesArr['field']['title']	=	$templatetitle;				$InsertTemplatesArr['field']['template']	=	$template;				$InsertTemplatesArr['field']['template_un']	=	$template;				$InsertTemplatesArr['field']['templatetype']	=	$templatetype;				$InsertTemplatesArr['field']['dateline']	=	$dateline;				$InsertTemplatesArr['field']['username']	=	$username;				$InsertTemplatesArr['field']['version']	=	$version;				$InsertTemplatesArr['field']['product']	=	$product;				$Insert = $PowerBB->core->Insert($InsertTemplatesArr,'template');                $PowerBB->html->open_p();				$PowerBB->html->p_msg($showmsgs.$templatetitle);                $PowerBB->html->close_p();	            if($x == $Templates_number-1)	            {    			$deltemplates = $PowerBB->DB->sql_query("DELETE FROM " . $PowerBB->table['template'] . " WHERE styleid = '$styleid' and title = ''");                 echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"2; URL=upg_304.php?step=5\">\n";                 break;	            }	            elseif($x == $y-1)	            {                 echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"2; URL=upg_304.php?step=4&u=$yx\">\n";                 break;	            }	            else	            {				$x += 1;				}			}	       if ($deltemplates)	        {			//$updatemember = $PowerBB->DB->sql_query("UPDATE " . $PowerBB->table['member'] . " SET style = '$styleid'");			//////////			//return ($Insert) ? true : false;	        }		 $PowerBB->html->close_table();	}    function _InsertLang_ar()	{		global $PowerBB;         $xml_code_ar = @file_get_contents("../resources/ArabicLanguage.xml");		$import = $this->xml_array($xml_code_ar);		$title = $import['language_attr']['name'];		$pbbversion = $import['language_attr']['version'];		$Languages = $import['language']['phrasegroup'];		$language_number = sizeof($import['language']['phrasegroup']['phrase'])/2;	       	$LangArr 					= 	array();			$LangArr['field']			=	array();			$LangArr['field']['lang_title'] 	= 	'Arabic-304';			$LangArr['field']['lang_order'] 	= 	"1";			$LangArr['field']['lang_on'] 		= 	"1";			$LangArr['field']['lang_path'] 		= 	"rtl";			$insert = $PowerBB->lang->InsertLang($LangArr);			$langid = $PowerBB->DB->sql_insert_id();		            $x = 0;     			while ($x < $language_number)     			{						$varname = $Languages['phrase'][$x.'_attr']['name'];						$fieldname = $Languages['phrase'][$x.'_attr']['fieldname'];						$version = $Languages['phrase'][$x.'_attr']['pbbversion'];						$text = $Languages['phrase'][$x];						$product = $Languages['phrase'][$x.'_attr']['product'];						$dateline = $Languages['phrase'][$x.'_attr']['date'];						$username = $Languages['phrase'][$x.'_attr']['username'];			            $text = str_replace("'", "&#39;", $text);						$InsertLanguagesArr	=	array();						$InsertLanguagesArr['field']	=	array();						$InsertLanguagesArr['field']['languageid']	=	$langid;						$InsertLanguagesArr['field']['varname']  	=	$varname;						$InsertLanguagesArr['field']['fieldname']	=	$fieldname;						$InsertLanguagesArr['field']['text']	    =	$text;						$InsertLanguagesArr['field']['dateline']	=	$dateline;						$InsertLanguagesArr['field']['username']	=	$username;						$InsertLanguagesArr['field']['version']	    =	$version;						$InsertLanguagesArr['field']['product']	    =	$product;						$insertLanguages_ar = $PowerBB->core->Insert($InsertLanguagesArr,'phrase_language');                     $x += 1;     			}           if ($insertLanguages_ar)			{		        $delLanguages_ar = $PowerBB->DB->sql_query("DELETE FROM " . $PowerBB->table['phrase_language'] . " WHERE languageid = '$langid' and varname = ''");   		        $update = $PowerBB->DB->sql_query("UPDATE " . $PowerBB->table['info'] . " SET value='$langid' WHERE var_name='def_lang'");			}		return ($insertLanguages_ar) ? true : false;	}  }  	$PowerBB->install = new PowerBBTHETA;		if ($PowerBB->_GET['step'] == 1)		{			$PowerBB->html->cells('عمليات التحديث','main1');			$PowerBB->html->close_table();		    $p[14] 		= 	$PowerBB->install->UpdateNoActiveAddons();			$msgs[14] 	= 	($p[14]) ? 'تم تعطيل كافة الاضافات البرمجية' : 'لم يتم تعطيل كافة الاضافات البرمجية';		    $p[15] 		= 	$PowerBB->install->DisableAllOldStyles();			$msgs[15] 	= 	($p[15]) ? 'تم تعطيل كافة الإستايلات السابقة' : 'لم يتم تعطيل كافة الإستايلات';		    $p[16] 		= 	$PowerBB->install->DisableAllOldLangs();			$msgs[16] 	= 	($p[16]) ? 'تم تعطيل كافة اللغات السابقة' : 'لم يتم تعطيل كافة اللغات';		    $p[22] 		= 	$PowerBB->install->profile_view_ADD_KEY();			$msgs[22] 	= 	($p[22]) ? 'تم تحديث حقل viewer_user_id ' : 'لم يتم تحديث حقل viewer_user_id  ';			$PowerBB->html->open_p();			foreach ($msgs as $msg)			{				$PowerBB->html->p_msg($msg);			}		$PowerBB->html->close_p();		$PowerBB->html->close_table();		$PowerBB->html->make_link('الخطوه الثانية -> إضافة اللغة والعبارات','?step=2');		}		if ($PowerBB->_GET['step'] == 2)		{			$PowerBB->html->cells('عمليات اضافة اللغة والعبارات','main1');			$PowerBB->html->close_table();			$p[17] 		= 	$PowerBB->install->_InsertLang_ar();			$msgs[17] 	= 	($p[17]) ? 'تم إدخال اللغة العربية  ' : 'لم يتم إدخال اللغة العربية';			$PowerBB->html->open_p();			foreach ($msgs as $msg)			{				$PowerBB->html->p_msg($msg);			}		$PowerBB->html->close_p();		$PowerBB->html->close_table();		$PowerBB->html->make_link('الخطوه الثالثة -> إنشاء جدول المنشن للأعضاء','?step=3');		}		if ($PowerBB->_GET['step'] == 3)		{		$PowerBB->html->cells('عمليات إنشاء جدول المنشن للأعضاء','main1');			$PowerBB->html->close_table();			$p[18] 		= 	$PowerBB->install->_CreateMention();			$msgs[18] 	= 	($p[18]) ? 'تم إنشاء جدول المنشن للأعضاء ' : 'لم يتم إنشاء جدول المنشن للأعضاء';			$PowerBB->html->open_p();			foreach ($msgs as $msg)			{				$PowerBB->html->p_msg($msg);			}		$PowerBB->html->close_p();		$PowerBB->html->close_table();		$PowerBB->html->make_link('الخطوه الثالثة -> تنصيب الاستايل الافتراضي','?step=4');		}		if ($PowerBB->_GET['step'] == 4)		{			if ($PowerBB->_GET['u'] == 0			or $PowerBB->_GET['u'])			{		      $p[18] = $PowerBB->install->_InsertStyle(intval($PowerBB->_GET['u']));			  $msgs[18] 	= 	$p[18];				$PowerBB->html->open_p();				foreach ($msgs as $msg)				{				$PowerBB->html->p_msg($msg);				}				$PowerBB->html->close_p();				$PowerBB->html->close_table();			}		}		if ($PowerBB->_GET['step'] == 5)		{			$PowerBB->html->cells('عملية اضافة الأستايل الافتراضي','main1');			$PowerBB->html->close_table();			$p[18] = true;			$msgs[18] 	= 	($p[18]) ? 'تم إنشاء قوالب الأستايل ' : 'لم يتم إنشاء قوالب الإستايل';			$p[21] 		= 	$PowerBB->install->update_mobile_style_id();			$msgs[21] 	= 	($p[21]) ? 'تم تخصيص الاستايل الافتراضي للمتصفحين من الهواتف النقالة ' : 'لم يتم تخصيص ستايل للمتصفحين من الهواتف النقالة';			$PowerBB->html->open_p();			foreach ($msgs as $msg)			{			$PowerBB->html->p_msg($msg);			}			$PowerBB->html->close_p();			$PowerBB->html->close_table();			$PowerBB->html->make_link('الخطوه الرابعة والأخيرة -> اتمام الترقية','../upgrade.php?action=upgrade304_finish_upgrade');		}