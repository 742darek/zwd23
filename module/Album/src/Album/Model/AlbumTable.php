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
//         $where = new Where();
//         $kolumna = `Rodzaj ksi±¿ki`;
//         $where->like($kolumna,1);
//         $resultSet = $this->tableGateway->select($where);
//         return $resultSet;
         $platform = $this->tableGateway->getAdapter()->getPlatform();
         $select = new Select();
        $select -> from("books");    
        $filterList = array("Rodzaj ksi±¿ki");

        $predicateIn = $platform->quoteIdentifierChain(array('books','1'));
        $predicateIn .= " in (";
        $predicateIn .= $platform->quoteValueList($filterList);
        $predicateIn .= ")";

        $select -> where(array($predicateIn));
        $resultSet = $this ->tableGateway-> selectWith($select);
        return $resultSet;
        
     }
     
     public function nowa()
     {
         
     }


     public function fetchAudio ()
     {  
         $sql = "SELECT * FROM books WHERE `Rodzaj ksi±¿ki` = 1";
         $resultSet = $this->tableGateway->getAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);
         //$resultSet = $result->toArray();
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