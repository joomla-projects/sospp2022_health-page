<?php
/**
 * @package     Joomla.UnitTest
 * @subpackage  Document
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Test class for JDocumentRenderer.
 */
class JDocumentRendererTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @var  JDocumentRenderer
	 */
	protected $object;

	/**
	 * Backup of the SERVER superglobal
	 *
	 * @var  array
	 */
	protected $backupServer;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		$doc = new JDocument;
		$this->object = new JDocumentRenderer($doc);

		$this->backupServer = $_SERVER;

		$_SERVER['HTTP_HOST'] = 'example.com';
		$_SERVER['SCRIPT_NAME'] = '';
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return  void
	 */
	protected function tearDown()
	{
		$_SERVER = $this->backupServer;
		unset($this->backupServer, $this->object);
		parent::tearDown();
	}

	public function testRenderByDefaultReturnsNull()
	{
		$this->assertNull($this->object->render('test'));
	}

	public function testGetTheDefaultContentType()
	{
		$this->assertEquals(
			'text/html',
			$this->object->getContentType()
		);
	}
}
