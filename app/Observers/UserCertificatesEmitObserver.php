<?php

namespace App\Observers;

use App\Mail\CertEmitMail;
use App\Mail\OrderShipped;
use App\Models\UserCertificatesEmit;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserCertificatesEmitObserver
{
    /**
     * Handle the UserCertificatesEmit "created" event.
     *
     * @param  \App\Models\UserCertificatesEmit  $userCertificatesEmit
     * @return void
     */
    public function created(UserCertificatesEmit $userCertificatesEmit)
    {
        $user = $userCertificatesEmit->getuser();
        $code = $userCertificatesEmit->code;

        if (str_contains($user->email, 'profissionalizaead')) {
            Mail::to('fabiorcamargo@gmail.com')
            ->queue(new CertEmitMail($code));
        } else {
            Mail::to($user->email)
            ->queue(new CertEmitMail($code));
        }
        
    }

    /**
     * Handle the UserCertificatesEmit "updated" event.
     *
     * @param  \App\Models\UserCertificatesEmit  $userCertificatesEmit
     * @return void
     */
    public function updated(UserCertificatesEmit $userCertificatesEmit)
    {
        //
    }

    /**
     * Handle the UserCertificatesEmit "deleted" event.
     *
     * @param  \App\Models\UserCertificatesEmit  $userCertificatesEmit
     * @return void
     */
    public function deleted(UserCertificatesEmit $userCertificatesEmit)
    {
        //
    }

    /**
     * Handle the UserCertificatesEmit "restored" event.
     *
     * @param  \App\Models\UserCertificatesEmit  $userCertificatesEmit
     * @return void
     */
    public function restored(UserCertificatesEmit $userCertificatesEmit)
    {
        //
    }

    /**
     * Handle the UserCertificatesEmit "force deleted" event.
     *
     * @param  \App\Models\UserCertificatesEmit  $userCertificatesEmit
     * @return void
     */
    public function forceDeleted(UserCertificatesEmit $userCertificatesEmit)
    {
        //
    }
}
