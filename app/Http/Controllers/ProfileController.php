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
use jlawrence\eos\Parser;

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
        $geo = (int) $request->get('geo');
        $graph = (int) $request->get('graph');
        $user = Auth::user();
        $majors = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedMajor')
            ->order('name'));
        $degrees = ['PhD', 'Masters', 'MFA', 'MBA', 'JD', 'EdD', 'Other'];
        $geos = ['American', 'International with US Degree', 'International', 'Other'];
        if ($college == 0 || $major == 0 || $degree == 0) {
            $statistics = $this->datastore->runQuery($this->datastore->query()->kind('AdmissionStatistics')
                ->filter('college', '=', $college)->filter('major', '=', $major)
                ->filter('degree', '=', $degree));
            return view('home')->with('statistics', $statistics)->with('colleges', $this->getFavoriteColleges())
                ->with('majors', $majors)->with('degrees', $degrees)->with('geos', $geos)
                ->with('geo', (int) $request->get('geo'))->with('selected_college', null)
                ->with('selected_major', null)->with('selected_degree', null)->with('selected_geo', null)
                ->with('selected_graph', null)->with('gpa', 0)->with('gre_math', 0)->with('gre_verbal', 0)
                ->with('average', 0)->with('decisions', null);
        }
        else
        {
            $statistic = collect(iterator_to_array($this->datastore->runQuery($this->datastore->query()
                ->kind('AdmissionStatistic')
                ->filter('college', '=', $college)
                ->filter('major', '=', $major)
                ->filter('degree', '=', $degree))))->first();
            $gpa = $this->getEquationResult($statistic['gpa_line'], $user->gpa);
            $grev = $this->getEquationResult($statistic['gre_verbal_line'], $user->grev);
            $grem = $this->getEquationResult($statistic['gre_math_line'], $user->grem);
            $math_stats = [$gpa, $grev, $grem];
            $average = array_sum($math_stats)/count($math_stats);
            $decisions = collect(iterator_to_array($this->datastore->runQuery($this->datastore->query()
                ->kind('Acceptance')
                ->filter('simplified_college', '=', $college)
                ->filter('simplified_major', '=', $major)
                ->filter('degree', '=', $degree))));
            $acceptances = $decisions->filter(function ($decision) {
                return array_get($decision, 'decision') == 1;
            })->map(function ($decision) {
                return $decision->get();
            });
            $rejections = $decisions->filter(function ($decision) {
                return array_get($decision, 'decision') == 2;
            })->map(function ($decision) {
                return $decision->get();
            });
            $acceptances_3d = $acceptances->map(function ($decision) {
                return [array_get($decision, 'gpa'), array_get($decision, 'gre_verbal'),
                    array_get($decision, 'gre_math')];
            })->values();
            $rejections_3d = $rejections->map(function ($decision) {
                return [array_get($decision, 'gpa'), array_get($decision, 'gre_verbal'),
                    array_get($decision, 'gre_math')];
            })->values();
            return view('home')->with('colleges', $this->getFavoriteColleges())->with('majors', $majors)
                ->with('degrees', $degrees)->with('geos', $geos)->with('decisions', $decisions)
                ->with('statistics', $statistic)->with('acceptances_3d', $acceptances_3d)
                ->with('rejections_3d', $rejections_3d)->with('selected_college', $college)
                ->with('selected_major', $major)->with('selected_degree', $degree)->with('selected_geo', $geo)
                ->with('selected_graph', $graph)->with('gpa', round($gpa*100, 2))
                ->with('gre_verbal', round($grev*100, 2))
                ->with('gre_math', round($grem*100, 2))
                ->with('average', round($average*100, 2));
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
        $majors = $this->datastore->runQuery($this->datastore->query()->kind('SimplifiedMajor')
            ->order('name'));
        return view('users.edit')->with('user', Auth::user())->with('majors', iterator_to_array($majors));
    }

    /**
     * Saves profile information
     *
     * @param EditProfileRequest $request
     * @return RedirectResponse
     */
    public function postProfile(Request $request)
    {
        $user = $this->datastore->lookup($this->datastore->key('User', (int) Auth::user()->getAuthIdentifier()));
        $user->set([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'gpa' => $request->get('gpa'),
            'grev' => $request->get('grev'),
            'grem' => $request->get('grem')
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

    /**
     * @param $statistic
     * @param $user
     */
    public function getEquationResult($line, $user)
    {
        $vars = explode('x', str_replace(' ', '', $line));
        $number = ((double)$vars[0]) * ((double) $user) + ((double)$vars[1]);
        return $number;
    }

}