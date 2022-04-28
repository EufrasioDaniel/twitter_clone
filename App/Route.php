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
			
			$this->setRoutes($routes);
		}
	}
 ?>