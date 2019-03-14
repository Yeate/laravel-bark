<?php
namespace Pokeface\BarkPush\Controllers;



use Mockery\Exception;
use Validator;
use Ixudra\Curl\Facades\Curl;

class BarkPushController{
    
    protected $data=[
        'api_key'=>'',
        'push_host'=>'',
        'url'=>'',
        'title'=>'',
        'content'=>'',
        'copy'=>'',
        'automaticallCopy'=>0
    ];
    protected $header;
    public function __construct()
    {
        $this->data['push_host']=config('BarkPushConfig.bark_host');
        $this->data['api_key']=request()->input('api_key','');
        $this->data['url']=request()->input('url','');
        $this->data['title']=request()->input('title','');
        $this->data['content']=request()->input('content','');
        $this->data['copy']=request()->input('copy','');
        $this->data['automaticallCopy']=request()->input('automaticallCopy',0);
        
    }
    
    public function ping(){
        $barkUrl = $this->data['push_host'].'/ping';
        $response = Curl::to($barkUrl)->get();
        return $response;
    }
    
    public function register(){
        $barkUrl = $this->data['push_host'].'/register';
        $response = Curl::to($barkUrl)->withData( request()->all() )->get();
        return $response;
        
    }
    public function test(){
        dd(Request::header());
    }
    public function setApiKey(String $apiKey){
        $this->data['api_key'] = $apiKey;
        return $this;
    }
    public function setUrl(String $url){
        $this->data['url'] = $url;
        return $this;
    }
    public function setTitle(String $title){
        $this->data['title'] = $title;
        return $this;
    }
    public function setContent(String $content){
        $this->data['content'] = $content;
        return $this;
    }
    public function setCopy(String $copy){
        $this->data['copy'] = $copy;
        return $this;
    }
    public function setAutomaticallCopy(String $automaticallCopy){
        $this->data['automaticallCopy'] = $automaticallCopy;
        return $this;
    }
    
    public function push(){
        $data = array_filter($this->data);
        $validator = Validator::make($data, [
            'push_host' => 'required|url',
            'api_key' => 'required',
            'url'=>'sometimes|url',
        ]);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
        list($toGetUrl,$data) = $this->format($data);
        $response = Curl::to($toGetUrl)->withData($data)->post();
        return $response;
        
    }
    
    private function format(Array $data){
        $link = $data['push_host'].'/'.$data['api_key'];
        $link .= isset($data['title'])?'/'.$data['title']:'';
        if(!isset($data['content'])){
            $data['content'] = $data['url'];
        }
        $data['copy']=$data['content'];
        $data['content']=preg_replace('/\n/','%E2%80%A8',$data['content']);
        $data['content']=preg_replace('/\n\r/','%E2%80%A8',$data['content']);
        $data['content']=preg_replace('/\s/','',$data['content']);
        
        $link .= isset($data['content'])?'/'.urlencode($data['content']):'';
        
        unset($data['push_host'],$data['title'],$data['content'],$data['api_key']);
        return [$link,$data];
    }
}