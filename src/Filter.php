<?php

namespace Saeed\VueFilter;


use Illuminate\Validation\ValidationException;

trait Filter
{


    public function scopeAdvancedFilter($query)
    {

        return $this->process($query, request()->all())
            ->orderBy(
                request('order_column', 'created_at'),
                request('order_direction', 'desc')
            )
            ->paginate(request('limit', 10));
    }

    public function process($query, $data)
    {
        $v= request()->validate([
            'order_column' => 'sometimes|required|in:'.$this->orderableColumns(),
            'order_direction'=>'sometimes|required|in:asc,desc',
            'limit' =>'sometimes|required|integer|min:1' ,
            'filter_match'=> 'sometimes|required|in:and,or',
            'f'=> 'sometimes|required|array',
            'f.*.column'=> 'required|in:'.$this->whiteListColumns(),
            'f.*.operator' => 'required_with:f.*.column|in:'.$this->allowedOperators(),
            'f.*.query_1'=> 'required',
            'f.*.query_2'=> 'required_if:f.*.operator , between, not_between ',



        ]);


        return (new QueryBuilder())->apply($query , $data);
    }

    protected function whiteListColumns()
    {
        return implode(',' , $this->allowedFilters);
    }

    protected function orderableColumns()
    {
        return implode(',' , $this->orderable);
    }

    protected function allowedOperators(){
        return implode(',' , [
            'equal_to',
            'not_equal_to',
            'less_than' ,
            'greater_than',
            'between' ,
            'not_between',
            'contains',
            'starts_with',
            'ends_with',
            'in_the_past',
            'in_the_next',
            'in_the_period',
            'less_then_count',
            'greater_then_count',
            'equal_to_count',
            'not_equal_to_count'
        ]);

    }

}