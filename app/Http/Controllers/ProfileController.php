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
        $colleges = $this->datastore->runQuery($this->datastore->query()->kind('UserCollege')
            ->filter('user', '=', (int) $user->getAuthIdentifier()));
        $collegeKeys = collect();
        foreach ($colleges as $college)
            /** @var Entity $college */
            $collegeKeys->push($this->datastore->key('SimplifiedCollege', $college->offsetGet('college')));
        $colleges = $this->datastore->lookupBatch($collegeKeys->toArray())['found'];
        $colleges = collect($colleges)->sortBy(function ($item) {
            /** @var Entity $item */
            return $item->offsetGet('name');
        });
        return view('users.profile')->with('user', $user)->with('colleges', $colleges);
    }

    public function editProfile()
    {
        $user = Auth::user();
        $colleges = iterator_to_array($this->datastore->runQuery($this->datastore->query()->kind('CollegeInterest')
            ->filter('user', '=', (int) $user->getAuthIdentifier())));
        $collegeKeys = collect();
        foreach ($colleges['found'] as $college)
            /** @var Entity $college */
            $collegeKeys->push($this->datastore->key('SimplifiedCollege', $college->offsetGet('college')));
        $colleges = $this->datastore->lookupBatch($collegeKeys->toArray())['found'];
        return view('users.edit')->with('user', $user)->with('colleges', $colleges);
    }

    /**
     * Saves profile information
     *
     * @param EditProfileRequest $request
     * @return RedirectResponse
     */
    public function postProfile(EditProfileRequest $request)
    {
        $user = $this->datastore->lookup($this->datastore->key('User', (int) Auth::user()->getAuthIdentifier()));
        $user->set([
            'name' => $request->get('name'),
            'email' => $request->get('email')
        ]);
        return redirect()->route('profile');
    }

}