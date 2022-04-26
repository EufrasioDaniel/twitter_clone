<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use App\Models\Produto;

//os models
use App\Models\Info;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$produto = Container::getModel('Produto');

		$produtos = $produto->getProdutos();

		$this->view->dados = $produtos;

		$this->render('index', 'layout1');
	}

	public function sobre_nos() {

		$info = Container::getModel('Info');

		$informacoes = $info->getInfo();
		
		$this->view->dados = $informacoes;

		$this->render('sobre_nos', 'layout1');
	}

}


?>