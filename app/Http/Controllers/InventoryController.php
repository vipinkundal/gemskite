<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\InwardEntry;
use App\Models\InwardEntryItem;
use App\Models\OutwardEntry;
use App\Models\OutwardEntryItem;
use App\Models\Products;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class InventoryController extends Controller
{
    /**
     * Show inward entry page
     *
     * @return mixed
     */
    public function showInwardEntry()
    {
        $supplier_list = Supplier::orderBy('id')->get();

        return Inertia::render('Inventory/InwardEntry', [
            'supplier-list' => $supplier_list,
        ]);
    }

    /**
     * Show outward entry page
     *
     * @return mixed
     */
    public function showOutwardEntry()
    {
        $dealer_list = Dealer::orderBy('id')->get();

        return Inertia::render('Inventory/OutwardEntry', [
            'dealer-list' => $dealer_list,
            'edit' => false,
        ]);
    }

    /**
     * Get product by sku for inward entry item
     *
     * @return mixed
     */
    public function productBySKU(Request $request)
    {
        $product = Products::where('sku', $request->search)->firstOrFail();

        return response()->json([
            'product' => $product,
        ]);
    }

    /**
     * Get next voucher number
     *
     * @return mixed
     */
    public function nextVoucherNumber(Request $request)
    {
        $last_entry = OutwardEntry::latest()->first();

        $last_entry_id = '000001';
        if (! empty ($last_entry)) {
            $last_entry_id = $last_entry->id;
        }

        return response()->json([
            'last_entry_id' => $last_entry_id,
        ]);
    }

    /**
     * Get product by stone name for outward entry item
     *
     * @return mixed
     */
    public function getProductByStoneName(Request $request)
    {
        $inward_entry_item = InwardEntryItem::with('inwardEntry')->where('stone_name', $request->search)->first();

        return response()->json([
            'inward_entry_item' => $inward_entry_item,
        ]);
    }

    /**
     * Save inward entry and related items
     *
     * @return mixed
     */
    public function saveInwardEntry(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'invoice_number' => 'nullable',
            'supplier' => 'nullable',
            'location' => 'required',
            'items.*.sku' => 'required | max:255',
            'items.*.stone_name' => 'nullable',
            'items.*.shape' => 'nullable',
            'items.*.size' => 'nullable',
            'items.*.piece' => 'nullable',
            'items.*.gross_weight' => 'nullable',
            'items.*.s_w' => 'nullable',
            'items.*.line' => 'nullable',
            'items.*.net_weight' => 'nullable',
            'items.*.price' => 'nullable',
            'items.*.color' => 'nullable',
            'items.*.description' => 'nullable',
        ]);
        $inward_entry = InwardEntry::create([
            'date' => $request->date,
            'invoice_number' => $request->invoice_number,
            'supplier' => $request->supplier,
            'location' => $request->location,
        ]);

        foreach ($request->items as $item) {
            InwardEntryItem::create([
                'inward_entry_id' => $inward_entry->id,
                'sku' => $item['sku'],
                'stone_name' => $item['stone_name'],
                'shape' => $item['shape'],
                'gross_weight' => $item['gross_weight'],
                'size' => $item['size'],
                'piece' => $item['piece'],
                's_w' => $item['s_w'],
                'line' => $item['line'],
                'net_weight' => $item['net_weight'],
                'price' => $item['price'],
                'color' => $item['color'],
                'description' => $item['description'],
            ]);
        }

        return response([], 204);
    }

    /**
     * Save outward entry and related items
     *
     * @return mixed
     */
    public function saveOutwardEntry(Request $request)
    {
        try {
            $request->validate([
                'outbound_date' => 'required',
                'voucher_number' => 'required',
                'dealer_name' => 'required',
                'firm_name' => 'required',
                'city' => 'required',
                'phone' => 'required',
                'items.*.sku' => 'required | max:255',
                'items.*.stone_name' => 'nullable',
                'items.*.shape' => 'nullable',
                'items.*.size' => 'nullable',
                'items.*.piece' => 'nullable',
                'items.*.gross_weight' => 'nullable',
                'items.*.s_w' => 'nullable',
                'items.*.line' => 'nullable',
                'items.*.net_weight' => 'nullable',
                'items.*.price' => 'nullable',
                'items.*.color' => 'nullable',
                'items.*.description' => 'nullable',
            ]);

            $outward_entry = OutwardEntry::create([
                'date' => $request->outbound_date,
                'voucher_number' => $request->voucher_number,
                'dealer_name' => $request->dealer_name,
                'firm_name' => $request->firm_name,
                'city' => $request->city,
                'phone' => $request->phone,
            ]);
            foreach ($request->items as $item) {
                OutwardEntryItem::create([
                    'outward_entry_id' => $outward_entry->id,
                    'sku' => $item['sku'],
                    'stone_name' => $item['stone_name'],
                    'shape' => $item['shape'],
                    'gross_weight' => $item['gross_weight'],
                    'size' => $item['size'],
                    'piece' => $item['piece'],
                    's_w' => $item['s_w'],
                    'line' => $item['line'],
                    'net_weight' => $item['net_weight'],
                    'price' => $item['price'],
                    'color' => $item['color'],
                    'description' => $item['description'],
                ]);
            }
        } catch (Exception $e) {
            Log::error('Failed updation', [
                'error' => $e->getMessage(),
            ]);
        }

        return response([], 204);
    }

    /**
     * Update outward entry
     *
     * @param Request $request
     */
    public function updateOutwardEntry(Request $request)
    {
        try {
            $request->validate([
                'outbound_date' => 'required',
                'voucher_number' => 'required',
                'dealer_name' => 'required',
                'firm_name' => 'required',
                'city' => 'required',
                'phone' => 'required',
                'items.*.sku' => 'required | max:255',
                'items.*.stone_name' => 'nullable',
                'items.*.shape' => 'nullable',
                'items.*.size' => 'nullable',
                'items.*.piece' => 'nullable',
                'items.*.gross_weight' => 'nullable',
                'items.*.s_w' => 'nullable',
                'items.*.line' => 'nullable',
                'items.*.net_weight' => 'nullable',
                'items.*.price' => 'nullable',
                'items.*.color' => 'nullable',
                'items.*.description' => 'nullable',
            ]);

            $outward_entry = OutwardEntry::where('id', $request->id)->update([
                'date' => $request->outbound_date,
                'voucher_number' => $request->voucher_number,
                'dealer_name' => $request->dealer_name,
                'firm_name' => $request->firm_name,
                'city' => $request->city,
                'phone' => $request->phone,
            ]);

            foreach ($request->items as $item) {
                OutwardEntryItem::updateOrCreate([
                    'outward_entry_id' => $outward_entry->id,
                    'sku' => $item['sku'],
                    'stone_name' => $item['stone_name'],
                    'shape' => $item['shape'],
                    'gross_weight' => $item['gross_weight'],
                    'size' => $item['size'],
                    'piece' => $item['piece'],
                    's_w' => $item['s_w'],
                    'line' => $item['line'],
                    'net_weight' => $item['net_weight'],
                    'price' => $item['price'],
                    'color' => $item['color'],
                    'description' => $item['description'],
                ]);
            }
        } catch (Exception $e) {
            Log::error('Failed updation', [
                'error' => $e->getMessage(),

            ]);
        }

        return response([], 204);
    }

    /**
     * Show inward list page
     */
    public function showManageInwardEntry()
    {
        $inward_entries = InwardEntry::orderBy('id')->get();

        return Inertia::render('Inventory/ManageInwardEntry', [
            'inward_entries' => $inward_entries,
        ]);
    }

    /**
     * Show inward entry list page
     */
    public function getInwardEntryList(Request $request)
    {
        $inward_entries = InwardEntry::orderBy('id')->with('inwardEntryItem')->get();
        if (! empty($request->searchBy)) {
            $inward_entries = InwardEntry::with(['inward_entry_items'])
                ->where('container_number', 'LIKE', '%'.$request->searchBy.'%')
                ->orWhere('supplier', 'LIKE', '%'.$request->searchBy.'%')
                ->orWhere('import_invoice_number', 'LIKE', '%'.$request->searchBy.'%')
                ->orderBy('id')->get();
        }

        return response()->json(['success' => [
            'inward_entries' => $inward_entries,
        ]]);
    }

    /**
     * Edit inward_entry
     *
     */
    public function editInwardEntry(InwardEntry $inward_entry, Request $request)
    {
        $entries = InwardEntry::where('id', $inward_entry->id)->with('inwardEntryItem')->first();
        $supplier_list = Supplier::orderBy('id')->get();

        return Inertia::render('Inventory/InwardEntry', [
            'inward-entry' => $entries,
            'supplier-list' => $supplier_list,
        ]);
    }

    /**
     * Delete inward_entry
     */
    public function deleteInwardEntry(InwardEntry $inward_entry, Request $request)
    {
        $items = InwardEntryItem::where('inward_entry_id', $inward_entry->id)->get();
        foreach ($items as $each) {
            $each->delete();
        }
        $inward_entry->delete();

        return redirect('inventory/manage-inward-entry');
    }

    /**
     * Show outward list page
     */
    public function showManageOutwardEntry()
    {
        $outward_entries = OutwardEntry::orderBy('id')->get();

        return Inertia::render('Inventory/ManageOutwardEntry', [
            'outward_entries' => $outward_entries,
        ]);
    }

    /**
     * Show outward entry list page
     */
    public function getOutwardEntryList(Request $request)
    {
        $outward_entries = OutwardEntry::with(['outwardEntryItem'])->orderBy('id')->get();
        if (! empty($request->searchBy)) {
            $outward_entries = OutwardEntry::with(['outward_entry_items'])
                ->where('dealer_name', 'LIKE', '%'.$request->searchBy.'%')
                ->orWhere('lr_number', 'LIKE', '%'.$request->searchBy.'%')
                ->orWhere('invoice_number', 'LIKE', '%'.$request->searchBy.'%')
                ->orderBy('id')->get();
        }

        return response()->json(['success' => [
            'outward_entries' => $outward_entries,
        ]]);
    }

    /**
     * Edit outward_entry
     *
     * @return void
     */
    public function editOutwardEntry(OutwardEntry $outward_entry, Request $request)
    {
        $entries = OutwardEntry::where('id', $outward_entry->id)->with('OutwardEntryItem')->first();
        $dealer = Dealer::orderBy('id')->get();
        $supplier_list = Supplier::orderBy('id')->get();

        return Inertia::render('Inventory/OutwardEntry', [
            'outward-entry' => $entries,
            'supplier-list' => $supplier_list,
            'dealer-list' => $dealer,
            'edit' => true,

        ]);
    }

    /**
     * Delete outward_entry
     */
    public function deleteOutwardEntry(OutwardEntry $outward_entry, Request $request)
    {
        $items = OutwardEntryItem::where('outward_entry_id', $outward_entry->id)->get();
        foreach ($items as $each) {
            $each->delete();
        }
        $outward_entry->delete();

        return redirect('inventory/manage-outward-entry');
    }
}
