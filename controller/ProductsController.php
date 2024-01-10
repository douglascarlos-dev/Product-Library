<?php

require_once 'model/productsModel.php';
require_once 'model/photoModel.php';
require_once 'model/videoModel.php';
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductsController {

    public function visualizar() {
        $products = new Products();
        require_once 'view/products_view.php';
    }

    public function new() {
        require_once 'view/products_new.php';
    }

    public function spreadsheet( $download ) {

        if ( $download == "download"){

            $spreadsheet = new Spreadsheet();

            // Set document properties
            $spreadsheet->getProperties()->setCreator('Product Library')
                ->setLastModifiedBy('Product Library')
                ->setTitle('Relatório de Produtos - Product Library');

            $richText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
            $payable = $richText->createTextRun('ID');
            $payable->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getCell('A1')->setValue($richText);

            $richText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
            $payable = $richText2->createTextRun('SKU');
            $payable->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getCell('B1')->setValue($richText2);

            $richText3 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
            $payable = $richText3->createTextRun('DESCRIÇÃO');
            $payable->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getCell('C1')->setValue($richText3);

            $products = new Products();
            $resultado = $products->get_all_products();
            if(count($resultado) >= 1){
                $i = 2;
                foreach($resultado as &$value){
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $value["id"])
                    ->setCellValue('B' . $i, $value["stock_keeping_unit"])
                    ->setCellValue('C' . $i, $value["description"]);
                    $i++;
                }
                
            }

            // Rename worksheet
            $spreadsheet->getActiveSheet()->setTitle('Produtos');

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="produtos-product-library.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        } elseif ( $download == "save") {
            if(isset($_FILES['planilha'])){
                $file_name = $_FILES['planilha']['name'];
                //echo '<br>';
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                //echo '<br>';
                $file_size = $_FILES['planilha']['size'];
                //echo '<br>';
                $file_tmp = $_FILES['planilha']['tmp_name'];
                //echo '<br>';
                $file_type = $_FILES['planilha']['type'];
                //echo '<br>';
                @$file_ext = strtolower(end(explode('.',$_FILES['planilha']['name'])));
                //echo '<br>';
                $extensions = array("xlsx","xlx","csv");
                move_uploaded_file($file_tmp,"spreadsheet/".$file_name);

                $inputFileName = './spreadsheet/produtos-product-library.xlsx';
                $sheetname = 'Produtos';
                /** Create a new Xls Reader  **/
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                /**  Advise the Reader that we only want to load cell data  **/
                $reader->setReadDataOnly(true);
                /**  Advise the Reader of which WorkSheets we want to load  **/
                $reader->setLoadSheetsOnly($sheetname);
                /** Load $inputFileName to a Spreadsheet Object  **/
                //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
                /**  Load $inputFileName to a Spreadsheet Object  **/
                $spreadsheet = $reader->load($inputFileName);
/*
                $worksheetNames = $reader->listWorksheetNames($inputFileName);

                echo '<h3>Worksheet Names</h3>';
                echo '<ol>';
                foreach ($worksheetNames as $worksheetName) {
                    echo '<li>', $worksheetName, '</li>';
                }
                echo '</ol>';
*/
/*
                $worksheetData = $reader->listWorksheetInfo($inputFileName);

                echo '<h3>Worksheet Information</h3>';
                echo '<ol>';
                foreach ($worksheetData as $worksheet) {
                    echo '<li>', $worksheet['worksheetName'], '<br />';
                    echo 'Rows: ', $worksheet['totalRows'],
                        ' Columns: ', $worksheet['totalColumns'], '<br />';
                    echo 'Cell Range: A1:',
                    $worksheet['lastColumnLetter'], $worksheet['totalRows'];
                    echo '</li>';
                }
                echo '</ol>';
*/
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                if (!empty($sheetData)) {
                    $products = new Products();
                    for ($i=1; $i<count($sheetData); $i++) {
                        $products->setId($sheetData[$i][0]);
                        $products->setStockKeepingUnit($sheetData[$i][1]);
                        $products->setDescription($sheetData[$i][2]);
                        if(is_numeric($products->getId())){
                            $products->post_products_id_update();
                        } elseif (($products->getId() == 'C') or ($products->getId() == 'I') or ($products->getId() == '')){
                            $products->products_insert();
                        } else {
                        }
                    }
                }
                unlink($inputFileName);
            }
            require_once 'view/products_spreadsheet.php';

        } else {
            require_once 'view/products_spreadsheet.php';
        }

    }

    public function save() {
        $products = new Products();
        $products->setStockKeepingUnit($_REQUEST['sku']);
        $products->setDescription($_REQUEST['descricao']);
        $products->post_products_new();
        ProductsController::edit($products->getStockKeepingUnit());
    }

    public static function edit( $stock_keeping_unit ) {
        $products = new Products();
        $products->setStockKeepingUnit($stock_keeping_unit);
        $products = $products->products_list();
        $photo = new Photo();
        $photo->setStockKeepingUnit($stock_keeping_unit);
        $photo = $photo->post_photo_list();
        $video = new Video();
        $video->setStockKeepingUnit($stock_keeping_unit);
        $video = $video->post_video_list();
        require_once 'view/products_edit.php';
    }

    public function update( $stock_keeping_unit ) {
        $products = new Products();
        $products->setStockKeepingUnit($stock_keeping_unit);
        $products->setDescription($_REQUEST['descricao']);
        $products->post_products_update();
        ProductsController::edit($products->getStockKeepingUnit());
    }

    public function delete( $stock_keeping_unit ){
        $products = new Products();
        $products->setStockKeepingUnit($stock_keeping_unit);
        $products = $products->products_list();
        $products->post_products_delete();
        ProductsController::visualizar();
    }

    public function search() {
        $products = new Products();
        $products->setDescription($_REQUEST['search']);
        require_once 'view/products_search.php';
    }

}