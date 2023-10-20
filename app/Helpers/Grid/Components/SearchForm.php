<?php

namespace App\Helpers\Grid\Components;

use App\Helpers\Grid\ComponentConvertDataTrait;
use App\Helpers\Grid\GridSearch;
use Illuminate\View\Component;

class SearchForm extends Component
{
    use ComponentConvertDataTrait;

    /**
     * @var GridSearch
     */
    protected $GridSearch;
    protected $template;
    public $skipPerPage;
    public $skipOrderBy;
    public $locale;

    /**
     * GridFormSearchComponent constructor.
     * @param $gridSearch
     * @param null|string $template
     * @param bool $skipPerPage
     */
    public function __construct($gridSearch, $template = null, $skipPerPage = false, $skipOrderBy = false, $locale = null)
    {
        $this->GridSearch = $gridSearch;
        $this->template = $template;
        $this->skipPerPage = $skipPerPage;
        $this->skipOrderBy = $skipOrderBy;
        $this->locale = $locale;
    }

    public function columns($key = null)
    {
        return $this->GridSearch->activeColumns($key);
    }

    public function dataRequest($key = null, $default = null)
    {
        if (!is_null($key)) {
            return data_get($this->GridSearch->gridSearchForm['data'], $key, $default);
        }

        return $this->GridSearch->gridSearchForm['data'];
    }

    public function dataRequestName()
    {
        return $this->GridSearch->gridSearchForm['name'];
    }

    public function options($name = null)
    {
        switch ($name) {
            case 'whereBoolean':
                return ['AND' => 'AND検索', 'OR' => 'OR検索'];
            case 'perPage':
                return config('params.perPageOptions');
            default:
                return $this->GridSearch->getSelectOptions($name);
        }
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

        return view('grid::search-form');
    }
}
