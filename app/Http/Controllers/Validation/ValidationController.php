<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class ValidationController extends Controller
{
    /**
     * @throws Exception
     */
    public function validateInput($req){
        $pass = true;
        $message = '';
        $data =[];
        foreach($req as $r){
            if(!$r->valid){
                $message .= $r->label.'<br><br>';
                $pass = false;
            }else{
                $data[$r->key] = $r->value;
            }
        }

        if(!$pass){
            return throw new Exception($message);
        }else{
            return (object) $data;
        }
    }

    public function input($key, $label, $type, $value){
        if($type != 'mix'){
            $getRegex = ValidationController::getReg($type);
            $tRegex = preg_match($getRegex['regex'], $value);
            if($tRegex){
                return (object)[
                    'valid' => true,
                    'key' => $key,
                    'value' => $value
                ];
            }else{
                return (object)[
                    'valid' => false,
                    'label' => '<b style="color: red">- '.$label.'</b> '.$getRegex['label']
                ];
            }
        }
        return (object)[
            'valid' => true,
            'key' => $key,
            'value' => $value
        ];
    }

    public static function getReg(&$type) : array{
        $reObject = [];
        switch ($type) {
            case 'mix':
                break;
            case 'string':
                $reObject = [
                    'regex' => '/^([a-zA-Z]+\s)*[a-zA-Z]+$/',
                    'label' => 'Must Only Contain Characters And Alphabets Only',
                ];
                break;
            case 'int':
                $reObject = [
                    'regex' => '/^\d+$/',
                    'label' => 'Must Only Contain Digits',
                ];
                break;
            case 'double':
                $reObject = [
                    'regex' => '/[^\.].+/',
                    'label' => 'Must Only Be In Double Format. Eg: 10.0',
                ];
                break;
            case 'email':
                $reObject = [
                    'regex' => '/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
                    'label' => 'Must Be In Corrent Email Format. Eg: aaa@aaa.com',
                ];
                break;
            case 'datedash':
                $reObject = [
                    'regex' => '/^\d{4}-\d{2}-\d{2}$/',
                    'label' => 'Must Be In The Correct Date Format DD-MM-YYYY',
                ];
                break;
            case 'datedashstandard':
                $reObject = [
                    'regex' => '/^\d{2}-\d{2}-\d{4}$/',
                    'label' => 'Must Be In The Correct Date Format DD-MM-YYYY',
                ];
                break;
            case 'intdoublemix':
                $reObject = [
                    'regex' => '/^[+-]?\d+(\.\d+)?$/',
                    'label' => 'Must Only Be In Double Format Or Integer',
                ];
                break;
            case 'datetime':
                $reObject = [
                    'regex' => '/^\d{2}-\d{2}-\d{4} (2[0-3]|[01][0-9]):[0-5][0-9]/',
                    'label' => 'Must Be In Date Time Format',
                ];
                break;
        }
        return $reObject;
    }
}
