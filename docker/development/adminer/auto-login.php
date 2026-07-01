<?php

class AdminerAutoLogin
{
    function login($login, $password)
    {
        return true;
    }

    function credentials()
    {
        return [
            $_GET["server"] ?? getenv('ADMINER_DEFAULT_SERVER') ?: 'postgres',
            $_GET["username"] ?? getenv('ADMINER_DEFAULT_USERNAME') ?: 'postgres',
            getenv('ADMINER_AUTO_PASSWORD') ?: 'postgres',
        ];
    }

    function loginFormField($name, $input, $more)
    {
        if ($name === 'password') {
            return '';
        }
        if ($name === 'driver') {
            $more = preg_replace('~(<option value="pgsql")~', '$1 selected', preg_replace('~ selected~', '', $more));
        }
        if ($name === 'server' && ($val = getenv('ADMINER_DEFAULT_SERVER'))) {
            $more = preg_replace('~value="[^"]*"~', "value=\"$val\"", $more);
        }
        if ($name === 'username' && ($val = getenv('ADMINER_DEFAULT_USERNAME'))) {
            $more = preg_replace('~value="[^"]*"~', "value=\"$val\"", $more);
        }

        return $input . $more;
    }
}

return new AdminerAutoLogin();