<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 namespace Album\Model;

 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Select;
 use Zend\Db\Sql\Sql;
 use Zend\Db\Sql\Where;
 use Zend\Db\Adapter\Adapter;
 use Zend\Db\ResultSet\ResultSet;
 
 class AlbumTable
 {
     protected $tableGateway;
     protected $adapter;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $select = new Select();
         $select->from('books');
         $select->order(array('nazwa'));
         $resultSet = $this->tableGateway->selectWith($select);
         return $resultSet;
     }
     
     public function fetchBooks()
     {
         $sql = "SELECT * FROM books WHERE `Rodzaj ksi±¿ki` = 2"
                 . " ORDER BY nazwa";
         $resultSet = $this->tableGateway->getAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);
         //$resultSet = $result->toArray();
         return $resultSet;
     }


     public function fetchAudio ()
     {  
         $sql = "SELECT * FROM books WHERE `Rodzaj ksi±¿ki` = 1"
                 . " ORDER BY nazwa";
         $resultSet = $this->tableGateway->getAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);
         //$resultSet = $result->toArray();
         return $resultSet;
     }
     
     public function fetchNew ()
     {  
         $sql = "SELECT * FROM books WHERE DATE(data) <= NOW()"
                 . " AND DATE(data) > (NOW() - INTERVAL 14 DAY)"
                 . " ORDER BY nazwa";
         $resultSet = $this->tableGateway->getAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);
         //$resultSet = $result->toArray();
         return $resultSet;
     }
     
     public function fetchFuture ()
     {  
         $sql = "SELECT * FROM books WHERE DATE(data) > NOW()"
                 . " AND DATE(data) < (NOW() + INTERVAL 14 DAY)"
                 . " ORDER BY nazwa";
         $resultSet = $this->tableGateway->getAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);
         //$resultSet = $result->toArray();
         return $resultSet;
     }
     
     public function fetchBest()
     {
         $select = new Select();
         $select->from('books')->where('okazja = 1')->order(array('nazwa'));
         $resultSet = $this->tableGateway->selectWith($select);
         return $resultSet;
     }
     
     public function sortzRows()
     {
         
         $resultSet= $this->order(array('nazwa'));
         return $resultSet;
     }

     public function getAlbum($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveAlbum(Album $album)
     {
         $data = array(
             'artist' => $album->nazwa,
             'title'  => $album->autor,
         );

         $id = (int) $album->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getAlbum($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Album id does not exist');
             }
         }
     }

     public function deleteAlbum($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }