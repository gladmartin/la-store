<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DataTableController extends Controller
{
    public function products()
    {
        $data = Product::query();
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return '<span class="badge badge-info">' . $row->created_at->format('d M Y h:i:s') . '</span>';
                // return $row->created_at;
            })
            ->editColumn('title', function ($row) {
                return '<a class="text-dark font-weight-bold" target="blank" href="' . route('product.single', [$row->slug, $row->id]) . '">' . $row->title . ' <i class="fa fa-link"></i></a>';
            })
            ->addColumn('aksi', function ($row) {
                $sumber = '';
                if ($row->url_sumber) {
                    $sumber = '<a target="blank" title="Lihat sumber" href="' . $row->url_sumber . '" class="btn btn-primary btn-sm"><i class="fa fa-globe"></i></a>';
                }
                // return $sumber
                return "<form action='" . route('product.destroy', $row->id) . "' method='post'>
                <input type='hidden' name='_token' value=" . csrf_token() . " />
                <input type='hidden' name='_method' value='delete'/>
                <a title='Edit' href='" . route('product.edit', $row->id) . "' class='btn btn-dark
                btn-sm'><i class='fa fa-edit'></i></a>
                <button title='Hapus' type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                $sumber
            </form>";
            })
            ->rawColumns(['aksi', 'created_at', 'title'])
            ->make(true);
    }

    public function order($status = 'all')
    {
        $data = Order::query();
        if ($status == 'pending') {
            $data->where('status_pembayaran', 'MENUNGGU KONFIRMASI');
        }
        if ($status == 'delivery') {
            $data->where('status_order', 'SEDANG DIKIRIM');
        }
        if ($status == 'close') {
            $data->where('status_order', 'ORDER TERKIRIM');
        }
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->editColumn('invoice', function ($row) {
                return '<span class="badge badge-dark">' . $row->invoice . '</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y h:i:s');
            })
            ->addColumn('customer', function ($row) {
                return "$row->nama </br> $row->email </br> $row->no_wa";
            })
            ->addColumn('product', function ($row) {
                return $row->product->title;
            })
            ->addColumn('aksi', function ($row) use ($status) {
                // return $sumber
                $tambahan = '';
                if ($status == 'pending') {
                    $tambahan = "<a title='Konfirmasi pembayaran' href='" . route('order.konfirmasi-bayar', $row->id) . "' class='btn btn-success
                    btn-sm'><i class='fa fa-check'></i></a>";
                }
                if ($status == 'delivery') {
                    $tambahan = "<a title='Orderan telah sampai' href='" . route('order.sampai', $row->id) . "' class='btn btn-success
                    btn-sm'><i class='fa fa-check'></i></a>";
                }
                return "<form action='" . route('order.destroy', $row->id) . "' method='post'>
                <input type='hidden' name='_token' value=" . csrf_token() . " />
                <input type='hidden' name='_method' value='delete'/>
                $tambahan
                <a title='Detail' href='" . route('order.show', $row->id) . "' class='btn btn-dark
                btn-sm'><i class='fa fa-eye'></i></a>
                <button title='Hapus' type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
            </form>";
            })
            ->rawColumns(['aksi', 'customer', 'invoice'])
            ->make(true);
    }

    public function delivery()
    {
        $data = Delivery::query()->with('order')->whereHas('order', function($query) {
            $query->where('status_order', 'SEDANG DIKIRIM');
        });
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('address', function ($row) {
                return $row->order->alamat;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y h:i:s');
            })
            ->addColumn('aksi', function ($row) {
                // return $sumber
                return "<form action='" . route('delivery.destroy', $row->id) . "' method='post'>
                <input type='hidden' name='_token' value=" . csrf_token() . " />
                <input type='hidden' name='_method' value='delete'/>
                <a title='Detail' href='" . route('delivery.edit', $row->id) . "' class='btn btn-dark
                btn-sm'><i class='fa fa-edit'></i></a>
                <button title='Hapus' type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
            </form>";
            })
            ->rawColumns(['aksi', 'customer', 'invoice'])
            ->make(true);
    }
}
