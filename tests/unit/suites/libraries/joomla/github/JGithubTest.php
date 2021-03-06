<?php
/**
 * @package     Joomla.UnitTest
 * @subpackage  Github
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Test class for JGithub.
 *
 * @package     Joomla.UnitTest
 * @subpackage  Github
 *
 * @since       1.7.0
 */
class JGithubTest extends \PHPUnit\Framework\TestCase
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
	 * @var    JGithub  Object under test.
	 * @since  2.5.0
	 */
	protected $object;

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

		$this->object = new JGithub($this->options, $this->client);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 *
	 * @return void
	 */
	protected function tearDown()
	{
		unset($this->options, $this->client, $this->object);
		parent::tearDown();
	}

	/**
	 * Tests the magic __get method - gists
	 *
	 * @since  1.7.3
	 *
	 * @return void
	 */
	public function test__GetGists()
	{
		$this->assertThat(
			$this->object->gists,
			$this->isInstanceOf('JGithubPackageGists')
		);
	}

	/**
	 * Tests the magic __get method - issues
	 *
	 * @since  1.7.3
	 *
	 * @return void
	 */
	public function test__GetIssues()
	{
		$this->assertThat(
			$this->object->issues,
			$this->isInstanceOf('JGithubPackageIssues')
		);
	}

	/**
	 * Tests the magic __get method - pulls
	 *
	 * @since  1.7.3
	 *
	 * @return void
	 */
	public function test__GetPulls()
	{
		$this->assertThat(
			$this->object->pulls,
			$this->isInstanceOf('JGithubPackagePulls')
		);
	}

	/**
	 * Tests the magic __get method - refs
	 *
	 * @since  1.7.3
	 *
	 * @return void
	 */
	public function test__GetRefs()
	{
		$this->assertThat(
			$this->object->data->refs,
			$this->isInstanceOf('JGithubPackageDataRefs')
		);
	}

	/**
	 * Tests the magic __get method - forks
	 *
	 * @since  2.5.0
	 *
	 * @return void
	 */
	public function test__GetForks()
	{
		$this->assertThat(
			$this->object->repositories->forks,
			$this->isInstanceOf('JGithubPackageRepositoriesForks')
		);
	}

	/**
	 * Tests the magic __get method - commits
	 *
	 * @since  3.0.0
	 *
	 * @return void
	 */
	public function test__GetCommits()
	{
		$this->assertThat(
			$this->object->repositories->commits,
			$this->isInstanceOf('JGithubPackageRepositoriesCommits')
		);
	}

	/**
	 * Tests the magic __get method - milestones
	 *
	 * @since  3.1.4
	 *
	 * @return void
	 */
	public function test__GetMilestones()
	{
		$this->assertThat(
			$this->object->issues->milestones,
			$this->isInstanceOf('JGithubPackageIssuesMilestones')
		);
	}

	/**
	 * Tests the magic __get method - statuses
	 *
	 * @since  3.1.4
	 *
	 * @return void
	 */
	public function test__GetStatuses()
	{
		$this->assertThat(
			$this->object->repositories->statuses,
			$this->isInstanceOf('JGithubPackageRepositoriesStatuses')
		);
	}

	/**
	 * Tests the magic __get method - account
	 *
	 * @since  3.1.4
	 *
	 * @return void
	 */
	public function test__GetAccount()
	{
		$this->assertThat(
			$this->object->authorization,
			$this->isInstanceOf('JGithubPackageAuthorization')
		);
	}

	/**
	 * Tests the magic __get method - hooks
	 *
	 * @since  3.1.4
	 *
	 * @return void
	 */
	public function test__GetHooks()
	{
		$this->assertThat(
			$this->object->repositories->hooks,
			$this->isInstanceOf('JGithubPackageRepositoriesHooks')
		);
	}

	/**
	 * Tests the magic __get method - failure
	 *
	 * @since  1.7.3
	 * @expectedException RuntimeException
	 *
	 * @return void
	 */
	public function test__GetFailure()
	{
		$this->assertThat(
			$this->object->other,
			$this->isNull()
		);
	}

	/**
	 * Tests the magic __get method - failure
	 *
	 * @since  1.7.3
	 * @expectedException RuntimeException
	 *
	 * @return void
	 */
	public function test__GetPackageFailure()
	{
		$this->assertThat(
			$this->object->repositories->other,
			$this->isNull()
		);
	}

	/**
	 * Tests the setOption method
	 *
	 * @since  1.7.3
	 *
	 * @return void
	 */
	public function testSetOption()
	{
		$this->object->setOption('api.url', 'https://example.com/settest');

		$this->assertThat(
			$this->options->get('api.url'),
			$this->equalTo('https://example.com/settest')
		);
	}

	/**
	 * Tests the getOption method
	 *
	 * @since  1.7.3
	 *
	 * @return void
	 */
	public function testGetOption()
	{
		$this->options->set('api.url', 'https://example.com/gettest');

		$this->assertThat(
			$this->object->getOption('api.url', 'https://example.com/gettest'),
			$this->equalTo('https://example.com/gettest')
		);
	}
}
