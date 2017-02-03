//Настройки datepicer: формат даты, минимальная дата начала и максимальная
$(function() {
	$( "#datepicker" ).datepicker({ 
	dateFormat: 'yy-mm-dd', 
	minDate: +1, 
	maxDate: "+1M +10D"
	});
});

//Показать все задачи
function showAllTasks() {
	var req = 0;
	$.ajax({
		url: "includes/handler.php",
		type: "POST",
		data: {data : req},
		dataType: 'html',
		beforeSend: function(){
			//добавляем анимацию в педальку "обновить"
			$('.checknow').html('<span class="glyphicon glyphicon-refresh spin-active"></span>');
		},
		success: function(data){
			$("#completed").html('');
			$("#result").html(data);
			$('#result').append('<div class="clearfix"></div>');
			//получаем все чекбоксы
			var allCheckboxes = $("input:checkbox:enabled");
			var count = Object.keys(allCheckboxes).length;
			//проверяем, если у чекбокса атрибут checked = true, значит перемещаем его в выполненные
			for(var i = 0; i < (count-4); i++){
				if(allCheckboxes[i].checked == true){
					var ch = $(allCheckboxes[i]).val();
					hideSuccesTask(ch, 1);
				}
			}
			$('.checknow').html('<span class="glyphicon glyphicon-refresh"></span>');
		}		
	});
	
}
$(document).ready(showAllTasks());

//Перемещение выполненных задач в выполненные + анимация
//Так же добавил опцию отображения с анимацией и без нее
function hideSuccesTask(check, options = 0){
	if(options == 0){
	$("#block" + check).animate({
		opacity: 0.5}, 600, 
		function(){	
			$("#block" + check + ' a').css('text-decoration', 'line-through');
			$("#completed").append( $("#result #block" + check) );
		});
	} else {
		$("#block" + check + ' a').css('text-decoration', 'line-through');
		$("#block" + check).css('opacity', '0.5');
		$("#completed").append( $("#result #block" + check) );
	}
}
//Возврат из выполненных в невыполненные
function showSuccesTask(check){
	$("#block" + check).animate({
		opacity: 1}, 600, 
		function(){	
			$("#block" + check + ' a').css('text-decoration', 'none');
			$("#result").prepend( $("#completed #block" + check) );
		}); 
}

//Добавление новой задачи через ajax
$(function(){
	$('#addtask').on('submit', function(e){
		e.preventDefault();
		//Получаем значения полей
		var task = $("#task").val();
		var date = $("#datepicker").val();
		
		//формируем json представление данных
		var newtask = {
		task : task,
		date : date
		}
		task = JSON.stringify(newtask);
		$.ajax({
			url: "includes/handler.php",
			type: "POST",
			data: {newtask: task},
			success: function(data){
				showAllTasks();
			}
		});
		//очищаем форму после ввода
		$('#addtask').trigger( 'reset' );
	});	
});

//Смена состояния задачи
$(document).on('change', '.check', function() {
	var check = $(this).val();
	if($("#tas" + check).prop("checked")){
		//если checked - меняем статус на 1 и анимируем блок задачи
		var stat = 1;
		hideSuccesTask(check);
	} else {
		var stat = 0;  
		showSuccesTask(check);
	}
	//формируем json представление данных
	var stat = {
	check : check,
	stat : stat
	}
	changestat = JSON.stringify(stat);

	$.ajax({
		url: "includes/handler.php",
		type: "POST",
		data: {checked: changestat},
		dataType: 'json',
		success: function(json){
			console.log(json);
		}
	});
});