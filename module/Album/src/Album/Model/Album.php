<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 namespace Album\Model;
 
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 class Album implements InputFilterAwareInterface
 {
     public $id;
     public $nazwa;
     public $autor;
     public $wydawnictwo;
     public $cena;
     public $data;
     public $Rodzaj_ksi±¿ki;
     protected $inputFilter;

     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->nazwa = (!empty($data['nazwa'])) ? $data['nazwa'] : null;
         $this->autor  = (!empty($data['autor'])) ? $data['autor'] : null;
         $this->wydawnictwo  = (!empty($data['wydawnictwo'])) ? $data['wydawnictwo'] : null;
         $this->cena  = (!empty($data['cena'])) ? $data['cena'] : null;
         $this->data  = (!empty($data['data'])) ? $data['data'] : null;
         $this->Rodzaj_ksi±¿ki  = (!empty($data['Rodzaj_ksi±¿ki'])) ? $data['Rodzaj_ksi±¿ki'] : null;
     }
     
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
 
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'nazwa',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'title',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }
     