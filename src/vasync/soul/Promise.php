<?php

declare(strict_types=1);

namespace vasync\soul;

class Promise {
  
    private $onFulfilled = null;
  
    private $onRejected = null;
  
    private $state = 'pending';
  
    private $value = null;

    public function __construct(callable $executor) {
        $resolve = function($value) {
            $this->resolve($value);
        };

        $reject = function($reason) {
            $this->reject($reason);
        };

        try {
            $executor($resolve, $reject);
        } catch (Exception $e) {
            $this->reject($e->getMessage());
        }
    }

    private function resolve($value) {
        if ($this->state !== 'pending') {
            return;
        }

        $this->state = 'fulfilled';
        $this->value = $value;

        if ($this->onFulfilled) {
            call_user_func($this->onFulfilled, $value);
        }
    }

    private function reject($reason) {
        if ($this->state !== 'pending') {
            return;
        }

        $this->state = 'rejected';
        $this->value = $reason;

        if ($this->onRejected) {
            call_user_func($this->onRejected, $reason);
        }
    }

    public function then(callable $onFulfilled = null, callable $onRejected = null) {
        if ($onFulfilled === null) {
            $onFulfilled = function($value) {};
        }

        if ($this->state === 'fulfilled' && $onFulfilled) {
            call_user_func($onFulfilled, $this->value);
        } elseif ($this->state === 'rejected' && $onRejected) {
            call_user_func($onRejected, $this->value);
        } else {
            $this->onFulfilled = $onFulfilled;
            $this->onRejected = $onRejected;
        }

        return $this;
    }

    public function catch(callable $onRejected) {
        return $this->then(null, $onRejected);
    }
}
