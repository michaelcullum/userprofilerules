<?php
/**
*
* User Profile Rules extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace phpbb\userprofilerules\acp;

class user_profile_rules_signature_info
{
	function module()
	{
		return array(
			'filename'	=> '\phpbb\userprofilerules\acp\user_profile_rules_signature_module',
			'title'		=> 'ACP_USER_PROFILE_RULES_SIGNATURE',
			'modes'		=> array(
				'settings'	=> array(
					'title' => 'ACP_USER_PROFILE_RULES_SIGNATURE',
					'auth' => 'ext_phpbb/userprofilerules && acl_a_board',
					'cat' => array('ACP_USER_PROFILE_RULES')
				),
			),
		);
	}
}
