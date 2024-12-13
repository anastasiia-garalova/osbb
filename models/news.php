<?php

class News extends Model{

    public  function  getList($only_published = false){
        $sql = "select * From news where 1";
        if($only_published){
            $sql .= "and is_published = 1";
        }
        return $this->db->query($sql);
    }

    public function getByAlias($alias){
        $alias = $this->db->escape($alias);

        $sql = "select * FROM news where  alias = '{$alias}' limit 1";
        $result =$this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }


    public function getById($id){
        $id = (int)$id;
        $sql = "select * FROM news where  id = '{$id}' limit 1";
        $result =$this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getMenu(){
        $sql = "SELECT id, title, id_category_menu, alias FROM pages ";
        $sel = $this->db->query($sql);
        foreach($sel as $arr){
            if($arr['id'] == $arr['id_category_menu']){
                $menu[] = $this->arrMenu($arr['id'],$sel);
            }
        }
        return $menu;
    }

    public function arrMenu($id, $arr){
        foreach($arr as $val){
            if($id == $val['id_category_menu']){
                $menu[$id][$val['alias']] = $val['title'];
            }
        }
        return $menu[$id];
    }

    public function save($data, $id= null){
        if(!isset($data['alias']) || !isset($data['title_news'] ) || !isset($data['content_news'])
        || !isset($data['data_news'])){
            return false;
        }

        $id = $data['id'];
        $alias = $this->db->escape($data['alias']);
        //$alias .= $id;
        $title_news = $this->db->escape($data['title_news']);
        $data_news = $this->db->escape($data['data_news']);
        $content = $this->db->escape($data['content_news']);
        $is_published = isset($data['is_published']) ? 1 : 0;
        $id_new = "SELECT MAX(id) as id FROM news";
        $id_new = $this->db->query($id_new);
        $alias = $id_new[0]['id'] + 1;
        //echo "<pre>";
        //echo $alias;

        if(!$id){
            $sql = "
                insert into news
                  set alias = '{$alias}',
                      title_news = '{$title_news}',
                      data_news = '{$data_news}',
                      content_news = '{$content}',
                      is_published = '{$is_published}'
            ";
        }else{
            $sql = "
                update news
                  set alias = '{$id}',
                      title_news = '{$title_news}',
                      data_news = '{$data_news}',
                      content_news = '{$content}',
                      is_published = '{$is_published}'
                  where id = '{$id}'
            ";
        }
        return $this->db->query($sql);
    }

    public function delete($id){
        $id = (int)$id;
        $sql = "delete FROM news where id={$id}";
        return $this->db->query($sql);
    }
}

