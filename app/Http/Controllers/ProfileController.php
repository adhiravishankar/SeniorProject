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
use Illuminate\View\View;

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

    /**
     * Show edit profile
     *
     * @return View
     */
    public function editProfile()
    {
        return view('users.edit')->with('user', Auth::user());
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
        $this->datastore->update($user);
        return redirect()->route('profile');
    }

}