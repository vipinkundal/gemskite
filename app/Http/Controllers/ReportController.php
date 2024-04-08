<?php

namespace App\Http\Controllers;

use App\Models\InwardEntry;
use App\Models\InwardEntryItem;
use App\Models\Ledger;
use App\Models\OutwardEntry;
use App\Models\OutwardEntryItem;
use App\Models\Products;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\SimpleExcel\SimpleExcelWriter;
use PDF;

class ReportController extends Controller
{
    /**
     * Show inward entry page
     *
     * @return mixed
     */
    public function showInwardEntryReport()
    {
        $inward_entry = DB::table('inward_entries as ie')
            ->leftJoin('inward_entry_items as iei', 'iei.inward_entry_id', '=', 'ie.id')
            ->select([
                'ie.id',
                'ie.inbound_date',
                'ie.import_invoice_number',
                'ie.supplier',
                'ie.location',
                'ie.container_number',
                DB::raw('COUNT(iei.id) as total_items'),
            ])
            ->groupBy('ie.id')
            ->get();

        return Inertia::render('Reports/InwardEntryReport', [
            'inward-entry' => $inward_entry,
        ]);
    }

    /**
     * Show outward entry page
     *
     * @return mixed
     */
    public function showOutwardEntryReport()
    {
        $outward_entry = DB::table('outward_entries as oe')
            ->leftJoin('outward_entry_items as oei', 'oei.outward_entry_id', '=', 'oe.id')
            ->select([
                'oe.id',
                'oe.dispatch_time',
                'oe.invoice_number',
                'oe.ship_to_party',
                'oe.bill_to_party',
                'oe.vehicle_number',
                'oe.destination_code',
                'oe.lr_number',
                DB::raw('COUNT(oei.id) as total_items'),
            ])
            ->groupBy('oe.id')
            ->get();

        return Inertia::render('Reports/OutwardEntryReport', [
            'outward-entry' => $outward_entry,
        ]);
    }

    /**
     * Show inward items page
     *
     * @return mixed
     */
    public function showInwardEntryItemsReport(Request $request)
    {
        $inward_entry_items = InwardEntryItem::orderBy('id')->where('inward_entry_id', '=', $request->id)->get();

        return Inertia::render('Reports/InwardEntryItemsReport', [
            'inward-entry-items' => $inward_entry_items,
        ]);
    }

    /**
     * Show outward items page
     *
     * @return mixed
     */
    public function showOutwardEntryItemsReport(Request $request)
    {
        $outward_entry_items = OutwardEntryItem::orderBy('id')->where('outward_entry_id', '=', $request->id)->get();

        return Inertia::render('Reports/OutwardEntryItemsReport', [
            'outward-entry-items' => $outward_entry_items,
        ]);
    }

    /**
     * Inward Entries
     *
     * @return mixed
     */
    public function getInwardEntries(Request $request)
    {
        $query = DB::table('inward_entries as ie');
        $sort_by = 'ie.inbound_date';
        if (! empty($request->sortBy) && 'null' !== $request->sortBy) {
            $sort_by = $request->sortBy;
        }
        $inward_entry = $query
            ->leftJoin('inward_entry_items as iei', 'iei.inward_entry_id', '=', 'ie.id')
            ->select([
                'ie.id',
                'ie.inbound_date',
                'ie.import_invoice_number',
                'ie.supplier',
                'ie.location',
                'ie.container_number',
                DB::raw('COUNT(iei.id) as total_items'),
            ])
            ->groupBy('ie.id')
            ->orderBy($sort_by, 'asc' === $request->sortType ? 'ASC' : 'DESC')
            ->get();

        return response()->json(['success' => [
            'inward_entry' => $inward_entry,
        ]]);
    }

    /**
     * Inward Entries
     *
     * @return mixed
     */
    public function getOutwardEntries(Request $request)
    {
        $query = DB::table('outward_entries as oe');
        $sort_by = 'oe.dispatch_time';
        if (! empty($request->sortBy) && 'null' !== $request->sortBy) {
            $sort_by = $request->sortBy;
        }
        $outward_entry = $query
            ->leftJoin('outward_entry_items as oei', 'oei.outward_entry_id', '=', 'oe.id')
            ->select([
                'oe.id',
                'oe.dispatch_time',
                'oe.invoice_number',
                'oe.ship_to_party',
                'oe.bill_to_party',
                'oe.vehicle_number',
                'oe.destination_code',
                'oe.lr_number',
                DB::raw('COUNT(oei.id) as total_items'),
            ])
            ->groupBy('oe.id')
            ->orderBy($sort_by, 'asc' === $request->sortType ? 'ASC' : 'DESC')
            ->get();

        return response()->json(['success' => [
            'outward_entry' => $outward_entry,
        ]]);
    }

    /**
     * Show stock items page
     *
     * @return mixed
     */
    public function stockItems(Request $request)
    {
        try {
            $products = Products::all();
            $stock = [];
            foreach ($products as $product) {
                $inward_entry = InwardEntryItem::where('sku', $product->sku)->count();
                $outward_entry = OutwardEntryItem::where('sku', $product->sku)->count();
                $qty = $inward_entry - $outward_entry;
                $array = [
                    'id' => $product->id,
                    'sku' => $product->sku,
                    'short_name' => $product->short_name,
                    'model' => $product->model,
                    'description' => $product->description,
                    'color' => $product->color,
                    'marin_code' => $product->marin_code,
                    'type' => $product->type,
                    'fork' => $product->fork,
                    'barcode_color' => $product->barcode_color,
                    'insera_code' => $product->insera_code,
                    'description_on_box' => $product->description_on_box,
                    'QTY' => $qty,
                ];
                array_push($stock, $array);
            }

            return Inertia::render('Reports/StockItemsReport', [
                'stock-data' => $stock,
            ]);
        } catch (Exception $e) {
            Log::error('Error : '.$e->getMessage());

            return null;
        }
    }

    /**
     * Export  Data to a CSV file
     */
    public function exportStockToCsv()
    {
        try {
            $products = Products::all();
            $stock = [];
            foreach ($products as $product) {
                $inward_entry = InwardEntryItem::where('sku', $product->sku)->count();
                $outward_entry = OutwardEntryItem::where('sku', $product->sku)->count();
                $qty = $inward_entry - $outward_entry;
                $array = [
                    'sku' => $product->sku,
                    'QTY' => $qty,
                    'short_name' => $product->short_name,
                    'model' => $product->model,
                    'color' => $product->color,
                    'marin_code' => $product->marin_code,
                    'type' => $product->type,
                    'fork' => $product->fork,
                    'barcode_color' => $product->barcode_color,
                    'insera_code' => $product->insera_code,
                    'description_on_box' => $product->description_on_box,
                    'description' => $product->description,

                ];
                array_push($stock, $array);
            }
            $header_row = [
                'Sku',
                'QTY',
                'Name',
                'Model',
                'Color',
                'Marin Code',
                'Type',
                'Fork',
                'Barcode Color',
                'Insera Code',
                'Box Description',
                'Description',
            ];

            SimpleExcelWriter::streamDownload('export.csv')
                ->noHeaderRow()
                ->addRow($header_row)
                ->addRows($stock)
                ->toBrowser();
        } catch (Exception $e) {
            Log::error('Error : '.$e->getMessage());

            return null;
        }
    }

    /**
     * Show stock details
     *
     * @return mixed
     */
    public function stockItemsDetails(Request $request)
    {
        try {
            $array =
            DB::table('inward_entry_items as iei')->where('sku', $request->sku)
                ->join('inward_entries as ie', 'ie.id', '=', 'iei.inward_entry_id')
                ->select(
                    'iei.inward_entry_id as inward_entry_id',
                    DB::raw('COUNT(iei.inward_entry_id) as total_items'),
                )->groupBy('inward_entry_id')
                ->get();

            $array2 =
            DB::table('outward_entry_items as oei')->where('sku', $request->sku)
                ->join('outward_entries as oe', 'oe.id', '=', 'oei.outward_entry_id')
                ->select(
                    'oei.outward_entry_id as outward_entry_id',
                    DB::raw('COUNT(oei.outward_entry_id) as total_items'),
                )->groupBy('outward_entry_id')
                ->get();
            $new_array = [];
            $new_array2 = [];
            if ($array) {
                foreach ($array as $item) {
                    $inward_entry = InwardEntry::where('id', $item->inward_entry_id)->first()->toArray();
                    $filter_array = [
                        'import_invoice_number' => $inward_entry['import_invoice_number'],
                        'QTY' => $item->total_items,
                        'supplier' => $inward_entry['supplier'],
                        'location' => $inward_entry['location'],
                        'container_number' => $inward_entry['container_number'],
                        'inbound_date' => $inward_entry['inbound_date'],

                    ];
                    array_push($new_array, $filter_array);
                }

            }

            if ($array2) {
                foreach ($array2 as $item) {
                    $outward_entry = OutwardEntry::where('id', $item->outward_entry_id)->first()->toArray();
                    $filter_array2 = [
                        'dispatch_time' => $outward_entry['dispatch_time'],
                        'QTY' => $item->total_items,
                        'invoice_number' => $outward_entry['invoice_number'],
                        'ship_to_party' => $outward_entry['ship_to_party'],
                        'bill_to_party' => $outward_entry['bill_to_party'],
                        'vehicle_number' => $outward_entry['vehicle_number'],
                        'lr_number' => $outward_entry['lr_number'],
                        'destination_code' => $outward_entry['destination_code'],

                    ];
                    array_push($new_array2, $filter_array2);
                }

            }
        } catch (Exception $e) {
            Log::error('Error : '.$e->getMessage());
        }

        return Inertia::render('Reports/StockItemsDetails', [
            'inward-entry' => $new_array,
            'outward-entry' => $new_array2,
        ]);
    }


    /**
     * Show stock items page
     *
     * @return mixed
     */
    public function ledgerItems(Request $request)
    {
        try {
            // $products = Products::all();
            // $ledger = [];
            // foreach ($products as $product) {
            //     $inward_entry = InwardEntryItem::where('sku', $product->sku)->count();
            //     $outward_entry = OutwardEntryItem::where('sku', $product->sku)->count();
            //     $qty = $inward_entry - $outward_entry;
            //     $array = [
            //         'id' => $product->id,
            //         'sku' => $product->sku,
            //         'short_name' => $product->short_name,
            //         'model' => $product->model,
            //         'description' => $product->description,
            //         'color' => $product->color,
            //         'marin_code' => $product->marin_code,
            //         'type' => $product->type,
            //         'fork' => $product->fork,
            //         'barcode_color' => $product->barcode_color,
            //         'insera_code' => $product->insera_code,
            //         'description_on_box' => $product->description_on_box,
            //         'QTY' => $qty,
            //     ];
            //     array_push($ledger, $array);
            // }

            $ledger = Ledger::all();

            return Inertia::render('Reports/LedgerReport', [
                'ledger-data' => $ledger,
            ]);
        } catch (Exception $e) {
            Log::error('Error : '.$e->getMessage());

            return null;
        }
    }

    /**
     * Export  Data to a CSV file
     */
    public function exportLedgerToCsv()
    {
        try {
            $products = Products::all();
            $stock = [];
            foreach ($products as $product) {
                $inward_entry = InwardEntryItem::where('sku', $product->sku)->count();
                $outward_entry = OutwardEntryItem::where('sku', $product->sku)->count();
                $qty = $inward_entry - $outward_entry;
                $array = [
                    'sku' => $product->sku,
                    'QTY' => $qty,
                    'short_name' => $product->short_name,
                    'model' => $product->model,
                    'color' => $product->color,
                    'marin_code' => $product->marin_code,
                    'type' => $product->type,
                    'fork' => $product->fork,
                    'barcode_color' => $product->barcode_color,
                    'insera_code' => $product->insera_code,
                    'description_on_box' => $product->description_on_box,
                    'description' => $product->description,

                ];
                array_push($stock, $array);
            }
            $header_row = [
                'Sku',
                'QTY',
                'Name',
                'Model',
                'Color',
                'Marin Code',
                'Type',
                'Fork',
                'Barcode Color',
                'Insera Code',
                'Box Description',
                'Description',
            ];

            SimpleExcelWriter::streamDownload('export.csv')
                ->noHeaderRow()
                ->addRow($header_row)
                ->addRows($stock)
                ->toBrowser();
        } catch (Exception $e) {
            Log::error('Error : '.$e->getMessage());

            return null;
        }
    }

    /**
     * Show stock details
     *
     * @return mixed
     */
    public function ledgerItemsDetails(Request $request)
    {
        try {
            $array = DB::table('inward_entry_items as iei')->where('sku', $request->sku)
                ->join('inward_entries as ie', 'ie.id', '=', 'iei.inward_entry_id')
                ->select(
                    'iei.inward_entry_id as inward_entry_id',
                    DB::raw('COUNT(iei.inward_entry_id) as total_items'),
                )->groupBy('inward_entry_id')
                ->get();

            $array2 = DB::table('outward_entry_items as oei')->where('sku', $request->sku)
                ->join('outward_entries as oe', 'oe.id', '=', 'oei.outward_entry_id')
                ->select(
                    'oei.outward_entry_id as outward_entry_id',
                    DB::raw('COUNT(oei.outward_entry_id) as total_items'),
                )->groupBy('outward_entry_id')
                ->get();
            $new_array = [];
            $new_array2 = [];
            if ($array) {
                foreach ($array as $item) {
                    $inward_entry = InwardEntry::where('id', $item->inward_entry_id)->first()->toArray();
                    $filter_array = [
                        'import_invoice_number' => $inward_entry['import_invoice_number'],
                        'QTY' => $item->total_items,
                        'supplier' => $inward_entry['supplier'],
                        'location' => $inward_entry['location'],
                        'container_number' => $inward_entry['container_number'],
                        'inbound_date' => $inward_entry['inbound_date'],
                    ];
                    array_push($new_array, $filter_array);
                }

            }

            if ($array2) {
                foreach ($array2 as $item) {
                    $outward_entry = OutwardEntry::where('id', $item->outward_entry_id)->first()->toArray();
                    $filter_array2 = [
                        'dispatch_time' => $outward_entry['dispatch_time'],
                        'QTY' => $item->total_items,
                        'invoice_number' => $outward_entry['invoice_number'],
                        'ship_to_party' => $outward_entry['ship_to_party'],
                        'bill_to_party' => $outward_entry['bill_to_party'],
                        'vehicle_number' => $outward_entry['vehicle_number'],
                        'lr_number' => $outward_entry['lr_number'],
                        'destination_code' => $outward_entry['destination_code'],

                    ];
                    array_push($new_array2, $filter_array2);
                }

            }
        } catch (Exception $e) {
            Log::error('Error : '.$e->getMessage());
        }

        return Inertia::render('Reports/StockItemsDetails', [
            'inward-entry' => $new_array,
            'outward-entry' => $new_array2,
        ]);
    }


    /**
     * Convert number to words
     *
     * @param int $num
     * @return string
     */
    public function numberTowords(int $num): string
    {
        $ones = [
            0 => 'ZERO',
            1 => 'ONE',
            2 => 'TWO',
            3 => 'THREE',
            4 => 'FOUR',
            5 => 'FIVE',
            6 => 'SIX',
            7 => 'SEVEN',
            8 => 'EIGHT',
            9 => 'NINE',
            10 => 'TEN',
            11 => 'ELEVEN',
            12 => 'TWELVE',
            13 => 'THIRTEEN',
            14 => 'FOURTEEN',
            15 => 'FIFTEEN',
            16 => 'SIXTEEN',
            17 => 'SEVENTEEN',
            18 => 'EIGHTEEN',
            19 => 'NINETEEN',
        ];
        $tens = [
            0 => 'ZERO',
            1 => 'TEN',
            2 => 'TWENTY',
            3 => 'THIRTY',
            4 => 'FORTY',
            5 => 'FIFTY',
            6 => 'SIXTY',
            7 => 'SEVENTY',
            8 => 'EIGHTY',
            9 => 'NINETY',
        ];
        $hundreds = ['HUNDRED', 'THOUSAND', 'MILLION', 'BILLION', 'TRILLION', 'QUARDRILLION']; /*limit t quadrillion */
        $num = number_format($num, 2, '.', ',');
        $num_arr = explode('.', $num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(',', $wholenum));
        krsort($whole_arr, 1);
        $rettxt = '';
        foreach ($whole_arr as $key => $i) {
            while (substr($i, 0, 1) == '0') {
                $i = substr($i, 1, 5);
            }
            if ($i < 20 && $i > 0) {
                /* echo "getting:".$i; */
                $rettxt .= $ones[$i];
            } elseif ($i < 100 && $i > 0) {
                if (substr($i, 0, 1) != '0') {
                    $rettxt .= $tens[substr($i, 0, 1)];
                }
                if (substr($i, 1, 1) != '0') {
                    $rettxt .= ' ' . $ones[substr($i, 1, 1)];
                }
            } else {
                if ($i > 0) {
                    if (substr($i, 0, 1) != '0') {
                        $rettxt .= $ones[substr($i, 0, 1)] . ' ' . $hundreds[0];
                    }
                    if (substr($i, 1, 1) != '0') {
                        $rettxt .= ' ' . $tens[substr($i, 1, 1)];
                    }
                    if (substr($i, 2, 1) != '0') {
                        $rettxt .= ' ' . $ones[substr($i, 2, 1)];
                    }
                }
            }
            if ($key > 0) {
                $rettxt .= ' ' . $hundreds[$key] . ' ';
            }
        }
        if ($decnum > 0) {
            $rettxt .= ' and ';
            if ($decnum < 20) {
                $rettxt .= $ones[$decnum];
            } elseif ($decnum < 100) {
                $rettxt .= $tens[substr($decnum, 0, 1)];
                $rettxt .= ' ' . $ones[substr($decnum, 1, 1)];
            }
        }
        return $rettxt . ' ONLY';
    }


    /**
     * Generate Invoice PDFReport
     *
     * @param Request $request
     * @param string|integer $id
     * @return PDF
     */
    public function generateInvoice(Request $request)
    {
        $dataEntry = OutwardEntry::findOrFail($request->id);
        \Log::info($dataEntry);
        try{
            view()->share([
                'date' => $dataEntry->date,
                "voucher_number" => $dataEntry->voucher_number,
                'dealer_name' => $dataEntry->dealer_name,
                'firm_name' => $dataEntry->firm_name,
                'city' => $dataEntry->city,
                'phone' => $dataEntry->phone,
                'created_at' => $dataEntry->created_at,
                'updated_at' => $dataEntry->updated_at,
            ]);

            $pdf = PDF::loadView('pdf.invoice');

            return $pdf->stream();
        }catch(Exception $e) {
            dd($e);
        }



    }

}
