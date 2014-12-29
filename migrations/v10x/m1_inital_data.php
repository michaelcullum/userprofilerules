<?php
/**
*
* User Profile Rules extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace phpbb\userprofilerules\migrations\v10x;

/**
* Migration stage 1: Inital data
*/
class m1_inital_data extends \phpbb\db\migration\migration
{
	/**
	* Add inital config data to the database
	*
	* @return array Array of table data
	* @access public
	*/
	public function update_data()
	{
		return array(
			array('config_text.add', array('signature_rules_text', '')),
			array('config_text.add', array('signature_rules_uid', '')),
			array('config_text.add', array('signature_rules_bitfield', '')),
			array('config_text.add', array('signature_rules_options', OPTION_FLAG_BBCODE + OPTION_FLAG_SMILIES + OPTION_FLAG_LINKS)),

			array('config_text.add', array('avatar_rules_text', '')),
			array('config_text.add', array('avatar_rules_uid', '')),
			array('config_text.add', array('avatar_rules_bitfield', '')),
			array('config_text.add', array('avatar_rules_options', OPTION_FLAG_BBCODE + OPTION_FLAG_SMILIES + OPTION_FLAG_LINKS)),
		);
	}
}
