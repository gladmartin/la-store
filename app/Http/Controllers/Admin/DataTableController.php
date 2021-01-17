<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DataTableController extends Controller
{
    public function products()
    {
        $data = Product::query();
        return datatables()->of($data)->addIndexColumn()
            ->addColumn('no', function($row) {
                // return 1;
            })
            ->addColumn('aksi', function ($row) {
                return "<form action='" . route('product.destroy', $row->id) . "' method='post'>
                <input type='hidden' name='_token' value=" . csrf_token() . " />
                <input type='hidden' name='_method' value='delete'/>
                <a title='Edit' href='" . route('product.edit', $row->id) . "' class='btn btn-dark
                btn-sm'><i class='fa fa-edit'></i></a>
                <button title='Hapus' type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
            </form>";
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
