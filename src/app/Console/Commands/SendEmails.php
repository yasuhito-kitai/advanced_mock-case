<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\OwnerEmail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendEmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '予約当日の朝に予約情報のリマインダーを送る';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');
        $find_reservations=Reservation::with('user')->where("date","=",$today)->get();
        $send_users = $find_reservations->user->email->get();
        foreach($send_users as $send_user){
        Mail::to($send_user)->send(new OwnerEmail($subject, $body));
        }
    }

}