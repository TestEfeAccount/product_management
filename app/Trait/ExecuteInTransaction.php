<?php

namespace App\Trait;

use Illuminate\Support\Facades\DB;
use Throwable;

trait ExecuteInTransaction
{
    private function executeInTransaction(callable $callback): mixed
    {
        try {
            DB::beginTransaction();
            $result = $callback();
            DB::commit();
            return $result;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
