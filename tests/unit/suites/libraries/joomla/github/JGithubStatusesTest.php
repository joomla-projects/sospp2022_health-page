<?php
/**
 * @package     Joomla.UnitTest
 * @subpackage  Github
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Test class for JGithubGists.
 *
 * @package     Joomla.UnitTest
 * @subpackage  Github
 *
 * @since       1.7.0
 */
class JGithubStatusesTest extends TestCase
{
	/**
	 * @var    JRegistry  Options for the GitHub object.
	 * @since  2.5.0
	 */
	protected $options;

	/**
	 * @var    JGithubHttp  Mock client object.
	 * @since  2.5.0
	 */
	protected $client;

	/**
	 * @var    JGithubGists  Object under test.
	 * @since  2.5.0
	 */
	protected $object;

	/**
	 * @var    string  Sample JSON string.
	 * @since  2.5.0
	 */
	protected $sampleString = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

	/**
	 * @var    string  Sample JSON error message.
	 * @since  2.5.0
	 */
	protected $errorString = '{"message": "Generic Error"}';

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 *
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->options = new JRegistry;
		$this->client = $this->getMockBuilder('JGithubHttp')->setMethods(array('get', 'post', 'delete', 'patch', 'put'))->getMock();

		$this->object = new JGithubStatuses($this->options, $this->client);
	}

	/**
	 * Overrides the parent tearDown method.
	 *
	 * @return  void
	 *
	 * @see     \PHPUnit\Framework\TestCase::tearDown()
	 * @since   3.6
	 */
	protected function tearDown()
	{
		unset($this->options, $this->client, $this->object);
		parent::tearDown();
	}

	/**
	 * Tests the create method
	 *
	 * @return void
	 */
	public function testCreate()
	{
		$returnData = new stdClass;
		$returnData->code = 201;
		$returnData->body = $this->sampleString;

		// Build the request data.
		$data = json_encode(
			array(
				'state' => 'success',
				'target_url' => 'http://example.com/my_url',
				'description' => 'Success is the only option - failure is not.'
			)
		);

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/statuses/6dcb09b5b57875f334f61aebed695e2e4193db5e', $data)
			->will($this->returnValue($returnData));

		$this->assertThat(
			$this->object->create(
				'joomla',
				'joomla-platform',
				'6dcb09b5b57875f334f61aebed695e2e4193db5e',
				'success',
				'http://example.com/my_url',
				'Success is the only option - failure is not.'
			),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the create method - failure
	 *
	 * @expectedException  DomainException
	 *
	 * @return void
	 */
	public function testCreateFailure()
	{
		$returnData = new stdClass;
		$returnData->code = 501;
		$returnData->body = $this->errorString;

		// Build the request data.
		$data = json_encode(
			array(
				'state' => 'pending'
			)
		);

		$this->client->expects($this->once())
			->method('post')
			->with('/repos/joomla/joomla-platform/statuses/6dcb09b5b57875f334f61aebed695e2e4193db5e', $data)
			->will($this->returnValue($returnData));

		$this->object->create('joomla', 'joomla-platform', '6dcb09b5b57875f334f61aebed695e2e4193db5e', 'pending');
	}

	/**
	 * Tests the getList method
	 *
	 * @return void
	 */
	public function testGetList()
	{
		$returnData = new stdClass;
		$returnData->code = 200;
		$returnData->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/statuses/6dcb09b5b57875f334f61aebed695e2e4193db5e')
			->will($this->returnValue($returnData));

		$this->assertThat(
			$this->object->getList('joomla', 'joomla-platform', '6dcb09b5b57875f334f61aebed695e2e4193db5e'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * Tests the getList method - failure
	 *
	 * @expectedException  DomainException
	 *
	 * @return void
	 */
	public function testGetListFailure()
	{
		$returnData = new stdClass;
		$returnData->code = 500;
		$returnData->body = $this->errorString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/statuses/6dcb09b5b57875f334f61aebed695e2e4193db5e')
			->will($this->returnValue($returnData));

		$this->object->getList('joomla', 'joomla-platform', '6dcb09b5b57875f334f61aebed695e2e4193db5e');
	}
}
