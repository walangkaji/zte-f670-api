<?php
/**
 * @author walangkaji (https://github.com/walangkaji)
 */

namespace walangkaji\ZteF670;

require_once 'simple_html_dom.php';

use walangkaji\ZteF670\GlobalFunction as Func;

/**
 * ZteF670
 *
 * CATATAN FENTING DEK:
 * - Library ini dibuat tidak untuk kejahatan ataupun kegiatan yang merugikan orang lain,
 *   apalagi untuk usil ke teman atau sanak saudara, itu dosa dek. Mending langsung gelut aja.
 *
 * @author walangkaji (https://github.com/walangkaji)
 */
class ZteF670
{
    public static $proxy;

    public function __construct($ipModem, $username, $password, $debug = false, $proxy = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->debug    = $debug ? true : false;
        self::$proxy    = $proxy;
        $this->modemUrl = "http://$ipModem";
        $this->status   = new Request\Status\Status($this);
    }

    /**
     * Fungsi untuk login
     *
     * @return bool
     */
    public function login()
    {
        $cekLogin = $this->cekLogin();

        if ($cekLogin) {
            $this->debug(__FUNCTION__, 'Login session masih aktif.');

            return true;
        }

        $get = (new Request)
            ->request()
            ->get($this->modemUrl)
            ->getResponse();

        $rand = rand(10000000, 99999999);

        $postdata = [
            'frashnum'       => '',
            'action'         => 'login',
            'Frm_Logintoken' => Func::getLoginToken($get),
            'Username'       => $this->username,
            'Password'       => md5($this->password . $rand),
            'UserRandomNum'  => $rand,
        ];


        $get = (new Request)
        ->request()
        ->post($this->modemUrl, $postdata)
        ->getResponse();

        $cekLogin = $this->cekLogin();

        if ($cekLogin) {
            $this->debug(__FUNCTION__, 'Berhasil login dengan user ' . $this->username);
        } else {
            $this->debug(__FUNCTION__, 'Gagal login dengan user ' . $this->username);
        }

        return $cekLogin;
    }

    /**
     * Fungsi untuk reboot modem
     *
     * @return bool
     */
    public function reboot()
    {
        $get = (new Request)
            ->request()
            ->get($this->modemUrl . Constants::REBOOT)
            ->getResponse();

        $postdata = [
            'IF_ACTION'      => 'devrestart',
            'IF_ERRORSTR'    => 'SUCC',
            'IF_ERRORPARAM'  => 'SUCC',
            'IF_ERRORTYPE'   => -1,
            'flag'           => 1,
            '_SESSION_TOKEN' => Func::find($get, 'session_token = "', '";'),
        ];

        $request = (new Request)
        ->request()
        ->post($this->modemUrl . Constants::REBOOT, $postdata)
        ->getResponse();

        $cek = Func::find($request, "flag','", "'");

        if ($cek == 1) {
            $this->debug(__FUNCTION__, 'Berhasil Reboot modem.');

            return true;
        }

        $this->debug(__FUNCTION__, 'Gagal Reboot modem.');

        return false;
    }

    /**
     * Fungsi untuk cek login
     *
     * @return bool
     */
    private function cekLogin()
    {
        $response = (new Request)
            ->request()
            ->get($this->modemUrl . Constants::TEMPLATE)
            ->getResponse();

        if (strpos($response, 'logout_redirect') !== false) {
            return false;
        }

        return true;
    }

    /**
     * Untuk debug proses
     *
     * @param mixed $function
     * @param mixed $text
     */
    private function debug($function, $text = '')
    {
        $space = 10 - strlen($function);
        $space = ($space < 0) ? 0 : $space;

        if ($this->debug) {
            echo '[' . date('h:i:s A') . "]: $function" . str_repeat(' ', $space);
            echo(empty($text) ? '' : ': ' . $text) . PHP_EOL;
        }
    }
}
