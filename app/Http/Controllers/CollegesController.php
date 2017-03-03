<?php
/**
 * Created by PhpStorm.
 * User: adhir
 * Date: 1/29/2017
 * Time: 2:07 PM
 */

namespace Caesar\Http\Controllers;

use Google\Cloud\Datastore\Query\Query;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollegesController extends Controller
{

    /**
     * Returns a list of colleges
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            $offset = $request->has('page') * 100 - 100;
            $colleges = iterator_to_array($this->datastore->runQuery($this->datastore->query()->kind('SimplifiedCollege')
                ->offset($offset)->order('name')->limit(100)));
        } else {
            $colleges = iterator_to_array($this->datastore->runQuery($this->datastore->query()->kind('SimplifiedCollege')
                ->order('name')->limit(100)));
        }
        return view('colleges.index')->with('colleges', $colleges);
    }

    /**
     * Return details of a colleges
     *
     * @param Request $request
     * @param $id
     */
    public function details(Request $request, $id)
    {
        $id = (int) base_convert($id, 36, 10);
        $college = $this->datastore->lookup($this->datastore->key('SimplifiedCollege', $id));
        if ($request->has('page')) {
            $offset = $request->has('page') * 100 - 100;
            $accepts = iterator_to_array($this->datastore->runQuery($this->datastore->query()->kind('Acceptance')
                ->filter('college', '=', $id)->offset($offset)->order('date_add_ts', 'DESCENDING')->limit(100)));
        } else {
            $accepts = iterator_to_array($this->datastore->runQuery($this->datastore->query()->kind('Acceptance')
                ->filter('college', '=', $id)->order('date_add_ts', 'DESCENDING')->limit(100)));
        }
        dd($college, $accepts);
    }

}