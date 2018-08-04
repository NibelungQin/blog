<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links=Link::latest()->paginate(10);
        return view('admin.link.index',compact('links'));
    }

    public function changeorder()
    {
        $input=Input::all();
        $link=Link::find($input['link_id']);
        $link->link_order=$input['link_order'];
        $re=$link->update();
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
        return view('admin.link.add');
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
            'link_name'=>'required',
            'link_title'=>'required',
            'link_url'=>'required',
        ];
        $messages=[
            'link_name.required'=>'链接名称不能为空',
            'link_title.required'=>'链接标题不能为空',
            'link_url.required'=>'链接不能为空',
        ];
        $validator=Validator::make($input,$rules,$messages);
        if ($validator->passes()){
            $re=Link::create($input);
            if ($re){
                return redirect('admin/link');
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
        $link=Link::findOrFail($id);
        return view('admin.link.edit',compact('link'));
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
        $re=Link::find($id)->update($input);
        if ($re){
            return redirect('admin/link');
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
        $re=Link::find($id)->delete();
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
