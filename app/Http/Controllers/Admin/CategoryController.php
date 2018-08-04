<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\CommonController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorys=(new Category())->tree();
        return view('admin.category.index',compact('categorys'));
    }

    public function changeorder()
    {
        $input=Input::all();
        $cate=Category::find($input['cate_id']);
        $cate->cate_order=$input['cate_order'];
        $re=$cate->update();
        if ($re){
            $data=[
                'status'=>0,
                'msg'=>'分类排序更新成功!',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'分类排序更新失败!',
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
        $categorys=Category::where('cate_pid',0)->get();
        return view('admin/category/add',compact('categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=Input::except('_token');
        $rules=[
            'cate_name'=>'required',
        ];
        $message=[
            'cate_name.required'=>'分类名称不能为空',
        ];
        $validator=Validator::make($input,$rules,$message);
        if ($validator->passes()){
            $re=Category::create($input);
            if ($re){
                return redirect('admin/category');
            }else{
                return back()->with('errors','添加文章分类失败!');
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
        $data=Category::findOrFail($id);
        $categorys=Category::where('cate_pid',0)->get();
        return view('admin.category.edit',compact('data','categorys'));
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
        $input=Input::except('_token','_method');
        $re=Category::find($id)->update($input);
        if ($re){
            return redirect('admin/category');
        }else{
            return back()->with('errors','修改文章分类失败!');
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
        $re=Category::find($id)->delete();
        Category::where('cate_pid',$id)->update(['cate_pid'=>0]);
        if ($re){
            $data=[
                'status'=>0,
                'msg'=>'文章分类删除成功!',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'文章分类删除失败!',
            ];
        }
        return $data;
    }
}
