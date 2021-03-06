<?php
/**
 * @package     Joomla.UnitTest
 * @subpackage  Model
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Test class for JModelItem.
 *
 * @package     Joomla.UnitTest
 * @subpackage  Model
 *
 * @since       3.4
 */
class JModelItemTest extends TestCase
{
	/**
	 * @var    JModelItem
	 * @since  3.4
	 */
	public $object;

	/**
	 * Setup each test.
	 *
	 * @since   3.4
	 *
	 * @return  void
	 */
	public function setUp()
	{
		// Create mock of abstract class JModelForm to test concrete methods in there
		$this->object = $this->getMockForAbstractClass('JModelItem');
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return void
	 *
	 * @see     \PHPUnit\Framework\TestCase::tearDown()
	 * @since   3.6
	 */
	protected function tearDown()
	{
		unset($this->object);
	}

	/**
	 * Tests the getStoreId method.
	 *
	 * @since   3.4
	 *
	 * @return  void
	 *
	 * @testdox getStoreId() returns correct id
	 */
	public function testCorrectStoreIdIsReturned()
	{
		$method = new ReflectionMethod('JModelItem', 'getStoreId');
		$method->setAccessible(true);

		$this->assertEquals(md5('teststring'), $method->invokeArgs($this->object, array('teststring')));
	}
}
