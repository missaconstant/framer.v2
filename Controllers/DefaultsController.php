<?php

namespace Framer\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Framer\Core\App\Controller;
use Framer\Core\App\Query;
use Framer\Core\App\Helpers;
use Framer\Core\App\Session;
use Framer\Core\App\Response;
use Framer\Core\App\Uploader;
use Framer\Core\Model\DbManager;
use Framer\Core\Useful\Auth\JWT as AuthJWT;
use Framer\Core\Useful\Classes\Mailer;
use Framer\Core\Useful\Classes\Utils;
use Framer\Models\Users;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

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
        Response::jsonError('Hello !', [], 200);
    }

    static function login(Query $query) {
        
        AuthJWT::setUserModel(Users::class);

        // $tk = AuthJWT::authentificate($query->post('username'), hash('sha256', $query->post('password')));
        // dump($tk);

        // dump(AuthJWT::trypass(str_replace('Bearer ', '', $query->header('Authorization'))));
    }

    static function uploading(Query $query) {

        $uploader = new Uploader();
        $file = $uploader->getFiles();
        dump($file, true, 'json');
        // $r = $file->moveFile(path('Temp/Files/'));

        // dump($r, true, 'json');
    }


    static function getTables() {

        json_dump(DbManager::getTableColumns('book'));
    }

    static function sendmail() {
        
        $mailObj = (object) [
            "sender" => ['support@sendem.ci', 'SENDEM SUPPORT'],
            "address" => [['missabaihconstant@gmail.com', 'Miss Constant']],
            "cc" => ['theonlyonevirus@gmail.com', 'The Only One'],
            "bcc" => [['missa@sendem.ci', 'Mr Missa'], ['constant.missa@sendem.ci']],
            "replyto" => [['support@sendem.ci', 'SENDEM']],
            "subject" => "Test Message",
            "body" => 'This a <b>TEST</b> message to show you that everything <b style="color:#ff0">works fine</b>.',
            "attachment" => [[__DIR__ . '/../Assets/images/bg.jpg', 'framer.background.jpg']]
        ];

        dump(Mailer::send($mailObj));
    }

}
