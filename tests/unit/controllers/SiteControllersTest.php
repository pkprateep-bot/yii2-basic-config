<?php
namespace tests\unit\controllers;

use app\controllers\SiteController;
use Yii;
use yii\web\Request;

class SiteControllersTest extends \Codeception\Test\Unit
{
    public function testActionIndex() {
        $controller = new SiteController('site', Yii::$app);

        $response = $controller->actionIndex();

        $this->assertStringContainsString('Congratulations!', $response);
        $this->assertStringNotContainsString('Go to the login page', $response);
    }

    public function testActionSignupUserSuccess() {
        $requert_mock = $this->createMock(Request::class);

        $requert_mock->method('post')->willReturn([
            'SignupForm' => [
                'username' => 'dev01',
                'email' => 'dev01@mail.com',
                'password' => '123456'
            ]
        ]);

        Yii::$app->set('request', $requert_mock);

        $controller = new SiteController('site', Yii::$app);
        $response = $controller->actionSignupUser();

        $this->assertArrayHasKey('response', $response);
        $this->assertEquals('Ok', $response['response']);

    }

    public function testActionSignupUserFail() {
        $requert_mock = $this->createMock(Request::class);

        $requert_mock->method('post')->willReturn([
            'SignupForm' => [
                'username' => 'dev01',
                'email' => 'dev01@mail.com'
            ]
        ]);

        Yii::$app->set('request', $requert_mock);

        $controller = new SiteController('site', Yii::$app);
        $response = $controller->actionSignupUser();

        $this->assertArrayHasKey('response', $response);
        $this->assertEquals('Error', $response['response']);

    }

}