<?php
include_once('connect.php');

//обработка и добавление новой задачи в БД
if(isset($_POST['newtask'])){
	
	//разбираем полученный json через ajax на массив
	$form_data = json_decode($_POST['newtask'], true);
		$task = $form_data['task'];
		$deadline = $form_data['date'];
		$status = false;
	//добавляем задачу в БД
	Tools::connect();
	$task = new Tasks($task, $deadline, $status);	
	$task->intoDb();
}

//обработка и смена состояния задачи в БД, через чекбокс
if(isset($_POST['checked'])){
	$form_data = json_decode($_POST['checked'], true);
	$id = $form_data['check'];
	$status = $form_data['stat'];
	Tools::connect();
	Tasks::updateDb($id, $status);
}

//Получение всех сущестсвующих задач
if(isset($_POST['data'])){
	$task = new Tasks($task, $deadline, $status);	
	$req = $task->fromDb();
	if(!empty($req)){
		foreach($req as $tasks => $val){
			Tasks::getTask($val['id'], $val['task'], $val['deadline'], $val['status']);
		}
	}
}
//класс задач
class Tasks{
	
	protected $task;
	protected $deadline;
	protected $status;
	function __construct($task, $deadline, $status){
		$this->task=htmlspecialchars($task);
		$this->deadline=$deadline;
		$this->status=$status;
	}
	//метод добавления новой задачи в БД
	function intoDb() {
		try	{
			$pdo = Tools::connect();
			$ps = $pdo->prepare('insert into Tasks (task, deadline, status) values (:task, :deadline, :status)');
			$a = array('task'=>$this->task, 'deadline'=>$this->deadline, 'status'=>$this->status);
			$ps->execute($a);			
		}
		catch(PDOException $e) {
			$err=$e->getMessage();
		}
	}
	//метод обновления статуса задачи
	static function updateDb($id, $status) {
		try	{
			$pdo = Tools::connect();
			$ps = $pdo->prepare('UPDATE Tasks SET status = '.$status.' WHERE id = '.$id);
			$ps->execute($a);
		}
		catch(PDOException $e) {
			$err=$e->getMessage();
		}
	}
	//метод выборки отсортированных задач из БД 
	static function fromDb() {
		$tasks = null;
		try {
			$pdo=Tools::connect();
			$ps=$pdo->prepare('SELECT * from Tasks ORDER BY deadline ASC');
			$ps->execute();
			
			while($row=$ps->fetch()) {
				$tasks[] = array('id' => $row['id'], 'task' => $row['task'], 'deadline' => $row['deadline'], 'status' => $row['status']);
			}
			return $tasks;
		}
			catch(PDOException $e) {
			$err=$e->getMessage();
			return false;
		}
	}
	//получение только одной задачи из БД
	static function oneTaskFromDb($id) {
		try {
			$pdo=Tools::connect();
			$ps=$pdo->prepare('SELECT * FROM Tasks WHERE id='.$id);
			$ps->execute();
			$row=$ps->fetch();
			return $row;
		}
			catch(PDOException $e) {
			$err=$e->getMessage();
			return false;
		}
	}
	//метод формирующий отображение задачи на экране
	static function getTask($id, $tasktext, $deadline, $status, $options = 0){
		$tasktext = trim($tasktext);
		echo '<div class="task col-lg-12" id="block'.$id.'">';
		//если статус чекбокса = 0, значит он не выбран
		if($status == 0){
			echo '<input type="checkbox" value="'.$id.'" id="tas'.$id.'" class="check">';	
		} else {
			echo '<input type="checkbox" value="'.$id.'" id="tas'.$id.'" class="check" checked>';
		}
		//условие формирования текста задачи, отдельно для страницы edit 
		if($options == 0){
			echo '<div class="task-item"><a href="?edit='.$id.'" target="_blank">'.$tasktext.'</a></div>';
		} else {
			echo '<div class="task-item">'.$tasktext.'</div>';
		}
		
		echo '<div class="task-date">'.$deadline.'</div>';
		echo '</div>';
		}

}
//класс комментариев
class Comment{
	
	protected $id;
	protected $name;
	protected $comment;
	function __construct($id, $name, $comment){
		$this->id=$id;
		$this->name=$name;
		$this->comment=$comment;
	}
	//метода записи комментария в бд
	function intoDb() {
		try	{
			$pdo = Tools::connect();
			$ps = $pdo->prepare('insert into Comments (parentid, name, comment, date) values (:id, :name, :comment, NOW())');
			$a = array('id'=>$this->id, 'name'=>$this->name, 'comment'=>$this->comment);
			$ps->execute($a);
		}
		catch(PDOException $e) {
			$err=$e->getMessage();
		}
	}
	//получение коммнтариев пренадлижащих к определенной задачи
	static function fromDb($id) {
		$comm = null;
		try {
			$pdo=Tools::connect();
			$ps=$pdo->prepare('SELECT * from Comments WHERE parentid='.$id);
			$ps->execute();
			while($row=$ps->fetch()) {
				$comm[] = array('comment' => $row['comment'], 'name' => $row['name'], 'date' => $row['date']);
			}
			return $comm;
		}
			catch(PDOException $e) {
			$err=$e->getMessage();
			return false;
		}
	}
	
}

?>