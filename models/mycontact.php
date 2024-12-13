<?php

class MyContact extends Model{

    public function getList(){
        $sql = "SELECT * FROM сontacts WHERE id=1";
        return $this->db->query($sql);
    }

    public  function save($data){
        $id = 1;



        $address = $data['address'];
        $email = $data['email'];
        $phone = $data['phone'];

        $sql = "
              UPDATE сontacts
                SET adress = '{$address}',
                  email = '{$email}',
                  tel_1 = '{$phone}'
                  where id = '{$id}'
            ";

        return $this->db->query($sql);

    }
}