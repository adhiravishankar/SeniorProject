<?php
/**
 * Created by PhpStorm.
 * User: adhir
 * Date: 1/29/2017
 * Time: 2:07 PM
 */

namespace Caesar\Http\Controllers;

use Auth;
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
            $colleges = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedCollege')
                ->offset($offset)->order('name')->limit(100));
        } else {
            $colleges = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedCollege')
                ->order('name')->limit(100));
        }
        return view('colleges.index')->with('colleges', $colleges);
    }

    /**
     * Return details of a colleges
     *
     * @param Request $request
     * @param $id
     * @return View
     */
    public function details(Request $request, $id)
    {
        $id = (int) base_convert($id, 36, 10);
        $college = $this->datastore->lookup($this->datastore->key('SimplifiedCollege', $id));
        $selected = iterator_to_array($this->datastore->runQuery($this->datastore->query()->kind('UserCollege')
            ->filter('user', '=', (int) Auth::user()->getAuthIdentifier())->filter('college', '=', (int) $id)->limit(1)));
        $selected = collect($selected)->count() == 0 ? false : true;
        if ($request->has('page')) {
            $offset = $request->has('page') * 100 - 100;
            $accepts = $this->datastore->runQuery($this->datastore->query()->kind('Acceptance')
                ->filter('simplified_college', '=', $id)->offset($offset)->order('date_add_ts', 'DESCENDING')->limit(100));
        } else {
            $accepts = $this->datastore->runQuery($this->datastore->query()->kind('Acceptance')
                ->filter('simplified_college', '=', $id)->order('date_add_ts', 'DESCENDING')->limit(100));
        }
        return view('colleges.data')->with('college', $college)->with('selected', $selected)->with('accepts', $accepts);
    }

    /**
     * Returns a list of colleges
     *
     * @return View
     */
    public function add()
    {
        $colleges = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedCollege')->order('name'));
        return view('colleges.add')->with('colleges', $colleges);
    }

}