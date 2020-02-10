document.addEventListener("DOMContentLoaded", function(event) {
	const weeksListEl = document.querySelector('.weeks-list');
	const ordersEl = document.querySelector('.orders');
	const ordersAdminEl = document.querySelector('.admin__orders');
	const addOrderLink = document.querySelector('.add-order');
	const modalEl = document.querySelector('.modal');
	const modalCrossEl = document.querySelector('.modal__cross');


	weeksListEl.addEventListener('change', fetchOrders)


	if (ordersAdminEl) {
		ordersAdminEl.addEventListener('click', clickHandler)
		addOrderLink.addEventListener('click', addOrder)
		modalCrossEl.addEventListener('click', closeModal)
	}

	fetchOrders();


	function openModal() {
		modalEl.classList.add('active')
	}

	function closeModal() {
		modalEl.classList.remove('active')
	}

	function addOrder() {
		openModal()
		const nameEL = document.querySelector('.name');
		const summEl= document.querySelector('.summ');

		document.querySelector('.form').addEventListener('submit', function (event) {
			event.preventDefault();
			const url = '/main/addOrder?async=1';
			const data = {
				'id': nameEL.value,
				'summ': summEl.value
			};

			fetch(url, {
				method: 'POST',
				headers: {
					'Accept': 'application/json, text/plain, */*',
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(data)
			})
				.then(res => res.text())
				.then(res => {
					fetchOrders()
					alert(res)
					closeModal()
					
					nameEL.value = 1
					summEl.value = ''
				})
				.catch(e => console.error(e))
		})
	}

	function clickHandler(event) {
		event.preventDefault()

		if (event.target.classList.contains('order__delete')) {
			const orderId = event.target.closest('.order').dataset.id
			deleteOrderById(orderId)
		}
	}

	function deleteOrderById(id) {
		const url = `/main/deleteOrder?async=1&orderId=${id}`;

		return fetch(url)
			.then(res => res.text())
			.then(res => {
				fetchOrders()
			})
			.catch(e => alert(e))
	}


	function fetchOrders() {
		const url = `/main/ordersByWeek?async=1&weekId=${weeksListEl.value}`;

		return fetch(url)
			.then(res => res.json())
			.then(res => {
				renderOrders(res)
			})
			.catch(e => alert(e))
	}

	function renderOrders(orders) {
		if (ordersAdminEl) {		
			ordersAdminEl.innerHTML = ''
		} else {
			ordersEl.innerHTML = ''
		}
		
		if (orders) {
			let ordersHTML = `<table>
								<thead>
								<tr class="order">
									<th class="order__date">Дата</th>
									<th class="order-date">Заказчики</th>
									<th class="order-date">Общая сумма</th>
									<th class="order-date">${ordersAdminEl ? 'Удалить' : ''}</th>
								</tr>
								</thead>
								<tbody>`
			
			let summ = 0;
			let customers = []
			orders.forEach(order => {
				summ += order.order_price
				customers.push(order.name)
				ordersHTML += `<tr class="order" data-id="${order.order_id}">
									<td class="order__date">${order.date}</td>
									<td class="order__name">${order.name}</td>
									<td class="order__price">${order.order_price} р</td>
									<td class="order__delete">${ordersAdminEl ? 'X' : ''}</td>
								</tr>`
				
				
			})
		
			ordersHTML += `<tbody>
								<tr class="order">
									<th class="order__date"></th>
									<th class="order-date">Заказчики за выбранный период</th>
									<th class="order-date">Итого за выбранный период</th>
									<th class="order-date"></th>
								</tr>
								<tr class="order">
									<td class="order__date"></td>
									<td class="order__name">${customers}</td>
									<td class="order__price">${summ} р</td>
									<td class="order__delete"></td>
								</tr>
							</table>`
							
			if (ordersAdminEl) {
				ordersAdminEl.insertAdjacentHTML('afterBegin', ordersHTML)
			} else {
				ordersEl.insertAdjacentHTML('afterBegin', ordersHTML)
			}
			
		} else {
			if (ordersAdminEl) {
				ordersAdminEl.innerHTML = '<p>Заказов за выбранную неделю нет</p>'
			} else {
				ordersEl.innerHTML = '<p>Заказов за выбранную неделю нет</p>'
			}
			
		}
	}
});

