<?php 
	namespace App;

	use MF\Init\Bootstrap;

	class Route extends Bootstrap {
		//Aqui ficou só oque está relacionado ao projeto em questao
		protected function initRoutes() {
			$routes['home'] = array(
				'route' => '/',
				'controller' => 'indexController',
				'action' => 'index'
			);
			$routes['sobre_nos'] = array(
				'route' => '/sobre_nos',
				'controller' => 'indexController',
				'action' => 'sobre_nos'
			);

			$this->setRoutes($routes);
		}
	}
 ?>