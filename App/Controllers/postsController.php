<?php 

namespace App\Controllers;

use App\Applecation;
use Core\Controller;
use App\Models\Post;

class postsController extends Controller{


    public function newPost()
    {
        $Post = new Post();
        
        $Post->loadData(Applecation::$app->request->getBody());
        if($Post->validate() && $Post->addPost())
        {
            return Applecation::$app->response->getJson(['ok'=>1,'message'=>"Your story had been added succesfully."]);
        }

        return Applecation::$app->response->getJson(['ok'=>0,'message'=>$Post->firstError()]);


    }


}

?>