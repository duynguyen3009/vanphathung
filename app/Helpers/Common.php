<?php


namespace App\Helpers;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;

class Common
{
    public static function makeEscLikePatternStr($str, $likeEscapeChar = '!')
    {
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = self::makeEscLikePatternStr($val);
            }

            return $str;
        }

        $listEscape = [
            $likeEscapeChar,
            '%',
            '_',
            '\\',
            "'",
            '"',
            '[',
            ']',
            '^',
            '-',
        ];

        return str_replace($listEscape, array_map(function ($s) use ($likeEscapeChar) {
            return $likeEscapeChar.(in_array($s, ['\\']) ? '\\' : '').$s;
        }, $listEscape), $str);

    }

    public static function makeEscapeLikeWhere($field, $strLikeEscape, $likeEscapeChar = '!')
    {
        $likeEscapeStr = " ESCAPE '%s' ";

        if (is_array($strLikeEscape) && count($strLikeEscape) > 0) {
            $strLikeEscape = str_replace(
                '{param}',
                Common::makeEscLikePatternStr($strLikeEscape[0], true),
                $strLikeEscape[1]
            );
        }

        return "$field like '$strLikeEscape' ".sprintf($likeEscapeStr,
                $likeEscapeChar);
    }

    public static function makeEscapeStr($str, $like = false, $likeEscapeChar = '!')
    {
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = self::makeEscapeStr($val, $like);
            }

            return $str;
        }

        $listEscape = [
            $likeEscapeChar,
            '%',
            '_',
            '\\',
            '\'',
            '"',
        ];

        return str_replace($listEscape, array_map(function ($s) use ($likeEscapeChar) {
            return $likeEscapeChar.(in_array($s, ['\\', '\'']) ? '\\' : '').$s;
        }, $listEscape), $str);

    }

    public static function returnEmptyPagination()
    {
        $items = collect([]);
        $perPage = 1;
        $total = 0;
        $currentPage = 1;
        $options = ['path' => Paginator::resolveCurrentPath(), 'pageName' => 'page'];
        return \Illuminate\Container\Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }

    public static function customFlexOrderByDefault(&$q, $GridSearch, $sortDef)
    {
        $orderBy = Arr::wrap($GridSearch->getOrderBySearch());
        $sortDefOrg = $sortDef;
        foreach ($sortDef as $k => $v) {
            if (in_array($k, $orderBy)) {
                unset($sortDef[$k]);
            }
        }
        foreach ($orderBy as $k) {
            $q->orderBy($k, $sortDefOrg[$k] ?? 'asc');
        }
        foreach ($sortDef as $k => $d) {
            $q->orderBy($k, $d);
        }
    }

    public static function generateIdFromElName($name)
    {
        return str_replace(["[", "]"], ["_", ""], $name);
    }

    public static function applyOtherWhereSearch($GridSearch, $qb)
    {
        $filters = [];
        foreach($GridSearch->getOtherWhereSearch() as $k => $v) {
            if (empty($v)) continue;
            array_push($filters, ['name' => $k, 'value' => $v]);
        }
        return $GridSearch->buildConditions($filters, 'AND', false, $qb);
    }
}
