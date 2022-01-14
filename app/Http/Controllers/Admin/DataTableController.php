<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlackList;
use App\Models\Delivery;
use App\Models\Log;
use App\Models\Order;
use App\Models\Post;
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
            ->addColumn('checkbox', function($row) {
                return '<input type="checkbox" name="delete_bulk" class="row-check" data-id="'. $row->id .'">';
            })
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
                <button title='Hapus' type='submit' class='btn btn-danger btn-sm btn-delete'><i class='fa fa-trash'></i></button>
                $sumber
            </form>";
            })
            ->rawColumns(['aksi', 'created_at', 'title', 'checkbox'])
            ->make(true);
    }

    public function order($status = 'all')
    {
        // $data = Order::query()->where('product_id', '!=', null);
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
            ->addColumn('checkbox', function($row) {
                return '<input type="checkbox" name="delete_bulk" class="row-check" data-id="'. $row->id .'">';
            })
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
                return $row->product->title ?? '--Produk Telah Dihapus--';
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
                <button title='Hapus' type='submit' class='btn btn-danger btn-sm btn-delete'><i class='fa fa-trash'></i></button>
            </form>";
            })
            ->rawColumns(['aksi', 'customer', 'invoice', 'checkbox'])
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
            ->addColumn('checkbox', function($row) {
                return '<input type="checkbox" name="delete_bulk" class="row-check" data-id="'. $row->id .'">';
            })
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
                <button title='Hapus' type='submit' class='btn btn-danger btn-sm btn-delete'><i class='fa fa-trash'></i></button>
            </form>";
            })
            ->rawColumns(['aksi', 'customer', 'invoice', 'checkbox'])
            ->make(true);
    }

    public function posts()
    {
        $data = Post::query()->where('type', 'post');;

        return datatables()
            ->of($data)
            ->addColumn('checkbox', function($row) {
                return '<input type="checkbox" name="delete_bulk" class="row-check" data-id="'. $row->id .'">';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y h:i:s');
            })
            ->editColumn('title', function ($row) {
                return '<a href="'. route('post.single', [$row->slug, $row->id]) .'">'. $row->title .'</a>';
            })
            ->editColumn('image', function ($row) {
                return '<img class="lozad" src="'. image($row->image) .'" width="200" height="200" />';
            })
            ->addColumn('aksi', function ($row) {
                // return $sumber
                return "<form action='" . route('post.destroy', $row->id) . "' method='post'>
                <input type='hidden' name='_token' value=" . csrf_token() . " />
                <input type='hidden' name='_method' value='delete'/>
                <a title='Edit' href='" . route('post.edit', $row->id) . "' class='btn btn-dark
                btn-sm'><i class='fa fa-edit'></i></a>
                <button title='Hapus' type='submit' class='btn btn-danger btn-sm btn-delete'><i class='fa fa-trash'></i></button>
            </form>";
            })
            ->rawColumns(['aksi', 'image', 'title', 'checkbox'])
            ->make(true);
    }

    public function footer()
    {
        $data = Post::query()->where('type', 'widget_footer');

        return datatables()
            ->of($data)
            ->addColumn('checkbox', function($row) {
                return '<input type="checkbox" name="delete_bulk" class="row-check" data-id="'. $row->id .'">';
            })
            ->addColumn('aksi', function ($row) {
                // return $sumber
                return "<form action='" . route('post.destroy', $row->id) . "' method='post'>
                <input type='hidden' name='_token' value=" . csrf_token() . " />
                <input type='hidden' name='_method' value='delete'/>
                <a title='Edit' href='" . route('post.edit', $row->id) . "?type=widget_footer' class='btn btn-dark
                btn-sm'><i class='fa fa-edit'></i></a>
                <button title='Hapus' type='submit' class='btn btn-danger btn-sm btn-delete'><i class='fa fa-trash'></i></button>
            </form>";
            })
            ->rawColumns(['aksi', 'checkbox'])
            ->make(true);
    }

    public function bank()
    {
        $data = Post::query()->where('type', 'akun_bank');

        return datatables()
            ->of($data)
            ->addColumn('checkbox', function($row) {
                return '<input type="checkbox" name="delete_bulk" class="row-check" data-id="'. $row->id .'">';
            })
            ->addColumn('bank', function($row) {
                return $row->metas->where('key', 'bank')->first()->value ?? '';
            })
            ->addColumn('no_rek', function($row) {
                return $row->metas->where('key', 'no_rek')->first()->value ?? '';
            })
            ->addColumn('atas_nama', function($row) {
                return $row->metas->where('key', 'atas_nama')->first()->value ?? '';
            })
            ->addColumn('aksi', function ($row) {
                // return $sumber
                return "<form action='" . route('post.destroy', $row->id) . "' method='post'>
                <input type='hidden' name='_token' value=" . csrf_token() . " />
                <input type='hidden' name='_method' value='delete'/>
                <button title='Hapus' type='submit' class='btn btn-danger btn-sm btn-delete'><i class='fa fa-trash'></i></button>
            </form>";
            })
            ->rawColumns(['aksi', 'checkbox'])
            ->make(true);
    }

    public function blacklist()
    {
        $data = BlackList::query();

        return datatables()
            ->of($data)
            ->addColumn('checkbox', function($row) {
                return '<input type="checkbox" name="delete_bulk" class="row-check" data-id="'. $row->id .'">';
            })
            ->addColumn('aksi', function ($row) {
                // return $sumber
                return "<form action='" . route('blacklist.destroy', $row->id) . "' method='post'>
                <input type='hidden' name='_token' value=" . csrf_token() . " />
                <input type='hidden' name='_method' value='delete'/>
                <button title='Hapus' type='submit' class='btn btn-danger btn-sm btn-delete'><i class='fa fa-trash'></i></button>
            </form>";
            })
            ->rawColumns(['aksi', 'checkbox'])
            ->make(true);
    }

    public function log()
    {
        $data = Log::query();

        return datatables()
            ->of($data)
            ->editColumn('created_at', function($row) {
                return '<span class="badge badge-dark">'. $row->created_at->format('d M Y h:i:s') . '</span>';
            })
            ->rawColumns(['created_at'])
            ->make(true);
    }
}
