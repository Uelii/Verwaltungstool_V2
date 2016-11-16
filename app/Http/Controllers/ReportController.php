<?php
namespace App\Http\Controllers;
use App;
use PDF;
use App\Building;

class ReportController extends Controller {

    public function showReportView()
    {
        return view('reports.report');
    }

    /*Generate PDF*/
    public function createBuildingsPDF() {

        $buildings = Building::all();

        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML('<h1>Test</h1>');

        //Set Options
        $pdf->setOption('title', 'test.pdf');
        $pdf->setOption('orientation', 'landscape');
        $pdf->setOption('minimum-font-size', 18);

        $pdf->setOption('footer-center', 'Created on [date]: [time]');
        $pdf->setOption('footer-right', 'Page [sitepage]/[sitepages]');

        $pdf = PDF::loadView('pdfs.buildings', array('buildings' => $buildings)); //Es muss zwingend ein array übergeben werden

        /*return $pdf->inline();*/
        return $pdf->stream();

    }
}

