<?php

class ProductsController extends BaseController {

    public function index(){
        
        //  $pm = new ProductModel();
        //  $data = $pm->fetchAll('photos',1);
        //  return json_encode($data);
         $this->view('products');
    }

    public function fetchData(){
         $pm = new ProductModel();
         $conditions['userId']=1;
        //  $conditions['id'] = 13;
        return $pm->fetchAll($conditions);
        // echo json_encode($data);
    }
    public function updateData(){
        $pm = new ProductModel();
        $conditions['id']=12;
        $conditions['userId']=1;
        $updates['year'] = 2018;
        $updates['customer'] = "Rihanna";
        $msg = $pm->update($conditions,$updates);
        echo json_encode($msg);
    }
    public function deleteData(){
        $pm = new ProductModel();
        $conditions['id'] = 14;
        $msg = $pm->delete($conditions);
        echo json_encode($msg);
    }
    public function searchData(){
        $data = fetchData();
        
        echo json_encode($data); 
    }
}