<?php

use Illuminate\Support\Facades\Schedule;


Schedule::command('command:sendEmails')->dailyAt('7:00');