<?php
namespace immogate\Http\Controllers;

use Illuminate\Http\Request;
use App;
use PDF;
use immogate\Building;
use immogate\Object;
use immogate\Renter;
use immogate\Payment;
use immogate\Invoice;
use Carbon\Carbon;
use DB;


class ReportController extends Controller {

    public function createPDF(Request $request){

        if($request->action == 'create_renter_directory'){
            return $this->createRenterDirectoryPDF($request);
        } elseif($request->action == 'create_heat_and_ancillary_cost_billing'){
            return $this->createHeatAndAncillaryCostBilling($request);
        } elseif($request->action == 'create_balance_sheet'){
            return $this->createBalanceSheet($request);
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

        /*Validate Input*/
        $this->validate($request, [
            'building_id' => 'required',
        ]);

        $building = Building::findOrFail($request->building_id);
        $objects = Object::with('building')->where('building_id', '=', $request->building_id)->get();

        $carbon = Carbon::now();
        $current_date = $carbon->format('Y-m-d');

        foreach($objects as $object){
            $object_id_array[] = $object->id;
        }

        /*If building has no objects, set array[0] to zero*/
        if(empty($object_id_array)){
            $object_id_array[] = 0;
        }

        $renter = Renter::with('object')
            ->whereIn('object_id', $object_id_array)
            ->where('is_active', '=', 1)
            ->get();

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
            'renter_collection' => $renter
        )); //Es muss zwingend ein array übergeben werden

        return $pdf->stream();
    }

    /*
     * Create heat and ancillary cost billing (Heizkosten- und Nebenkostenabrechnung)
     */
    public function createHeatAndAncillaryCostBilling(Request $request){

        /*Validate Input*/
        $this->validate($request, [
            'building_id' => 'required',
            'start_date' => 'required|date|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date|before:tomorrow'
        ]);

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

        $total_other_cost = DB::table('invoices')
            ->where('invoice_type', '=', 'Other')
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
        $current_date =$carbon->format('Y-m-d');

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
            'total_other_cost' => $total_other_cost,
            'total_ancillary_cost' => $total_ancillary_cost,
            'start_date' => $start_date,
            'end_date' => $end_date
        )); //Es muss zwingend ein array übergeben werden

        return $pdf->stream();
    }

    /*
     * Create Balance Sheet (Einnahmen vs. Ausgaben)
     */
    public function createBalanceSheet(Request $request){

        /*Validate Input*/
        $this->validate($request, [
            'building_id' => 'required',
        ]);

        $carbon_start = new Carbon('first day of january');
        $start_date = $carbon_start->format('Y-m-d');
        $carbon_end = new Carbon('last day of december');
        $end_date = $carbon_end->format('Y-m-d');
        $building = Building::findOrFail($request->building_id);
        $objects = $building->objects;

        foreach($objects as $object){
            $object_id_array[] = $object->id;
        }

        /*If building has no objects, set array[0] to zero*/
        if(empty($object_id_array)){
            $object_id_array[] = 0;
        }

        $renter_collection = Renter::with('object')
            ->whereIn('object_id', $object_id_array)
            ->select('id')
            ->get();

        foreach($renter_collection as $renter){
            $renter_id_array[] = $renter->id;
        }

        /*If renter has no payments, set array[0] to zero*/
        if(empty($renter_id_array)){
            $renter_id_array[] = 0;
        }

        $total_rent_earnings  = DB::table('payments')
            ->where('amount_paid', '!=', '0.00')
            ->whereIn('renter_id', $renter_id_array)
            ->get()
            ->sum('amount_paid');

        $total_heat_cost = DB::table('invoices')
            ->where('invoice_type', '=', 'Oil')
            ->whereBetween('invoice_date', [$start_date, $end_date])
            ->whereIn('object_id', $object_id_array)
            ->get()
            ->sum('amount');

        $total_repair_cost = DB::table('invoices')
            ->where('invoice_type', '=', 'Repair')
            ->whereBetween('invoice_date', [$start_date, $end_date])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get()
            ->sum('amount');

        $total_water_cost = DB::table('invoices')
            ->where('invoice_type', '=', 'Water')
            ->whereBetween('invoice_date', [$start_date, $end_date])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get()
            ->sum('amount');

        $total_power_cost = DB::table('invoices')
            ->where('invoice_type', '=', 'Power')
            ->whereBetween('invoice_date', [$start_date, $end_date])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get()
            ->sum('amount');

        $total_caretaker_cost = DB::table('invoices')
            ->where('invoice_type', '=', 'Caretaker')
            ->whereBetween('invoice_date', [$start_date, $end_date])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get()
            ->sum('amount');

        $total_other_cost = DB::table('invoices')
            ->where('invoice_type', '=', 'Other')
            ->whereBetween('invoice_date', [$start_date, $end_date ])
            ->whereIn('object_id', $object_id_array)
            ->orderBy('invoice_date', 'asc')
            ->get()
            ->sum('amount');

        $total_cost = $total_heat_cost+$total_repair_cost+$total_water_cost+$total_power_cost+$total_caretaker_cost+$total_other_cost;

        $carbon = Carbon::now();
        $current_date = $carbon->format('Y-m-d');

        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML('<h1></h1>');

        //Set Options
        $pdf->setOption('title', 'balanc_sheet_' . $current_date . '.pdf');
        $pdf->setOption('orientation', 'portrait');
        $pdf->setOption('minimum-font-size', 18);

        $pdf->setOption('footer-center', 'Created at [date]: [time]');
        $pdf->setOption('footer-right', 'Page [sitepage]/[sitepages]');

        $pdf = PDF::loadView('pdfs.balance_sheet', array(
            'building' => $building,
            'total_rent_earnings' => $total_rent_earnings,
            'total_heat_cost' => $total_heat_cost,
            'total_repair_cost' => $total_repair_cost,
            'total_water_cost' => $total_water_cost,
            'total_power_cost' => $total_power_cost,
            'total_caretaker_cost' => $total_caretaker_cost,
            'total_other_cost' => $total_other_cost,
            'total_cost' => $total_cost,
            'start_date' => $start_date,
            'end_date' => $end_date
        )); //Es muss zwingend ein array übergeben werden

        return $pdf->stream();

    }
}

