<?php

namespace App\Helpers\Grid\Components;

use App\Helpers\Grid\ComponentConvertDataTrait;
use App\Helpers\Grid\GridSearch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class ResultTable extends Component
{
    use ComponentConvertDataTrait;

    /**
     * @var GridSearch
     */
    public $GridSearch;
    protected $template;

    /**
     * GridTableComponent constructor.
     * @param $gridSearch
     * @param string|null $template
     */
    public function __construct($gridSearch, $template = null)
    {
        $this->GridSearch = $gridSearch;
        $this->template = $template;
    }

    public function columns($key = null)
    {
        return $this->GridSearch->activeColumns($key);
    }

    /**
     * @return Collection|\Illuminate\Support\Collection|array
     */
    public function dataCollection()
    {
        return $this->GridSearch->pagination ? $this->GridSearch->pagination->getCollection() : [];
    }

    public function renderTd($item, $key, $loop = null)
    {
        $settings = $this->columns($key);

        $outer = @$settings['grid']['outer'];
        if (is_callable($outer)) {
            return $outer($item, $loop, $this);
        } elseif ($outer) {
            return $outer;
        }

        $attr = @$settings['grid']['attrTd'];

        $inner = @$settings['grid']['inner'];
        if (is_callable($inner)) {
            $inner = $inner($item, $key, $loop, $this);
        } elseif (!$inner && $convertFn = $this->getConvertDataMethod(@$settings['grid']['convert'], $params)) {
            $key = $settings['params']['column'] ?? $key;
            $inner = $this->$convertFn($item, $key, $loop, $params);
        } elseif (!$inner) {
            $key = $settings['params']['column'] ?? $key;
            $inner = e(data_get($item, $key));
        }

        if (isset($settings['grid']['empty_data']) && empty($inner)) {
            $inner = $settings['grid']['empty_data'];
        }

        return "<td $attr>{$inner}</td>";
    }

    public function getConvertDataMethod($name, &$params)
    {
        $params = [];
        $arr = explode(":", $name);
        $name = @$arr[0];
        $convertFn = Str::camel('get_'.$name.'_convert_data');

        if (isset($arr[1])) {
            $params = explode(",", $arr[1]);
        }

        return method_exists(ComponentConvertDataTrait::class, $convertFn) ? $convertFn : null;
    }

    public function hiddenHtml()
    {
        $html = '';

        $settings = Arr::where($this->columns(), function ($col) {
            return @$col['grid']['convert'] === 'grid_chosen';
        });
        if (!empty($settings)) {
            foreach ($settings as $k => $setting) {
                $key = @$setting['params']['column'];
                $gridChosen = data_get($this->dataRequest(), $key, []);
                $itemChosen = $this->dataCollection()->whereIn($key, $gridChosen)->pluck($key)->toArray();
                $hiddenChosen = array_diff($gridChosen, $itemChosen);
                foreach ($hiddenChosen as $v) {
                    $name = $this->dataRequestName()."[$key][]";
                    $html .= '<input type="hidden" name="'.$name.'" value="'.$v.'"/>';
                }
            }
        }

        return $html;
    }

    public function dataRequest($key = null, $default = null)
    {
        if (!is_null($key)) {
            return data_get($this->GridSearch->gridResultTable['data'], $key, $default);
        }

        return $this->GridSearch->gridResultTable['data'];
    }

    public function dataRequestName()
    {
        return $this->GridSearch->gridResultTable['name'];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if ($this->template && view()->exists($this->template)) {
            return view($this->template);
        }

        return view('grid::result-table');
    }
}
