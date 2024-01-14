<?php

namespace App\Http\Controllers;

use App\GithubApi;
use App\Http\Requests\GistCommentRequest;
use Inertia\Inertia;

class GithubGistsCommentsController extends Controller
{
    /**
     * Store a new comment for a gist.
     *
     * @param GistCommentRequest $request The request object.
     * @param GithubApi $githubApi The Github API client.
     * @param string $gistId The ID of the gist.

     * @return mixed The rendered view or the route to redirect to.
     */
    public function store(GistCommentRequest $request, GithubApi $githubApi, $gistId)
    {
        $path = 'gists/' . $gistId . '/comments';
        $validated = $request->validated();
        $response = $githubApi->post($validated, $path);

        return isset($response['message'])
            ? Inertia::render('Error', ['error' => $response['message']])
            : to_route('gists.show', ['gistId' => $gistId]);
    }

    /**
     * Update a comment on a gist.
     *
     * @param GistCommentRequest $request The request object.
     * @param GithubApi $githubApi The Github API instance.
     * @param string $gistId The ID of the gist.
     * @param string $commentId The ID of the comment to update.
     * 
     * @return mixed The rendered view or the route to redirect to.
     */
    public function update(GistCommentRequest $request, GithubApi $githubApi, $gistId, $commentId)
    {
        $validated = $request->validated();
        $path = 'gists/' . $gistId . '/comments/' . $commentId;
        $response = $githubApi->patch($validated, $path);

        return isset($response['message'])
            ? Inertia::render('Error', ['error' => $response['message']])
            : to_route('gists.show', ['gistId' => $gistId]);
    }

    /**
     * Delete a comment from a gist.
     *
     * @param GithubApi $githubApi The Github API instance.
     * @param string $gistId The ID of the gist.
     * @param string $commentId The ID of the comment to delete.
     * 
     * @return mixed The rendered view or the route to redirect to.
     */
    public function destroy(GithubApi $githubApi, $gistId, $commentId)
    {
        $path = 'gists/' . $gistId . '/comments/' . $commentId;
        $response = $githubApi->delete($path);

        return isset($response['message'])
            ? Inertia::render('Error', ['error' => $response['message']])
            : to_route('gists.show', ['gistId' => $gistId]);
    }
}
