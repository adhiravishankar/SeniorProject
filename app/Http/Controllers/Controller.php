<?php

namespace Caesar\Http\Controllers;

use Google\Cloud\Datastore\DatastoreClient;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var DatastoreClient
     */
    protected $datastore;

    /**
     * Controller constructor
     */
    public function __construct()
    {
        $this->datastore = new DatastoreClient([
            'projectId' => env('GOOGLE_PROJECT_ID'),
            'keyFilePath' => __DIR__ . '/../../' . env('GOOGLE_CREDENTIALS_JSON'),
            'namespaceId' => env('DB_DATABASE')
        ]);
    }
}
