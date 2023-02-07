<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailLulusTempahan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $id;
    public function __construct($tempahan_bilik_id)
    {
        $this->id = $tempahan_bilik_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data = $newRegistration->getData($m->id);
            try{
                if($m->status == 1){
                    Mail::send('segment/mail/invoice_pending', ['data' => $data], function($message) use ($data){
                        $message->to($data['personal']['email'], $data['personal']['name'])
                            ->subject('Registration Invoice');
                        $message->from('admin@klips2023.com', env('APP_NAME'));
                    });
                    $m->email_send = 3;
                }else if($m->status == 2){
                    if($m->email_send == 1){
                        Mail::send('segment/mail/invoice_pending', ['data' => $data], function($message) use ($data){
                            $message->to($data['personal']['email'], $data['personal']['name'])
                                ->subject('Registration Invoice');
                            $message->from('admin@klips2023.com', env('APP_NAME'));
                        });
                        $m->email_send = 3;
                    }

                    Mail::send('segment/mail/invoice', ['data' => $data], function($message) use ($data){
                        $message->to($data['personal']['email'], $data['personal']['name'])
                            ->subject('Registration Receipt');
                        $message->from('admin@klips2023.com', env('APP_NAME'));
                    });
                }

                $m->save();

            }catch (Exception $e){

            }
        }
    }
}
