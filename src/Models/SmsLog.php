<?php

namespace Gengxuliang\LaravelSms\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = ['mobile', 'content', 'template', 'type', 'gateway'];
}
