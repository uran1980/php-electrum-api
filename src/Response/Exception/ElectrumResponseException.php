<?php

namespace Electrum\Response\Exception;

use Exception;
use Throwable;

/**
 * @author Pascal Krason <p.krason@padr.io>
 * @deprecated Use \Electrum\Response\Exception\BadResponseException instead
 */
class ElectrumResponseException extends Exception
{
    /**
     * Extract electrum error from response
     *
     * @param array $response
     *
     * @return ElectrumResponseException
     */
    public static function createFromElectrumResponse(array $response)
    {
        $message = '';
        $code = 0;

        if (isset($response['error'])) {
            $text = '';
            if ( is_string($response['error']) ) {
                $text = $response['error'];
            }
            else if (
                is_array($response['error'])
                && isset($response['error']['message'])
                && is_string($response['error']['message'])
            ) {
                $text = $response['error']['message'];
            }

            // FIX -------------------------------------------------------------
            $text  = is_string($text) ? [$text] : $text;
            // -----------------------------------------------------------------

            $message = vsprintf( 'Electrum API returned error: `%s`', $text);
        }

        if ( isset($response['error']['code']) ) {
            $code = $response['error']['code'];
        }

        return new self($message, $code);
    }
}
