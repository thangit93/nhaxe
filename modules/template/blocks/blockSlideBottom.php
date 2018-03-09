<?php
namespace module\template\blockSlideBottom;
use BlockGlobal;
use ModelSlide;

include_once DIR_MODULES . 'template/model/slide.php';
class Block extends BlockGlobal {
	public $returnData = array();
	public $lang;
	public $idw;

	public function __construct() {
		parent::__construct();
		$this->setData();
	}

	public function setData() {
		$Obj              = new ModelSlide;
		$data             = $Obj->slide(3);
		$this->returnData = $data;
	}

}
