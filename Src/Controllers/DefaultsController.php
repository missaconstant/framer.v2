<?php

namespace Framer\Controllers;

use Framer\Core\App\Controller;
use Framer\Core\App\Query;
use Framer\Core\Useful\Auth\JWT;
use Framer\Core\Useful\Classes\Mailer;
use Laminas\Diactoros\ServerRequest;

class DefaultsController extends Controller
{

    /**
     * Index Page
     *
     * @param Query query object
     *
     * @return View
     */
    static function index(ServerRequest $sr) {
        dump($sr->getUri()->getHost());
        return view('FramerViews/template');
    }

    static function testLogin() {
        $auth =  JWT::authentificate(
            'username',
            hash('sha256', 'password')
        );

        response_success($auth);
    }

    static function testEmail() {
        $email = new \stdClass();
        $email->sender = ['sender@email.com', 'Framer team'];
        $email->addresses = [['to@email.com', 'Receiver']];
        $email->subject = 'Greetings !';
        $email->body = 'Hello ze world.';

        Mailer::send($email);
    }
}
