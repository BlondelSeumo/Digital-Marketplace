<?php

namespace App\View\Components;

use App\Models\OAuthProvider;
use Illuminate\View\Component;

class OauthButtons extends Component
{
    public function render()
    {
        $oauthProviders = OAuthProvider::active()->get();
        return theme_view('components.oauth-buttons', ['oauthProviders' => $oauthProviders]);
    }
}
