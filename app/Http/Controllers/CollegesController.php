<?php
/**
 * Created by PhpStorm.
 * User: adhir
 * Date: 1/29/2017
 * Time: 2:07 PM
 */

namespace Caesar\Http\Controllers;

use Caesar\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CollegesController extends Controller
{

    /**
     * Returns a list of colleges
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            dd('page');
            $offset = $request->has('page') * 100 - 100;
            $colleges = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedCollege')->offset($offset)
                ->order('Name'));
        } else {
            $colleges = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedCollege')->order('name')
                ->limit(100));
        }
        dd(iterator_to_array($colleges));
    }

    /**
     * Return details of a colleges
     *
     * @param Request $request
     * @param $id
     */
    public function details(Request $request, $id)
    {
        $college = $this->datastore->lookup($this->datastore->key('SimplifiedCollege', $id));
        dd($college);
    }

}