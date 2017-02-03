<?php
include_once('connect.php');
include_once('handler.php');

//Получаем из бд данные про необходимую задачу
$id = $_GET['edit'];
Tools::connect();
$row = Tasks::oneTaskFromDb($id);

echo '<div class="edit-group">';
//формируем и выводим задачи на экран
Tasks::getTask($row['id'], $row['task'], $row['deadline'], $row['status'], 1);

//обработка и добавление нового комментария в бд
if(isset($_POST['submit'])){
	$comment = $_POST['comm'];
	$name = $_POST['name'];
	$comment = new Comment($id, $name, $comment);	
	$comment->intoDb();
}

//если есть комментариии - выводим их на экран
$arr = Comment::fromDb($id);
if(!empty($arr)){
	
	foreach($arr as $row){
	echo '<div class="comment">';
	echo '<div class="comment-name">'.$row['name'].'</div>';
	echo '<div class="comment-date">'.$row['date'].'</div>';
	echo '<div class="comment-block">'.$row['comment'].'</div>';
	echo '</div>';
	}
}
?>
<!-- форма комментариев -->
<div class="form-comment col-lg-12">
<form method="post" class="">
<div class="form-group col-xs-12">
<textarea class="form-control" name="comm" rows="3" placeholder="Оставьте свой комментарий" required></textarea>
</div>
<div class="form-group col-xs-4">
<input type="text" name="name" class="form-control" placeholder="Ваше имя" required />
</div>


<button type="submit" class="btn btn-primary" name="submit">Оставить комментарий</button>
</form>
</div>
</div>
