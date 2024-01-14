<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GithubLoginController extends Controller
{
    /**
     * Redirects the user to the GitHub authentication page using the Socialite package.
     */
    public function redirect()
    {
        return Socialite::driver('github')->scopes(['read:user', 'gist'])->redirect();
    }
    
    /**
     * Callback function for handling the response from the GitHub OAuth callback.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback()
    {
        $githubUser = Socialite::driver('github')->user();
        
        $user = User::updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'github_id' => $githubUser->id,
            'github_nickname' => $githubUser->nickname,
            'github_avatar' => $githubUser->avatar,
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]);
     
        Auth::login($user);
     
        return redirect('/dashboard');
    }
}
