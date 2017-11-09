<?php
/**
 * mongodb中间类，兼容处理新老mongo驱动
 * 参考文档：http://php.net/manual/zh/set.mongodb.php
 * 使用方式:
 * @author lijie
 */
namespace app\template\lib;
class Mongodb{


    private $mongo;//mongo

    private $isnew = false;//是否是新驱动

    /**
     * 链接mongo
     */
    public function __construct()
    {
        if(!class_exists('MongoClient')){
            $this->mongo = new \MongoDB\Driver\Manager( getMonogoStr() );
            if($this->mongo){
                $this->isnew = true;
            }
        }else{
            $this->mongo = new \MongoClient( getMonogoStr() );
        }
    }


    /**
     * @param $db  数据库名
     * @param $collection  集合名
     * @param $filter  条件 参考：http://php.net/manual/zh/class.mongodb-driver-query.php
     * @param $options 选项 参考同上
     */
    public function findOne($db,$collection,$filter,$options){
        if($this->isnew)
        {//新版本
            $query = new \MongoDB\Driver\Query($filter, $options);
            $rows   = $this->mongo->executeQuery($db.'.'.$collection, $query);

            $rs = [];
            foreach ($rows as $document) {
                $rs[] = (array)$document;
            }
        }
        else{//老版本
            $rs = $this->mongo->selectDB($db)
                ->selectCollection($collection)
                ->findOne(
                    $filter,
                    $options
                );
        }

        return $rs;
    }







}