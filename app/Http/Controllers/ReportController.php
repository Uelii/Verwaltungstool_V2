<?php
namespace grabem\Http\Controllers;

use Illuminate\Http\Request;
use App;
use PDF;
use grabem\Building;
use grabem\Object;
use grabem\Renter;
use Carbon\Carbon;
use DB;


class ReportController extends Controller {

    public function createPDF(Request $request){

        if($request->action == 'create_renter_directory'){
            return $this->createRenterDirectoryPDF($request);
        } elseif($request->action == 'create_heat_and_ancillary_cost_billing'){
            return $this->createHeatAndAncillaryCostBilling($request);
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
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $renter = DB::table('renter')
            ->whereBetween('end_of_contract', [$start_date, $end_date ])
            ->get();

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

        $pdf = PDF::loadView('pdfs.renter_directory', array(
            'building' => $building,
            'renter' => $renter,
            'start_date' => $start_date,
            'end_date' => $end_date
        )); //Es muss zwingend ein array übergeben werden

        return $pdf->stream();
    }

    /*
     * Create heat and ancillary cost billing (Heizkosten- und Nebenkostenabrechnung)
     */
    public function createHeatAndAncillaryCostBilling(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $building = Building::findOrFail($request->building_id);
        $objects = $building->objects;

        foreach($objects as $object){
            $object_id_array[] = $object->id;
        }

        /*If building has no objects, set array[0] to zero*/
        if(empty($object_id_array)){
            $object_id_array[] = 0;
        }

        $heat_invoices = DB::table('invoices')
            ->where('invoice_type', '=', 'Oil')
            ->whereBetween('invoice_date', [$start_date, $end_date ])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get();

        $total_heat_cost = DB::table('invoices')
            ->where('invoice_type', '=', 'Oil')
            ->whereBetween('invoice_date', [$start_date, $end_date ])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get()
            ->sum('amount');

        $ancillary_invoices = DB::table('invoices')
            ->where('invoice_type', '!=', 'Oil')
            ->whereBetween('invoice_date', [$start_date, $end_date ])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get();

        $total_repair_cost = DB::table('invoices')
            ->where('invoice_type', '=', 'Repair')
            ->whereBetween('invoice_date', [$start_date, $end_date ])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get()
            ->sum('amount');

        $total_water_cost = DB::table('invoices')
            ->where('invoice_type', '=', 'Water')
            ->whereBetween('invoice_date', [$start_date, $end_date ])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get()
            ->sum('amount');

        $total_power_cost = DB::table('invoices')
            ->where('invoice_type', '=', 'Power')
            ->whereBetween('invoice_date', [$start_date, $end_date ])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get()
            ->sum('amount');

        $total_caretaker_cost = DB::table('invoices')
            ->where('invoice_type', '=', 'Caretaker')
            ->whereBetween('invoice_date', [$start_date, $end_date ])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get()
            ->sum('amount');

        $total_ancillary_cost  = DB::table('invoices')
            ->where('invoice_type', '!=', 'Oil')
            ->whereBetween('invoice_date', [$start_date, $end_date ])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get()
            ->sum('amount');

        $carbon = Carbon::now();
        $current_date =$carbon->format('Y-d-m');

        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML('<h1></h1>');

        //Set Options
        $pdf->setOption('title', 'heat_and_ancillary_cost_billing_' . $current_date . '.pdf');
        $pdf->setOption('orientation', 'landscape');
        $pdf->setOption('minimum-font-size', 18);

        $pdf->setOption('footer-center', 'Created at [date]: [time]');
        $pdf->setOption('footer-right', 'Page [sitepage]/[sitepages]');

        $pdf = PDF::loadView('pdfs.heat_and_ancillary_cost_billing', array(
            'building' => $building,
            'heat_invoices' => $heat_invoices,
            'total_heat_cost' => $total_heat_cost,
            'ancillary_invoices' => $ancillary_invoices,
            'total_repair_cost' => $total_repair_cost,
            'total_water_cost' => $total_water_cost,
            'total_power_cost' => $total_power_cost,
            'total_caretaker_cost' => $total_caretaker_cost,
            'total_ancillary_cost' => $total_ancillary_cost,
            'start_date' => $start_date,
            'end_date' => $end_date
        )); //Es muss zwingend ein array übergeben werden

        return $pdf->stream();
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

