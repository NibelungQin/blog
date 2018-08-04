<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Nav;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navs=Nav::latest()->paginate(10);
        return view('admin.nav.index',compact('navs'));
    }

    public function changeorder()
    {
        $input=Input::all();
        $nav=Nav::find($input['nav_id']);
        $nav->nav_order=$input['nav_order'];
        $re=$nav->update();
        if ($re){
            $data=[
                'status'=>0,
                'msg'=>'链接排序更新成功!',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'链接排序更新失败!',
            ];
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.nav.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=[];
        $input=Input::except('_token');
        $input['created_at']=Carbon::now();
        $rules=[
            'nav_name'=>'required',
            'nav_alias'=>'required',
            'nav_url'=>'required',
        ];
        $message=[
            'nav_name.required'=>'链接名称不能为空',
            'nav_alias.required'=>'链接标题不能为空',
            'nav_url.required'=>'链接不能为空',
        ];
        $validator=Validator::make($input,$rules,$message);
        if ($validator->passes()){
            $re=Nav::create($input);
            if ($re){
                return redirect('admin/nav');
            }else{
                return back()->with('errors','添加链接失败!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nav=Nav::findOrFail($id);
        return view('admin.nav.edit',compact('nav'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input=Input::except('_method','_token');
        $re=Nav::find($id)->update($input);
        if ($re){
            return redirect('admin/nav');
        }else{
            return back()->with('errors','修改链接失败!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re=Nav::find($id)->delete();
        if ($re){
            $data=[
                'status'=>1,
                'msg'=>'删除链接成功!',
            ];
        }else{
            $data=[
                'status'=>0,
                'msg'=>'删除链接成功!',
            ];
        }
        return $data;
    }
}
