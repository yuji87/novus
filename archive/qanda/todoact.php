<?php

include_once 'act.php';

// ToDo取得系
define("QUERY_TODO_LIST", "SELECT TODO_ID,USER_ID,TITLE,STATE,REMIND_DATE FROM TODO WHERE USER_ID=:user_id");

// ToDo更新系
define("INSERT_TODO", "INSERT INTO TODO (USER_ID,TITLE,STATE,REMIND_DATE) VALUES (:user_id, :title, 'active', :remind_date)");
define("UPDATE_TODO", "UPDATE TODO SET TITLE=:title,REMIND_DATE=:remind_date WHERE TODO_ID=:todo_id AND USER_ID=:user_id");
define("UPDATE_TODO_STATE", "UPDATE TODO SET STATE=:state WHERE TODO_ID=:todo_id AND USER_ID=:user_id");
define("DELETE_TODO", "DELETE FROM TODO WHERE TODO_ID=:todo_id AND USER_ID=:user_id");

// ToDO関連のクラス
class ToDoAct extends Action
{
	// ToDo一覧取得
	function todlist() {
		$retinfo = array();

		// ToDo情報取得
		$activelist = array();
		$finlist = array();
		$handle = $this->conn->prepare(QUERY_TODO_LIST);
		$handle->bindValue(':user_id', $this->member['USER_ID']);
		$result = $handle->execute();
		if ($result) {
			while ($rec =  $handle->fetch(PDO::FETCH_ASSOC)) {
				switch ($rec['STATE']) {
					case 'active': $activelist[] = $rec; break;
					case 'finish': $finlist[] = $rec; break;
				}
			}
		}
		$retinfo['activelist'] = $activelist;
		$retinfo['finlist'] = $finlist;

		return $retinfo;
	}
	// ToDo登録
	function registToDo($title, $remind_date) {
		$handle = $this->conn->prepare(INSERT_TODO);
		$handle->bindValue(':user_id', $this->member['USER_ID']);
		$handle->bindValue(':title', $title);
		$handle->bindValue(':remind_date', $remind_date);
		$handle->execute();
	}
	// ToDo編集
	function editToDo($todo_id, $title, $remind_date) {
		$handle = $this->conn->prepare(UPDATE_TODO);
		$handle->bindValue(':todo_id', $todo_id);
		$handle->bindValue(':user_id', $this->member['USER_ID']);
		$handle->bindValue(':title', $title);
		$handle->bindValue(':remind_date', $remind_date);
		return $handle->execute();
	}
	// ToDo 状態変更
	function changeStateToDo($todo_id, $state) {
		if ($state != 'active'
			&& $state != 'finish') {
			return;
		}

		$handle = $this->conn->prepare(UPDATE_TODO_STATE);
		$handle->bindValue(':todo_id', $todo_id);
		$handle->bindValue(':user_id', $this->member['USER_ID']);
		$handle->bindValue(':state', $state);
		return $handle->execute();
	}
	// ToDo削除
	function deleteToDo($todo_id) {
		$handle = $this->conn->prepare(DELETE_TODO);
		$handle->bindValue(':todo_id', $todo_id);
		$handle->bindValue(':user_id', $this->member['USER_ID']);
		return $handle->execute();
	}
}

?>
