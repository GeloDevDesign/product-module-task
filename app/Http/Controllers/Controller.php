<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const PER_PAGE = 50;
    const DISPLAY_ALL = 'all';

    public function paginateCollection($results, $currentPage, $perPage, $opt = null)
    {
        $temp = $results;
        $currentIndex = (($currentPage == 1 || $currentPage == 0) ? 0 : $currentPage - 1) * $perPage;
        $slice = $temp->slice($currentIndex, $perPage)->values();

        $opt = ($opt == null) ? ['path' => ''] : $opt;

        return new LengthAwarePaginator($slice, count($results), $perPage, $currentPage, $opt);
    }

    public function paginateData(Request $request, $collection)
    {
        $paginated = null;
        $page = $request->page ?? 1;
        $perPage = $request->filled('per_page') ?  $request->per_page : self::PER_PAGE;

        if ($request->filled('per_page')) {
            if ($request->per_page != self::DISPLAY_ALL) {
                $paginated = $this->paginateCollection($collection, $page, $perPage);
            } else {
                $paginated = $collection;
            }
        } else {
            $paginated = $this->paginateCollection($collection, $page, $perPage);
        }

        return $paginated;
    }

    public function paginateQuery(Request $request, $query)
    {
        $collection = null;
        if ($request->filled('per_page')) {
            if ($request->per_page != 'all') {
                $collection = $query->paginate($request->per_page);
            } else {
                $collection = $query->get();
            }
        } else {
            $collection = $query->paginate(50);
        }

        return $collection;
    }


    public function sanitizeDateRange($date)
    {
        $exploded = explode(' - ', $date);

        if (count($exploded) == 2) {
            $fromDate = Carbon::createFromFormat('m/d/Y', $exploded[0])->copy()->toDateString();
            $toDate = Carbon::createFromFormat('m/d/Y', $exploded[1])->copy()->toDateString();


            $dateRangeObj = new \StdClass;
            $dateRangeObj->fromDate = $fromDate;
            $dateRangeObj->toDate = $toDate;
            return $dateRangeObj;
        }


        throw new Exception("Provided daterange is invalid.", 1);

    }
}
