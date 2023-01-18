<?php

namespace Tests\Unit\App\Mail\User;

use Tests\TestCase;
use App\Mail\User\ChangePasswordMail;

class RequestChangePasswordMailTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_mail_content()
    {
        $user = $this->userTenant;
        $subject = config('app.name').' - Requested to Change Password';
        $url = url("/user/change-password/from-mail/{$user->id}");

        $mailable = new ChangePasswordMail($user);
        $mailable->assertHasSubject($subject);
    
        $mailable->assertSeeInHtml($user->name);
        $mailable->assertSeeInHtml('Change Password');
        $mailable->assertSeeInHtml($url);
    
        $mailable->assertSeeInText($user->name);
        $mailable->assertSeeInText('Change Password');
        $mailable->assertSeeInText($url);
    }
}
