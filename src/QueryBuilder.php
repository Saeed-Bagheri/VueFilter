<?php

namespace Saeed\VueFilter;


class  QueryBuilder
{

    public function apply($query, $data)
    {
        if (isset($data['f'])) {
            foreach ($data['f'] as $filter) {
                $filter['match'] = isset($filter['filter_match']) ? $ $filter['filter_match'] : 'and';
                $this->makeFilter($query, $filter);
            }
        }
        return $query;
    }

    protected function makeFilter($query, $filter)
    {
        //find the type of colum
        if(strpos($filter['column'] , '.') !== false)
        {
            //nested column

            list($relation , $filter['column']) =explode('.' , $filter['column']);
            $filter['match'] ='and';
            if($filter['column']=='count')
            {
                $this->{camel_case($filter['operator'])}($filter, $query , $relation);

            }else
            {
                $query->whereHas($relation , function ($q) use ($filter){

                    $this->{camel_case($filter['operator'])}($filter, $q);

                });
            }

        }else
        {

            //normal column
            $this->{camel_case($filter['operator'])}($filter, $query);

        }
    }

    public function equalTo($filter, $query)
    {
        $query->where($filter['column'], '=', $filter['query_1'], $filter['match']);
    }

    public function notEqualTo($filter, $query)
    {
        $query->where($filter['column'], '<>', $filter['query_1'], $filter['match']);
    }

    public function lessThan($filter, $query)
    {
        $query->where($filter['column'], '<', $filter['query_1'], $filter['match']);
    }

    public function greaterThan($filter, $query)
    {
        $query->where($filter['column'], '>', $filter['query_1'], $filter['match']);
    }

    public function between($filter, $query)
    {
        $query->whereBetween($filter['column'], [
            $filter['query_1'], $filter['query_2']
        ], $filter['match']);
    }

    public function notBetween($filter, $query)
    {
        $query->whereNotBetween($filter['column'], [
            $filter['query_1'], $filter['query_2']
        ], $filter['match']);
    }

    public function contains($filter, $query) //search
    {
        $query->where($filter['column'], 'like', '%' . $filter['query_1'] . '%', $filter['match']);
    }

    public function startsWith($filter, $query)
    {
        $query->where($filter['column'], 'like', $filter['query_1'] . '%', $filter['match']);
    }

    public function endsWith($filter, $query)
    {
        $query->where($filter['column'], 'like', '%' . $filter['query_1'], $filter['match']);
    }


    public function inThePast($filter, $query)
    {
        $end = now()->endOfDay();
        $begin = now();

        switch ($filter['query_2']) {
            case 'hours':
                $begin->subHour($filter['query_1']);
                break;

            case 'days':
                $begin->subDays($filter['query_1'])->startOfDay();
                break;

            case 'months':
                $begin->subMonth($filter['query_1'])->startOfDay();
                break;

            case 'years':
                $begin->subYears($filter['query_1'])->startOfDay();
                break;

            default:
                $begin->subDays($filter['query_1'])->startOfDay();
        }

        return $query->whereBetween($filter['column'], [$begin, $end], $filter['match']);
    }


    public function inTheNext($filter, $query)
    {
        $begin = now()->startOfDay();
        $end = now();

        switch ($filter['query_2']) {
            case 'hours':
                $end->addHour($filter['query_1']);
                break;

            case 'days':
                $end->addDays($filter['query_1']);
                break;
            case 'days':
                $end->addDays($filter['query_1'])->endOfDay();
                break;

            case 'months':
                $end->addMonth($filter['query_1'])->endOfDay();
                break;

            case 'years':
                $end->addYears($filter['query_1'])->endOfDay();
                break;

            default:
                $end->addDays($filter['query_1'])->endOfDay();
        }

        return $query->whereBetween($filter['column'], [$begin, $end], $filter['match']);
    }

    public function inThePeriod($filter, $query)
    {
        $begin = now();
        $end = now();

        switch ($filter['query_1']) {
            case 'today':
                $begin->startOfDay();
                $end->endOfDay();
                break;

            case 'yesterday':
                $begin->subDays(1)->startOfDay();
                $end->subDays(1)->endOfDay();
                break;

            case 'tomorrow':
                $begin->addDay(1)->startOfDay();
                $end->addDay(1)->endOfDay();
                break;

            case 'last_month':
                $begin->subMonth(1)->startOfMonth();
                $end->subMonth(1)->endOfMonth();
                break;

            case 'this_month':
                $begin->startOfMonth();
                $end->endOfMonth();
                break;

            case 'next_month':
                $begin->addMonth(1)->startOfMonth();
                $end->addMonth(1)->endOfMonth();
                break;

            case 'last_year':
                $begin->subYear(1)->startOfYear();
                $end->subYear(1)->endOfYear();
                break;

            case 'this_year':
                $begin->startOfYear();
                $end->endOfYear();
                break;

            case 'next_year':
                $begin->addYear(1)->startOfYear();
                $end->addYear(1)->endOfYear();
                break;

            default:
                break;
        }

        $query->whereBetween($filter['column'] , [$begin ,$end] ,$filter['match']);
    }


    public function equalToCount($filter, $query , $relation)
    {
        $query->has($relation, '=', $filter['query_1']);
    }

    public function notequalToCount($filter, $query , $relation)
    {
        $query->has($relation, '<>', $filter['query_1']);
    }

    public function lessThanCount($filter, $query , $relation)
    {
        $query->has($relation, '<', $filter['query_1']);
    }

    public function greaterThanCount($filter, $query , $relation)
    {
        $query->has($relation, '>', $filter['query_1']);
    }



}
