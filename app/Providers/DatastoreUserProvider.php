<?php
/**
 * Created by PhpStorm.
 * User: adhi
 * Date: 2/26/17
 * Time: 5:25 PM
 */

namespace Caesar\Providers;


use Caesar\User;
use Google\Cloud\Datastore\DatastoreClient;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class DatastoreUserProvider implements UserProvider
{

    protected $datastore;

    /**
     * Create a new database user provider.
     *
     */
    public function __construct()
    {
        $this->datastore = new DatastoreClient([
            'projectId' => env('GOOGLE_PROJECT_ID'),
            'keyFilePath' => __DIR__ . '/../../' . env('GOOGLE_CREDENTIALS_JSON'),
            'namespaceId' => env('DB_DATABASE')
        ]);
    }


    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $user = $this->datastore->lookup($this->datastore->key('User', $identifier));
        if (!is_null($user))
            return User::createUser($user);
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return User::createUser($this->datastore->lookup($this->datastore->key('User', $identifier)));
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user = $this->datastore->lookup($this->datastore->key('User', $user->getAuthIdentifier()));
        $user->offsetSet('remember_token', $token);
        $this->datastore->update($user);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        // TODO: Implement retrieveByCredentials() method.
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // TODO: Implement validateCredentials() method.
    }
}