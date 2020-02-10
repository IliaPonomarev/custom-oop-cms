<div class="container">
	<h2>Заказы по неделям</h2>
	<select name="" id="" class="weeks-list">
		<option value="0">Текущая неделя</option>
		<option value="1">Неделю назад</option>
		<option value="2">2 недели назад</option>
		<option value="3">3 недели назад</option>
		<option value="4">4 недели назад</option>
		<option value="all">Все заказы</option>
	</select>
	<?if(!$vars['admin']):?>
		<a href="/main/export" class="export button" style="float: right">Экспорт заказов</a>
	<?endif?>
	<div class="orders"></div>
	
	<?if($vars['admin']):?>
		<div class="admin">
			<div class="admin__links">
				<a href="/main/export" class="export button">Экспорт заказов</a>
				<a href="#" class="add-order button">Добавить заказ</a>
			</div>
			
			<div class="admin__orders"></div>
		</div>
		
	<?endif?>

	<div class="modal">
		<div class="modal__content">
			<div class="modal__cross"></div>
			<form action="/main/addOrder" class="form">
				<select name="name" id="" value="" class="name">
					<?foreach($vars['customers'] as $customer):?>
						<option value="<?=$customer['id']?>"><?=$customer['name']?></option>
					<?endforeach?>
				</select>
				<input type="number" name="summ" class="summ" value="" placeholder="Цена" required>
				<input type="submit" value="Создать заказ">
			</form>
		</div>
	</div>
</div>