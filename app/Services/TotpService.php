<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Real 2FA Engine (RFC 6238 TOTP)
 * Padrão da indústria compatível com Google Authenticator, Proton Pass, 1Password, Microsoft Authenticator e Authy.
 */
class TotpService
{
    private const BASE32_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    public function generateSecret(int $length = 16): string
    {
        $secret = '';
        $max = strlen(self::BASE32_ALPHABET) - 1;
        for ($i = 0; $i < $length; $i++) {
            $secret .= self::BASE32_ALPHABET[random_int(0, $max)];
        }
        return $secret;
    }

    public function getCode(string $secret, ?int $timestamp = null): string
    {
        $timestamp = $timestamp ?? time();
        $slice = (int) floor($timestamp / 30);
        $secretKey = $this->base32Decode($secret);

        $timeBytes = pack('N*', 0) . pack('N*', $slice);
        $hash = hash_hmac('sha1', $timeBytes, $secretKey, true);

        $offset = ord($hash[19]) & 0x0f;
        $hashpart = substr($hash, $offset, 4);
        $value = unpack('N', $hashpart)[1] & 0x7fffffff;

        return str_pad((string) ($value % 1000000), 6, '0', STR_PAD_LEFT);
    }

    public function verify(string $secret, string $code, int $discrepancy = 1): bool
    {
        $code = trim($code);
        if (strlen($code) !== 6 || !ctype_digit($code)) {
            return false;
        }

        $currentTime = time();
        for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
            $time = $currentTime + ($i * 30);
            $calculated = $this->getCode($secret, $time);
            if (hash_equals($calculated, $code)) {
                return true;
            }
        }

        return false;
    }

    public function getOtpAuthUri(string $company, string $holder, string $secret): string
    {
        $encodedCompany = rawurlencode($company);
        $encodedHolder = rawurlencode($holder);
        return sprintf(
            'otpauth://totp/%s:%s?secret=%s&issuer=%s&algorithm=SHA1&digits=6&period=30',
            $encodedCompany,
            $encodedHolder,
            $secret,
            $encodedCompany
        );
    }

    public function formatSecret(string $secret): string
    {
        return trim(chunk_split($secret, 4, ' '));
    }

    private function base32Decode(string $b32): string
    {
        $b32 = strtoupper(str_replace(' ', '', $b32));
        $binary = '';
        $len = strlen($b32);

        for ($i = 0; $i < $len; $i++) {
            $pos = strpos(self::BASE32_ALPHABET, $b32[$i]);
            if ($pos === false) {
                continue;
            }
            $binary .= str_pad(decbin($pos), 5, '0', STR_PAD_LEFT);
        }

        $bytes = '';
        $binLen = strlen($binary);
        for ($i = 0; $i + 8 <= $binLen; $i += 8) {
            $bytes .= chr(bindec(substr($binary, $i, 8)));
        }

        return $bytes;
    }
}
