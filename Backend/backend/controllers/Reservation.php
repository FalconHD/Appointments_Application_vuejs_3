<?php

require_once '../vendor/autoload.php';
require_once '../vendor/fpdf/fpdf.php';

class Reservation extends Controller
{

    public $data = [];

    public function __construct()
    {
        $this->resModel = $this->model('ReservationModel');
        $this->validator = $this->middleware();
    }

    public function myReservation()
    {
        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        $cin = $this->verifyAuth($headers[1]);
        $cin = $cin->cin;
        if ($headers) {
            try {
                $reservations = $this->resModel->getMyReservations($cin);
                print_r(json_encode($reservations));
            } catch (\Throwable$th) {
                //throw $th;
            }
        }
    }

    public function all()
    {

        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                $info = $this->verifyAuth($headers[1]);
                $all = $this->resModel->getMyReservations($info->reference);
                foreach ($all as $res) {
                    unset($res->password);
                };
                print_r(json_encode($all));
            } catch (\Throwable$th) {
                print_r(json_encode(array(
                    'error' => "Authentication error 💢 ",
                )));
            }
        } else {
            print_r(json_encode(array(
                'error' => "Login first please 💢 ",
            )));
        }

    }

    public function add()
    {
        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                $this->verifyAuth($headers[1]);
                $this->data = json_decode($this->data);
                $Appointment = $this->resModel->checkAppointment($this->data);
                if (!$Appointment) {
                    $result = $this->resModel->add($this->data);
                } else {
                    print_r(json_encode(array('error' => 'appointment already reserved 🙄')));
                    die();
                }
                print_r(json_encode(array(
                    'message' => 'done 📅',
                    'result' => $result,
                )));
            } catch (\Throwable$th) {
                print_r(json_encode(array(
                    'error' => 'auth required'
                )));
            }
        }
    }

    public function delete($id)
    {
        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                $this->verifyAuth($headers[1]);
                $this->resModel->delete($id);
                print_r(json_encode(array(
                    "message" => "deleted 😱",
                )));
            } catch (\Throwable$th) {
                throw $th;
            }
        }
    }

    public function update($id)
    {
        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                $this->data = json_decode($this->data);
                $this->verifyAuth($headers[1]);
                $this->resModel->update($id,$this->data->time);
                print_r(json_encode(array(
                    "message" => "updated 🎃",
                )));
            } catch (\Throwable$th) {
                throw $th;
            }
        }
    }


    public function find()
    {
        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                $this->data = json_decode($this->data);
                $this->verifyAuth($headers[1]);
                $result = $this->resModel->checkDay($this->data);
                print_r(json_encode($result));
            } catch (\Throwable$th) {
                throw $th;
            }
        }
    }

}
