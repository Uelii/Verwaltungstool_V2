<?php
namespace App\Http\Controllers;
use App;
use PDF;
use App\Building;

class ReportController extends Controller {

    /*Generate PDF*/
    public function createBuildingsPDF() {

        $buildings = Building::all();

        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML('<h1>Test</h1>');

        //Set Options
        $pdf->setOption('title', 'test.pdf');
        $pdf->setOption('orientation', 'landscape');
        $pdf->setOption('minimum-font-size', 18);

        $pdf = PDF::loadView('pdfs.buildings', array('buildings' => $buildings)); //Es muss zwingend ein array übergeben werden

        /*return $pdf->inline();*/
        return $pdf->stream();

    }
}

