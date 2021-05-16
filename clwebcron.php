<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.cache
 * @author		Christophe Lance
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Plugin\CMSPlugin;

/**
 * Joomla! Page Cache Plugin.
 *
 * @since  1.5
 */
class PlgSystemClwebcron extends CMSPlugin
{

	/**
	 * Application object
	 *
	 * @var    CMSApplication
	 * @since  1.0.0
	 */
	protected $app;

	public function __construct(&$subject, $config)
    	{
        	parent::__construct($subject, $config);

		if (!$this->app)
		{
    			$this->app = Factory::getApplication();
    		}

	}

	/**
	 * After Initialise Event.
	 * 
	 *
	 * @return  void
	 *
	 * @since   1.5
	 */
	public function onAfterInitialise()
	{

		// Cron is valid ?
		$ctoken = trim($this->app->input->get->get('ctoken', null, 'STRING'));
		
		if ( !empty($ctoken) and ($this->app->isClient('site')))
		{
			// Check token
			if ($ctoken != $this->params->get('token', 'webcron'))
			{
				return;
			}
		} else return;

		// Doing something
		$cache = Factory::getCache();
		$cache->gc();

		// Closes the application.
		$this->app->close();
	}

}
