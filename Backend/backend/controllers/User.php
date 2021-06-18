<?php

header('Access-Control-Allow-Origin: http://127.0.0.1:3000');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../vendor/autoload.php';

class User extends Controller
{

    public $data = [];

    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
        $this->validator = $this->middleware('Middleware');
    }
    public function index()
    {
        $this->view('index');
    }

    public function me()
    {
        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                $info = $this->verifyAuth($headers[1]);
                    $user = $this->userModel->getUserByid($info->reference);
                    unset($user->password);
                    print_r(json_encode($user));
                
            } catch (\Throwable$th) {
                print_r(json_encode(array(
                    "error" => "unauthorized",
                )));
            }
        } else {
            print_r(json_encode(array(
                "error" => "unauthorized",
            )));
        }
    }


    

}
