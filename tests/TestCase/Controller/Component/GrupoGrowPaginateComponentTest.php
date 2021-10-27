<?php

namespace Cakephp3Paginate\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use Cakephp3Paginate\Controller\Component\Cakephp3PaginateComponent;

/**
 * Cakephp3Paginate\Controller\Component\Cakephp3PaginateComponent Test Case
 */
class Cakephp3PaginateComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Cakephp3Paginate\Controller\Component\Cakephp3PaginateComponent
     */
    public $Cakephp3Paginate;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Cakephp3Paginate = new Cakephp3PaginateComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cakephp3Paginate);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
