<?php
/**
 * Created by PhpStorm.
 * User: adhi
 * Date: 2/26/17
 * Time: 5:11 PM
 */

namespace Caesar\Http\Controllers;

use Auth;
use Caesar\Http\Requests\EditProfileRequest;
use Google\Cloud\Datastore\Entity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Returns the home page
     *
     * @param Request $request
     * @return View
     */
    public function home(Request $request)
    {
        $college = (int) $request->get('college');
        $major = (int) $request->get('major');
        $degree = (int) $request->get('degree');
        $majors = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedMajor')->order('name'));
        $degrees = ['PhD', 'Masters', 'MFA', 'MBA', 'JD', 'EdD', 'Other'];
        $geos = ['American', 'International with US Degree', 'International', 'Other'];
        if (is_null($college) || is_null($major) || is_null($degree)) {
            $statistics = $this->datastore->runQuery($this->datastore->query()->kind('AdmissionStatistics')
                ->filter('college', '=', $college)->filter('major', '=', $major)
                ->filter('degree', '=', $degree));
            return view('home')->with('statistics', $statistics)->with('colleges', $this->getFavoriteColleges())
                ->with('majors', $majors)->with('degrees', $degrees)->with('geos', $geos)
                ->with('geo', (int) $request->get('geo'));
        }
        else
        {
            return view('home')->with('colleges', $this->getFavoriteColleges())->with('majors', $majors)
                ->with('degrees', $degrees)->with('geos', $geos);
        }
    }

    public function home2()
    {
        return redirect()->route('home');
    }

    public function profile()
    {
        $colleges = $this->getFavoriteColleges();
        return view('users.profile')->with('user', Auth::user())->with('colleges', $colleges);
    }

    /**
     * Show edit profile
     *
     * @return View
     */
    public function editProfile()
    {
        $majors = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedMajor')->order('name'));
        return view('users.edit')->with('user', Auth::user())->with('majors', iterator_to_array($majors));
    }

    /**
     * Saves profile information
     *
     * @param EditProfileRequest $request
     * @return RedirectResponse
     */
    public function postProfile(EditProfileRequest $request)
    {
        dd($request->all());
        $user = $this->datastore->lookup($this->datastore->key('User', (int) Auth::user()->getAuthIdentifier()));
        $user->set([
            'name' => $request->get('name'),
            'email' => $request->get('email')
        ]);
        $this->datastore->update($user);
        return redirect()->route('profile');
    }

    /**
     * Get favorite colleges
     *
     * @return array
     */
    public function getFavoriteColleges()
    {
        $user = Auth::user();
        $colleges = $this->datastore->runQuery($this->datastore->query()->kind('UserCollege')
            ->filter('user', '=', (int)$user->getAuthIdentifier()));
        $collegeKeys = collect();
        foreach ($colleges as $college)
            /** @var Entity $college */
            $collegeKeys->push($this->datastore->key('SimplifiedCollege', $college->offsetGet('college')));
        $colleges = $this->datastore->lookupBatch($collegeKeys->toArray());
        if (collect($colleges)->has('found')) {
            $colleges2 = collect($colleges['found'])->sortBy(function ($item) {
                /** @var Entity $item */
                return $item->offsetGet('name');
            })->toArray();
        } else {
            $colleges2 = [];
        }
        return $colleges2;
    }

}