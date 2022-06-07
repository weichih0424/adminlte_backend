<?php

namespace App\Http\Controllers\shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReorderController extends Controller
{
    public function save_reorder(Request $request)
    {
        DB::table($request->table)->update(['sort' => '0']);

        foreach($request->sort_order as $order => $id){
            DB::table($request->table)
            ->where('id', $id)
            ->update(['sort' => $order]);
        }

        return redirect()->route($request->table.'.index')->with('success', '排序更新成功');
    }

    public function save_reorder_nav(Request $request)
    {
        if(isset($request->parent_id) && !empty($request->parent_id)){
            DB::table($request->table)->where('parent_id', $request->parent_id)->update(['sort' => '0']);
        }else{
            DB::table($request->table)->where('parent_id', NULL)->update(['sort' => '0']);
        }

        foreach($request->sort_order as $order => $id){
            DB::table($request->table)
            ->where('id', $id)
            ->update(['sort' => $order]);
        }

        if(isset($request->parent_id) && !empty($request->parent_id)){
            return redirect()->route($request->table.'.index',['parent_id' => $request->parent_id])->with('success', '排序更新成功');
        }else{
            return redirect()->route($request->table.'.index')->with('success', '排序更新成功');
        }
    }
}
