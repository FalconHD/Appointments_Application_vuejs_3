<?php

class UserModel
{
  

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getUsers()
    {
        $this->db->query("SELECT * FROM user");
        return $this->db->all();
    }

    public function getUserById($reference)
    {
        $this->db->query("SELECT * FROM user WHERE reference = :reference");
        $this->db->bind(':reference', $reference);
        return $this->db->single();
    }

    public function getUserByEmail($email)
    {
        $this->db->query("SELECT * FROM user WHERE email = :email");
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    public function getEmailById($reference)
    {
        $this->db->query("SELECT email FROM user WHERE reference = :reference");
        $this->db->bind(':reference', $reference);
        return $this->db->single();
    }


    public function getUserByRole($role)
    {
        echo $role;
        $this->db->query("SELECT * FROM user WHERE role = :role");
        $this->db->bind(':role', $role);
        return $this->db->all();
    }
    public function archiveUser($id)
    {
        echo $role;
        $this->db->query("UPDATE `user` SET `archived`='1' WHERE id=:id");
        $this->db->bind(':id', $id);
        return $this->db->all();
    }

    public function register($data)
    {

        try {
            $this->db->query("INSERT INTO
                user
            SET
                name = :name,
                cin = :cin,
                reference = :reference,
                email = :email,
                password = :password,
                phone = :phone
            ");
            $this->db->bind(':reference', $data->reference);
            $this->db->bind(':name', $data->name);
            $this->db->bind(':cin', $data->cin);
            $this->db->bind(':email', $data->email);
            $this->db->bind(':password', $data->password);
            $this->db->bind(':phone', $data->phone);
            $this->db->single();
        } catch (\PDOExeption $err) {
            return $err->getMessage();
            die();
        }
        return $this->getUserById($data->reference);
    }


    
   
}
