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

class user_profile_rules_signature_module
{
	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var ContainerInterface */
	protected $phpbb_container;

	/** @var string */
	protected $phpbb_root_path;

	/** @var string */
	protected $php_ext;

	/** @var string */
	public $u_action;

	public function main($id, $mode)
	{
		// This is really ugly, we need to do something about this as soon as phpBB enables us to
		global $db, $request, $template, $user, $phpbb_root_path, $phpEx, $phpbb_container;

		$this->config_text = $phpbb_container->get('config_text');
		$this->db = $db;
		$this->log = $phpbb_container->get('log');
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $phpEx;

		// BBcodes stuff has some custom language vars so we need to load those
		$this->user->add_lang(array('posting'));

		// As we use custom set language variables we need to load the language file
		$this->user->add_lang_ext('phpbb/userprofilerules', 'userprofilerules_acp');

		// Set the template, we share a template for avatar/signature rules changes
		$this->tpl_name = 'user_profile_rules';

		// Set the page <title> for our ACP page as a language variable
		$this->page_title = 'ACP_USER_PROFILE_RULES_SIGNATURE_SETTINGS';

		// We need to set a form key for CRSF protection
		$form_name = 'acp_user_profile_rules';
		add_form_key($form_name);

		// Set an empty error string so it's ready if we have an error later on
		$error = '';

		// We use a number of bbcode functions for getting text ready for storage/display
		// which are kept inside this functions file
		if (!function_exists('display_custom_bbcodes'))
		{
			include($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
		}

		// We need the avatar rules data to manipulate on the acp page so we get it from the db/cache
		// via the config_text abstraction layer
		$data = $this->config_text->get_array(array(
			'signature_rules_text',
			'signature_rules_uid',
			'signature_rules_bitfield',
			'signature_rules_options',
		));

		// We need to process submitted data if we are previewing or saving
		if ($this->request->is_set_post('submit') || $this->request->is_set_post('preview'))
		{
			// Test if form key is valid for CRSF protection
			if (!check_form_key($form_name))
			{
				$error = $this->user->lang('FORM_INVALID');
			}

			// We obviously need to get the new announcement text from the submitted
			// form for saving/generating a new preview
			$data['signature_rules_text'] = $this->request->variable('user_profile_rules_text', '', true);

			// We need to specially prepare the submitted data for storage with some
			// special bbcode processing and sanitization
			generate_text_for_storage(
				$data['signature_rules_text'],
				$data['signature_rules_uid'],
				$data['signature_rules_bitfield'],
				$data['signature_rules_options'],
				!$this->request->variable('disable_bbcode', false),
				!$this->request->variable('disable_magic_url', false),
				!$this->request->variable('disable_smilies', false)
			);

			// If all is okay then we have to persist the submitted data to the database
			if (empty($error) && $this->request->is_set_post('submit'))
			{
				// Here we persist the submitted datas to the db/cache via the config_text
				// abstraction layer
				$this->config_text->set_array(array(
					'signature_rules_text'			=> $data['signature_rules_text'],
					'signature_rules_uid'			=> $data['signature_rules_uid'],
					'signature_rules_bitfield'		=> $data['signature_rules_bitfield'],
					'signature_rules_options'		=> $data['signature_rules_options'],
				));

				// Log the rules update to the ACP logs
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'USER_PROFILE_RULES_UPDATED_LOG');

				// Finally we need to inform the user this process has completed so we output
				// an auto-generated message with a link back where they were before
				trigger_error($this->user->lang('USER_PROFILE_RULES_UPDATED') . adm_back_link($this->u_action));
			}
		}

		// Prepare a fresh announcement preview
		$signature_rules_text_preview = '';
		if ($this->request->is_set_post('preview'))
		{
			// We need to parse the message stored in the db as it's not stored in a raw format
			$signature_rules_text_preview = generate_text_for_display($data['signature_rules_text'], $data['signature_rules_uid'], $data['signature_rules_bitfield'], $data['signature_rules_options']);
		}

		// We also then need to be able to get the message in a format that is the one we can edit it in
		$signature_rules_text_edit = generate_text_for_edit($data['signature_rules_text'], $data['signature_rules_uid'], $data['signature_rules_options']);

		// Output data to the template
		$this->template->assign_vars(array(
			'ERRORS'						=> $error,
			'USER_PROFILE_RULES_TEXT'		=> $signature_rules_text_edit['text'],
			'USER_PROFILE_RULES_PREVIEW'	=> $signature_rules_text_preview,

			'S_BBCODE_DISABLE_CHECKED'		=> !$signature_rules_text_edit['allow_bbcode'],
			'S_SMILIES_DISABLE_CHECKED'		=> !$signature_rules_text_edit['allow_smilies'],
			'S_MAGIC_URL_DISABLE_CHECKED'	=> !$signature_rules_text_edit['allow_urls'],

			'BBCODE_STATUS'			=> $this->user->lang('BBCODE_IS_ON', '<a href="' . append_sid("{$this->phpbb_root_path}faq.{$this->php_ext}", 'mode=bbcode') . '">', '</a>'),
			'SMILIES_STATUS'		=> $this->user->lang('SMILIES_ARE_ON'),
			'IMG_STATUS'			=> $this->user->lang('IMAGES_ARE_ON'),
			'FLASH_STATUS'			=> $this->user->lang('FLASH_IS_ON'),
			'URL_STATUS'			=> $this->user->lang('URL_IS_ON'),

			'S_BBCODE_ALLOWED'		=> true,
			'S_SMILIES_ALLOWED'		=> true,
			'S_BBCODE_IMG'			=> true,
			'S_BBCODE_FLASH'		=> true,
			'S_LINKS_ALLOWED'		=> true,

			'USER_PROFILE_RULES_AVATAR'	=> false,

			'S_USER_PROFILE_RULES'	=> true,

			'U_ACTION'				=> $this->u_action,
		));

		// Assigning custom bbcodes
		display_custom_bbcodes();
	}
}
