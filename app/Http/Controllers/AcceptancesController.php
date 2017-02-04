<?php
/**
 * Created by PhpStorm.
 * User: adhir
 * Date: 1/29/2017
 * Time: 2:15 PM
 */

namespace Caesar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AcceptancesController extends Controller
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
            $colleges = $this->datastore->runQuery($this->datastore->query()->kind('College')->offset($offset)
                ->order('Name')->projection(['name']));
        } else {
            $colleges = $this->datastore->runQuery($this->datastore->query()->kind('College')->order('Name')
                ->limit(100)->projection(['name']));
        }
        return view('colleges.list')->with('colleges', $colleges);
    }

    /**
     * Return details of a college
     *
     * @param Request $request
     * @return View
     */
    public function details(Request $request)
    {
        $college = $this->datastore->lookup($this->datastore->key('College', $request->get('id')));
        return view('colleges.data')->with('college', $college);
    }
}