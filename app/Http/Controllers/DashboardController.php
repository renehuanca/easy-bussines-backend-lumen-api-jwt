<?php

namespace App\Http\Controllers;

use App\Sale;
use Carbon\Carbon;
use Exception;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get card EARNINGS(MONTHLY) this month.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function monthlyEarning()
    {
        $current_month = date('m');
        $current_year = date('Y');
        try {
            $sum = Sale::select('sales.total')
                ->whereMonth('sales.created_at','=', $current_month)
                ->whereYear('sales.created_at','=', $current_year)
                ->where('sales.is_deleted','=', 0)
                ->sum('sales.total');

            return response()->json(['monthly_earning' =>  $sum], 200);
        } catch ( Exception $error ) {

            return response()->json(['message' => 'earnings monthly not found!'], 404);
        }
    }

    /**
     * Get card EARNINGS(ANNUAL) this year.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function annualEarning()
    {
        $current_year = date('Y');
        try {
            $sum = Sale::select('sales.total')
                ->whereYear('sales.created_at','=', $current_year)
                ->where('sales.is_deleted','=', 0)
                ->sum('sales.total');

            return response()->json(['annual_earning' =>  $sum], 200);
        } catch ( Exception $error ) {

            return response()->json(['message' => 'Earnings Annual not found!', $error], 404);
        }
    }


    /**
     * EARNINGS FOR MONTH.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function earningsPerMonthDiagram(){

        $arrayEarnings = array(
            'enero' => $this->earningsPerMonth(1),
            'febrero' => $this->earningsPerMonth(2),
            'marzo' => $this->earningsPerMonth(3),
            'abril' => $this->earningsPerMonth(4),
            'mayo' => $this->earningsPerMonth(5),
            'junio' => $this->earningsPerMonth(6),
            'julio' => $this->earningsPerMonth(7),
            'agosto' => $this->earningsPerMonth(8),
            'septiembre' => $this->earningsPerMonth(9),
            'octubre' => $this->earningsPerMonth(10),
            'noviembre' => $this->earningsPerMonth(11),
            'diciembre' => $this->earningsPerMonth(12),
        );
        try {


            return response()->json(['earnings_per_month' =>  $arrayEarnings], 200);
        } catch ( Exception $error ) {

            return response()->json(['message' => 'earnings monthly not found!'], 404);
        }
    }

    /**
     * Earning Per month example 10 -> october
     * @param month Number
     *
     */
    private function earningsPerMonth($month)
    {
        $current_year = date('Y');
        $sum = Sale::select('sales.total')
            ->whereMonth('sales.created_at','=', $month)
            ->whereYear('sales.created_at','=', $current_year)
            ->where('sales.is_deleted','=', 0)
            ->sum('sales.total');
        return $sum;
    }



    /**
     * EARNINGS FOR MONTH. - no terminado
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function earningsPerDayThisWeek()
    {
        /*$arrayEarnings = array(
            'lunes' => $this->earningsPerMonth(1),
            'martes' => $this->earningsPerMonth(2),
            'miercoles' => $this->earningsPerMonth(3),
            'jueves' => $this->earningsPerMonth(4),
            'viernes' => $this->earningsPerMonth(5),
            'sabado' => $this->earningsPerMonth(6),
            'domingo' => $this->earningsPerMonth(7)
        );*/

        try {

            $arrayEarnings = $this->earningPerDay(1);

            return response()->json(['earnings_per_week' =>  $arrayEarnings, 'day' => Carbon::now()->day], 200);
        } catch ( Exception $error ) {

            return response()->json(['message' => 'earnings monthly not found!'], 404);
        }
    }

    /**
     * Earning Per month example 10 -> october
     * @param month Number
     *
     */
    private function earningPerDay($day)
    {

        // El problema es obtener el lunes martes ... de esta semanaf
        // Carbon::now()->dayOfWeek    obtiene el numero del dia de la semana 1234567
        $sum = Sale::select('*')
            ->where('sales.is_deleted','=', 0)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            //->where('created_at', Carbon::now()->day(1) dia (lunes)1 de la semana actual)
            ->sum('sales.total');
        return $sum;
    }


}
