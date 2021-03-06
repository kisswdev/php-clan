<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		Xcel Gaming Development Team
 * @copyright		Copyright (c) 2010 - 2011, Xcel Gaming, Inc.
 * @license		http://www.xcelgaming.com/about/license/
 * @link			http://www.xcelgaming.com
 * @since			Version 0.6.0
 */

// ------------------------------------------------------------------------
/**
 * ClanCMS Twitter Widget
 *
 * @package		CZ Gaming
 * @subpackage	Widgets
 * @category		Widgets
 * @author		co[dezyne]
 * @link			http://codezyne.me
 */
 
class Twitter_widget extends Widget {

	// Widget information
	public $title = 'Twitter';
	public $description = "Display's the clan's official twitter feed.";
	public $author = 'co[dezyne]';
	public $link = 'http://codezyne.me';
	public $version = '0.6';
	
	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		// Call the Widget constructor
		parent::__construct();
		
		// Create a instance to CI
		$CI =& get_instance();
	}
	
	// --------------------------------------------------------------------
	/**
	 * Twitter
	 *
	 * Display's twitter feed
	 *
	 * @access	public
	 * @return	void
	 */
	 
	function index()
	{
		// Load twitter library
		$this->CI->load->library('Twitter', 'twitter');
		
		// Receiver twitter setting
		$tweeter = $this->CI->settings->get_setting(array('setting_title' => 'Twitter'));
		
		if($tweeter->setting_value)
		{
			// Run through library
			$tweets = $this->CI->twitter->parse($tweeter->setting_value, 3);		
			
		}
		else
		{
			// No public twitter user
			$tweets = '';
		}
		
		// Reference object
		$this->data->tweets =& $tweets;
		$this->data->tweeter = $tweeter->setting_value;
		
		// Assign the widget info
		$widget->title = 'Twitter Feed';
		$widget->content = $this->CI->load->view('widgets/twitter', $this->data, TRUE);
		
		// Load the widget view
		$this->CI->load->view(WIDGET . 'widget', $widget);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Uninstall
	 *
	 * Uninstall's the widget
	 *
	 * @access	public
	 * @return	void
	 */
	function uninstall()
	{
		// Assign files
		$files = array(
			APPPATH . 'views/widgets/twitter.php'
		);
		
		// Loop through the files
		foreach($files as $file)
		{
			// Check if the file exists
			if(file_exists($file))
			{
				// Delete the file
				unlink($file);
			}
		}
		
		// Delete the widget
		unlink(__FILE__);
	}
}
	
/* End of file twitter_widget.php */
/* Location: ./clancms/widgets/twitter_widget.php */