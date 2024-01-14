<?php

namespace App\Http\Controllers;

use App\GithubApi;
use Inertia\Inertia;

class GithubGistsStarredController extends Controller
{
    /**
     * Retrieves list of gist comments.
     *
     * @return \Inertia\Response
     */
    public function index(GithubApi $githubApi)
    {
        $path = 'gists/starred';
        $response = $githubApi->get($path);

        return Inertia::render('Gists/Index', [
            'gists' => $response
        ]);
    }

    /**
     * Star a gist.
     *
     * @param GithubApi $githubApi The Github API instance.
     * @param string $gistId The ID of the gist to star.
     * 
     * @return mixed The rendered view or the route to redirect to.
     */
    public function star(GithubApi $githubApi, $gistId)
    {
        $path = 'gists/' . $gistId . '/star';
        $response = $githubApi->put($path);

        return isset($response['message'])
            ? Inertia::render('Error', ['error' => $response['message']])
            : to_route('gists.show', ['gistId' => $gistId]);
    }

    /**
     * Unstar a gist.
     *
     * @param GithubApi $githubApi The Github API instance.
     * @param string $gistId The ID of the gist to unstar.
     * 
     * @return mixed The rendered view or the route to redirect to.
     */
    public function unstar(GithubApi $githubApi, $gistId)
    {
        $path = 'gists/' . $gistId . '/star';
        $response = $githubApi->delete($path);

        return isset($response['message'])
            ? Inertia::render('Error', ['error' => $response['message']])
            : to_route('gists.show', ['gistId' => $gistId]);
    }
}
