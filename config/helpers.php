<?php

if(!function_exists('config')):

    function config($key, $default = null){

        $Config = (new \Flexe\Config\Read\ReadConfig())->getConfig();

        return array_get($Config, $key, $default);

    }

endif;

if(!function_exists('trans')):

    function trans($lang,$provider,$replace){

        $lines = (new \Flexe\Config\Read\ReadConfig())->getLang($lang);

        $line = $lines[$provider];

        foreach ($replace as $key => $value) {

            $line = str_replace(
                [':'.$key, ':'.strtoupper($key), ':'.ucfirst($key)],
                [$value, strtoupper($value), ucfirst($value)],
                $line
            );
        }

        return $line;
    }

endif;

if(!function_exists('translate')):

    function translate($provider,$replace=[]){

        $lines = (new \Flexe\Config\Read\ReadConfig())->getLang(config('language','pt_BR'));

        if(isset($lines[$provider])):

            $line = $lines[$provider];

            if($replace):

                foreach ($replace as $key => $value) {

                    $line = str_replace(
                        [':'.$key, ':'.strtolower($key), ':'.strtoupper($key), ':'.ucfirst($key)],
                        [$value, strtolower($value), strtoupper($value), ucfirst($value)],
                        $line
                    );
                }
            endif;

            return $line;

        endif;

        return $provider;
    }

endif;


if(!function_exists('status_class')):

    function status_class($key, $default = 'success'){

        $class = [
            0=>'danger',
            1=>'success',
            2=>'info',
            3=>'primary',
        ];

        if(isset($class[$key])):

            return $class[$key];

        endif;

        return $default;

    }

endif;
if(!function_exists('JsonEncoder')):

    function JsonEncoder($value, $options = 0){

        return \Flexe\Services\JsonEncoder::encode($value, $options);

    }

endif;

if (!function_exists('format_date')) {
    /**
     * Flash an alert.
     *
     * @param $Date
     * @return array
     */
    function format_date($Date)
    {
        $Format = str_replace(['-','/'],[' ',' '], $Date);
        $Result = explode(' ', $Format);
        return $Result;
    }
}

if (!function_exists('format_date_time')) {
    /**
     * Flash an alert.
     *
     * @param $Date
     * @return array
     */
    function format_date_time($Date)
    {
        $Format = str_replace(['-', '/', ':'], [' ', ' ', ' '], $Date);
        $Result = explode(' ', $Format);
        return $Result;
    }

}

if (!function_exists('assest')) {
    /**
     * Flash an alert.
     *
     * @param $assets
     * @return string
     */
    function assest($assets,$default = '_cdn')
    {
        return sprintf("%s%s%s",config('paths.base'),$default ,$assets);
    }

}

if (!function_exists('asset')) {
    /**
     * Flash an alert.
     *
     * @param $assets
     * @return string
     */
    function asset($assets,$default = '_cdn')
    {
        return sprintf("%s%s%s",config('paths.base'),$default ,$assets);
    }

}

if (!function_exists('img')) {
    /**
     * Flash an img.
     *
     * @param $img
     * @return string
     */
    function img($img)
    {
        return sprintf("%s%s",config('paths.base') ,substr($img,1));
    }

}

if (!function_exists('_rgba')) {
    /**
     * view the passed variables and end the script.
     *
     * @param $transparent
     * @return string
     */

    function _rgba($transparent =' 0.3'){
        $color = sprintf('rgba(%s, %s, %s,%s)',rand(1,255),rand(1,255),rand(1,255),$transparent);
        return $color;

    }
}


if (!function_exists('script')) {
    /**
     * view the passed variables and end the script.
     *
     * @return string
     */

    function script(){

        return new Flexe\Plugins\ScripitJS\Render();

    }
}




if (!function_exists('month_ptBR')) {
    function month_ptBR($month)
    {
        $months = [
            "01" => "Janeiro",
            "02" => "Fevereiro",
            "03" => "Março",
            "04" => "Abril",
            "05" => "Máio",
            "06" => "Junho",
            "07" => "Julho",
            "08" => "Agosto",
            "09" => "Setembro",
            "10" => "Outubro",
            "11" => "Novembro",
            "12" => "Dezembro",
        ];

        if (isset($months[str_pad($month,2,'0',STR_PAD_LEFT)])):
            return $months[str_pad($month,2,'0',STR_PAD_LEFT)];
        endif;
        return $month;
    }
}


if (!function_exists('view')) {
    /**
     * view the passed variables and end the script.
     *
     * @return string
     */
    function view($view, $data){

        return new \Flexe\Plugins\Fullcalendar\View($view, $data);

    }
}