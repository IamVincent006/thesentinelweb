<?php
class Model extends Select {

	
	 /**
     	 * @desc Add join tables
     	 * @param array $joins array of Join
     	 */
	
	public function show_records(array $columns, $tableName, Query $condition = null, array $sort = null, $start = 0, $limit = -1, array $groupFields = null) {



		$select = new Select();
		$select->add_fields($columns);
		$select->set_table_name($tableName);
		
		if ($condition != null) {
		    $select->set_condition($condition);
		}
		
		if ($sort != null && count($sort) > 0) {
		    $select->add_sorts($sort);
		}
		$select->set_start($start);
		$select->set_limit($limit);
		
		if ($groupFields != null && count($groupFields) > 0) {
		    $select->add_groups($groupFields);
		}
		return $this->select($select);

	}

	public function insert_records() {


	
	}

	public function update_records() {

	}

		
}

?>
