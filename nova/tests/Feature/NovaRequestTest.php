<?php

namespace Laravel\Nova\Tests\Feature;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Tests\Fixtures\User;
use Laravel\Nova\Tests\IntegrationTest;

class NovaRequestTest extends IntegrationTest
{
    public function test_checking_if_create_request()
    {
        $request = NovaRequest::create('/nova-api/users/1', 'POST', [
            'editing' => true,
            'editMode' => 'create',
        ]);

        $this->assertTrue($request->isCreateOrAttachRequest());
        $this->assertFalse($request->isUpdateOrUpdateAttachedRequest());
    }

    public function test_checking_if_update_request()
    {
        $request = NovaRequest::create('/nova-api/users/1', 'PUT', [
            'editing' => true,
            'editMode' => 'update',
        ]);

        $this->assertTrue($request->isUpdateOrUpdateAttachedRequest());
        $this->assertFalse($request->isCreateOrAttachRequest());
    }

    public function test_it_bound_nova_request_to_the_container()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $request = Request::create('/nova-api/users/action?action=noop-action', 'POST', [
            'resources' => implode(',', [$user->id, $user2->id]),
            'test' => 'Taylor Otwell',
            'callback' => '',
        ]);

        $this->app->instance('request', $request);

        $actionRequest = $this->app->make(ActionRequest::class);

        $this->assertTrue($this->app->bound(NovaRequest::class));

        $this->assertSame([
            'resources' => implode(',', [$user->id, $user2->id]),
            'test' => 'Taylor Otwell',
            'callback' => '',
            'action' => 'noop-action',
        ], $actionRequest->all());
    }
}
