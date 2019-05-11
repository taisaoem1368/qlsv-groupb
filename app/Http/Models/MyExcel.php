<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\ExcelServiceProvider;


class MyExcel extends Model
{

	/**
     * Create a new file
     * @param                $filename
     * @param  callable|null $callback
     * @return LaravelExcelWriter
     */
	public function create($filename, $callback = null)
	{
		return Excel::create($filename, $callback);
	}


	 /**
     *
     *  Load an existing file
     *
     * @param  string        $file The file we want to load
     * @param  callback|null $callback
     * @param  string|null   $encoding
     * @param  bool          $noBasePath
     * @param  callback|null $callbackConfigReader
     * @return LaravelExcelReader
     */
	public function load($file, $index = 0, $callback = null, $encoding = null, $noBasePath = false, $callbackConfigReader = null)
	{
		return Excel::selectSheetsByIndex($index)->load($file, $callback, $encoding, $noBasePath, $callbackConfigReader);
	}

	//=================================================================================\\
	/**
     * Load file excel chuyển thành mảng
     * string $file_url
     * int $read_row
     * @return array
     */
	public function loadConvertArray($file_url, $read_row = 0, $index = 0)
	{
		return $this->load($file_url, $index)->noHeading()->skip($read_row)->get()->toArray();
	}

	/**
     * Cắt chuỗi kí tự đầu và 2 kí tự cuối
     * @return string
     */
	public function cutFisrtAndLastLetter($string)
	{
		if(strlen($string) == 5)
			return '';
		$kq = mb_substr($string, 1, -2);
		return $kq;
	}

	public function checkExcelInput($array)
	{
		if(count($array[0]) == 20)
			return true;
		return false;
	}

	/**
     * Trả về mảng export ra file Excel
     * table $table : bảng dữ liệu cần xuất từ database ra file excel
     * array $arr1 : Tiêu đề cột, Lưu ý phần tử $arr1[0] luôn là cột số thứ tự
     * array $arr2 : Giá trị phần tử tương ứng với các cột của mảnh arr1
     * @return array
     */
	public function getDataTableToLaravelExcel($table, $arr1, $arr2)
	{
		$result = [];
		foreach ($table as $key => $value) {
			$result[] = $this->getIssueArray($arr1, $arr2, $value, $key+1);
			;
		}
		return $result;
	}

	 /**
     * Đọc phần tử của object $value
     *
     * @return array
     */
	private function getIssueArray($arr1, $arr2, $value, $key)
	{
		$res = [];
		for($i = 1; $i < count($arr1); $i++) {	
			$string = $arr2[$i];
			$temp = $value->$string;
			$res[$arr1[0]] = $key;	
			$res[$arr1[$i]] =  isset($temp) ? $temp : '';	
		}
		return $res;
	}



	public function CustomTableThongTinKyLuatgetDataTableToLaravelExcel($major, $arr1, $arr2)
	{
		$result = [];
		foreach ($major as $key => $value) {
			$result[] = $this->CustomTalbeThongTinKyLuatgetIssueArray($arr1, $arr2, $value, $key);
		}
		return $result;
	}

	private function CustomTalbeThongTinKyLuatgetIssueArray($arr1, $arr2, $value, $key)
	{
		$res = [];
		for($i = 1; $i < count($arr1); $i++) {	
			$string = $arr2[$i];
			$temp = $value->$string;
	
			$res[$arr1[0]] = $key+1;
			if($arr2[$i] == 'student_fullname')
			{
				$res[$arr1[$i]] =  isset($temp) ? $this->getHoTen($temp, $arr1[$i]) : '';	
			} else if($arr2[$i] == 'student_birth')
			{
				$res[$arr1[$i]] =  isset($temp) ? date('d/m/Y', mktime(0,0, $temp)) : '';	
			}
			else {
				$res[$arr1[$i]] =  isset($temp) ? $temp : '';	
			}
		}
		return $res;
	}

	private function getHoTen($string, $ho_or_ten)
	{
		$arr_name = explode(' ', $string);
		if($ho_or_ten == "Họ")
		{
			$first_name = $arr_name;
			unset($first_name[count($first_name) - 1]);
			return count($arr_name) <= 1 ? '' : implode(' ', $first_name);
		}
		return $arr_name[count($arr_name) - 1];
	}

	/**
     * Viết mảng object lên file Json
     *
     * @return void
     */
	public function wirteToFile($file_name, $object)
	{
		$json_data = json_encode($object, JSON_UNESCAPED_UNICODE);

		file_put_contents('excel/json/'.$file_name.'.json', $json_data);	
	}

	/**
     * Đọc mảng object lên từ file Json
     *
     * @return array
     */
	public function readToFile($file_name)
	{
		$json = file_get_contents('excel/json/'.$file_name.'.json');
		$obj = json_decode($json, true);
		return $obj;
	}

	/**
     * Xóa dữ liệu trên file Json
     *
     * @return array
     */
	public function deleteFile($file_name)
	{
		file_put_contents('excel/json/'.$file_name.'.json', '');
	}

	public function deleteItemOnFile($file_name, $id)
	{
		$data = $this->readToFile($file_name);
		unset($data[$id]);
		$this->wirteToFile($file_name, array_merge($data, []));
	}

	/**
	* string $excel_name : tên workbook
	* string $sheet_name : tên worksheet
	* array $table_data : dữ liệu đã được convert từ bảng Database bằng hàm $this->getDataTableToLaravelExcel($table, $arr1, $arr2)
	* string $extension : đuôi file xuất ra
	* array $merge : Tạo mergeCells, dữ liệu từ form nhập từ Client
	* array $table_style : Tạo Table, dữ liệu từ form nhập từ Client
	* @return dowload file excel
	*/
	public function ExportCustumAllTable($excel_name, $sheet_name, $table_data, $extension, $merge, $table_style)
	{
		//$merge[0] = ['from', 'to', 'background', 'color', 'text', 'font', 'size', 'text_align', 'text_align_2'], bold, italic, underline

		//$table_style = ['tb_wirte', 'tb_font', 'tb_background', 'tb_color', 'tb_text_align', 'tb_text_align_2'], tb_bold, tb_italic, tb_underline, tb_even_odd
		
		//Create WorkBook
		$this->create($excel_name, function ($excel) use ($sheet_name, $table_data, $extension, $merge, $table_style) {
			//Create WorkSheet 1
			$excel->sheet($sheet_name, function($sheet) use ($table_data, $extension, $merge, $table_style){
				
				//Table
				$tb_bold = isset($table_style['tb_bold']) ? true : false;
				$tb_italic = isset($table_style['tb_italic']) ? true : false;
				$tb_underline = isset($table_style['tb_underline']) ? true : false;
				$tb_even_odd = isset($table_style['tb_even_odd']) ? true : false;
				$tb_color = substr($table_style['tb_color'], 1);
				$tb_background = substr($table_style['tb_background'], 1);
				if($tb_background == 'fffff')
					$tb_background = '';
				$table_font_size = $table_style['tb_font_size'];
				if($table_font_size <= 0)
					$table_font_size = 5;

				//Style Table
				$styleArray = array(
					'borders' => array(
						'allborders' => array(
							'style' => 'thin',
							//'color' => array('rgb' => $tb_color),
							// 'size' => 1,
						)
					),
					'font' => array(
						'name' => $table_style['tb_font'],
						'bold' => $tb_bold,
						'italic' => $tb_italic,
						'underline' => $tb_underline,
						'size' => $table_font_size,
						'color' => array('rgb' => $tb_color),
					),
					'alignment' => array(
						// 'wrap' => true,
						'horizontal' => $table_style['tb_text_align'],
						'vertical'   => $table_style['tb_text_align_2'],
					),
					'fill' => array(
			            'type' => 'solid',
			            'color' => array('rgb' => $tb_background)
			        )
				);
				//$sheet->getStyle('A3:H5')->applyFromArray($styleArray);
				//Wirte table_data to Excel
				$sheet->fromArray($table_data, null, $table_style['tb_wirte'], true, true)->getStyle(
					$table_style['tb_wirte'].':' . 
					$sheet->getHighestColumn() . 
					$sheet->getHighestRow()
				)->applyFromArray($styleArray);
				$getHighestRow = $sheet->getHighestRow();
				//set Even-Odd Table
				if($tb_even_odd == true)
				{
					$table_start = $table_style['tb_wirte'];
					$i = 0;
					while (true) {
						$table_start = substr($table_start, 1);
						if(is_numeric($table_start))
						{
							$i = $table_start;
							break;
						}
					}

					while ($i <= $getHighestRow) {
						$sheet->row($i, function($row){
							$row->setBackground('#dee2e6');
						});
						$i+=2;
					}
				}


				//All merge cell
				for($i = 0; $i < count($merge); $i++)
				{
					//Create mergeCells
					$sheet->mergeCells($merge[$i]['from'].':'.$merge[$i]['to']);
					$sheet->cell($merge[$i]['from'], function($cell) use ($merge, $i){

						//SetText mergeCells
						$cell->setValue($merge[$i]['text']);

						//Font Style
						$bold = isset($merge[$i]['bold']) ? true : false;
						$italic = isset($merge[$i]['italic']) ? true : false;
						$underline = isset($merge[$i]['underline']) ? true : false;
						if($merge[$i]['size'] <= 0)
							$merge[$i]['size'] = 5;

						$cell->setFont(array(
							'bold' => $bold,
							'italic' => $italic,
							'underline' => $underline,
							'name' => $merge[$i]['font'],
							'size' => $merge[$i]['size'],
						));

						//Font Family | cách 2
						//$cell->setFontFamily();
						//FontSize | cách 2
						//$cell->setFontSize($merge[$i]['size']);

						//Background and Color
						if($merge[$i]['background'] != '#ffffff')
							$cell->setBackground($merge[$i]['background']);
						$cell->setFontColor($merge[$i]['color']);
						//Text-Align- Top - Middle - Bottom
						$cell->setValignment($merge[$i]['text_align_2']);
						//Text-Align- Left - Center - Right
						$cell->setAlignment($merge[$i]['text_align']);

						
						

						//
						// $cells->setBorder(array(
						//     'top'   => array(
						//         'style' => 'solid'
						//     ),
						// ));
					});
				}


			
				//Set kích thước cột tiêu đề của table là 30
				$sheet->setHeight($table_style['tb_wirte'], 30);

			});
		})->download($extension);
	}

	public function ExportTTKLMacDinh($excel_name, $sheet_name, $nam, $hocky, $result, $duoifile)
	{
		
		$this->create($excel_name, function($excel) use ($nam, $hocky, $result, $sheet_name){
			$excel->sheet($sheet_name, function($sheet) use ($nam, $hocky, $result) 
			{
				$hocky == 1 ? $hocky_str = "I" :  $hocky_str = "II";
				$sheet->mergeCells('A1:F1');
				$sheet->mergeCells('A2:F2');
				$sheet->mergeCells('A3:F3');
				$sheet->mergeCells('A4:S4');
				$sheet->mergeCells('A5:S5');
					// $sheet->mergeCells('A6:T6');
				$sheet->cell('A1', function($cell){ 
					$cell->setValue('TRƯỜNG CAO ĐẲNG CÔNG NGHỆ THỦ ĐỨC '); 
					$cell->setAlignment('center');
					$cell->setFontWeight('bold');
					// $cell->setFont(array(
					// 	'italic' => true,
					// ));
				});

				$sheet->cell('A2', function($cell){ 
					$cell->setValue('KHOA CÔNG NGHỆ THÔNG TIN')->setFontWeight('bold'); 
					$cell->setAlignment('center');

				});
				$sheet->cell('A3', function($cell){ 
					$cell->setValue('*********'); 
					$cell->setAlignment('center');
				});
				$sheet->cell('A4', function($cell) use ($hocky_str, $nam){ 
					$cell->setValue('PHẢN HỒI DANH SÁCH HỌC SINH BỊ BUỘC THÔI HỌC - HK' . $hocky_str . ' - NĂM HỌC ' . $nam . '-' . ($nam+1));
					$cell->setFontSize(12);
					$cell->setAlignment('center');
					$cell->setFontFamily('Times New Roman');
					$cell->setFontWeight('bold');
					//$cell->setFontWeight('italic');
					//$cell->setFontWeight('underline');
				});
				$sheet->cell('A5', function($cell){ 
					$cell->setValue('TRÌNH ĐỘ CAO ĐẲNG. KHOA CÔNG NGHỆ THÔNG TIN');
					$cell->setFontSize(12);
					$cell->setAlignment('center');
					$cell->setFontFamily('Times New Roman');
					$cell->setFontWeight('bold');
				});

					// $sheet->cell('A6', function($cell) use ($hocky_str, $nam, $hocky) { 
					// 	$cell->setValue('(Đính kèm Quyết định số         /QĐ-CNTĐ- ĐT ngày         / '.date('m').' /'.date('Y').' về việc buộc thôi học - học kỳ '.$hocky.' năm học '. $nam . '-' . ($nam+1).')');
					// 	$cell->setFontSize(12);
					// 	$cell->setAlignment('center');
					// 	$cell->setFontFamily('Times New Roman');
					// });


				
				$styleArray = array(
					'borders' => array(
						'allborders' => array(
							'style' => \PHPExcel_Style_Border::BORDER_THIN
						)
					),
					'font' => array(
						'name' => 'Calibri',
						// 'size' => 15,
						// 'bold' => true,
						// 'italic' => true,
						// 'underline' => true,
					),
					'alignment' => array(
						//'wrap' => true,
						//'horizontal' => 'center',
						'vertical'   => 'center',
					),
				);



				$sheet->fromArray($result, null, 'A8', true, true)->getStyle(
					'A8:' . 
					$sheet->getHighestColumn() . 
					$sheet->getHighestRow()
				)->applyFromArray($styleArray);

					// $sheet->setColumnFormat(array(
     //                 'K' => '#.###,0#',
     //             	));

				$sheet->row(8, function($row){
						// $row->setBackground('#000000');
						// $row->setFontColor('#db893d');
					$row->setFontWeight('bold');
					$row->setAlignment('center');

				});
				$last_row = $sheet->getHighestRow();

				$sheet->mergeCells('B'.($last_row+3).':J'.($last_row+3));
				$sheet->mergeCells('B'.($last_row+8).':J'.($last_row+8));
				$sheet->mergeCells('K'.($last_row+2).':S'.($last_row+2));
				$sheet->mergeCells('K'.($last_row+3).':S'.($last_row+3));
				$sheet->mergeCells('K'.($last_row+8).':S'.($last_row+8));
				$sheet->cell('B'.($last_row+3), function($cell){ 
					$cell->setValue('Trưởng khoa'); 
					$cell->setAlignment('center');
					$cell->setFontWeight('bold');
					$cell->setFontFamily('Times New Roman');
				});

				$sheet->cell('K'.($last_row+2), function($cell){ 
					$cell->setValue('TP.HCM, ngày '.date('d').' tháng '.date('m').' năm '.date('Y')); 
					$cell->setAlignment('center');
					$cell->setFont(array(
						'italic' => true,
					));
					$cell->setFontFamily('Times New Roman');

				});

				$sheet->cell('K'.($last_row+3), function($cell){ 
					$cell->setValue('Người tổng hợp'); 
					$cell->setAlignment('center');
					$cell->setFontWeight('bold');
					$cell->setFontFamily('Times New Roman');
				});

				$sheet->getStyle('O1:O'.$sheet->getHighestRow())->applyFromArray(array('alignment' => array('wrap' => true)));
				$sheet->getStyle('P1:P'.$sheet->getHighestRow())->applyFromArray(array('alignment' => array('wrap' => true)));
				$sheet->getStyle('R1:R'.$sheet->getHighestRow())->applyFromArray(array('alignment' => array('wrap' => true)));
				$sheet->getStyle('S1:S'.$sheet->getHighestRow())->applyFromArray(array('alignment' => array('wrap' => true)));
				$sheet->getStyle('A8:S8')->applyFromArray(array('alignment' => array('wrap' => true)));
				$sheet->getStyle('A8:A'.$sheet->getHighestRow())->applyFromArray(array('alignment' => array('horizontal' => 'center')));
				$sheet->setHeight(8, 30);//row thứ 8 tăng chiều cao 60
				$sheet->setWidth('A', 5);	
				$sheet->setWidth('B', 15);	
				$sheet->setWidth('C', 12);	
				$sheet->setWidth('D', 7);	
				$sheet->setWidth('E', 12);	
				$sheet->setWidth('F', 10);
				$sheet->setWidth('G', 10);
				$sheet->setWidth('H', 10);
				$sheet->setWidth('I', 24);
				$sheet->setWidth('J', 7);
				$sheet->setWidth('K', 7);
				$sheet->setWidth('L', 7);
				$sheet->setWidth('M', 7);
				$sheet->setWidth('N', 7);
				$sheet->setWidth('O', 15);
				$sheet->setWidth('P', 20);
				$sheet->setWidth('Q', 15);
				$sheet->setWidth('R', 20);
				$sheet->setWidth('S', 25);
			});

		})->download($duoifile);
	}

}