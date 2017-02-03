<?php
include_once('../includes/connect.php');
	
	$pdo=Tools::connect();
	$tasks='create table Tasks(id int not null auto_increment primary key,
		task varchar(1024) not null,
		deadline date,
		status boolean default 0)default charset="utf8"';

	$comments='create table Comments(id int not null auto_increment primary key,
		parentid int,
		foreign key(parentid) references Tasks(id) on update cascade,
		name varchar(128),
		comment varchar(1024),
		date datetime
		)default charset="utf8"';

		$pdo->exec($tasks);
		$pdo->exec($comments);
?>