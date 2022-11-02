<?php

namespace App\Helpers;
class Pagination
{
    public static function defaultMetaInput($input) : array
    {
        $page = isset($input['page']) ? (int)$input['page'] : 1;
        $perPage = isset($input['perPage']) ? (int)$input['perPage'] : 50;
        $order = $input['order'] ?? 'created_at';
        $dir = $input['dir'] ?? 'desc';
        $search = isset($input['search']) ? ($input['search']) : '';
        $filter = isset($input['filterID']) ? ($input['filterID']):'';
        $offset = ($page - 1) * $perPage;
        return [
            'order'     => $order,
            'dir'       => $dir,
            'page'      => $page,
            'perPage'   => $perPage,
            'offset'    => $offset,
            'search'    => $search,
            'filterID'  => $filter
        ];
    }

    public static function additionalMeta($meta, $total)
    {
        $meta['total'] = $total;
        $meta['totalPage'] = ceil( $total / $meta['perPage']);
        if($meta['totalPage'] < $meta['page']){
            $meta['page'] = $meta['totalPage'];
        }
        return $meta;
    }

}
