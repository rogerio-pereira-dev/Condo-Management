<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Api;

use Tests\TestCase;

class AuthenticatedApiEndpointsTest extends TestCase 
{
    #region dataProviders
    public function getUrlDataProvider() : array
    {
        return [
            'get_users_by_category' => ['url' => '/user/category/id'],
            'get_user' => ['url' => '/user'],
            // 'show_user' => ['url' => '/user/1'],
        ];
    }

    public function postUrlDataProvider() : array
    {
        return [
            'logout'                    => ['url' => '/logout'],
            'change_password_request'   => ['url' => '/user/change-password/request'],
            'change_password_reset'     => ['url' => '/user/change-password/reset'],
            'change_password'           => ['url' => '/user/change-password'],

            'create_user' => ['url' => '/user'],
        ];
    }

    public function putUrlDataProvider() : array
    {
        return [
            'home'              => ['url' => '/'],
            'change_password'   => ['url' => '/change-password'],
            'employees'         => ['url' => '/employees'],
            'update_user'       => ['url' => '/user/1'],
        ];
    }

    public function deleteUrlDataProvider() : array
    {
        return [
            'delete_user' => ['url' => '/user/1'],
        ];
    }
    #endregion

    /**
     * @dataProvider getUrlDataProvider
     */
    public function testGetEndpoint($url)
    {
        $this->assertGuest();
        $this->getJson('/api'.$url)
            ->assertStatus(401);
    }


    /**
     * @dataProvider postUrlDataProvider
     */
    public function testPostEndpoint($url)
    {
        $this->assertGuest();
        $this->postJson('/api'.$url, [])
            ->assertStatus(401);
    }


    /**
     * @dataProvider putUrlDataProvider
     */
    public function testPutEndpoint($url)
    {
        $this->assertGuest();
        $this->putJson('/api'.$url, [])
            ->assertStatus(401);
    }


    /**
     * @dataProvider deleteUrlDataProvider
     */
    public function testDeleteEndpoint($url)
    {
        $this->assertGuest();
        $this->deleteJson('/api'.$url)
            ->assertStatus(401);
    }

}
