<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 */

namespace Flexe\Db\Extras;

use Carbon\Carbon;

/**
 * Description of Utilities
 *
 * @author caltj
 */
class Utilities {

    /**
     * Convert "camelCaseWord" to "CAMEL CASE WORD"
     * @param string $string
     * @return string Convert "camelCaseWord" to "CAMEL CASE WORD"
     */
    public static function toUpperWords($string) {

        return trim(strtoupper(preg_replace('/(.)([A-Z]+)/', '$1 $2', $string)));
    }

    public static function formatQuery($query) {

        $query = preg_replace(
            '/\b(WHERE|FROM|GROUP BY|HAVING|ORDER BY|LIMIT|OFFSET|UNION|ON DUPLICATE KEY UPDATE|VALUES|SET)\b/', "\n$0", $query
        );

        $query = preg_replace(
            '/\b(INNER|OUTER|LEFT|RIGHT|FULL|CASE|WHEN|END|ELSE|AND)\b/', "\n    $0", $query
        );

        $query = preg_replace("/\s+\n/", "\n", $query); // remove trailing spaces

        return $query;
    }

    public static function isCountable($subject) {

        return (is_array($subject) || ($subject instanceof \Countable));
    }

    public static function convertTypes($s, $rows) {

        return $rows;
    }
    public static function fillable($fillable, $values) {

        $data = [];

        if(!isset($values['updated_at'])):

            $values['updated_at'] = Carbon::create()->format("d/m/Y H:i:s");

        endif;
        if($fillable):
            foreach ($fillable as  $key):
                if(isset($values[$key])):
                    switch ($key):
                        case 'created_at':
                        case 'updated_at':
                        case 'activity_date':
                        case 'publication':
                            $dataArray = format_date_time($values[$key]);
                            if(!isset($dataArray[5])):

                                $dataArray[5] = null;

                            endif;
                            if(!isset($dataArray[4])):

                                $dataArray[4] = null;

                            endif;
                            if(!isset($dataArray[3])):

                                $dataArray[3] = null;

                            endif;
                            list($d, $m, $y, $h, $i, $s) = $dataArray;
                            $data[$key] = Carbon::create($y, $m, $d, $h, $i, $s)->format("Y-m-d H:i:s");
                            break;
                        case 'alias':
                        case 'slug':
                            $data[$key] = str_slug($values['name']);
                            break;
                        case 'price':
                        case 'discount':
                        case 'affix':
                        case 'total':
                        case 'rate_adult':
                        case 'rate_child':
                        case 'rate_cross':
                            $data[$key] = self::form_w($values[$key]);
                            break;
                        case 'password':
                            if(!empty($values[$key])):
                                $data[$key] = Utilities::generate_hash(sprintf("%s-%s",$values[$key],$values['email']));
                            endif;
                            break;
                        default:
                            $data[$key] = $values[$key];
                            break;
                    endswitch;
                endif;
            endforeach;
        endif;
        return $data;
    }

    /*
        * Generate a secure hash for a given password. The cost is passed
        * to the blowfish algorithm. Check the PHP manual page for crypt to
        * find more information about this setting.
        */
    public static function generate_hash($password, $cost=11){
        return password_hash($password, PASSWORD_DEFAULT, [
            'cost' => $cost
        ]);
    }

    public static function calc($amount,$sum, $op = '+'){

        if(!is_numeric(self::form_w($amount))):

            return $amount;

        endif;

        if(!is_numeric(self::form_w($sum))):

            return $sum;

        endif;


        $v1 = str_replace ( ".", "", $amount);

        $v1 = str_replace ( ",", ".", $v1);

        $v2 = str_replace ( ".", "",$sum );

        $v2 = str_replace ( ",", ".",$v2);

        switch ($op) {
            case "+":
                $r = $v1 + $v2;
                break;
            case "-":
                $r = $v1 - $v2;
                break;
            case "*":
                $r = $v1 * $v2;
                break;
            case "%":
                $bs = $v1 / 100;
                $j = $v2 * $bs;
                $r = $v1 + $j;
                break;
            case "/":
                $r='0';
                if((int)$v1 && (int)$v2){
                    @$r = @$v1 / $v2;
                }
                break;
            case "tj":
                $bs = $v1 / 100;
                $j = $v2 * $bs;
                $r = $j;
                break;
            default :
                $r = $v1;
                break;
        }
        $ret = @number_format ( $r, 2, ",", "." );
        return $ret;
    }

    public static function form_read($post) {
        //$res=str_replace ( ",", "", $post );
        if(is_numeric($post)):
            return @number_format($post,2, ",", "."  );
        endif;
        return $post;
    }

    public static function form_w($post) {
        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $post); //remove os pontos e substitui a virgula pelo ponto
        return $valor; //retorna o valor formatado para gravar no banco
    }

    /**
     * @param $String
     * @param $Limite
     * @param null $Pointer
     * @return string
     */
    public static function Words($String, $Limite, $Pointer = null) {
        $Data = strip_tags(trim($String));
        $Format = (int) $Limite;

        $ArrWords = explode(' ', $Data);
        $NumWords = count($ArrWords);
        $NewWords = implode(' ', array_slice($ArrWords, 0, $Format));

        $Pointer = (empty($Pointer) ? '...' : ' ' . $Pointer );
        $Result = ( $Format < $NumWords ? $NewWords . $Pointer : $Data );
        return $Result;
    }


    /**
     * @param $String
     * @param $Limite
     * @return string
     */
    public static function Chars($String, $Limite) {
        $Data = strip_tags($String);
        $Format = $Limite;
        if (strlen($Data) <= $Format) {
            return $Data;
        } else {
            $subStr = strrpos(substr($Data, 0, $Format), ' ');
            return substr($Data, 0, $subStr) . '...';
        }
    }

}
