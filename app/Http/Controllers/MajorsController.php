<?php
/**
 * Created by PhpStorm.
 * User: adhi
 * Date: 2/21/17
 * Time: 10:09 PM
 */

namespace Caesar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MajorsController extends Controller
{

    /**
     * Returns a list of majors
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            $offset = $request->has('page') * 100 - 100;
            $majors = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedMajor')->offset($offset)
                ->order('name')->limit(100));
        } else {
            $majors = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedMajor')->order('name')
                ->limit(100));
        }
        return view('majors.index')->with('majors', $majors);
    }

    /**
     * Return details of a majors
     *
     * @param Request $request
     * @param $id
     * @return View
     */
    public function details(Request $request, $id)
    {
        $major = $this->datastore->lookup($this->datastore->key('SimplifiedMajor', $id));
        if ($request->has('page')) {
            $offset = $request->has('page') * 100 - 100;
            $accepts = $this->datastore->runQuery($this->datastore->query()->kind('Acceptance')
                ->filter('simplified_major', '=', (int) $id)->offset($offset)->order('date_add_ts', 'DESCENDING')->limit(100));
        } else {
            $accepts = $this->datastore->runQuery($this->datastore->query()->kind('Acceptance')
                ->filter('simplified_major', '=', (int) $id)->order('date_add_ts', 'DESCENDING')->limit(100));
        }
        return view('majors.details')->with('major', $major)->with('accepts', $accepts);
    }
}