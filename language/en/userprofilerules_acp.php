<?php
/**
*
* User Profile Rules extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'USER_PROFILE_RULES_SETTINGS'			=> 'User profile rules settings',
	'USER_PROFILE_RULES_SETTINGS_EXPLAIN'	=> 'Here you can change the user profile rules that are displayed on the avatar/signature UCP pages.',

	'USER_PROFILE_RULES_SIGNATURE_TEXT'				=> 'Signature rules message',
	'USER_PROFILE_RULES_SIGNATURE_PREVIEW'			=> 'Signature rules - preview',
	'USER_PROFILE_RULES_SIGNATURE_UPDATED'			=> 'Signature rules have been updated.',

	'USER_PROFILE_RULES_AVATAR_TEXT'				=> 'Avatar rules message',
	'USER_PROFILE_RULES_AVATAR_PREVIEW'			=> 'Avatar rules - preview',
	'USER_PROFILE_RULES_AVATAR_UPDATED'			=> 'Avatar rules have been updated.',
));
