<div id="result"></div>

<form id="addtask" class="form-inline">
	<div class="form-group col-lg-8">
		<input type="text" name="task" id="task" class="form-control" placeholder="Добавьте новую задачу" required />
	</div>
	<div class="input-group col-lg-2">
		<input type="text" name="deadline" id="datepicker" class="form-control" placeholder="гг-мм-дд" required />
		<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-primary" name="addtask">Добавить задачу</button>
	</div>
</form>

<div id="completed"></div>