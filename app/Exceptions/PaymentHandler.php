<?php

namespace App\Exceptions;

use Exception;

class PaymentHandler extends Exception
{
    //
    protected string $payment_method = '';
    const PAYMENT_METHODS = ['cash', 'paystack'];
    const NOT_INTEGRATED = 404;
    const INVALID_PAYMENT_METHOD = 403;
    public function __construct(
    $payment_method,
    int $code = 0,
    string $message = "",
    \Throwable|null $previous = null)
    {
        $this->payment_method = $payment_method;
        parent::__construct($message, $code, $previous);
    }
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }
    public function resolve()
    {
        switch($this->code){
            case self::NOT_INTEGRATED:
                return back()->withError("$this->payment_method not integrated");
            case self::INVALID_PAYMENT_METHOD:
                    return back()->withError("$this->payment_method not accepted");
            default:
                return back()->withError("Error : $this->message");
        }
    }
}
