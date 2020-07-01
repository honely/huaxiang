<?php


namespace app\api\controller;


use think\Controller;

class Addres extends Controller
{

    public function getAdd(){
        $querys = $this->request->param();
        $APP_ID_HERE = "QuHxU6ypXzp37Dci84o8";
        $APP_CODE_HERE = "TDu_enlm0QIblRnIl33buw";
        $url = "https://autocomplete.geocoder.api.here.com/6.2/suggest.json?query=".$querys."&app_id=".$APP_ID_HERE."&app_code=".$APP_CODE_HERE."&country=AUS";

    }
}