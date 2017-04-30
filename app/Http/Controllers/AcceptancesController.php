<?php
/**
 * Created by PhpStorm.
 * User: adhir
 * Date: 1/29/2017
 * Time: 2:15 PM
 */

namespace Caesar\Http\Controllers;

use Caesar\Http\Requests\PostAcceptanceRequest;
use Illuminate\Http\RedirectResponse;
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
            $accepts = $this->datastore->runQuery($this->datastore->query()->kind('Acceptance')->offset($offset)
                ->limit(100));
        } else {
            $accepts = $this->datastore->runQuery($this->datastore->query()->kind('Acceptance')->limit(100));
        }
        return view('accepts.index')->with('accepts', $accepts);
    }

    /**
     * Return details of a colleges
     *
     * @param Request $request
     * @param int $college
     * @param int $major
     * @return View
     */
    public function details(Request $request, $college, $major)
    {
        $college = $this->datastore->lookup($this->datastore->key('SimplifiedCollege', $college));
        $major = $this->datastore->lookup($this->datastore->key('SimplifiedMajor', $major));
        if ($request->has('page')) {
            $offset = $request->has('page') * 100 - 100;
            $accepts = $this->datastore->runQuery($this->datastore->query()->kind('Acceptance')
                ->filter('college', '=', $college)->filter('major', '=', $major)
                ->offset($offset)->limit(100));
        } else {
            $accepts = $this->datastore->runQuery($this->datastore->query()->kind('Acceptance')
                ->filter('college', '=', $college)->filter('major', '=', $major)
                ->limit(100));
        }
        return view('accepts.details')->with('accepts', $accepts);
    }

    /**
     * Post an acceptance and redirect back to acceptances
     *
     * @param PostAcceptanceRequest $request
     * @return RedirectResponse
     */
    public function postAcceptance(PostAcceptanceRequest $request)
    {
        $acceptanceKey = $this->datastore->key('Acceptance');
        $acceptance = $this->datastore->entity($acceptanceKey, $request->all());
        $this->datastore->insert($acceptance);
        return redirect()->route('acceptancesList');
    }

}