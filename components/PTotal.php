<?php
namespace app\components;
use Yii;
class PTotal {
	public static function pageTotal($provider, $fieldName)
	{
	    $total=0;
	    foreach($provider as $item){
	        $total+=$item[$fieldName];
	    }
	    return $total;
	}
}