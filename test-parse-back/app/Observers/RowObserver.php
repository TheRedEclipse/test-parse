<?php

namespace App\Observers;

use App\Events\RowChannel;
use App\Models\Row;

class RowObserver
{
    /**
     * Broadcast newly created Row model on the RowChannel.
     *
     * @param  \App\Models\Row  $product
     * @return void
     */
    public function created(Row $row)
    {
        event(new RowChannel($row));
    }
}
