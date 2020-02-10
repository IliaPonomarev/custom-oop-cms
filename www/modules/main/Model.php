<?php
namespace modules\main;

use modules\core\MModel;

class Model extends MModel
{

	public function deleteOrderById($id) {
		return $this->DB->query("DELETE FROM orders WHERE order_id = :id", ['id' => $id]);
	}

	public function addOrder($data) {
		return $this->DB->query("INSERT INTO orders (customer_id, order_price) VALUES (:customer_id, :order_price)", [
			'customer_id' => $data['id'],
			'order_price' => $data['summ']
		]);
	}

	public function getCustomers() {
		return $this->DB->query("SELECT * FROM customers");
	}

	public function getOrders() {
		return $this->DB->query("SELECT * FROM orders as ord INNER JOIN customers as cus ON cus.id = ord.customer_id");
	}
	
	public function getOrdersByWeek($weekOrdinal) {
		$orders = $this->getOrders();
		
		if ($weekOrdinal == 'all') {
			return $orders;
		}

		$splitted = [];

		foreach ($orders as $dot) {
			$week = date("W", strtotime($dot['date']));
			$splitted[$week][] = $dot;
		}

		$requestWeek = date("W") - $weekOrdinal;
		$requestWeek = '0' . $requestWeek;

		return $splitted[$requestWeek];
	}
}