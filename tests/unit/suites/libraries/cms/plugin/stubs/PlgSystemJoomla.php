<?php
/**
 * @package     Joomla.UnitTest
 * @subpackage  Plugin
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\Registry\Registry;

/**
 * Stub plugin class for unit testing
 *
 * @package     Joomla.UnitTest
 * @subpackage  Plugin
 * @since       3.1
 */
class PlgSystemJoomla extends JPlugin
{
	/**
	 * Application object
	 *
	 * @var    JApplicationBase
	 * @since  3.1
	 */
	protected $app;

	/**
	 * Database object
	 *
	 * @var    JDatabaseDriver
	 * @since  3.1
	 */
	protected $db;

	/**
	 * Constructor
	 *
	 * @since   3.1
	 */
	public function __construct()
	{
		$this->autoloadLanguage = true;

		// Config array for JPlugin constructor
		$config = array();
		$config['name']   = 'Joomla';
		$config['type']   = 'System';
		$config['params'] = new Registry;

		$dispatcher = JEventDispatcher::getInstance();

		// Call the parent constructor
		parent::__construct($dispatcher, $config);
	}
}
