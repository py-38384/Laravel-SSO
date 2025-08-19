<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected $next;
    public function create(Request $request): View
    {
        $next = $request->get('next');
        return view('auth.login',['next' => $next]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        if($request->exists('next')){
            $this->next = $request->next;
        }

        $request->authenticate();

        $request->session()->regenerate();

        if($this->next){
            return redirect(route('redirect.token').'?next='.$this->next);
        }
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if(isset(Auth::user()->token)){
            $token_id = Auth::user()->token->token_id;
            $user->tokens()->where('id', $token_id)->delete();
            Auth::user()->token->delete();
        }
        

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
