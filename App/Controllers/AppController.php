<?php 
	namespace App\Controllers;

	//os recursos do miniframework
	use MF\Controller\Action;
	use MF\Model\Container;

	class AppController extends Action{
		public function timeline(){
			$this->validaAutenticacao();

			//recuperacao dos tweets
			$tweet = Container::getModel('Tweet');

			$tweet->__set('id_usuario', $_SESSION['id']);

			//Variáveis de Paginacao - limit
			$total_registros_pagina = 10;
			$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
			$deslocamento = ($pagina -1) * $total_registros_pagina;


/*			$total_registros_pagina = 10;
			$deslocamento = 10;
			$pagina = 2;

			$total_registros_pagina = 10;
			$deslocamento = 20;
			$pagina = 3;*/

			//echo "<br><br><br>Página: $pagina | Total de Registros Por Página: $total_registros_pagina | Deslocamento: $deslocamento";

			// $tweets = $tweet->getAll();
			$tweets = $tweet->getPorPagina($total_registros_pagina, $deslocamento);
			$total_tweets = $tweet->getTotalRegistros();

			$this->view->total_de_paginas = ceil($total_tweets['total'] /$total_registros_pagina);
			$this->view->pagina_ativa = $pagina;

			$this->view->tweets = $tweets;

			$usuario =  Container::getModel('Usuario');
			$usuario->__set('id',$_SESSION['id']);

			$this->view->info_usuario = $usuario->getInfoUsuario();

			$this->view->total_tweets = $usuario->getTotalTweets();

			$this->view->total_seguindo = $usuario->getTotalSeguindo();

			$this->view->total_seguidores = $usuario->getTotalSeguidores();

			$this->render('timeline');
			
		}

		public function tweet(){
			$this->validaAutenticacao();

			$tweet = Container::getModel('Tweet');

			$tweet->__set('tweet', $_POST['tweet']);
			$tweet->__set('id_usuario', $_SESSION['id']);

			$tweet->salvar();

			header('Location: /timeline');
		}


		public function validaAutenticacao(){
			session_start(); //abrir a superglobal session
			if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '' ) {
				header('Location: /?login=erro');
			}
		}

		public function quemSeguir(){
			$this->validaAutenticacao();
			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

			
			$usuarios = array();

			if($pesquisarPor != ''){
				$usuario = Container::getModel('Usuario');
				$usuario->__set('nome',$pesquisarPor);
				$usuario->__set('id',$_SESSION['id']);
				$usuarios = $usuario->getAll();

			}

			$usuario_sessao = Container::getModel('Usuario');
			$usuario_sessao->__set('id',$_SESSION['id']);

			$this->view->info_usuario = $usuario_sessao->getInfoUsuario();

			$this->view->total_tweets = $usuario_sessao->getTotalTweets();

			$this->view->total_seguindo = $usuario_sessao->getTotalSeguindo();

			$this->view->total_seguidores = $usuario_sessao->getTotalSeguidores();

			$this->view->usuarios = $usuarios;

			$this->render('quemSeguir');
		}

		public function acao(){
			$this->validaAutenticacao();
	
			//acao
			$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
			//id_usuario
			$id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';


			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);

			if($acao == 'seguir'){
				$usuario->seguirUsuario($id_usuario_seguindo);
			}elseif ($acao == 'deixar_de_seguir') {
				$usuario->deixarSeguirUsuario($id_usuario_seguindo);
			}

			header('Location: /quem_seguir');
		}

		public function removerTweet(){
			$this->validaAutenticacao();

			$tweet = Container::getModel('Tweet');
			$tweet->__set('id', $_GET['id']);

			$tweet->remover();

			header('Location: /timeline');

		}	

	}


 ?>