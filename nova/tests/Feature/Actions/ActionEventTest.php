<?php

namespace Laravel\Nova\Tests\Feature\Actions;

use Laravel\Nova\Actions\ActionEvent;
use Laravel\Nova\Tests\Fixtures\User;
use Laravel\Nova\Tests\IntegrationTest;

class ActionEventTest extends IntegrationTest
{
    public function test_it_belongs_to_default_user_model()
    {
        $action = new ActionEvent();

        $relation = $action->user();

        $this->assertSame(\Illuminate\Foundation\Auth\User::class, get_class($relation->getQuery()->getModel()));
    }

    /**
     * @environment-setup useCustomUserModelProvider
     */
    public function test_it_belongs_to_custom_user_model()
    {
        $action = new ActionEvent();

        $relation = $action->user();

        $this->assertSame(User::class, get_class($relation->getQuery()->getModel()));
    }

    public function useCustomUserModelProvider($app)
    {
        tap($app->make('config'), function ($config) {
            $config->set([
                'auth.providers.admin' => [
                    'driver' => 'eloquent',
                    'model' => User::class,
                ],
                'nova.guard' => 'admin',
            ]);
        });
    }
}
