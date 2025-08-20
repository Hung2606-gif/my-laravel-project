
protected function schedule(Schedule $schedule)
{
    // Gửi mail cho từng user lúc 9h sáng và 5h chiều
    $schedule->command('report:send-users')->dailyAt('09:00');
    $schedule->command('report:send-users')->dailyAt('15:02');
}
