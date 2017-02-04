<?php
/**
 * Created by PhpStorm.
 * User: adhir
 * Date: 1/29/2017
 * Time: 2:07 PM
 */

namespace Caesar\Http;

use Caesar\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CollegesController extends Controller
{

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            $offset = $request->has('page') * 100 - 100;
            $colleges = $this->datastore->runQuery($this->datastore->query()->kind('College')->offset($offset)
                ->order('Name'));
        } else {
            $colleges = $this->datastore->runQuery($this->datastore->query()->kind('College')->order('Name')
                ->limit(100));

        }
    }

}