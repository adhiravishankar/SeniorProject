<?php
/**
 * Created by PhpStorm.
 * User: adhir
 * Date: 1/29/2017
 * Time: 2:15 PM
 */

namespace Caesar\Http\Controllers;

use Illuminate\Http\Request;

class AcceptancesController extends Controller
{

    /**
     * Returns a list of colleges
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            $offset = $request->has('page') * 100 - 100;
            $accepts = $this->datastore->runQuery($this->datastore->query()->kind('Acceptance')->offset($offset));
        } else {
            $accepts = $this->datastore->runQuery($this->datastore->query()->kind('Acceptance')->limit(100));
        }
        dd($accepts);
    }

    /**
     * Return details of a colleges
     *
     * @param Request $request
     * @param $id
     */
    public function details(Request $request, $id)
    {
        $accept = $this->datastore->lookup($this->datastore->key('Acceptance', $id));
        dd($accept);
    }
}