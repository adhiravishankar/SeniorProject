<?php
/**
 * Created by PhpStorm.
 * User: adhi
 * Date: 2/21/17
 * Time: 10:09 PM
 */

namespace Caesar\Http\Controllers;


use Illuminate\Http\Request;

class MajorsController extends Controller
{
    /**
     * Returns a list of majors
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            $offset = $request->has('page') * 100 - 100;
            $majors = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedMajor')->offset($offset)
                ->order('Name'));
        } else {
            $majors = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedMajor')->order('name')
                ->limit(100));
        }
        dd(iterator_to_array($majors));
    }

    /**
     * Return details of a majors
     *
     * @param Request $request
     * @param $id
     */
    public function details(Request $request, $id)
    {
        $major = $this->datastore->lookup($this->datastore->key('SimplifiedMajor', $id));
    }
}