<?php
use Pyjac\TodoAPI\App;
use Slim\Http\Environment;
use Slim\Http\Request;
use PHPUnit\Framework\TestCase;

class TodoTest extends TestCase
{
    protected $app;

    public function setUp(): void
    {
        $this->app = (new App())->get();
    }

    public function testTodoGet() {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/',
        ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame((string)$response->getBody(), "Hello, Todo");
    }

    /***********************************************************************************
     * Let’s test GET request to /todo
     */
    public function testTodoGetAll() {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/todo',
        ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode($response->getBody(), true);
        $this->assertSame($result["message"], "Hello, Todo");
    }

    /***********************************************************************************
     * For POST request to /todo/{id}
     */
    public function testTodoPost() {
        $id = 1;
        $env = Environment::mock([
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI'    => '/todo/'.$id,
            'CONTENT_TYPE'   => 'application/x-www-form-urlencoded',
        ]);
        $req = Request::createFromEnvironment($env)->withParsedBody([]);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode($response->getBody(), true);
        $this->assertSame($result["message"], "Todo ".$id." updated successfully");
    }

    /***********************************************************************************
     * For DELETE request /todo/{id}
     */
    public function testTodoDelete() {
        $id = 1;
        $env = Environment::mock([
            'REQUEST_METHOD' => 'DELETE',
            'REQUEST_URI'    => '/todo/'.$id,
            'CONTENT_TYPE'   => 'application/x-www-form-urlencoded',
        ]);
        $req = Request::createFromEnvironment($env)->withParsedBody([]);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode($response->getBody(), true);
        $this->assertSame($result["message"], "Todo ".$id." deleted successfully");
    }

}