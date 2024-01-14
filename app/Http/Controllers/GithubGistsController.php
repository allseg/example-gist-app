<?php

namespace App\Http\Controllers;

use App\GithubApi;
use App\Http\Requests\GistRequest;
use Inertia\Inertia;

class GithubGistsController extends Controller
{
    /**
     * Retrieves the list of gists.
     *
     * @return \Inertia\Response
     */
    public function index(GithubApi $githubApi)
    {
        $path = 'gists';
        $response = $githubApi->get($path);

        return Inertia::render('Gists/Index', [
            'gists' => $response
        ]);
    }

    /**
     * Show a specific gist by its ID.
     *
     * @param int $gistId The ID of the gist to show.
     * @return \Inertia\Response The rendered Inertia response.
     */
    public function show(GithubApi $githubApi, $gistId)
    {
        $path = 'gists/' . $gistId;
        $response = $githubApi->get($path);

        $path = 'gists/' . $gistId . '/comments';
        $commentsResponse = $githubApi->get($path);

        $path = 'gists/starred';
        $starredResponse = $githubApi->get($path);
        $isStarred = collect($starredResponse)->firstWhere('id', $gistId) ? true : false;

        return isset($response['message'])
            ? Inertia::render('Error', ['error' => $response['message']])
            : Inertia::render('Gists/Show', [
                'gist' => $response,
                'comments' => $commentsResponse,
                'isStarred' => $isStarred
            ]);
    }

    /**
     * Create a new gist.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Gists/Create');
    }

    /**
     * Store a new gist.
     *
     * @param GistRequest $request The request object.
     * @param GithubApi $githubApi The Github API instance.
     * 
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    public function store(GistRequest $request, GithubApi $githubApi)
    {
        $validated = $request->validated();
        $path = 'gists';
        $response = $githubApi->post($validated, $path);

        return isset($response['message'])
            ? Inertia::render('Error', ['error' => $response['message']])
            : to_route('gists.show', ['gistId' => $response['id']]);
    }

    /**
     * Edit a gist using.
     *
     * @param GithubApi $githubApi The Github API instance.
     * @param string $gistId The ID of the gist to edit.
     * 
     * @return Inertia::render The rendered view for the Gists/Edit page.
     */
    public function edit(GithubApi $githubApi, $gistId)
    {
        $path = 'gists/' . $gistId;
        $response = $githubApi->get($path);

        return isset($response['message'])
            ? Inertia::render('Error', ['error' => $response['message']])
            : Inertia::render('Gists/Edit', ['gist' => $response]);
    }

    /**
     * Update a gist.
     *
     * @param GistRequest $request The request object.
     * @param GithubApi $githubApi The Github API instance.
     * @param string $gistId The ID of the gist to update.
     * 
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    public function update(GistRequest $request, GithubApi $githubApi, $gistId)
    {
        $validated = $request->validated();
        $path = 'gists/' . $gistId;
        $response = $githubApi->patch($validated, $path);

        return isset($response['message'])
            ? Inertia::render('Error', ['error' => $response['message']])
            : to_route('gists.show', ['gistId' => $gistId]);
    }

    /**
     * Delete a gist.
     *
     * @param GithubApi $githubApi The Github API instance.
     * @param string $gistId The ID of the gist to delete.
     * 
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    public function destroy(GithubApi $githubApi, $gistId)
    {
        $path = 'gists/' . $gistId;
        $response = $githubApi->delete($path); 

        return isset($response['message'])
            ? Inertia::render('Error', ['error' => $response['message']])
            : to_route('gists.index');
    }
}
