<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Dealer;
use App\Models\InwardEntry;
use App\Models\InwardEntryItem;
use App\Models\OutwardEntry;
use App\Models\OutwardEntryItem;
use App\Models\Products;
use App\Models\Supplier;

class TrashController extends Controller
{
    public function manageTrsh() {
        $inwardEntry = InwardEntry::onlyTrashed()->get();
        $dealers = Dealer::onlyTrashed()->get();
        $inwardEntryItems = InwardEntryItem::onlyTrashed()->get();
        $outwardEntrys = OutwardEntry::onlyTrashed()->get();
        $outwardEntryItems = OutwardEntryItem::onlyTrashed()->get();
        $products = Products::onlyTrashed()->get();
        $suppliers = Supplier::onlyTrashed()->get();
        $data = compact('inwardEntry','dealers','inwardEntryItems','outwardEntrys','outwardEntryItems','products','suppliers');
        return Inertia::render('Trash/ManageTrash', $data);
    }

    public function outwardEntryRestore($id) {
        $entry = OutwardEntry::withTrashed()->find($id);
        if(!is_null($entry)){
            $entry->restore();
        }
        return redirect()->back();
    }
    public function inwardEntryRestore($id) {
        $entry = InwardEntry::withTrashed()->find($id);
        if(!is_null($entry)){
            $entry->restore();
        }
        return redirect()->back();
    }
    public function supplierRestore($id) {
        $entry = Supplier::withTrashed()->find($id);
        if(!is_null($entry)){
            $entry->restore();
        }
        return redirect()->back();
    }
    public function dealerRestore($id) {
        $entry = Dealer::withTrashed()->find($id);
        if(!is_null($entry)){
            $entry->restore();
        }
        return redirect()->back();
    }
    public function productRestore($id) {
        $entry = Products::withTrashed()->find($id);
        if(!is_null($entry)){
            $entry->restore();
        }
        return redirect()->back();
    }
    public function outwardEntryPermanentDelete($id) {
        $entry = OutwardEntry::withTrashed()->find($id);
        if(!is_null($entry)){
            $entry->forceDelete();
        }
        return redirect()->back();
    }
    public function inwardEntryPermanentDelete($id) {
        $entry = InwardEntry::withTrashed()->find($id);
        if(!is_null($entry)){
            $entry->forceDelete();
        }
        return redirect()->back();
    }
    public function supplierPermanentDelete($id) {
        $entry = Supplier::withTrashed()->find($id);
        if(!is_null($entry)){
            $entry->forceDelete();
        }
        return redirect()->back();
    }
    public function dealerPermanentDelete($id) {
        $entry = Dealer::withTrashed()->find($id);
        if(!is_null($entry)){
            $entry->forceDelete();
        }
        return redirect()->back();
    }
    public function productPermanentDelete($id) {
        $entry = Products::withTrashed()->find($id);
        if(!is_null($entry)){
            $entry->forceDelete();
        }
        return redirect()->back();
    }

    
}
