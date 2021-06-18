<?php

class Auth extends Controller
{

    public function __construct()
    {
        $this->AuthModel = $this->model('AuthModel');
        $this->userModel = $this->model('UserModel');
        $this->validator = $this->middleware();
        // $this->notifModel = $this->model('notifModel');
    }

    public function login()
    {

        // TODO  :  schema validation
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:0',
        ];
        try {
            $response = $this->validator->validate($this->data, $rules);
            if ($response->error) {
                die(print_r(json_encode($response)));
            }
        } catch (\Exception$th) {
            die(print_r($th->getMessage()));
        }

        // TODO  :  Login The User
        $this->data = json_decode($this->data);
        $user = $this->userModel->getUserByEmail($this->data->email);
        if ($user) {
            if (password_verify($this->data->password, $user->password)) {
                $token = $this->getToken($user->reference);
                $refrechToken = $this->getRefrechToken($user->reference);
                unset($user->password);

                // !TODO : Store the Refrech Token in DB
                $this->AuthModel->add($refrechToken, $user->reference);
                print_r(json_encode(array(
                    'User' => $user,
                    'Token' => $token,
                )));
            } else {
                $res = json_encode(array(
                    'error' => 'password incorrect',
                ));
                print_r($res);
            }
        } else {
            $res = json_encode(array(
                'error' => 'email incorrect',
            ));
            print_r($res);
        }
    }

    public function register()
    {
        // TODO  :  schema validation
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:0',
            'cin' => 'required',
            'name' => 'required',
            'phone' => 'phone',
        ];
        try {
            $response = $this->validator->validate($this->data, $rules);
            if ($response->error) {
                die(print_r(json_encode($response)));
            }
        } catch (\Exception$th) {
            die(print_r($th->getMessage()));
        }

        //TODO : REGISTRETION :
        $this->data = json_decode($this->data);
        try {
            $this->data->reference = base64_encode($this->data->cin.'/'.uniqid());
            $this->data->password = password_hash($this->data->password, PASSWORD_DEFAULT);
            $user = $this->userModel->register($this->data);
            $token = $this->getToken($user->reference);
            $refrechToken = $this->getRefrechToken($user->reference);
            unset($user->password);

            // !TODO : Store the Refrech Token in DB
            $this->AuthModel->add($refrechToken, $user->reference);
            print_r(json_encode(array(
                'User' => $user,
                'Token' => $token,
            )));
        } catch (\PDOExeption$err) {
            http_response_code(500);
            print_r(json_encode(array('error' => $err->getMessage())));
            die();
        }

    }

    // public function delete($id){
    //     $this->userModel->delete($id);
    // }

    public function Token($id)
    {
        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            $user = $this->userModel->getUserById($id);
            try {
                $this->verifyAuth($headers[1], $user->reference);
                print_r(json_encode(array('message' => 'Authorized', 'reference' => $user->reference)));

            } catch (\Throwable$th) {
                $refresh = $this->AuthModel->currToken($user->reference);
                if ($refresh) {
                    try {
                        $this->verifyAuth($refresh->refreshToken, $user->reference);
                        $token = $this->getToken($user->reference);
                        print_r(json_encode(array(
                            "User" => $user,
                            "newToken" => $token,
                        )));
                    } catch (\Throwable$th) {
                        $this->AuthModel->expiredToken($refresh->id);
                        print_r(json_encode(array(
                            "error" => "expired Session Please Login Again",
                        )));
                    }
                } else {
                    print_r(json_encode(array(
                        "error" => "expired Session Please Login Again no token stored",
                    )));
                }
            }
        } else {
            print_r(json_encode(array(
                "error" => "Login First",
            )));
        }
    }
}
