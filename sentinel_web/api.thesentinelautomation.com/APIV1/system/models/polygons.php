<?php
class Polygons extends Model {
 	
	private $tableName;
	private $model;
	
	public function __construct() {
	    $this->model     = new Model();	
	    $this->tableName = PREFIX.'polygons';	
	}
	
	public function get_polygons_map_geojson() {				
		$polygons = $this->model->show_records(array("polygonID","polygonName","polygonLatitude","polygonLongitude"),$this->tableName, new QueryField("polygonStatus","=",0),array("polygonName ASC"), null, null, array("polygonName"));
		return $polygons;
	}
	
	public function get_polygons_coordinates($polygonName) {
		$condition = new QueryGroup();
		$condition->and_query(new QueryField("polygonStatus","=",0));
		$condition->and_query(new QueryField("polygonName","=",$polygonName));
		
		$polygons = $this->model->show_records(array("polygonLatitude","polygonLongitude"),$this->tableName, $condition,array("polygonName ASC"));
		$polyRes = array();
		foreach($polygons as $poly) {
			$polyRes[]  = array($poly['polygonLatitude'],$poly['polygonLongitude'],0);
		}
		return $polyRes;
	}	
}
?>