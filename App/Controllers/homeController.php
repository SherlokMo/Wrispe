<?php 

namespace App\Controllers;

use Core\Controller;
use App\Models\Post;

class homeController extends Controller{


    public function index()
    {
        $Post = new Post();

        return $this->render('home',['posts'=> $Post->getPosts()]);
    }


}

?>