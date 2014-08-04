<?php
namespace oDesk\API\Tests\Routers;

require_once __DIR__  . '/CommonTestRouter.php';

class McTest extends CommonTestRouter
{
    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function testGetTrays()
    {
        $router = new \oDesk\API\Routers\Mc($this->_client);
        $response = $router->getTrays();
        
        $this->_checkResponse($response);
    }

    /**
     * @test
     */
    public function testGetTrayByType()
    {
        $router = new \oDesk\API\Routers\Mc($this->_client);
        $response = $router->getTrayByType('username', 'inbox');
        
        $this->_checkResponse($response);
    }

    /**
     * @test
     */
    public function testGetThreadDetails()
    {
        $router = new \oDesk\API\Routers\Mc($this->_client);
        $response = $router->getThreadDetails('username', 12345);
        
        $this->_checkResponse($response);
    }

    /**
     * @test
     */
    public function testMarkThread()
    {
        $router = new \oDesk\API\Routers\Mc($this->_client);
        $response = $router->markThread('username', 12345, array());
        
        $this->_checkResponse($response);
    }

    /**
     * @test
     */
    public function testStartNewThread()
    {
        $router = new \oDesk\API\Routers\Mc($this->_client);
        $response = $router->startNewThread('username', array());
        
        $this->_checkResponse($response);
    }

    /**
     * @test
     */
    public function testReplyToThread()
    {
        $router = new \oDesk\API\Routers\Mc($this->_client);
        $response = $router->replyToThread('username', 12345, array());
        
        $this->_checkResponse($response);
    }
}