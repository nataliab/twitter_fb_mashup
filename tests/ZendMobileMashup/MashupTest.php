<?php

use Zend\ServiceManager\ServiceManager;
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Mashup test case.
 */
class MashupTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var Mashup
	 */
	private $Mashup;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated MashupTest::tearDown()
		$this->Mashup = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	/**
	 * Tests Mashup->__construct()
	 */
	public function test__construct() {
		$services = new ServiceManager();
        $services->setService('Config', include 'config/application.config.php');
        $services->setFactory('Mashup', 'ZendMobileMashup\Factory');
        $this->Mashup = $services->get('Mashup');
        $this->assertNotEmpty($this->Mashup, "Mashup should be initialized");
	}
	
	/**
	 * Tests Mashup->getMergedStream()
	 */
	public function testGetMergedStream() {
		// TODO Auto-generated MashupTest->testGetMergedStream()
		$this->markTestIncomplete ( "getMergedStream test not implemented" );
		
		$this->Mashup->getMergedStream(/* parameters */);
	}
	
	public function testSettingDifferentFacebookPageIds() {
		$services = new ServiceManager();
		$services->setService('Config', include 'config/application.config.php');
		$services->setFactory('Mashup', 'ZendMobileMashup\Factory');
		$mashup1 = $services->get('Mashup');
	
		$services2 = new ServiceManager();
		$services2->setService('Config', include 'config/application.config.2.php');
		$services2->setFactory('Mashup', 'ZendMobileMashup\Factory');
		$mashup2 = $services2->get('Mashup');
		
		$this->assertNotEquals($mashup1, $mashup2);
	
	}
}

