<?php

class Mysql {

    private $_db = null;

    public function __construct()
    {
        $this->_db = mysqli_connect("39.106.203.45","location","cBrh77FdL65h4r75");
        mysqli_select_db($this->_db,'location');
    }

    public function insert($data)
    {
        $sql = 'INSERT INTO `visit`(`track_id`,`ip`,`user_agent`,`create_time`) VALUES('.$data['track_id'].','.$data['ip'].',\''.$data['user_agent'].'\','.$data['create_time'].')';
        $res = mysqli_query($this->_db,$sql);
        if($res){
            return mysqli_insert_id($this->_db);
        }
        return false;
    }

    public function update($id,$data)
    {
        $str = '';
        foreach($data as $key=>$value){
            $str .= $key . ' = \'' . $value .'\' ';
        }
        $sql = 'UPDATE `visit` SET '.$str .' WHERE `id` = '.$id;
        $res = mysqli_query($this->_db,$sql);
        if($res !== false){
            return true;
        }
        return false;
    }

    public function insertTrack($data)
    {
        $sql = 'INSERT INTO `track`(`user_id`,`remarks`,`create_time`) VALUES('.$data['user_id'].',\''.$data['remarks'].'\','.$data['create_time'].')';
//        print_r($sql);die;
        $res = mysqli_query($this->_db,$sql);
        if($res){
            return mysqli_insert_id($this->_db);
        }
        return false;
    }

    public function getOneTrack($id)
    {
        $sql = 'SELECT * FROM `visit` WHERE `id` = ' .$id;
//        print_r($sql);die;
        $res = mysqli_query($this->_db,$sql);
        return mysqli_fetch_assoc($res);
    }

    public function getAllTrack($id)
    {
        $sql = 'SELECT * FROM `visit` WHERE `track_id` = ' .$id .' ORDER BY `id` desc';
//        print_r($sql);die;
        $res = mysqli_query($this->_db,$sql);
        return mysqli_fetch_all($res,MYSQLI_ASSOC);
    }


    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        mysqli_close($this->_db);
    }


}

?>