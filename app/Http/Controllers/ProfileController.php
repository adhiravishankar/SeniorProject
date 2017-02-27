<?php
/**
 * Created by PhpStorm.
 * User: adhi
 * Date: 2/26/17
 * Time: 5:11 PM
 */

namespace Caesar\Http\Controllers;


use Auth;
use Google\Cloud\Datastore\Entity;

class ProfileController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function profile()
    {
        $user = Auth::user();
        $colleges = iterator_to_array($this->datastore->runQuery($this->datastore->query()->kind('CollegeInterest')
            ->filter('user', '=', $user->getAuthIdentifier())));
        $collegeKeys = collect();
        foreach ($colleges as $college)
            /** @var Entity $college */
            $collegeKeys->push($this->datastore->key('SimplifiedCollege', $college->offsetGet('college')));
        $colleges = $this->datastore->lookupBatch($collegeKeys->toArray());
        return view('users.profile')->with('user', $user)->with('colleges', $colleges);
    }

    public function editProfile()
    {

    }

}