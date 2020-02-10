<?php
namespace modules\main;

use modules\core\MController;

class Controller extends MController
{
    public function action_index()
    {
		$login = "admin";
		$password = "demo";
		$customers = $this->model->getCustomers();
		
		if(isset($_SERVER['PHP_AUTH_USER']) && ($_SERVER['PHP_AUTH_PW']==$password) && (strtolower($_SERVER['PHP_AUTH_USER'])==$login)){
			// авторизован успешно
			$vars = [
				'customers' => $customers,
				'admin' => true
			];

			$this->view->render('Главная страница', $vars);
		} else {
			// если ошибка при авторизации, выводим соответствующие заголовки и сообщение
			header('WWW-Authenticate: Basic realm="Backend"');
			header('HTTP/1.0 401 Unauthorized');
			$this->view->render('Главная страница');
		}
        
	}

	public function action_deleteOrder() {
		$this->model->deleteOrderById($_GET['orderId']);
		echo 'Запись успешно удалена!';
	}
	
	public function action_addOrder() {
		$data = json_decode(file_get_contents("php://input"), true);
		$this->model->addOrder($data);
		echo 'Запись успешно создана!';
	}

	public function action_ordersByWeek() {
		$result = $this->model->getOrdersByWeek($_GET['weekId']);
		echo json_encode($result);
	}

	public function action_export() {
		$login = "admin";
		$password = "admin";
	
		if(isset($_SERVER['PHP_AUTH_USER']) && ($_SERVER['PHP_AUTH_PW']==$password) && (strtolower($_SERVER['PHP_AUTH_USER'])==$login)){
			// авторизован успешно
			$result = $this->model->getOrders();
			file_put_contents('public/orders.json', json_encode($result));
			$this->view->render('Экспорт страница');
		} else {
			// если ошибка при авторизации, выводим соответствующие заголовки и сообщение
			header('WWW-Authenticate: Basic realm="Backend"');
			header('HTTP/1.0 401 Unauthorized');
		}
	}
}