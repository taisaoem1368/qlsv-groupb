<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\disciplinary_information;


class UserController extends Controller
{
    private $file = 'charts-value.json';

	public function getValueCharts()
	{
		$obj_di = new disciplinary_information();
		$chartsValues = $obj_di->getValueCharts();
		$this->wirteToFile($this->file, $chartsValues);
		$chartsValues = $this->readToFile($this->file);
		dd($chartsValues);
	}

	public function wirteToFile($file_name, $object)
	{
		$json_data = json_encode($object, JSON_UNESCAPED_UNICODE);
		file_put_contents('charts-value/'.$file_name, $json_data);	
	}

	/**
     * Đọc mảng object lên từ file Json
     *
     * @return array
     */
	public function readToFile($file_name)
	{
		$json = file_get_contents('charts-value/'.$file_name);
		$obj = json_decode($json, true);
		return $obj;
	}
}
