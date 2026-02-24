<?php
interface DatabaseClient {
    
    /**
     * @desc Retrieve records from the database.
     *
     * @return multitype:
     */
    public function select(Select $select);
    
    /**
     * @param string $procedureName
     * @param array $input e.g. array(value1, value2) 
     */
    public function call_stored_procedure($procedureName = '', array $input = null);

    /**
     * 
     * @param string $tableName
     * @param array $data containing fields to be set.
     * @throws Exception
     * @return last generated id (when applicable)
     */
    public function insert($tableName='', array $data);

    /**
     * @param string $tableName
     * @param array $data containing fields to be set. 
     * @param Query $conditions limit update to records that satisfy the given condition. Required.
     * @throws Exception
     * @return boolean if successful or not
     */
    public function update($tableName='', array $data, Query $conditions);

    /**
     * 
     * @param string $tablename
     * @param Query $conditions limit update to records that satisfy the given condition. Required.
     * @throws Exception
     * @return boolean
     */
    public function delete($tablename='', Query $conditions);


    /**
     * 
     * @param string $tableName
     * @param array $data containing fields to be set.
     * @throws Exception
     * @return last generated id (when applicable)
     */
    public function replace($tableName='', array $data);

}
?>
