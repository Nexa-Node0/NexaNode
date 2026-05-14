<?php

namespace App\Jobs;

use App\Mail\PostEmail;
use App\Models\Post;
use App\Models\BlogSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Traits\HasMailSettings;

class SendPostJob implements ShouldQueue
{
    use Dispatchable ,Queueable, InteractsWithQueue, SerializesModels;
    use HasMailSettings;

    /**
     * Create a new job instance.
     */
    public function __construct(public Post $post){}
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->bootstrapMailConfig();

        BlogSubscriber::query()
            ->whereNotNull('email')
            ->where('can_receive_updates', true)
            ->chunk(100, function ($subscribers){
                foreach($subscribers as $subscriber){
                    if(!$subscriber->can_receive_updates) continue;
                    Mail::to($subscriber->email)
                        ->queue(new PostEmail($this->post));
                }
        });
    }
}
