<?php
class ReservationModel
{
    private $db;
    public function __construct()
    {
        $this->db = new DB();
    }

    public function getMyReservations($user)
    {
        $this->db->query("SELECT * FROM reservation r,user u WHERE :user=r.user AND r.user=u.reference ORDER BY  created_At DESC");

        $this->db->bind(':user', $user);
        return $this->db->all();
    }

    public function checkAppointment($data)
    {
        $this->db->query("SELECT * FROM reservation WHERE user = :user && time=:time && day=:day");
        $this->db->bind(':user', $data->user);
        $this->db->bind(':time', $data->time);
        $this->db->bind(':day', $data->day);
        return $this->db->all();
    }
    public function checkDay($data)
    {
        $this->db->query("SELECT * FROM reservation WHERE day=:day");
        $this->db->bind(':day', $data->day);
        return $this->db->all();
    }
    public function getReservations()
    {
        $this->db->query("SELECT * FROM reservation");
        return $this->db->all();
    }

    public function getReservationByInfos($data)
    {
        $this->db->query("SELECT * FROM
            reservation WHERE user=:user && time=:time && day=:day");
        $this->db->bind(':user', $data->user);
        $this->db->bind(':time', $data->time);
        $this->db->bind(':day', $data->day);
        return $this->db->single();
    }

    public function add($data)
    {
        try {
            $this->db->query("INSERT INTO
            reservation
        SET
            user = :user,
            time = :time,
            day = :day
        ");
            $this->db->bind(':user', $data->user);
            $this->db->bind(':time', $data->time);
            $this->db->bind(':day', $data->day);
            $this->db->single();
            return $this->getReservationByInfos($data);
        } catch (\PDOExeption$err) {
            return $err->getMessage();
            die();
        }
        return true;
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM reservation WHERE id=:id');
        $this->db->bind(':id', $id);
        $this->db->execute();
    }

    public function update($id,$time)
    {
        $this->db->query('UPDATE reservation SET time=:time WHERE id=:id');
        $this->db->bind(':id', $id);
        $this->db->bind(':time', $time);
        $this->db->execute();
    }


}
