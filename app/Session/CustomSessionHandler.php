<?php


namespace App\Session;

use App\User;
use Illuminate\Support\Facades\Auth;
use SessionHandlerInterface;

class CustomSessionHandler implements SessionHandlerInterface
{
    public function open($savePath, $sessionName)
    {
        return true;
    }

    public function close()
    {
        $userId = session('user_id');

        // Check if the user ID exists and the user is authenticated
        if ($userId && Auth::check()) {
            // Get the user associated with the user ID
            $user = User::find($userId);

        }

        return true;
    }

    public function read($sessionId)
    {
        // Implement session data retrieval here
    }

    public function write($sessionId, $data)
    {
        // Implement session data storage here
    }

    public function destroy($sessionId)
    {
        // Implement session destruction here
    }

    public function gc($maxLifetime)
    {
        // Implement garbage collection here
    }
}