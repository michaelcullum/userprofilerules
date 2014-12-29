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

class user_profile_rules_avatar_info
{
	function module()
	{
		return array(
			'filename'	=> '\phpbb\userprofilerules\acp\user_profile_rules_avatar_module',
			'title'		=> 'ACP_USER_PROFILE_RULES_AVATAR',
			'modes'		=> array(
				'settings'	=> array(
					'title' => 'ACP_USER_PROFILE_RULES_AVATAR',
					'auth' => 'ext_phpbb/userprofilerules && acl_a_board',
					'cat' => array('ACP_USER_PROFILE_RULES')
				),
			),
		);
	}
}
