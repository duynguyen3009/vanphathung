<?php


namespace App\Helpers\Grid;


use App\Helpers\Formatter;

trait ComponentConvertDataTrait
{
    public function getGridNumberedConvertData($item, $key, $loop)
    {
        return number_format($this->GridSearch->pagination->firstItem() + $loop->index);
    }

    public function getGridNumberFormatConvertData($item, $key, $loop)
    {
        $value = data_get($item, $key);

        return Formatter::number($value);
    }

    public function getGridJoinCdNameConvertData($item, $key, $loop, $params)
    {
        return e(Formatter::joinCdName($item, $params));
    }

    public function getGridChosenConvertData($item, $key, $loop)
    {
        $settings = $this->columns($key);
        $key = @$settings['params']['column'];
        $value = data_get($item, $key);

        $gridChosen = data_get($this->dataRequest(), $key, []);
        $checked = in_array($value, $gridChosen) ? "checked=checked" : '';

        $name = $this->dataRequestName()."[$key][]";

        return '<input type="checkbox" name="'.$name.'" value="'.$value.'" '.$checked.'/>';
    }

    public function getGridLinkConvertData($item, $key)
    {
        $value = data_get($item, $key);
        $str = json_encode($item);
        return "<a href='javascript:void(0);' data-info='$str'" .
            " class='grid_link__$key'>$value</a>";
    }
}