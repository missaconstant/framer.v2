<?php

namespace Framer\Controllers;

use Framer\Core\App\Controller;
use Framer\Core\App\Query;
use Framer\Core\Useful\Auth\JWT;
use Framer\Core\Useful\Classes\Mailer;

class DefaultsController extends Controller
{

    /**
     * Index Page
     *
     * @param Query query object
     *
     * @return View
     */
    static function index(Query $query) {
        view('FramerViews/template');
    }

    static function testLogin(Query $q) {
        $auth =  JWT::authentificate(
            $q->input('username'),
            hash('sha256', $q->input('password'))
        );

        response_success($auth);
    }

    static function testEmail(Query $q) {
        $email = new \stdClass();
        $email->sender = ['sender@email.com', 'Framer team'];
        $email->addresses = [['to@email.com', 'Receiver']];
        $email->subject = 'Greetings !';
        $email->body = 'Hello ze world.';

        Mailer::send($email);
    }
}
