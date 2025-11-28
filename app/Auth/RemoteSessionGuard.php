<?php

namespace App\Auth;

use App\Models\User;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class RemoteSessionGuard implements StatefulGuard
{
    use GuardHelpers;

    protected Session $session;
    protected Request $request;
    protected string $name;
    protected string $sessionKey;
    protected string $tokenKey;

    public function __construct(string $name, Session $session, Request $request)
    {
        $this->name = $name;
        $this->session = $session;
        $this->setRequest($request);

        $this->sessionKey = "remote_{$name}_user";
        $this->tokenKey = "remote_{$name}_token";
    }

    public function check(): bool
    {
        return !is_null($this->user());
    }

    public function guest(): bool
    {
        return !$this->check();
    }

    public function user(): ?Authenticatable
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $data = $this->session->get($this->sessionKey);

        if (!$data) {
            return null;
        }

        $user = new User();
        $user->forceFill($data);
        $user->exists = false;

        if ($token = $this->session->get($this->tokenKey)) {
            $user->setAttribute('api_token', $token);
        }

        return $this->user = $user;
    }

    public function id(): mixed
    {
        return $this->user()?->getAuthIdentifier();
    }

    public function validate(array $credentials = []): bool
    {
        return false;
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;

        return $this;
    }

    public function attempt(array $credentials = [], $remember = false): bool
    {
        return false;
    }

    public function once(array $credentials = []): bool
    {
        return $this->attempt($credentials, false);
    }

    public function login(Authenticatable $user, $remember = false): void
    {
        $this->storeUser($user);
    }

    public function loginUsingId($id, $remember = false): bool
    {
        return false;
    }

    public function onceUsingId($id): bool
    {
        return false;
    }

    public function logout(): void
    {
        $this->user = null;
        $this->session->forget([$this->sessionKey, $this->tokenKey]);
    }

    public function hasUser(): bool
    {
        return !is_null($this->user);
    }

    public function viaRemember(): bool
    {
        return false;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Persist remote user data and its API token inside the session.
     */
    public function storeRemoteUser(array $userData, string $token): User
    {
        $user = new User();
        $user->forceFill($userData);
        $user->exists = false;
        $user->setAttribute('api_token', $token);

        $this->session->put($this->sessionKey, $userData);
        $this->session->put($this->tokenKey, $token);
        $this->session->migrate(true);

        $this->setUser($user);

        return $user;
    }

    public function token(): ?string
    {
        return $this->session->get($this->tokenKey);
    }

    protected function storeUser(Authenticatable $user): void
    {
        $this->session->put($this->sessionKey, $user->toArray());
        $this->session->migrate(true);
        $this->setUser($user);
    }
}



