<?php

namespace app\admin\controller;

class Role extends Loam
{


    public function _beforeIndex($data){
          $this->model('Data')::listGet();
          return $data;
    }

    public function dataIndexGet()
    {

        $data = $this->model()::listGet();

        return json($data);

    }

    public function _afterIndex($data){
        return $data;
    }


    public function access(){

        return view();
    }


}