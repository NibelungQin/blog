<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configs=Config::latest('created_at')->paginate(10);
        foreach ($configs as $K=>$v){
            switch ($v->filed_type){
                case 'input':
                    $configs[$K]->_html='<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $configs[$K]->_html='<textarea type="text" class="lg" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    $array=explode(',',$v->filed_value);
                    $str='';
                    foreach ($array as $m=>$n){
                        $arr=explode('|',$n);
                        $checked=$v->conf_content==$arr[0]?'checked':'';
                        $str.='<input type="radio" name="conf_content[]" value="'.$arr[0].'"'.$checked.'>'.$arr[1].'　';
                    }
                    $configs[$K]->_html=$str;
                    break;
            }
        }
        return view('admin.config.index',compact('configs'));
    }

    public function changecontent()
    {
        $input=Input::all();
        foreach ($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putConfigFile();
        return back()->with('errors','配置项更新成功!');
    }

    public function putConfigFile()
    {
        $config=Config::pluck('conf_content','conf_name')->all();
        $path=base_path().'\config\web.php';
        $str='<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
    }

    public function changeorder()
    {
        $input=Input::all();
        $config=Config::find($input['conf_id']);
        $config->conf_order=$input['conf_order'];
        $re=$config->update();
        if ($re){
            $data=[
                'status'=>'0',
                'msg'=>'配置项序列更新成功!'
            ];
        }else{
            $data=[
                'status'=>'1',
                'msg'=>'配置项序列更新失败!'
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
        return view('admin.config.add');
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
            'conf_title'=>'required',
            'conf_name'=>'required',
        ];
        $message=[
            'conf_title.required'=>'配置项标题不能为空!',
            'conf_name.required'=>'变量名不能为空!',
        ];
        $validator=Validator::make($input,$rules,$message);
        if ($validator->passes()){
            $re=Config::create($input);
            if ($re){
                return redirect('admin/config');
            }else{
                return back()->with('errors','配置项添加失败!');
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
        $config=Config::findOrFail($id);
        return view('admin.config.edit',compact('config'));
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
        $re=Config::find($id)->update($input);
        if ($re){
            $this->putConfigFile();
            return redirect('admin/config');
        }else{
            return back()->with('errors','修改配置项失败!');
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
        $re=Config::find($id)->delete();
        if ($re){
            $this->putConfigFile();
            $data=[
                'status'=>'0',
                'msg'=>'删除配置项成功!',
            ];
        }else{
            $data=[
                'status'=>'1',
                'msg'=>'删除配置项失败!',
            ];
        }
        return $data;
    }
}
