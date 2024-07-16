<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Usuario;

class UserController extends Controller {

    public function index(){
        $usuarios =  Usuario::select()->execute();

        $this->render('usuario', [
            'usuarios' => $usuarios
        ]);
    }

    public function add() {
       $this->render('add');
    }

    public function addAction(){
        $name = filter_input(INPUT_POST,'name');
        $email = filter_input(INPUT_POST,'email');

        if($name && $email){
          $data = Usuario::select()->where('email', $email)->execute();
          if(count($data) === 0) {
            Usuario::insert([
                'nome' => $name,
                'email' => $email
            ])->execute();
            $this->redirect('/usuario');
          }
        } 

        $this->redirect('/new');

    }

    public function edit($args){
        $usuario =  Usuario::select()->find($args['id']);
        $this->render('edit',['usuario' => $usuario]);
    }

    public function editAction($args){
        $name = filter_input(INPUT_POST,'name');
        $email = filter_input(INPUT_POST,'email');

        if($name && $email){

            Usuario::update()
                    ->set('nome', $name)
                    ->set('email', $email)
                    ->where('id', $args['id'])
                    ->execute();

            $this->redirect('/usuario');
        }

        $this->redirect('/usuario/'.$args['id'].'/editar');
    }

    public function del($args){
        Usuario::delete()->where('id', $args['id'])->execute();  
        $this->redirect('/usuario');
    }
}