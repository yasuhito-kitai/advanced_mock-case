<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderEmail;

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

        $today_reservations = Reservation::with('user','shop')->where("date","=",$today)->get();

        foreach($today_reservations as $today_reservation){
            $send_user = $today_reservation->user;
            $customer_name = $send_user->name;
            $customer_email = $send_user->email;
            $shop_name = $today_reservation->shop->name;
            $reservation_date = $today_reservation->date;
            $reservation_time = $today_reservation->time;
            $reservation_number = $today_reservation->number;
        Mail::to($customer_email)->send(new ReminderEmail($customer_email,$customer_name,$shop_name, $reservation_date, $reservation_time, $reservation_number));
        }
    }

}