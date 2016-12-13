<?php
namespace grabem\Http\Controllers;

use Illuminate\Http\Request;
use App;
use PDF;
use grabem\Building;
use grabem\Object;
use grabem\Renter;
use Carbon\Carbon;


class ReportController extends Controller {

    public function createPDF(Request $request){

        if($request->action == 'create_renter_directory'){
            return $this->createRenterDirectoryPDF($request);
        } elseif($request->action == 'create_heat_billing_and_service_charge_statement'){
            return $this->createHeatBillingAndServiceChargeAgreement($request);
        } elseif($request->action == 'create_closing_statement'){
            return $this->createClosingStatement($request);
        }
    }

    /**
     * Display the report view
     *
     * @return \Illuminate\Http\Response
     */
    public function showReportView()
    {
        $buildings = Building::all();

        return view('reports.report', compact('buildings'));
    }

    /*
     * Create renter directory (Mieterspiegel)
     */
    public function createRenterDirectoryPDF(Request $request){
        $building = Building::findOrFail($request->building_id);
        $renter = Renter::all();

        $carbon = Carbon::now();
        $current_date =$carbon->format('Y-d-m');

        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML('<h1></h1>');

        //Set Options
        $pdf->setOption('title', 'renter_directory_' . $current_date . '.pdf');
        $pdf->setOption('orientation', 'landscape');
        $pdf->setOption('minimum-font-size', 18);

        $pdf->setOption('footer-center', 'Created at [date]: [time]');
        $pdf->setOption('footer-right', 'Page [sitepage]/[sitepages]');

        $pdf = PDF::loadView('pdfs.renter_directory', array('building' => $building, 'renter' => $renter)); //Es muss zwingend ein array übergeben werden

        /*return $pdf->inline();*/
        return $pdf->stream();
    }

    /*
     * Create heat billing and service charge agreement (Heizkosten- und Nebenkostenabrechnung)
     */
    public function createHeatBillingAndServiceChargeAgreement(Request $request){

    }

    /*
     * Create closing statement (Jahresendabrechnung)
     */
    public function createClosingStatement(Request $request){

    }

    /*
     * Create building overview
     */
    public function createBuildingsPDF(){

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

