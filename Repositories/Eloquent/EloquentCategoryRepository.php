<?php

namespace Modules\Vblog\Repositories\Eloquent;

use Modules\Vblog\Repositories\CategoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{


    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {
            $query->with(['translations']);
        } else {//Especific relationships
            $includeDefault = ['translations'];
            if (isset($params->include))
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;//Short filter


            if (isset($filter->search) && !empty($filter->search)) {
                $criterion = $filter->search;

                $query->whereHas('translations', function (Builder $q) use ($criterion) {
                    $q->where('title', 'like', "%{$criterion}%");
                });
            }

            //Filter by date
            if (isset($filter->date) && !empty($filter->date)) {
                $date = $filter->date;//Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from))//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                if (isset($date->to))//to a date
                    $query->whereDate($date->field, '<=', $date->to);
            }

            //Order by
            if (isset($filter->order) && !empty($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at';//Default field
                $orderWay = $filter->order->way ?? 'desc';//Default way
                $query->orderBy($orderByField, $orderWay);//Add order to query
            }

        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);
        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            if (isset($params->skip) && !empty($params->skip)) {
                $query->skip($params->skip);
            };

            $params->take ? $query->take($params->take) : false;//Take

            return $query->get();
        }

    }

    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {
            $query->with(['translations']);
        } else {
            $includeDefault = ['translations'];
            if (isset($params->include))
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);
        }

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field))//Filter by specific field
                $field = $filter->field;

            // find translatable attributes
            $translatedAttributes = $this->model->translatedAttributes;

            // filter by translatable attributes
            if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
                $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
                    $query->where('locale', $filter->locale)
                        ->where($field, $criteria);
                });
            else
                // find by specific attribute or by id
                $query->where($field ?? 'id', $criteria);
        }

        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        return $query->first();

    }



}
