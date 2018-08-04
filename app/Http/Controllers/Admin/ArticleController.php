<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\CommonController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles=Article::latest('art_time')->paginate(7);
        return view('admin.article.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorys=(new Category())->tree();
        return view('admin.article.add',compact('categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=Input::except('_token','file_upload');
        $rules=[
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $messages=[
            'art_title.required'=>'文章标题不能为空',
            'art_content.required'=>'文章内容不能为空',
        ];
        $validator=Validator::make($input,$rules,$messages);
        if ($validator->passes()) {
            if ($request->isMethod('post')) {
                $file = $request->file('file_upload');
                // 文件是否上传成功
                if ($file->isValid()) {
                    // 获取文件相关信息
                    $originalName = $file->getClientOriginalName(); // 文件原名
                    $ext = $file->getClientOriginalExtension();     // 扩展名
                    $realPath = $file->getRealPath();   //临时文件的绝对路径
                    $type = $file->getClientMimeType();     // image/jpeg
                    // 上传文件
                    $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                    // 使用我们新建的uploads本地存储空间（目录）
//                $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                    $path = $file->move(base_path() . '/public/uploads', $filename);
                    $input['art_thumb'] = '/public/uploads/' . $filename;
                    $re = Article::create($input);
                    if ($re) {
                        return redirect('admin/article');
                    } else {
                        return back()->with('errors', '文章发表失败!');
                    }
                }
            }
        }
        else {
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
        $article=Article::findOrFail($id);
        $categorys=(new Category())->tree();
        return view('admin.article.edit',compact('categorys','article'));
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
        $input=Input::except('_method','_token','file_upload');
        $rules=[
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $messages=[
            'art_title.required'=>'文章标题不能为空',
            'art_content.required'=>'文章内容不能为空',
        ];
        $validator=Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $file=$request->file('file_upload');
            if ($file->isValid()){
                $originalName=$file->getClientOriginalName();
                $ext=$file->getClientOriginalExtension();
                $type=$file->getClientMimeType();
                $filename=date('Y-m-d-H-i-s').'-'.uniqid().'.'.$ext;
                $file->move(base_path().'/public/uploads/',$filename);
            }
            $input['art_thumb']='/public/uploads/'.$filename;
            $re=Article::find($id)->update($input);
            if ($re){
                return redirect('admin/article');
            }else{
                return back()->with('errors','文章修改失败!');
            }
        }else{
            return back()->withErrors($validator);
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
        $re=Article::find($id)->delete();
        if ($re){
            $data=[
                'sataus'=>0,
                'msg'=>'文章删除成功！',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'文章删除失败，请重试!',
            ];
        }
        return $data;
    }
}
