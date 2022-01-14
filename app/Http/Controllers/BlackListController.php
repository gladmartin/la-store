<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlackList\StoreBlackListRequest;
use App\Http\Requests\Bulk\DeleteBulk;
use App\Models\BlackList;
use Illuminate\Http\Request;

class BlackListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.blacklist.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blacklist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlackListRequest $request)
    {
        BlackList::create([
            'blacklist' => $request->blacklist,
            'replace' => $request->replace,
        ]);
        
        return redirect()->back()->with('info', "Blacklist berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlackList  $blackList
     * @return \Illuminate\Http\Response
     */
    public function show(BlackList $blackList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlackList  $blackList
     * @return \Illuminate\Http\Response
     */
    public function edit(BlackList $blackList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlackList  $blackList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlackList $blackList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlackList  $blackList
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlackList $blacklist)
    {
        $blacklist->delete();
        
        return redirect()->back()->with('info', "Blacklist berhasil dihapus");
    }

    public function deleteBulk(DeleteBulk $request)
    {
        $deleted = BlackList::destroy($request->ids);
        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada blacklist yang dihpaus',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Blacklist berhasil dihapus',
        ]);
    }
}
