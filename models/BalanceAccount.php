<?php

class BalanceAccount extends Model{

    public  function  getList($only_published = false){
        $sql = "select * From balance where 1";
        if($only_published){
            $sql .= "and is_published = 1";
        }
        return $this->db->query($sql);
    }

    public function getById($id){
        $id = (int)$id;
        $sql = "select * FROM balance where  id = '{$id}' limit 1";
        $result =$this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function save($data, $files, $id = null ){
        if(!isset($data['title_balance'] )  || !isset($data['data_balance'])){
            return false;
        }

        $name = $files['img_balance']['name'];
        $tmp_name = $_FILES['img_balance']['tmp_name'];
        $uploads_dir = '../webroot/uploads';

        if(!move_uploaded_file($tmp_name,"$uploads_dir/$name")){
            echo "Произошла ошибка загрузки файла!";
        }


        $id = (int)$id;
        $title_balance = $this->db->escape($data['title_balance']);
        $img_balance = $name;
        $data_balance = $this->db->escape($data['data_balance']);
        $is_published = isset($data['is_published']) ? 1 : 0;

        if( !$id){
            $sql = "
                insert into balance
                  set
                    id = '{$id}',
                      title_balance = '{$title_balance}',
                      img_balance = '{$img_balance}',
                      data_balance = '{$data_balance}',
                      is_published = '{$is_published}'
            ";
        }else{
            $sql = "
                update balance
                  set title_balance = '{$title_balance}',
                      img_balance = '{$img_balance}',
                      data_balance = '{$data_balance}',
                      is_published = '{$is_published}'
                  where id = '{$id}'
            ";
        }

        return $this->db->query($sql);
    }

    public function delete($id){
        $id = (int)$id;
        $sql = "delete FROM balance where id={$id}";
        return $this->db->query($sql);
    }
}