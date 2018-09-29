<?php
/**
 * Created by PhpStorm.
 * User: Kevinsa
 * Date: 2018/9/28
 * Time: 下午7:45
 */

class ThinkTest{
    private $options = array('order'=>array('id'));

    private function order($field,$order = null){
        if(empty($field)) {
            return $this;
        }
        if(is_string($field)) {
            $field = $this->options['via'] . '.' . $field;
        }
        if(is_array($field)){
            $this->options['order'] = array_merge($this->options['order'], $field);
        } else {
            $this->options['order'][] = $field;
        }
        return $this;
    }

    public function MysqlDb() {
        $id = 2;
        $order = implode("|",$this->options['order']);
        var_dump($order);
        //$order = 'id | updatexml(0,concat(0xa,user()),0)';
        $dbh = new PDO('mysql:dbname=test;host=127.0.0.1;','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        try {
            $link = $dbh -> prepare("select * from test where id =:id order by " . $order);
            $link->bindParam(':id',$id,PDO::PARAM_INT);
            $link->execute();
            //var_dump($link);
            while($row = $link -> fetch(PDO::FETCH_ASSOC)) {
                var_Dump($row);
            }
        } catch (\PDOException $e) {
            var_dump($e);
        }
    }
    /**
     * ThinkPHP order by 预编译sql语句拼接注入
     * @version 5.1.22
     */
    public function OrderTest() {
        //$field = array(' updatexml(0,concat(0xa,user()),0)');
        $field = $_GET['filed'];
        $this->order($field);
        $this->MysqlDb();

    }
}

$a = new ThinkTest();
$a->OrderTest();